@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6">

    <h2 class="text-xl font-bold mb-4">Categories</h2>

    <!-- Add Category Button -->
    <button id="createNewCategory" class="bg-blue-600 text-white px-4 py-2 mb-4">➕ Add Category</button>

    <!-- Categories Table -->
    <table class="table-auto w-full border">
        <thead class="bg-gray-200">
            <tr>
                <th class="border px-3 py-2">ID</th>
                <th class="border px-3 py-2">Name</th>
                <th class="border px-3 py-2">Actions</th>
            </tr>
        </thead>
        <tbody id="categoryTable">
            @foreach($categories as $category)
            <tr id="categoryRow{{ $category->id }}">
                <td class="border px-3 py-2">{{ $category->id }}</td>
                <td class="border px-3 py-2">{{ $category->name }}</td>
                <td class="border px-3 py-2 flex gap-2">
                    <button class="text-yellow-600 editCategory" data-id="{{ $category->id }}">✏ Edit</button>
                    <button class="text-red-600 deleteCategory" data-id="{{ $category->id }}">🗑 Delete</button>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="mt-4">
        {{ $categories->links() }}
    </div>

    <!-- Modal -->
    <div id="categoryModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
        <div class="bg-white p-6 rounded w-1/3">
            <h3 id="modalTitle" class="text-lg font-bold mb-4">Add Category</h3>
            <form id="categoryForm">
                @csrf
                <input type="hidden" name="category_id" id="category_id">
                <div class="mb-3">
                    <label>Name</label>
                    <input type="text" name="name" id="name" class="border p-2 w-full" required>
                    <span class="text-red-600" id="nameError"></span>
                </div>

                <div class="flex justify-end gap-2">
                    <button type="button" id="closeModal" class="bg-gray-500 text-white px-4 py-2">Cancel</button>
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
    const modal = document.getElementById('categoryModal');
    const createBtn = document.getElementById('createNewCategory');
    const closeModalBtn = document.getElementById('closeModal');
    const form = document.getElementById('categoryForm');
    const nameInput = document.getElementById('name');
    const categoryIdInput = document.getElementById('category_id');
    const modalTitle = document.getElementById('modalTitle');
    const nameError = document.getElementById('nameError');
    const categoryTable = document.getElementById('categoryTable');

    function openModal(title) {
        modalTitle.textContent = title;
        modal.classList.remove('hidden');
    }

    function closeModalFunc() {
        modal.classList.add('hidden');
        form.reset();
        categoryIdInput.value = '';
        nameError.textContent = '';
    }

    createBtn.addEventListener('click', () => openModal('Add Category'));
    closeModalBtn.addEventListener('click', closeModalFunc);

    // Edit buttons
    document.querySelectorAll('.editCategory').forEach(button => {
        button.addEventListener('click', function() {
            const id = this.dataset.id;
            fetch(`/categories/${id}/edit`)
                .then(res => res.json())
                .then(data => {
                    categoryIdInput.value = data.id;
                    nameInput.value = data.name;
                    openModal('Edit Category');
                });
        });
    });

    // Delete buttons
    document.querySelectorAll('.deleteCategory').forEach(button => {
        button.addEventListener('click', function() {
            if (!confirm('Are you sure?')) return;
            const id = this.dataset.id;
            fetch(`/categories/${id}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                }
            }).then(res => res.json())
            .then(data => {
                alert(data.success);
                document.getElementById(`categoryRow${id}`).remove();
            });
        });
    });

    // Submit form
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        nameError.textContent = '';
        const id = categoryIdInput.value;
        const url = id ? `/categories/${id}` : '/categories';
        const method = id ? 'PUT' : 'POST';

        fetch(url, {
            method: method,
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
            },
            body: JSON.stringify({ name: nameInput.value })
        })
        .then(res => res.json())
        .then(data => {
            if(data.errors) {
                nameError.textContent = data.errors.name ? data.errors.name[0] : '';
            } else if(data.category) {
                const cat = data.category;

                // Update Product dropdown dynamically
                const productDropdown = document.getElementById('category_id_product');
                if(productDropdown) {
                    const option = document.createElement('option');
                    option.value = cat.id;
                    option.text = cat.name;
                    productDropdown.appendChild(option);
                }

                // Update categories table
                if(!id) { // new category
                    const tr = document.createElement('tr');
                    tr.id = `categoryRow${cat.id}`;
                    tr.innerHTML = `
                        <td class="border px-3 py-2">${cat.id}</td>
                        <td class="border px-3 py-2">${cat.name}</td>
                        <td class="border px-3 py-2 flex gap-2">
                            <button class="text-yellow-600 editCategory" data-id="${cat.id}">✏ Edit</button>
                            <button class="text-red-600 deleteCategory" data-id="${cat.id}">🗑 Delete</button>
                        </td>
                    `;
                    categoryTable.prepend(tr);

                    // Attach edit/delete events to new row
                    tr.querySelector('.editCategory').addEventListener('click', function() {
                        categoryIdInput.value = cat.id;
                        nameInput.value = cat.name;
                        openModal('Edit Category');
                    });
                    tr.querySelector('.deleteCategory').addEventListener('click', function() {
                        if(!confirm('Are you sure?')) return;
                        fetch(`/categories/${cat.id}`, {
                            method: 'DELETE',
                            headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Accept':'application/json'}
                        }).then(res => res.json())
                          .then(d => { tr.remove(); alert(d.success); });
                    });
                }

                closeModalFunc();
            }
        });
    });
});
</script>
@endsection