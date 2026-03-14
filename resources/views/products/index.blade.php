<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Inventory Products') }}
            </h2>
            
            @can('product.create')
                <a href="{{ route('products.create') }}" 
                   style="background-color: #2563eb; color: white; padding: 10px 20px; border-radius: 8px; font-weight: bold; transition: 0.3s;"
                   onmouseover="this.style.backgroundColor='#1d4ed8'" onmouseout="this.style.backgroundColor='#2563eb'">
                    + Add Product
                </a>
            @endcan
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="mb-4 p-4 bg-green-100 text-green-700 rounded-lg">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-50 border-b">
                            <th class="px-6 py-4 text-sm font-bold text-gray-700 uppercase">Product Name</th>
                            <th class="px-6 py-4 text-sm font-bold text-gray-700 uppercase">Category</th>
                            <th class="px-6 py-4 text-sm font-bold text-gray-700 uppercase">Price (ETB)</th>
                            <th class="px-6 py-4 text-sm font-bold text-gray-700 uppercase">Quantity</th>
                            <th class="px-6 py-4 text-sm font-bold text-gray-700 text-center uppercase">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse($products as $product)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-6 py-4 font-medium text-gray-900">{{ $product->name }}</td>
                                <td class="px-6 py-4 text-gray-600">
                                    <span class="px-2 py-1 bg-gray-100 text-gray-800 rounded text-xs">
                                        {{ $product->category->name }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-gray-600">{{ number_format($product->price, 2) }}</td>
                                <td class="px-6 py-4 text-gray-600">{{ $product->quantity }}</td>
                                <td class="px-6 py-4">
                                    <div class="flex justify-center items-center gap-6">
                                        
                                        @can('product.edit')
                                            <a href="{{ route('products.edit', $product) }}" class="text-indigo-600 hover:text-indigo-900 font-semibold no-underline">
                                                Edit
                                            </a>
                                        @endcan
                                        
                                        @if(auth()->user()->can('product.edit') && auth()->user()->can('product.delete'))
                                            <span class="text-gray-300">|</span>
                                        @endif

                                        @can('product.delete')
                                            <form action="{{ route('products.destroy', $product) }}" method="POST" onsubmit="return confirm('Delete this product?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-900 font-semibold bg-transparent border-none cursor-pointer">
                                                    Delete
                                                </button>
                                            </form>
                                        @endcan

                                        @if(!auth()->user()->can('product.edit') && !auth()->user()->can('product.delete'))
                                            <span class="text-xs text-gray-400 italic">View Only</span>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-10 text-center text-gray-500 italic">
                                    No products found. Start by adding one!
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>