<!-- Font Awesome for icons -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<!-- Log New Sale Button -->
<div style="display:flex; justify-content:center; margin: 40px 0 20px 0;">
<a href="{{ route('sales.create', ['source' => 'employee']) }}" 
   class="btn btn-success"
   style="width:220px; height:50px; font-weight:bold; font-size:18px; display:flex; align-items:center; justify-content:center;">
    <i class="fa fa-shopping-cart" style="margin-right:8px;"></i> Log a New Sale
</a>
</div>

<h2>Sales List</h2> 

@if(session('success'))
    <p style="color:green">{{ session('success') }}</p>
@endif

<table border="1" cellpadding="10" cellspacing="0">
    <thead>
        <tr>
            <th>ID</th>
            <th>Product Name</th>
            <th>Quantity Sold</th>
            <th>Total Price</th>
            <th>Sold At</th>
        </tr>
    </thead>
    <tbody>
      @foreach($sales as $sale)
    <tr>
        <td>{{ $sale->id }}</td>
        <td>{{ $sale->product_name }}</td>
        <td>{{ $sale->quantity_sold }}</td>
        <td>{{ $sale->total_price }}</td>
        <td>{{ \Carbon\Carbon::parse($sale->created_at)->format('Y-m-d H:i') }}</td>
    </tr>
@endforeach
    </tbody>
</table>

<br>