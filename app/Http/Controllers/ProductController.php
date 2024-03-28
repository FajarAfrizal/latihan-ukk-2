<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Product::latest()->get();
        return view('product.product', compact('data'));
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
            'name' => 'required',
            'price' => 'required',
            'stock' => 'required',
        ]);

        Product::create([
            'name' => $request->name,
            'price' => preg_replace('/[Rp. ]/','',$request->price),
            'stock' => $request->stock
        ]);

        return redirect()->route('pageProduct');
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product, $id)
    {
        $data = Product::where('id', $id)->first();
        return view('product.edit', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product, $id)
    {
        $request->validate([
            'name' => 'required',
            'price' => 'required',
        ]);

        Product::where('id', $id)->update([
            'name' => $request->name,
            'price' => $request->price,
        ]);

        return redirect()->route('pageProduct');
    }

    public function pageStock($id)
    {
        $data = Product::where('id', $id)->first();
        return view('product.stock', compact('data'));
    }
    public function updateStock(Request $request, Product $product, $id)
    {
        $request->validate([
            'stock' => 'required',
        ]);

        $product = Product::findOrFail($id);
        $product->increment('stock', $request->stock);

        return redirect()->route('pageProduct');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product, $id)
    {
        Product::findOrFail($id)->delete();
        return redirect()->route('pageProduct');
    }
}
