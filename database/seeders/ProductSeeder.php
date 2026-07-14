<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        // Ambil kategori berdasarkan nama untuk mendapatkan ID-nya secara dinamis
        $makanan = Category::where('name', 'Makanan')->first();
        $minuman = Category::where('name', 'Minuman')->first();
        $snack   = Category::where('name', 'Snack')->first();

        // Input data produk contoh terhubung dengan category_id
        Product::create([
            'category_id' => $makanan->id,
            'name'        => 'Nasi Goreng Spesial',
            'harga'       => 15000,
            'stock'       => 50,
        ]);

        Product::create([
            'category_id' => $minuman->id,
            'name'        => 'Es Teh Manis',
            'harga'       => 4000,
            'stock'       => 100,
        ]);

        Product::create([
            'category_id' => $snack->id,
            'name'        => 'Keripik Singkong Pedas',
            'harga'       => 8000,
            'stock'       => 30,
        ]);

        Product::create([
            'category_id' => $minuman->id,
            'name'        => 'Kopi Susu Gula Aren',
            'harga'       => 12000,
            'stock'       => 40,
        ]);
    }
}
