<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = \App\Models\Product::query()
            ->withSum(['orderItems as sold_count' => function ($q) {
                $q->whereHas('order', fn($oq) => $oq->where('status', 'selesai'));
            }], 'quantity')
            ->orderBy('created_at', 'desc');

        if ($request->search) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        if ($request->stock === 'low') {
            $query->where('stock', '>', 0)->where('stock', '<=', 10);
        } elseif ($request->stock === 'empty') {
            $query->where('stock', 0);
        }

        $products = $query->paginate(12);

        return view('admin.products.index', compact('products'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'        => 'required|string|max:255',
            'price'       => 'required|numeric|min:0',
            'stock'       => 'required|integer|min:0',
            'description' => 'nullable|string',
            'image_url'   => 'nullable|string|max:500',
        ]);

        Product::create([
            'name'        => $request->name,
            'price'       => $request->price,
            'stock'       => $request->stock,
            'description' => $request->description,
            'image_url'   => $request->image_url,
        ]);

        return back()->with('success', 'Produk berhasil ditambahkan!');
    }

    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $request->validate([
            'name'        => 'required|string|max:255',
            'price'       => 'required|numeric|min:0',
            'stock'       => 'required|integer|min:0',
            'description' => 'nullable|string',
            'image_url'   => 'nullable|string|max:500',
        ]);

        $product->update([
            'name'        => $request->name,
            'price'       => $request->price,
            'stock'       => $request->stock,
            'description' => $request->description,
            'image_url'   => $request->image_url,
        ]);

        return back()->with('success', 'Produk berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();

        return back()->with('success', 'Produk berhasil dihapus!');
    }
}
