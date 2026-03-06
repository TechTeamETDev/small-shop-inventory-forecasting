@if ($errors->any())
    <div style="background-color: #f8d7da; color: #842029; padding: 10px; border-radius: 5px; margin-bottom: 15px;">
        <ul style="margin: 0; padding-left: 20px;">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<h2>Add Product</h2>

<form action="{{ route('products.store') }}" method="POST">
    @csrf

    <input type="text" name="name" placeholder="Product Name"
           value="{{ old('name') }}"
           style="@error('name') border:1px solid red; @enderror">
    <br><br>

    <input type="text" name="description" placeholder="Description"
           value="{{ old('description') }}">
    <br><br>
    <input type="number" step="0.01" name="purchase_price" placeholder="Purchase Price"
       value="{{ old('purchase_price') }}">
    <br><br>

    <input type="number" name="price" placeholder="Price"
           value="{{ old('price') }}">
    <br><br>

    <input type="number" name="quantity" placeholder="Quantity"
           value="{{ old('quantity') }}">
    <br><br>

    <button type="submit">Save</button>
</form>