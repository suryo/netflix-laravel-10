# Netflixku - Streaming Platform Laravel 10

Netflixku adalah platform streaming film modern yang dibangun menggunakan Laravel 10 dan Tailwind CSS. Aplikasi ini mendukung fitur autentikasi berbasis KTP, kategori konten dewasa yang dibatasi, serta pemisahan antara Film dan Serial TV.

## ✨ Fitur Utama

- **Premium UI**: Desain terinspirasi Netflix dengan Glassmorphism dan Hero Banner dinamis.
- **Role-Based Access**:
    - **Admin**: Mengelola film, kategori, komentar, dan memberikan persetujuan akses konten dewasa.
    - **Member**: Menonton film umum. Memerlukan verifikasi KTP untuk konten 18+.
- **Video Player**: Terintegrasi dengan Google Drive Embed (otomatis konversi link).
- **TV Series Section**: Pemisahan konten Film Layar Lebar dan Serial TV.
- **Adult Content Security**:
    - Konten 🔞 disembunyikan secara otomatis dari daftar jika belum disetujui.
    - Guard keamanan pada level Controller untuk mencegah akses via URL langsung.
- **Rich Text Editor**: Pengelolaan deskripsi film menggunakan Quill.js.

## 🚀 Instalasi

1. Clone repository ini.
2. Install dependencies:
    ```bash
    composer install
    npm install && npm run dev
    ```
3. Copy `.env.example` ke `.env` dan konfigurasi database.
4. Generate key:
    ```bash
    php artisan key:generate
    ```
5. Jalankan migrasi dan seeder:
    ```bash
    php artisan migrate --seed
    ```
6. Link storage:
    ```bash
    php artisan storage:link
    ```

## 🧪 Akun Uji Coba

Gunakan akun berikut untuk melihat fitur admin dan member:

| Role                  | Email                    | Password   | Status               |
| :-------------------- | :----------------------- | :--------- | :------------------- |
| **Admin**             | `admin@netflixku.com`    | `password` | Full Access          |
| **Member (New)**      | `member@netflixku.com`   | `password` | Butuh Verifikasi KTP |
| **Member (Approved)** | `approved@netflixku.com` | `password` | Akses Konten Dewasa  |

## 🛠️ Teknologi

- **Framework**: Laravel 10
- **Styling**: Tailwind CSS
- **Interactivity**: Alpine.js
- **Database**: MySQL
- **Tooling**: Laragon (recommended), Vite

---

© 2026 Netflixku Project.
