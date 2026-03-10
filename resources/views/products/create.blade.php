@extends('layouts.app')

@section('content')

<!-- Select2 CSS -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

<div class="container mt-5">
    <h2 class="text-primary mb-4">Add Product</h2>

    {{-- Popup error message --}}
    @if ($errors->any())
        <script>
            alert("{{ $errors->first() }}");
        </script>
    @endif

    <form method="POST" action="{{ route('products.store') }}">
        @csrf

        <!-- Product Name -->
        <div class="mb-3">
            <label class="form-label">Name</label>
            <input type="text"
                   name="name"
                   value="{{ old('name') }}"
                   class="form-control"
                   required>
        </div>

        <!-- Category (Search + Select Together) -->
        <div class="mb-3">
            <label class="form-label">Category</label>

            <select name="category_id"
                    id="categorySelect"
                    class="form-control"
                    required>

                <option value="">Search or Select Category</option>

                @foreach($categories as $category)

                    <option value="{{ $category->id }}">
                        {{ $category->name }}
                    </option>

                @endforeach

            </select>
        </div>

        <!-- Quantity -->
        <div class="mb-3">
            <label class="form-label">Quantity</label>

            <input type="number"
                   name="quantity"
                   value="{{ old('quantity') }}"
                   class="form-control"
                   min="0"
                   required>
        </div>

        <!-- Buy Price -->
        <div class="mb-3">
            <label class="form-label">Buy Price</label>

            <input type="number"
                   name="buy_price"
                   value="{{ old('buy_price') }}"
                   class="form-control"
                   step="0.01"
                   min="0"
                   required>
        </div>

        <!-- Sell Price -->
        <div class="mb-3">
            <label class="form-label">Sell Price</label>

            <input type="number"
                   name="sell_price"
                   value="{{ old('sell_price') }}"
                   class="form-control"
                   step="0.01"
                   min="0"
                   required>
        </div>

        <!-- Buttons -->
        <button type="submit" class="btn btn-success">
            Save Product
        </button>

        <a href="{{ route('products.index') }}" class="btn btn-secondary">
            Cancel
        </a>

    </form>
</div>

<!-- jQuery -->
<script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>

<!-- Select2 -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
$(document).ready(function(){

    $('#categorySelect').select2({
        placeholder: "Search or Select Category",
        allowClear: true,
        width: '100%'
    });

});
</script>

@endsection