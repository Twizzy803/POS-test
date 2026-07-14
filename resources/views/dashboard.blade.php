@extends('layouts.app')

@section('content')
<div class="bg-white rounded-xl shadow-sm border border-gray-200 p-8">
    <!-- Ucapan Selamat Datang Menyesuaikan Nama Login -->
    <h1 class="text-3xl font-bold text-gray-800 tracking-tight">
        👋 Selamat Datang Kembali, <span class="text-blue-600">{{ Auth::user()->name }}</span>!
    </h1>
    <p class="text-gray-500 mt-2">
        Aplikasi POS Anda siap digunakan. Silakan pilih menu di sebelah kiri untuk mulai mengelola data atau bertransaksi.
    </p>

    <!-- Baris Info Kartu Ringkas (Dashboard Stats) -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-8">
        <!-- Kartu 1 -->
        <div class="p-6 bg-blue-50 border border-blue-100 rounded-xl flex flex-col justify-between">
            <span class="text-sm font-semibold text-blue-600 uppercase tracking-wider">Hak Akses Anda</span>
            <span class="text-2xl font-bold text-blue-900 mt-2 capitalize">{{ Auth::user()->role }}</span>
        </div>
        
        <!-- Kartu 2 -->
        <div class="p-6 bg-slate-50 border border-slate-100 rounded-xl flex flex-col justify-between">
            <span class="text-sm font-semibold text-slate-600 uppercase tracking-wider">Hari Ini</span>
            <span class="text-2xl font-bold text-slate-900 mt-2">{{ date('d M Y') }}</span>
        </div>
        
        <!-- Kartu 3 -->
        <div class="p-6 bg-green-50 border border-green-100 rounded-xl flex flex-col justify-between">
            <span class="text-sm font-semibold text-green-600 uppercase tracking-wider">Status Sistem</span>
            <span class="text-2xl font-bold text-green-900 mt-2">⚡ Aktif Optimal</span>
        </div>
    </div>
</div>
@endsection