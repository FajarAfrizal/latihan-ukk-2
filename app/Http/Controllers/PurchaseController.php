<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Purchase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PurchaseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Purchase::all();
        $product = Product::all();
        return view('purchase.purchase', compact('data', 'product'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('product.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'qty' => 'required|integer|min:1',
            'products.*.product_id' => 'required|exists:products,id',
            'products.*.quantity' => 'required|integer|min:1',
        ]);

        $purchase = Purchase::create([
            'user_id' => Auth::user()->id,
            'total_price' => 0, // Akan diisi setelah menghitung total
            'qty' => $request->qty,
        ]);

        foreach ($request->products as $product) {
            $productModel = Product::find($product['product_id']);
            $subtotal = $product['quantity'] * $productModel->price;

            $purchase->products()->attach($product['product_id'], [
                'quantity' => $product['quantity'],
                'price' => $productModel->price,
            ]);

            $productModel->stock -= $product['quantity']; // Kurangi stok produk
            $productModel->save();

            // Tambahkan operasi lain jika diperlukan, misalnya update statistik, dll.
        }

        $totalPrice = $purchase->products()->sum('price');
        $purchase->update(['total_price' => $totalPrice]);

        return redirect()->route('purchases.index')->with('success', 'Purchase created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Purchase $purchase)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Purchase $purchase)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Purchase $purchase)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Purchase $purchase)
    {
        //
    }
}
