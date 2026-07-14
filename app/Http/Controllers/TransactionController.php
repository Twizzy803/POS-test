<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TransactionController extends Controller
{
    public function create()
    {
        $products = Product::where('stock', '>', 0)->latest()->get();
        return view('kasir.order', compact('products'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'bayar'     => 'required|numeric|min:0',
            'items'     => 'required|array|min:1',
            'items.*.product_id'    => 'required|exists:products,id',
            'items.*.qty'   => 'required|numeric|min:1',
        ]);

        DB::beginTransaction();
        try {
            $totalHarga = 0;
            $itemsToInsert = [];

            foreach ($request->items as $item) {
                $product = Product::findOrFail($item['product_id']);

                if ($product->stock < $item['qty']) {
                    return back()->withErrors(['error' => "Stok {$product->name} tidak mencukupi"]);
                }
                $subtotal = $product->harga * $item['qty'];
                $totalHarga += $subtotal;

                $itemsToInsert[] = [
                    'product_id'    => $product->id,
                    'qty'           => $item['qty'],
                    'harga'         => $product->harga,
                    'subtotal'      => $subtotal,
                ];
            }
            if ($request->bayar < $totalHarga) {
                return back()->withErrors(['error' => 'Uang pembayaran kurang!!']);
            }
            $transaction = Transaction::create([
                'invoice_number'    => 'INV-' . strtoupper(uniqid()),
                'total_harga'       => $totalHarga,
                'bayar'             => $request->bayar,
                'kembalian'         => $request->bayar - $totalHarga,
            ]);
            foreach ($itemsToInsert as $item) {
                $item['transaction_id'] = $transaction->id;
                TransactionDetail::create($item);

                Product::where('id', $item['product_id'])->decrement('stock', $item['qty']);
            }

            DB::commit();
            return redirect()->route('kasir.order')->with('success', 'Transaksi berhasil');
        } catch (\Exception $e) {
            DB::rollback();
            return back()->withErrors(['error' => 'Sistem error!!' . $e->getMessage()]);
        }
    }

    public function history()
    {
        $transactions = Transaction::latest()->get();
        return view('kasir.history', compact('transactions'));
    }
}
