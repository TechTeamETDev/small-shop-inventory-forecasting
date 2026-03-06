<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
@extends('layouts.app')

@section('content')



<h2>Products</h2>

<div style="display:flex; gap:10px; margin-bottom:20px;">
    
    <a href="{{ route('products.create') }}" class="btn btn-primary toolbar-btn">
        <i class="fa fa-plus"></i> Add Product
    </a>

    <a href="{{ route('sales.admin') }}" class="btn btn-primary toolbar-btn">
        <i class="fa fa-chart-line"></i> Admin Sales List
    </a>
    <style>
.toolbar-btn{
    width:180px;
    text-align:center;
}
</style>

</div>

@foreach($products as $product)
    <p>
        {{ $loop->iteration }}.
        {{ $product->name }} - {{ $product->price }} - Stock: {{ $product->quantity }}
        <!-- Edit button -->
        <a href="{{ route('products.edit', $product->id) }}" class="btn btn-warning btn-sm">Edit</a>

        <form action="{{ route('products.destroy', $product->id) }}" method="POST" style="display:inline;">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger btn-sm">Delete</button>
        </form>
    </p>
@endforeach

@endsection