<?php

namespace App\Providers;

use App\Encryption\Salsa20Encrypter;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;

/**
 * Class EncryptionServiceProvider
 * 
 * FUNGSI:
 * Service Provider ini bertugas untuk "membajak" atau mengambil alih layanan enkripsi bawaan Laravel
 * dan menggantikannya dengan layanan enkripsi Salsa20 yang sudah kita buat.
 * 
 * CARA KERJA:
 * Ketika aplikasi Laravel berjalan, file ini akan dipanggil. Di dalam method `register()`,
 * kita mendaftarkan ulang 'encrypter' ke dalam sistem (Singleton pattern).
 * Sehingga, kapanpun aplikasi meminta fungsi enkripsi (misal untuk Enkripsi Model atau Sesi Login), 
 * Laravel akan menggunakan class `Salsa20Encrypter` kita, bukan AES default lagi.
 */
class EncryptionServiceProvider extends ServiceProvider
{
    /**
     * Daftarkan services ke dalam container Laravel.
     */
    public function register()
    {
        // Mengubah default 'encrypter' pada sistem Laravel
        $this->app->singleton('encrypter', function ($app) {
            // Ambil konfigurasi dari file config/app.php
            $config = $app->make('config')->get('app');

            // Ambil kunci rahasia (APP_KEY) yang ada di file .env
            $key = $config['key'];

            // Jika format kunci diawali dengan 'base64:', kita harus decode dulu
            if (Str::startsWith($key, 'base64:')) {
                $key = base64_decode(substr($key, 7));
            }

            // Kembalikan instance dari Salsa20Encrypter dengan kunci rahasia yang sudah didecode
            return new Salsa20Encrypter($key);
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot()
    {
        // Tidak ada yang perlu dibooting khusus
    }
}
