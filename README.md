# 🛒 Aplikasi Point of Sales (POS) Toko

Aplikasi sistem kasir modern berbasis web yang dibangun menggunakan **Laravel (Backend)** dan kombinasi **Tailwind CSS + Alpine.js (Frontend)**. Proyek ini mendukung Multi-Role (Admin & Kasir), manajemen kategori, manajemen produk, serta simulasi transaksi kasir secara realtime.



## 🛠️ Spesifikasi Lingkungan (Environment)

Untuk memastikan aplikasi berjalan dengan optimal, proyek ini dikembangkan dan diuji menggunakan spesifikasi berikut:

- **Laravel Framework** `13.19.0`
- **PHP Version:** `8.3.6 (cli)`
- **Node Package Manager (NPM):** `11.6.2`
- **pnpm Version:** `10.23.0`
- **Database Engine:** MySQL
- **Asset Bundler:** Vite

Aplikasi POS ini dirancang dengan alur kerja yang terintegrasi antara hak akses pengguna dan manajemen data sebagai berikut:

1. **Autentikasi & Pengalihan Berbasis Peran (Gate Redirect):**
   - Pengguna melakukan login melalui halaman berkode warna minimalis.
   - Setelah sukses, sistem akan memeriksa hak akses pengguna menggunakan **Gate** yang telah didaftarkan pada Service Provider (`access-admin` dan `access-kasir`).
   - Jika masuk sebagai **Admin**, pengguna diarahkan ke rute `/admin/dashboard`. Jika masuk sebagai **Kasir**, pengguna langsung diarahkan ke rute `/kasir/order`.

2. **Manajemen Data Master (Khusus Admin):**
   - Admin memiliki akses penuh untuk menambah, melihat, mengubah, dan menghapus data pada menu **Kategori Barang** dan **Master Produk**.
   - Setiap produk yang dibuat wajib dihubungkan dengan `category_id` yang valid dari database untuk menjaga integritas relasi data.

3. **Mesin Transaksi POS Realtime (Khusus Kasir):**
   - Halaman order kasir memanfaatkan **Alpine.js lokal** yang terkompilasi melalui Vite untuk memproses keranjang belanja secara interaktif tanpa *reload* halaman.
   - **Manajemen Stok Realtime:** Ketika kasir menambahkan produk ke keranjang belanja, angka stok produk yang tampil di layar kiri akan berkurang secara otomatis dan instan.
   - **Kalkulator Otomatis:** Subtotal item, total harga keseluruhan, dan jumlah uang kembalian dihitung secara *realtime* saat kasir mengetikkan jumlah uang bayar.
   - Tombol "Simpan Transaksi" akan terkunci (*disabled*) secara otomatis jika keranjang kosong atau uang pembayaran kurang.

4. **Penyimpanan Transaksi & Riwayat:**
   - Saat transaksi disimpan, data dikirim dalam bentuk *clean array structure* ke `TransactionController`.
   - Sistem akan membuat nomor invoice unik, mengurangi stok asli di database MySQL, dan menyimpan detailnya.
   - Kasir dapat melihat kembali semua nota yang sukses pada halaman **Riwayat Transaksi**.

## 🚀 Panduan Instalasi & Cara Menjalankan

Ikuti langkah-langkah berikut untuk memasang aplikasi di lingkungan lokal Anda:
```bash
1.  git clone https://github.com/Twizzy803/POS-test.git
2.  composer install
3.  pnpm install
4.  cp .env.example .env (Salin file .env.example menjadi .env)
5.  php artisan key:generate
6.  php artisan migrate:fresh --seed
7.  menjalankan server aplikasi
    - php artisan serve
    - pnpm run dev

  ## Kredensial Akun uji coba
  - admin@gmail.com|password123
  - kasir@gmail.com|password123
```

## ⚡ Catatan Pemeliharaan & Troubleshooting

Jika Anda melakukan modifikasi pada hak akses atau mengalami kendala pemantulan halaman (*403 Unauthorized / Route Not Found*), pastikan:
1. Konfigurasi `Gate::define` sudah aktif di dalam `AppServiceProvider` (atau `AuthServiceProvider` tergantung versi Laravel Anda).
2. Jalankan perintah pembersihan cache memori Laravel berikut di terminal:
   ```bash
   php artisan route:clear
   php artisan view:clear
   php artisan cache:clear

