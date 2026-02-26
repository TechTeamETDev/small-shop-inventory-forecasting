<!DOCTYPE html>
<html>
<head>
    <title>All Users</title>
</head>
<body>
    <h1>Users</h1>

    <a href="{{ route('users.create') }}">Create New User</a> |
    <a href="{{ route('admin.dashboard') }}">Back to Dashboard</a>

    @if(session('success'))
        <p style="color:green;">{{ session('success') }}</p>
    @endif

    <table border="1" cellpadding="5" cellspacing="0">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Role</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
                <tr>
                    <td>{{ $user->id }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->role }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>