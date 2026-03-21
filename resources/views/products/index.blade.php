@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6">

    <h2 class="text-xl font-bold mb-4">Products</h2>

    <button id="createNewProduct" class="bg-blue-600 text-white px-4 py-2 mb-4">➕ Add Product</button>

    <table class="table-auto w-full border">
        <thead class="bg-gray-200">
            <tr>
                <th class="border px-3 py-2">ID</th>
                <th class="border px-3 py-2">Name</th>
                <th class="border px-3 py-2">Category</th>
                <th class="border px-3 py-2">Buy Price</th>
                <th class="border px-3 py-2">Sell Price</th>
                <th class="border px-3 py-2">Quantity</th>
                <th class="border px-3 py-2">Low Stock Threshold</th>
                <th class="border px-3 py-2">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($products as $product)
            <tr id="productRow{{ $product->id }}">
                <td class="border px-3 py-2">{{ $product->id }}</td>
                <td class="border px-3 py-2">{{ $product->name }}</td>
                <td class="border px-3 py-2">{{ $product->category->name ?? 'N/A' }}</td>
                <td class="border px-3 py-2">{{ $product->buy_price }}</td>
                <td class="border px-3 py-2">{{ $product->sell_price }}</td>
                <td class="border px-3 py-2">{{ $product->quantity }}</td>
                <td class="border px-3 py-2">{{ $product->low_stock_threshold }}</td>
                <td class="border px-3 py-2 flex gap-2">
                    <button class="text-yellow-600 editProduct" data-id="{{ $product->id }}">✏ Edit</button>
                    <button class="text-red-600 deleteProduct" data-id="{{ $product->id }}">🗑 Delete</button>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="mt-4">{{ $products->links() }}</div>

    <!-- Product Modal -->
    <div id="productModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
        <div class="bg-white p-6 rounded w-1/2">
            <h3 id="productModalTitle" class="text-lg font-bold mb-4">Add Product</h3>

            <form id="productForm">
                @csrf
                <input type="hidden" id="product_id" name="product_id">

                <div class="mb-3">
                    <label>Name</label>
                    <input type="text" name="name" id="product_name" class="border p-2 w-full" required>
                </div>

                <div class="mb-3">
                    <label>Category</label>
                    <select name="category_id" id="product_category_id" class="border p-2 w-full" required>
                        <option value="">-- Select Category --</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label>Buy Price</label>
                    <input type="number" step="0.01" name="buy_price" id="product_buy_price" class="border p-2 w-full" required>
                </div>

                <div class="mb-3">
                    <label>Sell Price</label>
                    <input type="number" step="0.01" name="sell_price" id="product_sell_price" class="border p-2 w-full" required>
                </div>

                <div class="mb-3">
                    <label>Quantity</label>
                    <input type="number" name="quantity" id="product_quantity" class="border p-2 w-full" required>
                </div>

                <div class="mb-3">
                    <label>Low Stock Threshold</label>
                    <input type="number" name="low_stock_threshold" id="product_low_stock_threshold" class="border p-2 w-full" required>
                </div>

                <div class="flex justify-end gap-2">
                    <button type="button" id="closeProductModal" class="bg-gray-500 text-white px-4 py-2">Cancel</button>
                    <button type="submit" class="bg-blue-600 text-white px-4 py-2">Save</button>
                </div>
            </form>
        </div>
    </div>

</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const modal = document.getElementById('productModal');
    const createBtn = document.getElementById('createNewProduct');
    const closeModal = document.getElementById('closeProductModal');
    const form = document.getElementById('productForm');

    const productFields = {
        id: document.getElementById('product_id'),
        name: document.getElementById('product_name'),
        category: document.getElementById('product_category_id'),
        buy_price: document.getElementById('product_buy_price'),
        sell_price: document.getElementById('product_sell_price'),
        quantity: document.getElementById('product_quantity'),
        low_stock_threshold: document.getElementById('product_low_stock_threshold')
    };

    function openModal(title) {
        document.getElementById('productModalTitle').textContent = title;
        modal.classList.remove('hidden');
    }

    function closeModalFunc() {
        modal.classList.add('hidden');
        form.reset();
        productFields.id.value = '';
    }

    createBtn.addEventListener('click', () => openModal('Add Product'));
    closeModal.addEventListener('click', closeModalFunc);

    // Edit Product
    document.querySelectorAll('.editProduct').forEach(btn => {
        btn.addEventListener('click', function() {
            const id = this.dataset.id;
            fetch(`/products/${id}/edit`)
                .then(res => res.json())
                .then(data => {
                    productFields.id.value = data.id;
                    productFields.name.value = data.name;
                    productFields.category.value = data.category_id;
                    productFields.buy_price.value = data.buy_price;
                    productFields.sell_price.value = data.sell_price;
                    productFields.quantity.value = data.quantity;
                    productFields.low_stock_threshold.value = data.low_stock_threshold;
                    openModal('Edit Product');
                });
        });
    });

    // Delete Product
    document.querySelectorAll('.deleteProduct').forEach(btn => {
        btn.addEventListener('click', function() {
            if (!confirm('Are you sure?')) return;
            const id = this.dataset.id;
            fetch(`/products/${id}`, {
                method: 'DELETE',
                headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Accept': 'application/json'}
            }).then(res => res.json())
            .then(data => {
                alert(data.success);
                document.getElementById(`productRow${id}`).remove();
            });
        });
    });

    // Submit Product Form
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        const id = productFields.id.value;
        const url = id ? `/products/${id}` : '/products';
        const method = id ? 'PUT' : 'POST';

        fetch(url, {
            method: method,
            headers: {'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Accept': 'application/json'},
            body: JSON.stringify({
                name: productFields.name.value,
                category_id: productFields.category.value,
                buy_price: productFields.buy_price.value,
                sell_price: productFields.sell_price.value,
                quantity: productFields.quantity.value,
                low_stock_threshold: productFields.low_stock_threshold.value
            })
        }).then(res => res.json())
        .then(data => {
            if(data.errors) {
                alert(Object.values(data.errors).flat().join('\n'));
            } else {
                location.reload(); // simple reload for now
            }
        });
    });
});
</script>
@endsection