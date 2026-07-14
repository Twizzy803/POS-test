<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'POS') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-slate-50 flex items-center justify-center min-h-screen font-sans antialiased text-slate-900">

    <div class="bg-white p-8 rounded-2xl shadow-sm border border-slate-200/80 w-full max-w-md mx-4">

        <!-- Header Halaman Login -->
        <div class="text-center mb-8">
            <div
                class="h-12 w-12 bg-blue-50 text-blue-600 rounded-xl flex items-center justify-center mx-auto mb-3 text-2xl font-bold shadow-sm">
                🛒
            </div>
            <!-- Font Bold untuk Judul Utama -->
            <h1 class="text-2xl font-bold tracking-tight text-slate-900">Selamat Datang Kembali</h1>
            <!-- Font Normal/Light untuk Keterangan -->
            <p class="text-sm font-normal text-slate-500 mt-1">Silakan masuk untuk mengakses sistem POS</p>
        </div>

        <!-- Form Login -->
        <form action="{{ route('login') }}" method="POST" class="space-y-5">
            @csrf

            <!-- Notifikasi Error (Merah Soft) -->
            @if ($errors->any())
                <div class="bg-red-50 border border-red-200 text-red-600 px-4 py-3 rounded-xl text-sm font-normal">
                    <span class="font-bold block mb-0.5">Gagal Masuk</span>
                    {{ $errors->first() }}
                </div>
            @endif

            <!-- Input Email -->
            <div>
                <!-- Font Medium untuk Label agar Tegas tapi tidak Bold berlebih -->
                <label for="email" class="block text-sm font-medium text-slate-700 mb-1.5">Alamat Email</label>
                <!-- Input menggunakan border tipis, warna tulisan normal, focus warna biru soft -->
                <input type="email" id="email" name="email" value="{{ old('email') }}"
                    class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm font-normal placeholder-slate-400 bg-white focus:outline-none focus:border-blue-400 focus:ring-4 focus:ring-blue-50 transition"
                    placeholder="nama@perusahaan.com" required autocomplete="email" autofocus>
            </div>

            <!-- Input Password -->
            <div>
                <label for="password" class="block text-sm font-medium text-slate-700 mb-1.5">Kata Sandi</label>
                <input type="password" id="password" name="password"
                    class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm font-normal placeholder-slate-400 bg-white focus:outline-none focus:border-blue-400 focus:ring-4 focus:ring-blue-50 transition"
                    placeholder="••••••••" required autocomplete="current-password">
            </div>

            <!-- Tombol Submit (Biru Soft Menuju Gelap) -->
            <button type="submit"
                class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 px-4 rounded-xl transition duration-200 shadow-sm text-sm focus:outline-none focus:ring-4 focus:ring-blue-100">
                Masuk ke Sistem
            </button>
        </form>

    </div>

</body>

</html>
