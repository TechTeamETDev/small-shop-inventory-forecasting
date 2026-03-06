<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    // Display all products
    public function index()
    {
        $products = Product::all();
        return view('products.index', compact('products'));
    }

    // Show the form to create a new product
    public function create()
    {
        return view('products.create');
    }

    // Store a new product
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:products,name',
            'description' => 'nullable|string',
            'purchase_price' => 'required|numeric',
            'price' => 'required|numeric',
            'quantity' => 'required|integer|min:0',
        ], [
            'name.unique' => 'This product is already registered in the shop. Please use a different name.',
            'name.required' => 'Product name is required.',
        ]);

        Product::create($request->all());

        return redirect()->route('products.index')
            ->with('success', 'Product added successfully!');
    }

    // Show edit form
    public function edit(Product $product)
    {
        return view('products.edit', compact('product'));
    }

    // Update product
    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:products,name,' . $product->id,
            'description' => 'nullable|string',
            'purchase_price' => 'required|numeric',
            'price' => 'required|numeric',
            'quantity' => 'required|integer|min:0',

        ], [
            'name.unique' => 'This product is already registered in the shop. Please use a different name.',
        ]);

        $product->update($request->all());

        return redirect()->route('products.index')
            ->with('success', 'Product updated successfully!');
    }

    // Delete product
    public function destroy(Product $product)
    {
        $product->delete();

        return redirect()->route('products.index')
            ->with('success', 'Product deleted successfully!');
    }
}