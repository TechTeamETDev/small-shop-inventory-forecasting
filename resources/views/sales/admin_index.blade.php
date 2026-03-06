<!-- Font Awesome for icons -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<h2 style="margin-bottom:20px;">Admin Sales List</h2>

<!-- Toolbar with buttons -->
<div style="margin-bottom: 20px; display: flex; gap: 10px;">
    <!-- Log a New Sale -->
    <a href="{{ route('sales.create', ['source' => 'admin']) }}" 
       class="btn btn-success"
       style="width:200px; height:50px; font-weight:bold; font-size:16px; display:flex; align-items:center; justify-content:center;">
       <i class="fa fa-shopping-cart" style="margin-right:8px;"></i> Log a New Sale
    </a>

    <!-- Back to Products -->
    <a href="{{ route('products.index') }}" 
       class="btn btn-primary" 
       style="width:200px; height:50px; font-weight:bold; font-size:16px; display:flex; align-items:center; justify-content:center;">
        <i class="fa fa-box" style="margin-right:8px;"></i> Products List
    </a>
</div>

<!-- Success message -->
@if(session('success'))
    <p style="color:green; font-weight:bold;">{{ session('success') }}</p>
@endif

<!-- Initialize totals -->
@php
    $totalPrice = 0;
    $totalProfit = 0;
@endphp

<!-- Sales Table -->
<table border="1" cellpadding="10" cellspacing="0" style="width:100%; border-collapse:collapse; text-align:center;">
    <thead style="background-color:#f2f2f2;">
        <tr>
            <th>ID</th>
            <th>Product Name</th>
            <th>Quantity Sold</th>
            <th>Daily Price</th>
            <th>Daily Profit</th>
            <th>Sold At</th>
        </tr>
    </thead>
    <tbody>
       @forelse($sales as $sale)
    @php
$product = $sale->product;

$profit = 0;

if ($product) {
    $profit = ($product->price - $product->purchase_price) * $sale->quantity_sold;
}

$totalPrice += $sale->total_price;
$totalProfit += $profit;
@endphp
        <tr>
            <td>{{ $sale->id }}</td>
            <td>{{ $sale->product_name }}</td>
            <td>{{ $sale->quantity_sold }}</td>
            <td>{{ number_format($sale->total_price,2) }}</td>
            <td>{{ number_format($profit,2) }}</td>
            <td>{{ \Carbon\Carbon::parse($sale->created_at)->format('Y-m-d H:i') }}</td>
        </tr>
       @empty
        <tr>
            <td colspan="6" style="text-align:center;">No sales recorded yet.</td>
        </tr>
       @endforelse
    </tbody>
    <tfoot>
        <tr style="background-color:#f9f9f9; font-weight:bold;">
            <td colspan="3" style="text-align:right;">Total:</td>
            <td>{{ number_format($totalPrice, 2) }}</td>
            <td>{{ number_format($totalProfit, 2) }}</td>
            <td></td>
        </tr>
    </tfoot>
</table>