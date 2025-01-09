# Articles Laravel

Proyek ini adalah aplikasi manajemen artikel yang dibangun menggunakan Laravel. Aplikasi ini memungkinkan pengguna untuk membuat, mengedit, menghapus, dan mengelola artikel dengan mudah.

## Fitur
- **Autentikasi Pengguna**: Pengguna dapat mendaftar dan login untuk mengakses artikel.
- **CRUD Artikel**: Pengguna dapat membuat, membaca, mengedit, dan menghapus artikel.
- **Manajemen Meta Tags dan Tags**: Setiap artikel dapat memiliki meta tags dan tags untuk mempermudah pencarian.
- **Upload Gambar**: Pengguna dapat mengunggah gambar untuk artikel mereka.
- **Dashboard Admin**: Admin dapat mengelola artikel melalui dashboard admin yang mudah digunakan.

## Persyaratan Sistem
Pastikan sistem Anda memenuhi persyaratan berikut sebelum melanjutkan instalasi:

- PHP 8.x atau lebih tinggi
- Composer
- Node.js dan npm (untuk pengelolaan frontend)
- Database MySQL

## Instalasi

### 1. Clone Repository
Clone proyek ini ke komputer Anda dengan perintah:

```bash
git clone https://github.com/amirrdn/articles-laravel.git
cd articles-laravel
```

### 2. Install Dependensi PHP
Setelah meng-clone proyek, install dependensi PHP menggunakan Composer:

```bash
composer install
```

### 3. Install Dependensi Frontend

```bash
npm install
```
### 4. Konfigurasi File .env

```bash
cp .env.example .env
```

### 5. Generate Application Key
Jalankan perintah berikut untuk menghasilkan application key yang diperlukan oleh Laravel:

```bash
php artisan key:generate
```

### 6. Jalankan Migrasi Database
Setelah file .env dikonfigurasi, jalankan migrasi untuk membuat tabel yang diperlukan oleh aplikasi:

```bash
php artisan migrate
```
### 7. Jalankan Seeder
```bash
php artisan db:seed
```

### 8. Jalankan Aplikasi
Sekarang, jalankan aplikasi menggunakan perintah berikut:

```bash
php artisan serve
```

### 9. (Opsional) Menjalankan Task Frontend
Untuk meng-compile asset frontend, jalankan perintah berikut:

```bash
npm run dev
```

### 10. Pengguna dan Admin
Admin dapat mengelola artikel, melihat artikel yang diposting, serta memoderasi konten.
Pengguna biasa dapat melihat artikel dan memposting artikel mereka.

### Penggunaan
Setelah aplikasi berjalan di lokal Anda, Anda dapat mengaksesnya melalui browser menggunakan http://localhost:8000. Jika Anda ingin mengelola artikel, pastikan Anda telah login dengan akun admin.

### Rute Pengguna
* /dashboard: Halaman dashboard pengguna setelah login.
* /admin/articles: Halaman admin untuk membuat, mengedit, dan mengelola artikel.
