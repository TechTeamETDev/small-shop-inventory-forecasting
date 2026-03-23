<h2>User Profile</h2>

<p><strong>Name:</strong> {{ $user->name }}</p>

<p><strong>Email:</strong> {{ $user->email }}</p>

<p><strong>Role:</strong>
{{ $user->getRoleNames()->join(', ') }}
</p>

<a href="{{ route('users.index') }}">Back</a>