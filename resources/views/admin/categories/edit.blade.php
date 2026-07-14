@extends('layouts.app')

@section('content')
<div class="max-w-xl space-y-6">
    <!-- Header -->
    <div>
        <h1 class="text-2xl font-bold tracking-tight text-slate-900">Ubah Kategori</h1>
        <p class="text-sm font-normal text-slate-500 mt-1">Perbarui nama kategori produk yang sudah ada.</p>
    </div>

    <!-- Form -->
    <div class="bg-white p-6 rounded-xl shadow-sm border border-slate-200">
        <form action="{{ route('admin.categories.update', $category->id) }}" method="POST" class="space-y-4">
            @csrf
            @method('PUT')

            <div>
                <label for="name" class="block text-sm font-medium text-slate-700 mb-1.5">Nama Kategori</label>
                <input type="text" id="name" name="name" value="{{ old('name', $category->name) }}"
                    class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm font-normal bg-white focus:outline-none focus:border-blue-400 focus:ring-4 focus:ring-blue-50 transition"
                    required autofocus>
                
                @error('name')
                    <p class="text-xs text-red-600 mt-1.5 font-normal">{{ $message }}</p>
                @enderror
            </div>

            <!-- Buttons -->
            <div class="flex items-center space-x-3 pt-2">
                <button type="submit" 
                    class="bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold py-2.5 px-4 rounded-xl transition shadow-sm">
                    Perbarui Kategori
                </button>
                <a href="{{ route('admin.categories.index') }}" 
                    class="border border-slate-200 hover:bg-slate-50 text-slate-700 text-sm font-semibold py-2.5 px-4 rounded-xl transition">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>
@endsection