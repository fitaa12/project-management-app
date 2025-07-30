# Project Management App

Aplikasi manajemen tugas proyek berbasis Laravel Blade. Aplikasi ini mendukung autentikasi pengguna, pembuatan proyek, manajemen tim, daftar tugas per proyek, dan progress bar.

## 📌 Fitur Utama

- Autentikasi pengguna (Login, Register)
- User dapat membuat proyek
- User dapat menambahkan tim ke proyek
- Task list per proyek (tambah, edit, hapus tugas)
- Progress bar berdasarkan penyelesaian tugas

## 🧩 User Stories

1. **Sebagai pengguna**, saya ingin dapat melakukan login dan registrasi agar dapat mengakses aplikasi dengan aman.
2. **Sebagai pengguna**, saya ingin membuat proyek baru agar saya dapat mengelola pekerjaan saya.
3. **Sebagai pengguna**, saya ingin menambahkan anggota tim ke dalam proyek agar kami bisa bekerja sama.
4. **Sebagai pengguna**, saya ingin menambahkan tugas ke dalam proyek agar saya dapat mengelola pekerjaan.
5. **Sebagai pengguna**, saya ingin melihat progress bar proyek agar saya tahu seberapa jauh pekerjaan sudah selesai.

## ✅ Acceptance Criteria

- Pengguna harus bisa melakukan registrasi dan login.
- Pengguna dapat membuat, melihat, mengedit, dan menghapus proyek.
- Pengguna dapat menambahkan anggota tim ke proyek.
- Pengguna dapat menambahkan tugas ke proyek dan menandainya sebagai selesai.
- Progress bar proyek harus berubah sesuai dengan jumlah tugas yang telah selesai.

## ⚙️ Instalasi

1. Clone repositori ini:
   ```bash
   git clone https://github.com/fitaa12/project-management-app.git
   cd project-management-app
   ```

2. Install dependensi Laravel:
   ```bash
   composer install
   npm install && npm run dev
   ```

3. Copy file `.env` dan buat kunci aplikasi:
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. Setup database dan migrasi:
   ```bash
   php artisan migrate --seed
   ```

5. Jalankan server:
   ```bash
   php artisan serve
   ```

## 📂 Struktur Folder Penting

- `app/Models` – Model Eloquent
- `resources/views` – Blade templates (UI)
- `routes/web.php` – Routing aplikasi
- `app/Http/Controllers` – Logika bisnis aplikasi

## 👤 Pengembang

Nama: [Luthfita Rahmaniahusna]  
NIM: [2023160014]  
Mata Kuliah: Pemrograman Web Berbasis Framework 
Tugas: UAS (Tugas Individu)

## 🔗 Link Repositori

[https://github.com/fitaa12/project-management-app](hhttps://github.com/fitaa12/project-management-app)
