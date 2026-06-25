<?php

namespace App\Encryption;

use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Contracts\Encryption\EncryptException;
use Illuminate\Contracts\Encryption\Encrypter as EncrypterContract;
use Illuminate\Contracts\Encryption\StringEncrypter;
use RuntimeException;

/**
 * Class Salsa20Encrypter
 * 
 * FUNGSI:
 * Menggantikan sistem enkripsi default Laravel (AES) dengan algoritma Stream Cipher Salsa20.
 * Class ini menangani proses mengacak data (enkripsi) dan mengembalikan data asli (dekripsi).
 * 
 * DITERAPKAN DIMANA:
 * 1. Di Database: Pada model User untuk kolom data pribadi warga (phone, address) yang menggunakan cast 'encrypted'.
 * 2. Di Browser: Pada file Sesi Login (Session) milik user agar session ID dan isinya aman dari pencurian.
 * 
 * CARA KERJA:
 * Menggunakan library native PHP libsodium (sodium_crypto_stream_salsa20_xor) untuk melakukan enkripsi XOR.
 * Hasil enkripsi juga ditambahkan kode keaslian (MAC - Message Authentication Code) menggunakan HMAC-SHA256,
 * untuk mencegah orang jahat memodifikasi (tampering) data yang sudah dienkripsi.
 */
class Salsa20Encrypter implements EncrypterContract, StringEncrypter
{
    /**
     * Kunci rahasia (Secret Key) yang digunakan untuk enkripsi dan dekripsi.
     * Diambil dari file .env (APP_KEY).
     */
    protected $key;

    public function __construct($key)
    {
        // Kunci harus sepanjang 32 byte untuk Salsa20.
        $this->key = (string) $key;
    }

    /**
     * Proses Enkripsi Data
     */
    public function encrypt($value, $serialize = true)
    {
        // 1. Buat 'nonce' (Number used ONCE) acak. 
        // Nonce ini seperti garam dalam masakan, membuat hasil enkripsi selalu unik 
        // meskipun data yang dienkripsi sama.
        $nonce = random_bytes(24); // XSalsa20 nonce length is 24 bytes

        // 2. Siapkan data (bisa berupa array atau object akan di-serialize jadi string)
        $value = $serialize ? serialize($value) : $value;

        try {
            // 3. Proses inti enkripsi menggunakan algoritma XSalsa20-Poly1305 (Secretbox)
            $value = \sodium_crypto_secretbox($value, $nonce, $this->key);
        } catch (\Exception $e) {
            throw new EncryptException('Gagal mengenkripsi data menggunakan Salsa20.');
        }

        // 4. Buat kode pengaman tambahan (MAC) menggunakan teknik HMAC-SHA256.
        // Tujuannya agar jika ada hacker yang mencoba mengubah 1 huruf saja dari data terenkripsi,
        // sistem akan tahu dan menolak data tersebut.
        $mac = $this->hash($nonce = base64_encode($nonce), $value = base64_encode($value));

        // 5. Bungkus semua komponen (nonce, data terenkripsi, mac) ke dalam format JSON.
        $json = json_encode(compact('nonce', 'value', 'mac'), JSON_UNESCAPED_SLASHES);

        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new EncryptException('Gagal membungkus data terenkripsi.');
        }

        // 6. Encode menjadi Base64 agar aman disimpan di database maupun cookie.
        return base64_encode($json);
    }

    /**
     * Enkripsi khusus untuk string (tanpa di-serialize)
     */
    public function encryptString($value)
    {
        return $this->encrypt($value, false);
    }

    /**
     * Proses Dekripsi Data (Mengembalikan data ke bentuk asli)
     */
    public function decrypt($payload, $unserialize = true)
    {
        // 1. Buka bungkus JSON dan validasi kode pengaman (MAC)-nya.
        // Jika MAC tidak cocok, proses berhenti di sini (menghindari manipulasi data).
        $payload = $this->getJsonPayload($payload);

        // 2. Ambil nonce dan data terenkripsi.
        $nonce = base64_decode($payload['nonce']);
        $value = base64_decode($payload['value']);

        try {
            // 3. Proses inti dekripsi menggunakan algoritma XSalsa20-Poly1305
            $decrypted = \sodium_crypto_secretbox_open($value, $nonce, $this->key);
            
            if ($decrypted === false) {
                throw new DecryptException('Gagal mendekripsi data (MAC tidak valid).');
            }
        } catch (\Exception $e) {
            throw new DecryptException('Gagal mendekripsi data Salsa20.');
        }

        // 4. Kembalikan data (jika sebelumnya di-serialize, maka di-unserialize)
        return $unserialize ? unserialize($decrypted) : $decrypted;
    }

    /**
     * Dekripsi khusus untuk string
     */
    public function decryptString($payload)
    {
        return $this->decrypt($payload, false);
    }

    /**
     * Fungsi untuk membuat kode pengaman tambahan (MAC).
     */
    protected function hash($nonce, $value)
    {
        return hash_hmac('sha256', $nonce.$value, $this->key);
    }

    /**
     * Fungsi untuk membuka payload JSON dan mengecek validitasnya.
     */
    protected function getJsonPayload($payload)
    {
        $payload = json_decode(base64_decode($payload), true);

        // Jika bentuk data tidak sesuai
        if (! $this->validPayload($payload)) {
            throw new DecryptException('Format data terenkripsi tidak valid.');
        }

        // Jika kode pengaman (MAC) tidak sesuai
        if (! $this->validMac($payload)) {
            throw new DecryptException('Kode pengaman (MAC) tidak valid, data mungkin telah dimanipulasi.');
        }

        return $payload;
    }

    /**
     * Cek apakah komponen payload lengkap.
     */
    protected function validPayload($payload)
    {
        return is_array($payload) && isset($payload['nonce'], $payload['value'], $payload['mac']) &&
               strlen(base64_decode($payload['nonce'], true)) === 24;
    }

    /**
     * Cek apakah MAC yang dihitung sistem sama dengan MAC yang ada di data.
     */
    protected function validMac(array $payload)
    {
        $calculated = $this->hash($payload['nonce'], $payload['value']);

        return hash_equals($calculated, $payload['mac']);
    }

    /**
     * Mendapatkan kunci enkripsi yang sedang digunakan.
     */
    public function getKey()
    {
        return $this->key;
    }

    /**
     * Mendapatkan semua kunci enkripsi (sekarang dan sebelumnya).
     * Wajib diimplementasikan di Laravel 11.
     */
    public function getAllKeys()
    {
        return [$this->key];
    }

    /**
     * Mendapatkan kunci enkripsi sebelumnya (untuk fitur rotasi kunci).
     * Wajib diimplementasikan di Laravel 11.
     */
    public function getPreviousKeys()
    {
        return [];
    }
}
