@extends('layouts.app')

@section('content')

<!-- Select2 CSS -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

<div class="container mt-5">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="text-primary">Add Purchase</h2>

        <a href="{{ route('products.index') }}" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> Back to Products
        </a>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">

            <form action="{{ route('purchases.store') }}" method="POST">
                @csrf

                <!-- Product Select with Search -->
                <div class="mb-3">
                    <label class="form-label">Select Product</label>
                    <select name="product_id" id="productSelect" class="form-control" required>
                        <option value="">Search or Select Product</option>

                        @foreach($products as $product)
                            <option value="{{ $product->id }}">
                                {{ $product->name }} (Stock: {{ $product->quantity }})
                            </option>
                        @endforeach

                    </select>
                </div>

                <!-- Quantity -->
                <div class="mb-3">
                    <label class="form-label">Quantity</label>
                    <input type="number" name="quantity" class="form-control" required min="1">
                </div>

                <!-- Buy Price -->
                <div class="mb-3">
                    <label class="form-label">Buy Price</label>
                    <input type="number" name="buy_price" class="form-control" step="0.01" required>
                </div>

                <!-- Total Cost -->
                <div class="mb-3">
                    <label class="form-label">Total Cost</label>
                    <input type="text" id="total_cost" class="form-control" readonly>
                </div>

                <!-- Save Button -->
                <button type="submit" class="btn btn-success">
                    <i class="bi bi-save"></i> Save Purchase
                </button>

            </form>

        </div>
    </div>

</div>

<!-- jQuery -->
<script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>

<!-- Select2 JS -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>

// Activate searchable dropdown
$(document).ready(function() {
    $('#productSelect').select2({
        placeholder: "Search or Select Product",
        allowClear: true,
        width: '100%'
    });
});

// Auto calculate total cost
document.addEventListener("input", function(){

    let quantity = document.querySelector('input[name="quantity"]').value;
    let price = document.querySelector('input[name="buy_price"]').value;

    let total = quantity * price;

    if(!isNaN(total) && total > 0){
        document.getElementById("total_cost").value = total.toFixed(2);
    }else{
        document.getElementById("total_cost").value = "";
    }

});

</script>

@endsection