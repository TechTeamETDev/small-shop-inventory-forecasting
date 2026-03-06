<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Sale;

class SaleController extends Controller
{
    // Employee dashboard sales list
    public function index()
    {
        $sales = Sale::all(); // fetch fresh data
        return view('sales.index', compact('sales'));
    }

    // Admin dashboard sales list
    public function adminSales()
    {
        $sales = Sale::with('product')->get(); // fetch fresh data
        return view('sales.admin_index', compact('sales'));
    }

    // Show form to log a new sale
    public function create(Request $request)
    {
        $products = Product::all();
        $source = $request->source ?? null;
        return view('sales.create', compact('products','source'));
    }

    // Log a new sale
public function store(Request $request)
{
    $request->validate([
        'product_id' => 'required|array',
        'quantity_sold' => 'required|array',
    ]);

    foreach ($request->product_id as $id) {

        $quantity = $request->quantity_sold[$id] ?? 1;

        $product = Product::findOrFail($id);

        if ($product->quantity < $quantity) {
            return back()->with('error', 'Not enough stock for ' . $product->name);
        }

     $profit = ($product->price - $product->purchase_price) * $quantity;

Sale::create([
    'product_id' => $product->id,
    'product_name' => $product->name,
    'quantity_sold' => $quantity,
    'total_price' => $product->price * $quantity,
    'profit' => $profit,
]);

        $product->quantity -= $quantity;
        $product->save();
    }

    if ($request->source === 'admin') {
        return redirect()->route('sales.admin')->with('success', 'Sale recorded successfully.');
    } else {
        return redirect()->route('sales.index')->with('success', 'Sale recorded successfully.');
    }
}
}