@extends('layouts.app')

@section('content')

<div class="container mx-auto p-6">

@if(session('success'))
<div class="bg-green-200 text-green-800 p-3 mb-4">
    {{ session('success') }}
</div>
@endif


<h2 class="text-xl font-bold mb-4">Create New User</h2>

<form method="POST" action="{{ route('users.store') }}" class="mb-8 border p-4">
@csrf

<div class="mb-3">
<label>Name</label>
<input type="text" name="name" class="border p-2 w-full" required>
</div>

<div class="mb-3">
<label>Email</label>
<input type="email" name="email" class="border p-2 w-full" required>
</div>

<div class="mb-3">
<label>Role</label>
<select name="role" class="border p-2 w-full">

@foreach($roles as $role)
<option value="{{ $role->name }}">
{{ $role->name }}
</option>
@endforeach

</select>
</div>

<button type="submit" class="bg-blue-600 text-white px-4 py-2">
Create User
</button>

</form>



<h2 class="text-xl font-bold mb-4">User List</h2>

<table class="table-auto w-full border">

<thead class="bg-gray-200">
<tr>

<th class="border px-3 py-2">Name</th>
<th class="border px-3 py-2">Email</th>
<th class="border px-3 py-2">Role</th>
<th class="border px-3 py-2">Status</th>
<th class="border px-3 py-2">Actions</th>

</tr>
</thead>


<tbody>

@foreach($users as $user)

<tr>

<td class="border px-3 py-2">
{{ $user->name }}
</td>

<td class="border px-3 py-2">
{{ $user->email }}
</td>

<td class="border px-3 py-2">
{{ $user->getRoleNames()->join(', ') ?: 'No Role' }}
</td>

<td class="border px-3 py-2">

@if($user->must_reset_password)

<span class="text-yellow-600 font-semibold">
Password Reset Required
</span>

@else

<span class="text-green-600 font-semibold">
Active
</span>

@endif

</td>


<td class="border px-3 py-2 flex gap-2">

<a href="{{ route('users.show',$user->id) }}" class="text-blue-600">
👤 View
</a>

<a href="{{ route('users.edit',$user->id) }}" class="text-yellow-600">
✏ Edit
</a>


<form action="{{ route('users.destroy',$user->id) }}" method="POST">
@csrf
@method('DELETE')

<button class="text-red-600">
🗑 Delete
</button>

</form>


<form action="{{ route('users.reset',$user->id) }}" method="POST">
@csrf

<button class="text-purple-600">
🔑 Reset
</button>

</form>

</td>

</tr>

@endforeach

</tbody>

</table>
<div class="mt-4">
{{ $users->links() }}
</div>


</div>

@endsection