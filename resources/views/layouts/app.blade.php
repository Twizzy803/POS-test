<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-100 font-sans antialiased">

    <div class="flex h-screen overflow-hidden">

        <!-- ================= SIDEBAR MENU ================= -->
        <aside class="w-64 bg-slate-800 text-slate-100 flex flex-col justify-between">
            <div>
                <!-- Logo / Nama Aplikasi -->
                <div class="h-16 flex items-center justify-center bg-slate-950 font-bold text-xl tracking-wider">
                    🛒 TOKO POS
                </div>

                <!-- Daftar Menu Navigasi -->
                <!-- Daftar Menu Navigasi Menggunakan Alpine.js -->
                <nav class="mt-6 px-4 space-y-2" x-data="{ currentUrl: window.location.pathname }">
                    @if (Auth::user()->role === 'admin')
                        <div class="text-xs font-semibold text-slate-400 uppercase px-3 mb-1">Menu Admin</div>

                        <!-- Menu Dashboard: Aktif jika URL adalah /admin/dashboard -->
                        <a href="{{ route('admin.dashboard') }}"
                            :class="currentUrl.includes('/admin/dashboard') ? 'bg-slate-900 text-white font-semibold' :
                                'hover:bg-slate-700 hover:text-white font-medium text-slate-300'"
                            class="flex items-center space-x-3 px-3 py-2.5 rounded-lg transition duration-200">
                            <span>📊 Dashboard</span>
                        </a>

                        <!-- Menu Kategori: Aktif jika URL mengandung kata /admin/categories -->
                        <a href="{{ route('admin.categories.index') }}"
                            :class="currentUrl.includes('/admin/categories') ? 'bg-slate-900 text-white font-semibold' :
                                'hover:bg-slate-700 hover:text-white font-medium text-slate-300'"
                            class="flex items-center space-x-3 px-3 py-2.5 rounded-lg transition duration-200">
                            <span>📁 Kategori Barang</span>
                        </a>

                        <!-- Menu Master Produk: Aktif jika URL mengandung kata /admin/products -->
                        <a href="{{ route('admin.products.index') }}"
                            :class="currentUrl.includes('/admin/products') ? 'bg-slate-900 text-white font-semibold' :
                                'hover:bg-slate-700 hover:text-white font-medium text-slate-300'"
                            class="flex items-center space-x-3 px-3 py-2.5 rounded-lg transition duration-200">
                            <span>📦 Master Produk</span>
                        </a>
                    @endif

                    @if (Auth::user()->role === 'kasir')
                        <div class="text-xs font-semibold text-slate-400 uppercase px-3 mb-1">Menu Kasir</div>

                        <!-- Menu Mesin Order -->
                        <a href="{{ route('kasir.order') }}"
                            :class="currentUrl.includes('/kasir/order') ? 'bg-slate-900 text-white font-semibold' :
                                'hover:bg-slate-700 hover:text-white font-medium text-slate-300'"
                            class="flex items-center space-x-3 px-3 py-2.5 rounded-lg transition duration-200">
                            <span>🖥️ Mesin Order Kasir</span>
                        </a>

                        <!-- Menu Riwayat Transaksi -->
                        <a href="{{ route('kasir.history') }}"
                            :class="currentUrl.includes('/kasir/history') ? 'bg-slate-900 text-white font-semibold' :
                                'hover:bg-slate-700 hover:text-white font-medium text-slate-300'"
                            class="flex items-center space-x-3 px-3 py-2.5 rounded-lg transition duration-200">
                            <span>📜 Riwayat Transaksi</span>
                        </a>
                    @endif
                </nav>
            </div>

            <!-- Tombol Logout di Bagian Bawah Sidebar -->
            <div class="p-4 bg-slate-900">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit"
                        class="w-full bg-red-600 hover:bg-red-700 text-white font-medium py-2 px-4 rounded-lg transition duration-200 flex items-center justify-center space-x-2">
                        <span>🚪 Keluar Sistem</span>
                    </button>
                </form>
            </div>
        </aside>

        <!-- ================= AREA KONTEN UTAMA ================= -->
        <div class="flex-1 flex flex-col overflow-y-auto">

            <!-- HEADER ATAS -->
            <header class="h-16 bg-white border-b border-gray-200 flex items-center justify-between px-8 shadow-sm">
                <!-- Bagian Kiri Header (Status Role) -->
                <div class="flex items-center space-x-2">
                    <span
                        class="px-3 py-1 text-xs font-bold uppercase rounded-full {{ Auth::user()->role === 'admin' ? 'bg-purple-100 text-purple-700' : 'bg-green-100 text-green-700' }}">
                        Akses: {{ Auth::user()->role }}
                    </span>
                </div>

                <!-- Bagian Kanan Header (Nama User yang Login) -->
                <div class="flex items-center space-x-3">
                    <div class="text-right">
                        <p class="text-sm font-semibold text-gray-800">{{ Auth::user()->name }}</p>
                        <p class="text-xs text-gray-500">{{ Auth::user()->email }}</p>
                    </div>
                    <!-- Avatar Lingkaran Singkatan Nama -->
                    <div
                        class="h-10 w-10 rounded-full bg-slate-700 text-white flex items-center justify-center font-bold shadow-inner">
                        {{ strtoupper(substr(Auth::user()->name, 0, 2)) }}
                    </div>
                </div>
            </header>

            <!-- ISI KONTEN DINAMIS -->
            <main class="p-8 flex-1">
                @yield('content')
            </main>

        </div>
    </div>

</body>

</html>
