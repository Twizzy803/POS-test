@extends('layouts.app')

@section('content')
    <div class="space-y-6">
        <!-- Header Halaman -->
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold tracking-tight text-slate-900">Master Produk</h1>
                <p class="text-sm font-normal text-slate-500 mt-1">Kelola data barang jualan, harga, dan pantau ketersediaan
                    stok.</p>
            </div>
            <div class="flex items-center space-x-3">
                <!-- Tombol Tambah (Biru Soft) -->
                <a href="{{ route('admin.products.create') }}"
                    class="bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold py-2.5 px-4 rounded-xl transition duration-200 shadow-sm">
                    ➕ Tambah Produk
                </a>
            </div>
        </div>

        <!-- Alert Sukses -->
        @if (session('success'))
            <div class="bg-blue-50 border border-blue-200 text-blue-700 px-4 py-3 rounded-xl text-sm font-normal">
                {{ session('success') }}
            </div>
        @endif

        <!-- Tabel Data Produk -->
        <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr
                        class="bg-slate-50 border-b border-slate-200 text-slate-700 text-xs font-bold uppercase tracking-wider">
                        <th class="py-4 px-6 w-16 text-center">No</th>
                        <th class="py-4 px-6">Nama Produk</th>
                        <th class="py-4 px-6">Kategori</th>
                        <th class="py-4 px-6 text-right">Harga</th>
                        <th class="py-4 px-6 text-center w-24">Stok</th>
                        <th class="py-4 px-6 w-48 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200 text-sm font-normal text-slate-600">
                    @forelse($products as $index => $product)
                        <tr class="hover:bg-slate-50/50 transition">
                            <td class="py-4 px-6 text-center text-slate-400 font-medium">{{ $index + 1 }}</td>
                            <td class="py-4 px-6 font-medium text-slate-900">{{ $product->name }}</td>
                            <td class="py-4 px-6">
                                <span class="bg-slate-100 text-slate-700 text-xs font-medium px-2.5 py-1 rounded-md">
                                    {{ $product->category->name ?? 'Tanpa Kategori' }}
                                </span>
                            </td>
                            <td class="py-4 px-6 text-right font-medium text-slate-900">Rp
                                {{ number_format($product->harga, 0, ',', '.') }}</td>
                            <td class="py-4 px-6 text-center">
                                <span
                                    class="{{ $product->stock <= 5 ? 'text-red-600 font-bold' : 'text-slate-600 font-medium' }}">
                                    {{ $product->stock }}
                                </span>
                            </td>
                            <td class="py-4 px-6 text-center">
                                <div class="flex items-center justify-center space-x-2">
                                    <a href="{{ route('admin.products.edit', $product->id) }}"
                                        class="border border-slate-200 hover:bg-slate-100 text-slate-700 text-xs font-semibold py-1.5 px-3 rounded-lg transition">
                                        Edit
                                    </a>
                                    <!-- Pemicu Soft Delete -->
                                    <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST"
                                        onsubmit="return confirm('Pindahkan produk ini ke keranjang sampah?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="bg-red-50 hover:bg-red-100 border border-red-200 text-red-600 text-xs font-semibold py-1.5 px-3 rounded-lg transition">
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-8 text-center text-slate-400 font-normal">Belum ada data produk.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
