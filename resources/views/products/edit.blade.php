<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Product: ') . $product->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-8">
                
                <form action="{{ route('products.update', $product) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-6">
                        <label class="block text-gray-700 font-bold mb-2">Product Name</label>
                        <input type="text" name="name" value="{{ old('name', $product->name) }}" 
                               class="w-full border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                    </div>

                    <div class="mb-6">
                        <label class="block text-gray-700 font-bold mb-2">Category</label>
                        <select name="category_id" class="w-full border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ $product->category_id == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div>
                            <label class="block text-gray-700 font-bold mb-2">Price (ETB)</label>
                            <input type="number" step="0.01" name="price" value="{{ old('price', $product->price) }}" 
                                   class="w-full border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                        </div>

                        <div>
                            <label class="block text-gray-700 font-bold mb-2">Quantity</label>
                            <input type="number" name="quantity" value="{{ old('quantity', $product->quantity) }}" 
                                   class="w-full border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                        </div>
                    </div>

                    <div class="flex items-center space-x-4">
                        <button type="submit" 
                                style="background-color: #2563eb; color: white; padding: 10px 24px; border-radius: 8px; font-weight: bold; border: none; cursor: pointer;">
                            Update Product
                        </button>
                        <a href="{{ route('products.index') }}" class="text-gray-600 hover:underline">Cancel</a>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>