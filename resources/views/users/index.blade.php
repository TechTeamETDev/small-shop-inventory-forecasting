@foreach($users as $user)
<tr>
    <td>{{ $user->name }}</td>
    <td>{{ $user->email }}</td>
    <td>{{ $user->getRoleNames()->join(', ') }}</td>
    <td>
        @if($user->must_reset_password)
            <span class="text-yellow-600">Password Reset Required</span>
        @else
            <span class="text-green-600">Active</span>
        @endif
    </td>
</tr>
@endforeach