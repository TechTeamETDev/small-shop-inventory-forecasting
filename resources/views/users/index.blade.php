@extends('layouts.app')

@section('content')

<div class="container mx-auto p-6">

    <h2 class="text-xl font-bold mb-4">User Management</h2>

    <!-- Add User Button -->
    <button onclick="openCreateModal()" class="bg-green-600 text-white px-4 py-2 mb-4">
        + Add User
    </button>

    <!-- Users Table -->
    <table class="table-auto w-full border">
        <thead class="bg-gray-200">
            <tr>
                <th class="border p-2">Name</th>
                <th class="border p-2">Email</th>
                <th class="border p-2">Role</th>
                <th class="border p-2">Actions</th>
            </tr>
        </thead>
        <tbody id="userTable">
            @foreach($users as $user)
            <tr id="row-{{ $user->id }}">
                <td class="border p-2">{{ $user->name }}</td>
                <td class="border p-2">{{ $user->email }}</td>
                <td class="border p-2">{{ $user->getRoleNames()->first() }}</td>
                <td class="border p-2">
                    <button onclick="editUser({{ $user->id }}, '{{ $user->name }}', '{{ $user->email }}', '{{ $user->getRoleNames()->first() }}')" class="text-yellow-600">
                        Edit
                    </button>
                    <button onclick="deleteUser({{ $user->id }})" class="text-red-600 ml-2">
                        Delete
                    </button>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<!-- Modal -->
<div id="userModal" class="fixed inset-0 bg-black bg-opacity-50 hidden flex justify-center items-center z-50">
    <div class="bg-white p-6 w-1/3 rounded shadow-lg">
        <h2 id="modalTitle" class="text-lg mb-4">Create User</h2>

        <form id="userForm">
            @csrf
            <input type="hidden" id="user_id">

            <input type="text" id="name" placeholder="Name" class="border w-full mb-2 p-2" required>
            <input type="email" id="email" placeholder="Email" class="border w-full mb-2 p-2" required>

            <select id="role" class="border w-full mb-2 p-2">
                @foreach($roles as $role)
                    <option value="{{ $role->name }}">{{ $role->name }}</option>
                @endforeach
            </select>

            <!-- Validation Errors -->
            <div id="formErrors" class="text-red-600 mb-2"></div>

            <div class="flex gap-2 justify-end">
                <button type="submit" class="bg-blue-600 text-white px-4 py-2">Save</button>
                <button type="button" onclick="closeModal()" class="px-4 py-2 border">Cancel</button>
            </div>
        </form>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
let isEdit = false;

function openCreateModal(){
    isEdit = false;
    $('#userForm')[0].reset();
    $('#user_id').val('');
    $('#modalTitle').text('Create User');
    $('#formErrors').html('');
    $('#userModal').removeClass('hidden').addClass('flex');
}

function editUser(id, name, email, role){
    isEdit = true;
    $('#user_id').val(id);
    $('#name').val(name);
    $('#email').val(email);
    $('#role').val(role);
    $('#modalTitle').text('Edit User');
    $('#formErrors').html('');
    $('#userModal').removeClass('hidden').addClass('flex');
}

function closeModal(){
    $('#userModal').removeClass('flex').addClass('hidden');
}

// Close modal when clicking outside
$('#userModal').click(function(e){
    if(e.target.id === 'userModal'){
        closeModal();
    }
});

// SAVE (Create/Update) with proper AJAX
$('#userForm').submit(function(e){
    e.preventDefault();
    let id = $('#user_id').val();

    $.ajax({
        url: isEdit ? `/users/${id}` : `/users`,
        type: isEdit ? 'PUT' : 'POST',
        data: {
            _token: '{{ csrf_token() }}',
            name: $('#name').val(),
            email: $('#email').val(),
            role: $('#role').val()
        },
        success: function(res){
            alert(res.message);
            location.reload(); // Reload table after success
        },
        error: function(xhr){
            // Display validation errors
            if(xhr.status === 422){
                let errors = xhr.responseJSON.errors;
                let html = '';
                for(let field in errors){
                    html += errors[field].join('<br>') + '<br>';
                }
                $('#formErrors').html(html);
            } else {
                alert('An error occurred.');
            }
        }
    });
});

// DELETE user
function deleteUser(id){
    if(!confirm('Delete user?')) return;

    $.ajax({
        url: `/users/${id}`,
        type: 'DELETE',
        data: {_token: '{{ csrf_token() }}'},
        success: function(res){
            alert(res.message);
            $('#row-'+id).remove();
        },
        error: function(err){
            alert('Delete failed.');
        }
    });
}
</script>

@endsection