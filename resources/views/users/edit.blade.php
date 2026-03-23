<h2>Edit User</h2>

<form method="POST" action="{{ route('users.update',$user->id) }}">
@csrf
@method('PUT')

<input type="text" name="name" value="{{ $user->name }}">

<input type="email" name="email" value="{{ $user->email }}">

<select name="role">
@foreach($roles as $role)

<option value="{{ $role->name }}"
@if($user->hasRole($role->name)) selected @endif>

{{ $role->name }}

</option>

@endforeach
</select>

<button type="submit">
Update
</button>

</form>