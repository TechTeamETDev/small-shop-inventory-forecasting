<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Inventory Categories') }}
            </h2>
            
            @can('category.create')
                <a href="{{ route('categories.create') }}" 
                   style="background-color: #2563eb; color: white; padding: 10px 20px; border-radius: 8px; font-weight: bold; transition: 0.3s;"
                   onmouseover="this.style.backgroundColor='#1d4ed8'" onmouseout="this.style.backgroundColor='#2563eb'">
                    + Add Category
                </a>
            @endcan
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            {{-- Added the success message block to match --}}
            @if(session('success'))
                <div class="mb-4 p-4 bg-green-100 text-green-700 rounded-lg">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-50 border-b">
                            <th class="px-6 py-4 text-sm font-bold text-gray-700 uppercase">Category Name</th>
                            <th class="px-6 py-4 text-sm font-bold text-gray-700 uppercase">Description</th>
                            <th class="px-6 py-4 text-sm font-bold text-gray-700 text-center uppercase">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse($categories as $category)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-6 py-4 font-medium text-gray-900">{{ $category->name }}</td>
                                <td class="px-6 py-4 text-gray-600">
                                    {{ $category->description ?? 'No description' }}
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex justify-center items-center gap-6">
                                        @can('category.edit')
                                            <a href="{{ route('categories.edit', $category) }}" class="text-indigo-600 hover:text-indigo-900 font-semibold no-underline">
                                                Edit
                                            </a>
                                        @endcan

                                        @if(auth()->user()->can('category.edit') && auth()->user()->can('category.delete'))
                                            <span class="text-gray-300">|</span>
                                        @endif

                                        @can('category.delete')
                                            <form action="{{ route('categories.destroy', $category) }}" method="POST" onsubmit="return confirm('Delete this category?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-900 font-semibold bg-transparent border-none cursor-pointer">
                                                    Delete
                                                </button>
                                            </form>
                                        @endcan

                                        @if(!auth()->user()->can('category.edit') && !auth()->user()->can('category.delete'))
                                            <span class="text-xs text-gray-400 italic">View Only</span>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="px-6 py-10 text-center text-gray-500 italic">
                                    No categories found. Start by adding one!
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
