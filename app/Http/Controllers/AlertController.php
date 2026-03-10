<?php

namespace App\Http\Controllers;

use App\Models\LowStockAlert;
use App\Models\Product;
use Illuminate\Http\Request;

class AlertController extends Controller
{
    /**
     * Display a listing of low stock products.
     */
    public function index()
    {
        // Fetch only alerts where product quantity <= alert quantity
        $alerts = LowStockAlert::with('product')
            ->whereHas('product', function($query) {
                $query->whereColumn('quantity', '<=', 'low_stock_alerts.alert_quantity');
            })
            ->get();

        return view('alerts.index', compact('alerts'));
    }

    /**
     * Show the form for creating a new low stock alert.
     */
    public function create()
    {
        $products = Product::all(); // Fetch all products for selection
        return view('alerts.create', compact('products'));
    }

    /**
     * Store a newly created low stock alert in storage.
     */
public function store(Request $request)
{
    // Validate input
    $request->validate([
        'product_id' => 'required|exists:products,id',
        'alert_quantity' => 'required|integer|min:1',
    ], [
        'product_id.required' => 'Please select a product',
        'alert_quantity.required' => 'Please enter the alert quantity',
    ]);

    // Update or create alert
    $alert = LowStockAlert::updateOrCreate(
        ['product_id' => $request->product_id],
        [
            'alert_quantity' => $request->alert_quantity,
            'alert_flag' => true
        ]
    );

    // Redirect to alerts index after saving
    return redirect()->route('alerts.index')->with('success', 'Low Stock Alert saved successfully.');
}
}