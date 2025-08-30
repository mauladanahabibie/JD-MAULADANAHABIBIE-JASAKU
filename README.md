# JasaKu - Marketplace Layanan Profesional

**JasaKu** adalah sebuah platform marketplace berbasis web modern yang dibangun untuk menghubungkan para penyedia jasa (Mitra) dengan pelanggan (Customer). Aplikasi ini dirancang dengan arsitektur yang kuat menggunakan Laravel dan Livewire, memberikan pengalaman pengguna yang interaktif dan *real-time*.

## Daftar Isi

1.  [Tentang Proyek](#tentang-proyek)
2.  [Fitur Utama](#fitur-utama)
3.  [Teknologi yang Digunakan](#teknologi-yang-digunakan)
4.  [Petunjuk Instalasi](#petunjuk-instalasi)
5.  [Cara Menjalankan Aplikasi](#cara-menjalankan-aplikasi)
6.  [Struktur Proyek](#struktur-proyek-penting)
7.  [Lisensi](#lisensi)

-----

## Tentang Proyek

Proyek ini bertujuan untuk menciptakan sebuah ekosistem marketplace yang lengkap di mana pengguna dapat dengan mudah mencari, berkomunikasi, dan bertransaksi dengan penyedia jasa profesional. Fokus utama pengembangan adalah pada interaktivitas *real-time*, pengalaman pengguna yang mulus, dan arsitektur kode yang bersih dan mudah dikelola.

-----

## Fitur Utama

  - **Pencarian & Penjelajahan Layanan**:

      - Halaman daftar layanan dengan *lazy loading* untuk performa.
      - Paginasi interaktif tanpa *refresh* halaman.
      - Pengurutan layanan secara acak yang konsisten per sesi.
      - Filter dan pencarian layanan secara *real-time*.

  - **Sistem Chat Real-Time (User-to-User)**:

      - Percakapan privat antara Customer dan Mitra.
      - Berjalan secara *real-time* menggunakan **Laravel Reverb**.
      - Dukungan pengiriman pesan **teks, gambar/file, dan lokasi**.
      - Sidebar kontak cerdas yang hanya menampilkan riwayat percakapan dan diurutkan berdasarkan pesan terakhir.
      - Notifikasi pesan belum dibaca (*unread messages*).
      - Fitur pencarian kontak berdasarkan nama dan username.

  - **Alur Pemesanan & Transaksi**:

      - Fitur **Tawaran Order** yang bisa dibuat oleh Mitra langsung dari dalam chat.
      - Sistem **Konfirmasi Order** oleh Customer.
      - Pencatatan order ke dalam database.

  - **AI Chatbot Assistant**:

      - Asisten AI berbasis `localStorage` untuk membantu pengguna baru.
      - Diprogram dengan *system prompt* yang detail untuk memahami konteks website "JasaKu".
      - Mampu menyimpan dan melanjutkan riwayat percakapan per sesi tab.

  - **Komponen Interaktif**:

      - Modal detail layanan yang dinamis dan dikelola oleh Livewire.
      - Formulir kontak dengan validasi *real-time* dan *rate limiting* untuk keamanan.
      - Navbar dan komponen UI lainnya yang responsif dan interaktif.

-----

## Teknologi yang Digunakan

Proyek ini dibangun di atas **TALL Stack** dengan beberapa tambahan:

  * **Backend**: Laravel 11, Filament
  * **Frontend**: Livewire 3, Alpine.js, Tailwind CSS
  * **Real-Time Engine**: Laravel Reverb
  * **Database**: MySQL
  * **Asset Bundling**: Vite

-----

## Petunjuk Instalasi

Berikut adalah langkah-langkah untuk menjalankan proyek ini di lingkungan lokal.

**Prasyarat**:

  * PHP 8.1+
  * Composer
  * Node.js & NPM
  * Database (MySQL)
  * [Opsional] Redis untuk *queue* & *caching* di production.

**Langkah-langkah:**

1.  **Clone repositori:**

    ```bash
    git clone https://github.com/mauladanahabibie/JD_026_MAULADANAHABIBIE_JASAKU.git
    cd JD_026_MAULADANAHABIBIE_JASAKU
    ```

2.  **Instal dependensi PHP:**

    ```bash
    composer install
    ```

3.  **Instal dependensi JavaScript:**

    ```bash
    npm install
    ```

4.  **Siapkan file `.env`:**
    Salin file `.env.example` menjadi `.env`.

    ```bash
    cp .env.example .env
    ```

    Buka file `.env` dan konfigurasikan koneksi database Anda (DB\_DATABASE, DB\_USERNAME, DB\_PASSWORD) atau pakai default aja.

5.  **Generate application key:**

    ```bash
    php artisan key:generate
    ```

6.  **Jalankan migrasi database:**
    Perintah ini akan membuat semua tabel yang dibutuhkan, termasuk untuk `users`, `services`, `chat_messages`, `orders`, `transactions`, dan `cache`.

    ```bash
    php artisan migrate --seed
    ```

7.  **Buat symbolic link untuk storage:**
    Agar file yang di-upload (seperti gambar layanan dan bukti bayar) bisa diakses publik.

    ```bash
    php artisan storage:link
    ```

**Langkah Ke 2:**
1.  **Clone repositori:**

    ```bash
    git clone https://github.com/mauladanahabibie/JD_026_MAULADANAHABIBIE_JASAKU.git
    cd JD_026_MAULADANAHABIBIE_JASAKU
    ```

2.  **Instal dependensi PHP:**

    ```bash
    composer install
    ```
3.  **Siapkan file `.env`:**
    Salin file `.env.example` menjadi `.env`.

    ```bash
    cp .env.example .env
    ```

    Buka file `.env` dan konfigurasikan koneksi database Anda (DB\_DATABASE, DB\_USERNAME, DB\_PASSWORD) atau pakai default aja.

4.  **Start Setup**

    ```bash
    php artisan app:setup-jasaku
    ```
-----


## Cara Menjalankan Aplikasi

Anda perlu menjalankan **4 proses** ini di terminal yang terpisah untuk fungsionalitas penuh.

1.  **Jalankan Development Server Laravel:**

    ```bash
    php artisan serve
    ```

2.  **Jalankan Vite untuk kompilasi Aset (CSS & JS):**

    ```bash
    npm run dev
    ```

3.  **Jalankan Server WebSocket (Reverb):**

    ```bash
    php artisan reverb:start
    ```

4.  **Jalankan Queue Worker (untuk broadcast event):**

    ```bash
    php artisan queue:work
    ```

Setelah semua berjalan, buka aplikasi di `http://127.0.0.1:8000` di browser Anda.

-----

## Struktur Proyek Penting

  * **Komponen Livewire**: Semua logika interaktif utama berada di `app/Livewire/`.
      * `Chat.php`: Otak dari fitur chat user-to-user.
      * `ServiceList.php`: Mengelola tampilan dan paginasi semua layanan.
      * `ServiceCard.php`: Mengelola interaksi untuk satu kartu layanan.
      * `ServiceDetailModal.php`: Menampilkan modal detail layanan.
      * `ContactForm.php`: Menangani formulir "Hubungi Kami".
  * **Event Broadcasting**: Event `MessageSent` di `app/Events/` digunakan untuk notifikasi chat *real-time*.
  * **Otorisasi Channel**: Logika otorisasi untuk channel privat chat ada di `routes/channels.php`.
  * **Aset Frontend**: File CSS kustom ada di `resources/css/custom.css` dan diimpor melalui `app.css`.

-----

## Lisensi

Proyek ini dilisensikan di bawah [Lisensi MIT](LICENSE.md).