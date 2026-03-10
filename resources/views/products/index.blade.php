@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="text-primary">Products Dashboard</h2>
        <div>
    <a href="{{ route('products.create') }}" class="btn btn-success me-2">
        <i class="bi bi-plus-circle"></i> Add Product
    </a>

    <a href="{{ route('categories.create') }}" class="btn btn-info me-2">
        <i class="bi bi-folder-plus"></i> Add Category
    </a>

    <a href="{{ route('purchases.create') }}" class="btn btn-secondary me-2">
        <i class="bi bi-cart-plus"></i> Add Purchase
    </a>

    <a href="{{ route('alerts.index') }}" class="btn btn-warning text-dark">
        <i class="bi bi-exclamation-triangle-fill"></i> Low Stock Alerts
    </a>
</div>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            @if($products->isEmpty())
                <p class="text-muted">No products available.</p>
            @else
                <div class="table-responsive">
                    <table class="table table-striped table-hover align-middle">
                        <thead class="table-dark">
                            <tr>
                                <th>Name</th>
                                <th>Category</th>
                                <th>Quantity</th>
                                <th>Buy Price</th>
                                <th>Sell Price</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($products as $product)
                            <tr>
                                <td>{{ $product->name }}</td>
                                <td>{{ $product->category->name }}</td>
                                <td>{{ $product->quantity }}</td>
                                <td>ETB {{ number_format($product->buy_price,2) }}</td>
                                <td>ETB {{ number_format($product->sell_price,2) }}</td>
                                <td>
                                    <a href="{{ route('products.edit', $product->id) }}" class="btn btn-sm btn-primary mb-1">
                                        <i class="bi bi-pencil-square"></i> Edit
                                    </a>
                                    <form action="{{ route('products.destroy', $product->id) }}" method="POST" class="d-inline-block">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger mb-1" onclick="return confirm('Are you sure you want to delete this product?');">
                                            <i class="bi bi-trash"></i> Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection