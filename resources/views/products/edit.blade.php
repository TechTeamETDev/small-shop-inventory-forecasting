@if ($errors->any())    
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<h2 class="mb-4" style="font-size: 2rem;">Edit Product</h2>

<form action="{{ route('products.update', $product->id) }}" method="POST">
    @csrf
    @method('PUT')
    
    <div class="row g-5 mb-5">
        <div class="col-md-5">
            <label for="name" class="form-label fs-5">Product Name</label>
            <input type="text" id="name" name="name" class="form-control form-control-lg mb-3"
                   value="{{ old('name', $product->name) }}" required>
        </div>
<br>
        <div class="col-md-5">
            <label for="description" class="form-label fs-5">Description</label>
            <input type="text" id="description" name="description" class="form-control form-control-lg mb-3"
                   value="{{ old('description', $product->description) }}" required>
        </div>
        <br>

        <div class="col-md-5">
            <label for="purchase_price" class="form-label fs-5">Purchase Price</label>
            <input type="number" step="0.01" id="purchase_price" name="purchase_price"
                   class="form-control form-control-lg mb-3" value="{{ old('purchase_price', $product->purchase_price) }}" required>
        </div>
<br>
        <div class="col-md-5">
            <label for="price" class="form-label fs-5">Selling Price</label>
            <input type="number" step="0.01" id="price" name="price"
                   class="form-control form-control-lg mb-3" value="{{ old('price', $product->price) }}" required>
        </div>
<br>
        <div class="col-md-5">
            <label for="quantity" class="form-label fs-5">Quantity</label>
            <input type="number" id="quantity" name="quantity" class="form-control form-control-lg mb-3"
                   value="{{ old('quantity', $product->quantity) }}" required>
        </div>
    </div>
<br>
    <div class="row mb-5">
        <div class="col-md-12 text-end">
            <button type="submit" class="btn btn-primary btn-lg">Update</button>
        </div>
    </div>
</form>