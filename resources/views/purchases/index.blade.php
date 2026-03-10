<h2>Purchases Dashboard</h2>

<table border="1">
<tr>
<th>ID</th>
<th>Product</th>
<th>Quantity</th>
<th>Buy Price</th>
<th>Total Cost</th>
<th>Purchased By</th>
</tr>

@foreach($purchases as $purchase)

<tr>
<td>{{ $purchase->id }}</td>
<td>{{ $purchase->product->name }}</td>
<td>{{ $purchase->quantity }}</td>
<td>{{ $purchase->buy_price }}</td>
<td>{{ $purchase->total_cost }}</td>
<td>{{ $purchase->user->name }}</td>
</tr>

@endforeach

</table>