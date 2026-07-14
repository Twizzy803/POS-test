@extends('layouts.app')

@section('content')
    <div class="max-w-2xl space-y-6">
        <div>
            <h1 class="text-2xl font-bold tracking-tight text-slate-900">Tambah Produk Baru</h1>
            <p class="text-sm font-normal text-slate-500 mt-1">Masukkan detail informasi produk jualan Anda.</p>
        </div>

        <div class="bg-white p-6 rounded-xl shadow-sm border border-slate-200">
            <form action="{{ route('admin.products.store') }}" method="POST" class="space-y-4">
                @csrf

                <!-- Pilihan Kategori -->
                <div>
                    <label for="category_id" class="block text-sm font-medium text-slate-700 mb-1.5">Kategori Produk</label>
                    <select id="category_id" name="category_id" required
                        class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm font-normal bg-white focus:outline-none focus:border-blue-400 focus:ring-4 focus:ring-blue-50 transition">
                        <option value="">-- Pilih Kategori --</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('category_id')
                        <p class="text-xs text-red-600 mt-1.5">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Nama Produk -->
                <div>
                    <label for="name" class="block text-sm font-medium text-slate-700 mb-1.5">Nama Produk</label>
                    <input type="text" id="name" name="name" value="{{ old('name') }}" required
                        class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm font-normal focus:outline-none focus:border-blue-400 focus:ring-4 focus:ring-blue-50 transition"
                        placeholder="Contoh: Kopi Hitam Toraja">
                    @error('name')
                        <p class="text-xs text-red-600 mt-1.5">{{ $message }}</p>
                    @enderror
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <!-- Harga -->
                    <div>
                        <label for="harga" class="block text-sm font-medium text-slate-700 mb-1.5">Harga Jual
                            (Rp)</label>
                        <input type="number" id="harga" name="harga" value="{{ old('harga') }}" required
                            min="0"
                            class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm font-normal focus:outline-none focus:border-blue-400 focus:ring-4 focus:ring-blue-50 transition"
                            placeholder="0">
                        @error('harga')
                            <p class="text-xs text-red-600 mt-1.5">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Stok -->
                    <div>
                        <label for="stock" class="block text-sm font-medium text-slate-700 mb-1.5">Jumlah Stok
                            Awal</label>
                        <input type="number" id="stock" name="stock" value="{{ old('stock') }}" required
                            min="0"
                            class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm font-normal focus:outline-none focus:border-blue-400 focus:ring-4 focus:ring-blue-50 transition"
                            placeholder="0">
                        @error('stock')
                            <p class="text-xs text-red-600 mt-1.5">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Tombol Aksi -->
                <div class="flex items-center space-x-3 pt-2">
                    <button type="submit"
                        class="bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold py-2.5 px-4 rounded-xl transition shadow-sm">
                        Simpan Produk
                    </button>
                    <a href="{{ route('admin.products.index') }}"
                        class="border border-slate-200 hover:bg-slate-50 text-slate-700 text-sm font-semibold py-2.5 px-4 rounded-xl transition">
                        Kembali
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection
