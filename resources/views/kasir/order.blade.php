@extends('layouts.app')

@section('content')
<div class="space-y-6" x-data="posSystem()">
    
    <!-- Header Halaman Kasir -->
    <div>
        <h1 class="text-2xl font-bold tracking-tight text-slate-900">Mesin Order POS</h1>
        <p class="text-sm font-normal text-slate-500 mt-1">Pilih produk di sebelah kiri untuk dimasukkan ke dalam keranjang belanja.</p>
    </div>

    <!-- Alert Notifikasi Sukses / Gagal -->
    @if(session('success'))
        <div class="bg-blue-50 border border-blue-200 text-blue-700 px-4 py-3 rounded-xl text-sm font-normal">
            {{ session('success') }}
        </div>
    @endif
    @if($errors->any())
        <div class="bg-red-50 border border-red-200 text-red-600 px-4 py-3 rounded-xl text-sm font-normal">
            {{ $errors->first() }}
        </div>
    @endif

    <!-- Layout Dua Kolom -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">
        
        <!-- KOLOM KIRI: Daftar Produk yang Tersedia (6 Kolom) -->
        <div class="lg:col-span-7 space-y-4">
            <div class="bg-white p-4 rounded-xl shadow-sm border border-slate-200">
                <h2 class="text-sm font-bold text-slate-700 uppercase tracking-wider mb-4">Daftar Produk Aktif</h2>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    @foreach($products as $product)
                        <!-- Card Produk -->
                        <!-- Baris di bawah ini memicu fungsi addToCart() Alpine.js saat diklik -->
                        <div @click="addToCart({{ $product->id }}, '{{ $product->name }}', {{ $product->harga }}, {{ $product->stock }})"
                             class="p-4 bg-slate-50 hover:bg-blue-50/50 border border-slate-200 hover:border-blue-300 rounded-xl cursor-pointer transition flex flex-col justify-between space-y-3">
                            <div>
                                <h3 class="font-semibold text-slate-900 text-sm">{{ $product->name }}</h3>
                                <p class="text-xs text-slate-400 mt-0.5">{{ $product->category->name ?? 'Tanpa Kategori' }}</p>
                            </div>
                            <div class="flex items-center justify-between pt-2 border-t border-slate-200/60">
                                <span class="text-sm font-bold text-blue-600">Rp {{ number_format($product->harga, 0, ',', '.') }}</span>
                                
                                <!-- REALTIME STOCK SCREEN: Angka stok di layar berkurang dinamis lewat Alpine -->
                                <span class="text-xs font-medium text-slate-500">
                                    Stok: <span class="font-bold text-slate-700" x-text="getLiveStock({{ $product->id }}, {{ $product->stock }})"></span>
                                </span>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- KOLOM KANAN: Struk & Pembayaran (5 Kolom) -->
        <div class="lg:col-span-5">
            <form action="{{ url('/kasir/order') }}" method="POST" class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
                @csrf
                
                <div class="p-4 bg-slate-50 border-b border-slate-200">
                    <h2 class="text-sm font-bold text-slate-700 uppercase tracking-wider">Struk Belanja Kasir</h2>
                </div>

                <!-- Daftar Item Keranjang Belanja -->
                <div class="p-4 divide-y divide-slate-100 max-h-64 overflow-y-auto bg-white">
                    <template x-if="cart.length === 0">
                        <p class="text-center text-slate-400 text-sm py-8 font-normal">Keranjang masih kosong.</p>
                    </template>

                    <template x-for="(item, index) in cart" :key="item.product_id">
                        <div class="py-3 flex items-center justify-between space-x-2">
                            <div class="flex-1">
                                <h4 class="text-sm font-medium text-slate-900" x-text="item.name"></h4>
                                <p class="text-xs text-slate-400 mt-0.5" x-text="'Rp ' + formatNumber(item.harga)"></p>
                                
                                <!-- Input Hidden untuk dikirim ke Laravel Backend (Array data items) -->
                                <input type="hidden" :name="`items[${index}][product_id]`" :value="item.product_id">
                            </div>
                            
                            <!-- Kontrol Jumlah (Qty) -->
                            <div class="flex items-center space-x-2">
                                <button type="button" @click="decreaseQty(index)" class="px-2 py-0.5 border border-slate-200 rounded hover:bg-slate-100 text-xs font-bold text-slate-600">-</button>
                                <input type="number" :name="`items[${index}][qty]`" x-model.number="item.qty" @input="validateQty(index)" class="w-12 text-center border border-slate-200 rounded p-0.5 text-xs font-semibold focus:outline-none" min="1">
                                <button type="button" @click="increaseQty(index)" class="px-2 py-0.5 border border-slate-200 rounded hover:bg-slate-100 text-xs font-bold text-slate-600">+</button>
                            </div>

                            <!-- Subtotal Item -->
                            <div class="text-right pl-2 w-24">
                                <span class="text-xs font-semibold text-slate-900" x-text="'Rp ' + formatNumber(item.harga * item.qty)"></span>
                            </div>
                        </div>
                    </template>
                </div>

                <!-- Panel Ringkasan Total & Pembayaran -->
                <div class="p-4 bg-slate-50 border-t border-slate-200 space-y-4">
                    
                    <!-- REALTIME TOTAL -->
                    <div class="flex items-center justify-between">
                        <span class="text-sm font-medium text-slate-600">Total Harga:</span>
                        <span class="text-xl font-bold text-slate-900" x-text="'Rp ' + formatNumber(getTotalharga())"></span>
                    </div>

                    <!-- Input Pembayaran -->
                    <div>
                        <label for="bayar" class="block text-xs font-semibold text-slate-600 uppercase mb-1">Uang Bayar (Rp)</label>
                        <input type="number" id="bayar" name="bayar" x-model.number="bayar" required min="0"
                            class="w-full px-3 py-2 rounded-xl border border-slate-200 text-sm font-normal bg-white focus:outline-none focus:border-blue-400 focus:ring-4 focus:ring-blue-50 transition" placeholder="0">
                    </div>

                    <!-- REALTIME KEMBALIAN -->
                    <div class="flex items-center justify-between pt-2 border-t border-slate-200/60">
                        <span class="text-xs font-medium text-slate-500">Kembalian:</span>
                        <span class="text-sm font-bold" :class="getReturnAmount() >= 0 ? 'text-green-600' : 'text-red-500'" x-text="'Rp ' + formatNumber(getReturnAmount())"></span>
                    </div>

                    <!-- Tombol Eksekusi Simpan Struk -->
                    <button type="submit" :disabled="cart.length === 0 || getReturnAmount() < 0"
                        class="w-full bg-blue-600 hover:bg-blue-700 disabled:bg-slate-300 text-white font-semibold py-2.5 px-4 rounded-xl transition text-sm shadow-sm">
                        💾 Simpan Transaksi
                    </button>
                </div>
            </form>
        </div>

    </div>
</div>

<!-- ================= SCRIPTS LOGIKA ALPINE.JS LOKAL ================= -->
<script>
    function posSystem() {
        return {
            cart: [],
            bayar: 0,

            // 1. Tambah Produk ke Keranjang Belanja
            addToCart(id, name, harga, maxStock) {
                let found = this.cart.find(item => item.product_id === id);
                if (found) {
                    if (found.qty < maxStock) {
                        found.qty++;
                    }
                } else {
                    if (maxStock > 0) {
                        this.cart.push({
                            product_id: id,
                            name: name,
                            harga: harga,
                            qty: 1,
                            max_stock: maxStock
                        });
                    }
                }
            },

            // 2. Kontrol Tombol Plus & Minus
            increaseQty(index) {
                if (this.cart[index].qty < this.cart[index].max_stock) {
                    this.cart[index].qty++;
                }
            },
            decreaseQty(index) {
                if (this.cart[index].qty > 1) {
                    this.cart[index].qty--;
                } else {
                    this.cart.splice(index, 1); // Hapus dari array jika qty menjadi 0
                }
            },

            // 3. Validasi Manual Ketika Kasir Mengetik Angka di Input Qty
            validateQty(index) {
                let item = this.cart[index];
                if (item.qty > item.max_stock) item.qty = item.max_stock;
                if (item.qty < 1 || isNaN(item.qty)) item.qty = 1;
            },

            // 4. Hitung TOTAL Belanja Keseluruhan
            getTotalharga() {
                return this.cart.reduce((sum, item) => sum + (item.harga * item.qty), 0);
            },

            // 5. Hitung KEMBALIAN Uang Secara Otomatis
            getReturnAmount() {
                if (this.bayar === 0 || !this.bayar) return 0;
                return this.bayar - this.getTotalharga();
            },

            // 6. LOGIKA PENGURANGAN STOK REALTIME DI LAYAR
            getLiveStock(productId, stockAsli) {
                let item = this.cart.find(i => i.product_id === productId);
                if (item) {
                    return stockAsli - item.qty; // Stok asli dikurangi qty yang ada di keranjang belanja
                }
                return stockAsli;
            },

            // Helper format mata uang rupiah di Javascript
            formatNumber(num) {
                return new Intl.NumberFormat('id-ID').format(num);
            }
        }
    }
</script>
@endsection