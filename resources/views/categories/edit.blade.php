<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Category: ') . $category->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-8">
                
                <form action="{{ route('categories.update', $category) }}" method="POST">
                    @csrf
                    @method('PUT') <div class="mb-6">
                        <label class="block text-gray-700 font-bold mb-2">Category Name</label>
                        <input type="text" name="name" value="{{ $category->name }}" 
                               class="w-full border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                    </div>

                    <div class="mb-6">
                        <label class="block text-gray-700 font-bold mb-2">Description</label>
                        <textarea name="description" rows="4" 
                                  class="w-full border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ $category->description }}</textarea>
                    </div>

                    <div class="flex items-center space-x-4">
                        <button type="submit" 
                                style="background-color: #2563eb; color: white; padding: 10px 24px; border-radius: 8px; font-weight: bold; border: none; cursor: pointer;">
                            Update Category
                        </button>
                        <a href="{{ route('categories.index') }}" class="text-gray-600 hover:underline">Cancel</a>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>