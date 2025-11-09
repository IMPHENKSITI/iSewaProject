
# iSewaProject

Perkembangan terhadap project Laravel ini akan didokumentasikan disini!

### _Sebagai Kontributor kami, Kalian Harus Setup untuk Pertama kali_ :
- Clone Repository ini
- Install Dependensi Project yang diperlukan
```bash
  composer create-project Laravel/Laravel iSewaProject
  cd iSewaProject
```
- Membuat file```.env ``` secara manual di Project nya, untuk referensi bisa mengambil di file ```.env.example ```
- Sesuaikan salah satu bagian di file ```.env ``` Dengan catatan Username dan Password boleh default, atau sesuai koneksi masing-masing.
```bash
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=isewaproject
```
- Buka terminal lalu jalankan 
```bash
  php artisan key::generate
```
- Jika langkah di atas udah terpenuhi, tetapi masih kendala. Maka, hubungi secara personal di RL.
## Keuntungan memakai Github
- Kita semua bisa saling pull dan push untuk membantu kita semua menyelasikan project yang sangat berharga ini :v

## Version 0.1.1

- Penambahan Template Admin 
- Asset Template admin di public/admin/
- Penambahan Resources/Views/ untuk admin
- Serta menambahkan Routes dan Controller apa adanya untuk admin

Catatan yang perlu diperbaiki :
-
- Error Update di Controllers/DashboardController.php
- Ini menggunakan dependensi public atau mengambil dari sumber luar jadi ada kendala bagi yang mau clone-nya
- Masih belum bisa untuk Profil Admin


