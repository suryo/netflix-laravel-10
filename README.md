# 🎬 Netflixku

Platform streaming film online mirip Netflix, dibangun dengan **Laravel 10** dan **Tailwind CSS**.

![Laravel](https://img.shields.io/badge/Laravel-10-FF2D20?style=flat-square&logo=laravel&logoColor=white)
![Tailwind CSS](https://img.shields.io/badge/Tailwind_CSS-CDN-06B6D4?style=flat-square&logo=tailwindcss&logoColor=white)
![PHP](https://img.shields.io/badge/PHP-8.1+-777BB4?style=flat-square&logo=php&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL-8.0-4479A1?style=flat-square&logo=mysql&logoColor=white)

---

## ✨ Fitur

### 🎥 Public / User

- **Landing Page** — Hero section dengan film featured + daftar film per kategori (horizontal scroll)
- **Semua Film** — Grid responsive dengan filter kategori (pills)
- **Detail Film** — Poster, sinopsis, rating, durasi, sutradara, cast, dan film terkait
- **Video Player** — Embed player Google Drive dengan cinema mode
- **Pencarian** — Cari film berdasarkan judul, sutradara, atau cast
- **Kategori** — Telusuri film berdasarkan genre/kategori

### 🛠️ Admin Dashboard

- **Dashboard** — Statistik (total film, kategori, featured) + tabel film terbaru
- **Kelola Kategori** — CRUD (Create, Read, Update, Delete)
- **Kelola Film** — CRUD lengkap dengan upload poster/backdrop dan input link Google Drive

### 🎨 Design

- Dark theme ala Netflix
- Glassmorphism navbar dengan efek scroll
- Hover animations pada movie cards
- Responsive design (mobile, tablet, desktop)
- Custom Tailwind pagination

---

## 🚀 Instalasi

### Prasyarat

- PHP >= 8.1
- Composer
- MySQL
- Laragon / XAMPP / MAMP (atau web server lokal lainnya)

### Langkah-langkah

1. **Clone repository**

    ```bash
    git clone <repo-url> netflix-laravel-10
    cd netflix-laravel-10
    ```

2. **Install dependencies**

    ```bash
    composer install
    ```

3. **Setup environment**

    ```bash
    cp .env.example .env
    php artisan key:generate
    ```

4. **Konfigurasi database** — Edit file `.env`:

    ```env
    DB_DATABASE=netflix_laravel_10
    DB_USERNAME=root
    DB_PASSWORD=
    ```

5. **Buat database**

    ```sql
    CREATE DATABASE netflix_laravel_10;
    ```

6. **Jalankan migrasi & seeder**

    ```bash
    php artisan migrate --seed
    ```

7. **Buat storage link**

    ```bash
    php artisan storage:link
    ```

8. **Jalankan server**
    ```bash
    php artisan serve
    ```
    Atau jika menggunakan Laragon, akses langsung di `http://netflix-laravel-10.test`

---

## 📁 Struktur Halaman

| Halaman         | URL                    | Deskripsi                   |
| --------------- | ---------------------- | --------------------------- |
| Landing Page    | `/`                    | Hero + film per kategori    |
| Semua Film      | `/movies`              | Grid film + filter kategori |
| Detail Film     | `/movies/{slug}`       | Info lengkap film           |
| Watch / Player  | `/movies/{slug}/watch` | Video player (Google Drive) |
| Pencarian       | `/search?q=keyword`    | Hasil pencarian film        |
| Per Kategori    | `/category/{slug}`     | Film dalam 1 kategori       |
| Admin Dashboard | `/admin`               | Overview statistik          |
| Admin Kategori  | `/admin/categories`    | CRUD kategori               |
| Admin Film      | `/admin/movies`        | CRUD film                   |

---

## 🎬 Integrasi Google Drive

Untuk memutar video dari Google Drive:

1. Upload video ke Google Drive
2. Klik kanan → **Bagikan** → Ubah ke **"Siapa saja yang memiliki link"**
3. Salin link (contoh: `https://drive.google.com/file/d/FILE_ID/view?usp=sharing`)
4. Paste link tersebut di field **Video URL** saat membuat/edit film di admin

Sistem otomatis mengkonversi link menjadi embed URL untuk diputar langsung di halaman Watch.

**Format link yang didukung:**

- `https://drive.google.com/file/d/FILE_ID/view?usp=sharing`
- `https://drive.google.com/open?id=FILE_ID`
- `https://drive.google.com/file/d/FILE_ID/preview`

---

## 🗄️ Database Schema

### Categories

| Column | Type    | Description       |
| ------ | ------- | ----------------- |
| id     | bigint  | Primary key       |
| name   | varchar | Nama kategori     |
| slug   | varchar | URL-friendly name |

### Movies

| Column       | Type    | Description               |
| ------------ | ------- | ------------------------- |
| id           | bigint  | Primary key               |
| category_id  | bigint  | Foreign key ke categories |
| title        | varchar | Judul film                |
| slug         | varchar | URL-friendly title        |
| description  | text    | Sinopsis film             |
| poster       | varchar | Path gambar poster        |
| backdrop     | varchar | Path gambar backdrop      |
| video_url    | varchar | Link Google Drive         |
| is_featured  | boolean | Tampil di hero section    |
| rating       | varchar | Rating film (misal: 8.5)  |
| release_year | year    | Tahun rilis               |
| duration     | varchar | Durasi (misal: 2h 30m)    |
| director     | varchar | Nama sutradara            |
| cast         | varchar | Daftar pemain             |

---

## 🛠️ Tech Stack

| Teknologi    | Versi | Keterangan        |
| ------------ | ----- | ----------------- |
| Laravel      | 10.x  | PHP Framework     |
| Tailwind CSS | CDN   | Utility-first CSS |
| MySQL        | 8.x   | Database          |
| Google Fonts | Inter | Typography        |
| Google Drive | -     | Video hosting     |

---

## 📝 Data Seeder

Saat menjalankan `php artisan migrate --seed`, database akan diisi dengan:

- **10 Kategori**: Action, Comedy, Drama, Horror, Sci-Fi, Thriller, Romance, Animation, Documentary, Adventure
- **15 Film Sample**: The Dark Knight, Inception, Interstellar, The Shawshank Redemption, dll.

---

## 📄 License

Open-source project for educational purposes.
