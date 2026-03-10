<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Purchase;
use App\Models\Product;
use App\Models\LowStockAlert;

class PurchaseController extends Controller
{
    //
public function store(Request $request)
{
    $request->validate([
        'product_id' => 'required|exists:products,id',
        'quantity' => 'required|integer|min:1',
        'buy_price' => 'required|numeric'
    ]);

    $product = Product::findOrFail($request->product_id);

    $totalCost = $request->quantity * $request->buy_price;

    Purchase::create([
        'product_id' => $request->product_id,
        'quantity' => $request->quantity,
        'buy_price' => $request->buy_price,
        'total_cost' => $totalCost,
        'purchased_by' => auth()->id() ?? 1,
    ]);

    // update stock
    $product->quantity += $request->quantity;
    $product->save();

    // CHECK LOW STOCK ALERT
    $alert = LowStockAlert::where('product_id',$product->id)->first();

    if($alert){

        if($product->quantity > $alert->alert_quantity){
            $alert->alert_flag = false;
            $alert->save();
        }
    }

    return redirect()->back()->with('success', 'Purchase recorded successfully');
}
public function index()
{
    $purchases = Purchase::with('product','user')->latest()->get();

    return view('purchases.index', compact('purchases'));
}
public function create()
{
    $products = Product::orderBy('name', 'ASC')->get();

    return view('purchases.create', compact('products'));
}
}
