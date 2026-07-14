@extends('layouts.app')

@section('content')
    <div class="space-y-6">
        <!-- Header Halaman -->
        <div>
            <h1 class="text-2xl font-bold tracking-tight text-slate-900">Riwayat Transaksi</h1>
            <p class="text-sm font-normal text-slate-500 mt-1">Pantau semua data penjualan dan struk yang telah berhasil
                disimpan.</p>
        </div>

        <!-- Tabel Riwayat Transaksi -->
        <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr
                        class="bg-slate-50 border-b border-slate-200 text-slate-700 text-xs font-bold uppercase tracking-wider">
                        <th class="py-4 px-6 w-16 text-center">No</th>
                        <th class="py-4 px-6">Nomor Invoice</th>
                        <th class="py-4 px-6">Tanggal & Waktu</th>
                        <th class="py-4 px-6 text-right">Total Harga</th>
                        <th class="py-4 px-6 text-right">Uang Bayar</th>
                        <th class="py-4 px-6 text-right">Kembalian</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200 text-sm font-normal text-slate-600">
                    @forelse($transactions as $index => $transaction)
                        <tr class="hover:bg-slate-50/50 transition">
                            <td class="py-4 px-6 text-center text-slate-400 font-medium">{{ $index + 1 }}</td>
                            <td class="py-4 px-6">
                                <span
                                    class="font-mono font-bold text-slate-900 tracking-wide bg-slate-100 px-2.5 py-1 rounded-md text-xs border border-slate-200/60">
                                    {{ $transaction->invoice_number }}
                                </span>
                            </td>
                            <td class="py-4 px-6 text-slate-500">
                                {{ $transaction->created_at->translatedFormat('d M Y, H:i') }} WIB
                            </td>
                            <td class="py-4 px-6 text-right font-semibold text-slate-900">
                                Rp {{ number_format($transaction->total_harga, 0, ',', '.') }}
                            </td>
                            <td class="py-4 px-6 text-right text-slate-600 font-medium">
                                Rp {{ number_format($transaction->bayar, 0, ',', '.') }}
                            </td>
                            <td class="py-4 px-6 text-right font-semibold text-green-600">
                                Rp {{ number_format($transaction->kembalian, 0, ',', '.') }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-12 text-center text-slate-400 font-normal">
                                <div class="text-3xl mb-2">📜</div>
                                Belum ada riwayat transaksi yang tercatat.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
