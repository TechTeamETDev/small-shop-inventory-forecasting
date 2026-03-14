<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Product</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-10">
    <div class="max-w-2xl mx-auto bg-white p-8 rounded-lg shadow-md">
        <h2 class="text-2xl font-bold mb-6 text-gray-800 border-b pb-4">Add New Product</h2>
        
        <form action="{{ route('products.store') }}" method="POST">
            @csrf
            
            <div class="mb-4">
                <label class="block text-gray-700 font-bold mb-2">Product Name</label>
                <input type="text" name="name" class="w-full border border-gray-300 p-2 rounded" placeholder="e.g. Coca Cola" required>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 font-bold mb-2">Category</label>
                <select name="category_id" class="w-full border border-gray-300 p-2 rounded" required>
                    <option value="">-- Select Category --</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="grid grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="block text-gray-700 font-bold mb-2">Price (ETB)</label>
                    <input type="number" step="0.01" name="price" class="w-full border border-gray-300 p-2 rounded" required>
                </div>
                <div>
                    <label class="block text-gray-700 font-bold mb-2">Quantity</label>
                    <input type="number" name="quantity" class="w-full border border-gray-300 p-2 rounded" required>
                </div>
            </div>

            <button type="submit" style="background-color: #2563eb; color: white; padding: 12px 24px; border-radius: 6px; font-weight: bold; width: 100%;">
                Save Product
            </button>
            
            <div class="mt-4 text-center">
                <a href="{{ route('products.index') }}" class="text-blue-500 hover:underline">Back to List</a>
            </div>
        </form>
    </div>
</body>
</html>