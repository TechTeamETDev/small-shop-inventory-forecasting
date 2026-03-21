<?php
namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\LowStockAlert;
use App\Models\AiPrediction;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function __construct()
    {
        // Only require authentication here
        $this->middleware('auth');
    }

    // View products
    public function index()
    {
        $this->authorize('view products'); // check permission dynamically
        $products = Product::with('category')->orderBy('id','desc')->paginate(10);
        $categories = Category::all();
        return view('products.index', compact('products','categories'));
    }

    // Create product
    public function store(Request $request)
    {
        $this->authorize('create products'); // check permission
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'buy_price' => 'required|numeric|min:0',
            'sell_price' => 'required|numeric|min:0',
            'quantity' => 'required|integer|min:0',
            'low_stock_threshold' => 'required|integer|min:0',
        ]);

        $product = Product::create($validated);

        // Low-stock alert
        LowStockAlert::updateOrCreate(
            ['product_id' => $product->id],
            [
                'threshold' => $product->low_stock_threshold,
                'current_stock' => $product->quantity,
                'status' => $product->quantity <= $product->low_stock_threshold ? 'low' : 'ok'
            ]
        );

        // AI prediction placeholder
        AiPrediction::create([
            'product_id' => $product->id,
            'predicted_quantity' => 0,
            'prediction_date' => now()
        ]);

        return response()->json(['success' => 'Product created successfully']);
    }

    // Edit product
    public function edit(Product $product)
    {
        $this->authorize('edit products'); // check permission
        return response()->json($product);
    }

    // Update product
    public function update(Request $request, Product $product)
    {
        $this->authorize('edit products'); // check permission
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'buy_price' => 'required|numeric|min:0',
            'sell_price' => 'required|numeric|min:0',
            'quantity' => 'required|integer|min:0',
            'low_stock_threshold' => 'required|integer|min:0',
        ]);

        $product->update($validated);

        // Update low-stock alert
        LowStockAlert::updateOrCreate(
            ['product_id' => $product->id],
            [
                'threshold' => $product->low_stock_threshold,
                'current_stock' => $product->quantity,
                'status' => $product->quantity <= $product->low_stock_threshold ? 'low' : 'ok'
            ]
        );

        // Update AI prediction placeholder
        AiPrediction::updateOrCreate(
            ['product_id' => $product->id, 'prediction_date' => now()->toDateString()],
            ['predicted_quantity' => 0]
        );

        return response()->json(['success' => 'Product updated successfully']);
    }

    // Delete product
    public function destroy(Product $product)
    {
        $this->authorize('delete products'); // check permission
        $product->delete();

        // Remove related low-stock alerts & AI predictions
        LowStockAlert::where('product_id', $product->id)->delete();
        AiPrediction::where('product_id', $product->id)->delete();

        return response()->json(['success' => 'Product deleted successfully']);
    }
}