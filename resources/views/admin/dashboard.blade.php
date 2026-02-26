<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard</title>
</head>
<body>
    <h1>Welcome, {{ auth()->user()->name }} (Admin)</h1>

    <nav>
        <a href="{{ route('users.index') }}">Manage Users</a> |
        <form method="POST" action="{{ route('logout') }}" style="display:inline;">
            @csrf
            <button type="submit">Logout</button>
        </form>
    </nav>

    <p>Admin dashboard content goes here.</p>
</body>
</html>