<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\LowStockAlert;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with('category')->get();
        return view('products.index', compact('products'));
    }

    public function create()
    {
        $categories = Category::orderBy('name','ASC')->get();
        return view('products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        // Validation
        $request->validate([
            'name' => 'required|string|max:255|unique:products,name',
            'category_id' => 'required|exists:categories,id',
            'quantity' => 'required|integer|min:0',
            'buy_price' => 'required|numeric|min:0',
            'sell_price' => 'required|numeric|min:0'
        ],[
            'name.unique' => 'This product name already exists. Please use another name.'
        ]);

        // Create Product
        $product = Product::create([
            'name' => $request->name,
            'category_id' => $request->category_id,
            'quantity' => $request->quantity,
            'buy_price' => $request->buy_price,
            'sell_price' => $request->sell_price
        ]);

        // Low Stock Alert
        if ($product->quantity < 10) {
            LowStockAlert::create([
                'product_id' => $product->id,
                'alert_quantity' => 10,
                'alert_flag' => true
            ]);
        }

        return redirect()->route('products.index')
            ->with('success','Product added successfully.');
    }

    public function edit($id)
    {
        $product = Product::findOrFail($id);
        $categories = Category::orderBy('name','ASC')->get();

        return view('products.edit', compact('product','categories'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:products,name,'.$id,
            'category_id' => 'required|exists:categories,id',
            'quantity' => 'required|integer|min:0',
            'buy_price' => 'required|numeric|min:0',
            'sell_price' => 'required|numeric|min:0'
        ],[
            'name.unique' => 'This product name already exists.'
        ]);

        $product = Product::findOrFail($id);

        $product->update([
            'name' => $request->name,
            'category_id' => $request->category_id,
            'quantity' => $request->quantity,
            'buy_price' => $request->buy_price,
            'sell_price' => $request->sell_price
        ]);

        // Low Stock Alert
        if ($product->quantity < 10) {
            LowStockAlert::firstOrCreate([
                'product_id' => $product->id
            ],[
                'alert_quantity' => 10,
                'alert_flag' => true
            ]);
        }

        return redirect()->route('products.index')
            ->with('success','Product updated successfully.');
    }

    public function destroy($id)
    {
        Product::destroy($id);

        return redirect()->route('products.index')
            ->with('success','Product deleted successfully.');
    }
}