@extends('layouts.app')

@section('content')
    <div class="max-w-2xl space-y-6">
        <div>
            <h1 class="text-2xl font-bold tracking-tight text-slate-900">Ubah Data Produk</h1>
            <p class="text-sm font-normal text-slate-500 mt-1">Perbarui informasi barang jualan yang terdaftar.</p>
        </div>

        <div class="bg-white p-6 rounded-xl shadow-sm border border-slate-200">
            <form action="{{ route('admin.products.update', $product->id) }}" method="POST" class="space-y-4">
                @csrf
                @method('PUT')

                <!-- Kategori -->
                <div>
                    <label for="category_id" class="block text-sm font-medium text-slate-700 mb-1.5">Kategori Produk</label>
                    <select id="category_id" name="category_id" required
                        class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm font-normal bg-white focus:outline-none focus:border-blue-400 focus:ring-4 focus:ring-blue-50 transition">
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}"
                                {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('category_id')
                        <p class="text-xs text-red-600 mt-1.5">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Nama -->
                <div>
                    <label for="name" class="block text-sm font-medium text-slate-700 mb-1.5">Nama Produk</label>
                    <input type="text" id="name" name="name" value="{{ old('name', $product->name) }}" required
                        class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm font-normal focus:outline-none focus:border-blue-400 focus:ring-4 focus:ring-blue-50 transition">
                    @error('name')
                        <p class="text-xs text-red-600 mt-1.5">{{ $message }}</p>
                    @enderror
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <!-- Harga -->
                    <div>
                        <label for="harga" class="block text-sm font-medium text-slate-700 mb-1.5">Harga Jual
                            (Rp)</label>
                        <input type="number" id="harga" name="harga" value="{{ old('harga', $product->harga) }}"
                            required min="0"
                            class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm font-normal focus:outline-none focus:border-blue-400 focus:ring-4 focus:ring-blue-50 transition">
                        @error('harga')
                            <p class="text-xs text-red-600 mt-1.5">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Stok -->
                    <div>
                        <label for="stock" class="block text-sm font-medium text-slate-700 mb-1.5">Jumlah Stok</label>
                        <input type="number" id="stock" name="stock" value="{{ old('stock', $product->stock) }}"
                            required min="0"
                            class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm font-normal focus:outline-none focus:border-blue-400 focus:ring-4 focus:ring-blue-50 transition">
                        @error('stock')
                            <p class="text-xs text-red-600 mt-1.5">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="flex items-center space-x-3 pt-2">
                    <button type="submit"
                        class="bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold py-2.5 px-4 rounded-xl transition shadow-sm">
                        Perbarui Produk
                    </button>
                    <a href="{{ route('admin.products.index') }}"
                        class="border border-slate-200 hover:bg-slate-50 text-slate-700 text-sm font-semibold py-2.5 px-4 rounded-xl transition">
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection
