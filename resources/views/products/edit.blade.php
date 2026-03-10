@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h2 class="text-primary mb-4">Edit Product</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('products.update', $product->id) }}">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="name" class="form-label">Name</label>
            <input type="text" name="name" id="name" value="{{ $product->name }}" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="category_id" class="form-label">Category</label>
            <select name="category_id" id="category_id" class="form-select" required>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ $product->category_id == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="quantity" class="form-label">Quantity</label>
            <input type="number" name="quantity" id="quantity" value="{{ $product->quantity }}" class="form-control" min="0" required>
        </div>

        <div class="mb-3">
            <label for="buy_price" class="form-label">Buy Price</label>
            <input type="number" name="buy_price" id="buy_price" value="{{ $product->buy_price }}" class="form-control" step="0.01" min="0" required>
        </div>

        <div class="mb-3">
            <label for="sell_price" class="form-label">Sell Price</label>
            <input type="number" name="sell_price" id="sell_price" value="{{ $product->sell_price }}" class="form-control" step="0.01" min="0" required>
        </div>

        <button type="submit" class="btn btn-primary">Update Product</button>
        <a href="{{ route('products.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection