@extends('layouts.app')

@section('content')
<div class="container mt-5">

    <h2 class="text-primary mb-4">Add Low Stock Alert</h2>

    <!-- Success message -->
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <!-- Validation errors -->
    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('alerts.store') }}">
        @csrf

        <div class="mb-3">
            <label class="form-label">Product</label>
            <select name="product_id" class="form-control" required>
                <option value="">-- Select Product --</option>
                @foreach($products as $product)
                    <option value="{{ $product->id }}" {{ old('product_id') == $product->id ? 'selected' : '' }}>
                        {{ $product->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Alert Quantity</label>
            <input type="number" name="alert_quantity" class="form-control" value="{{ old('alert_quantity') }}" required min="1">
        </div>

        <!-- Buttons -->
        <button type="submit" class="btn btn-danger">Save Alert</button>
        <a href="{{ route('alerts.index') }}" class="btn btn-secondary ms-2">Cancel</a>
    </form>

</div>
@endsection