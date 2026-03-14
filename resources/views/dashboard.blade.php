<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-slate-800 leading-tight">
            {{ __('Shop Overview') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-slate-50">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            @if(session('success'))
                <div class="mb-6 p-4 bg-emerald-50 border-l-4 border-emerald-500 text-emerald-700 rounded-r-xl shadow-sm">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="mb-6 p-4 bg-red-50 border-l-4 border-red-500 text-red-700 rounded-r-xl shadow-sm">
                    {{ session('error') }}
                </div>
            @endif

            @if(Auth::user()->hasRole('Admin') || Auth::user()->email === 'admin@shop.com')
                
                <div class="bg-white border border-slate-200 rounded-2xl shadow-sm mb-8 overflow-hidden">
                    <div class="p-6 border-b border-slate-100 bg-white">
                        <h3 class="font-bold text-slate-700">Registered Users</h3>
                        <p class="text-xs text-slate-400 mt-1">Assign roles to users to change their permissions instantly.</p>
                    </div>
                    
                    <table class="w-full text-left">
                        <thead>
                            <tr class="text-[10px] font-bold text-slate-400 uppercase tracking-widest border-b border-slate-50">
                                <th class="px-6 py-4">Name</th>
                                <th class="px-6 py-4">Email</th>
                                <th class="px-6 py-4">Current Role</th>
                                <th class="px-6 py-4 text-right">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach(\App\Models\User::all() as $user)
                            <tr class="border-b border-slate-50 hover:bg-slate-50/50 transition-colors">
                                <td class="px-6 py-4 text-sm font-bold text-slate-700">{{ $user->name }}</td>
                                <td class="px-6 py-4 text-sm text-slate-500">{{ $user->email }}</td>
                                <td class="px-6 py-4">
                                    <form action="{{ route('users.update-role', $user->id) }}" method="POST" class="flex items-center gap-2">
                                        @csrf
                                        @method('PUT')
                                        <select name="role" class="text-[11px] border-slate-200 rounded-lg p-1 focus:ring-indigo-500">
                                            <option value="">-- No Role --</option>
                                            @foreach(\Spatie\Permission\Models\Role::all() as $role)
                                                <option value="{{ $role->name }}" {{ $user->hasRole($role->name) ? 'selected' : '' }}>
                                                    {{ $role->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <button type="submit" class="text-[10px] font-bold text-indigo-600 uppercase hover:underline">Update</button>
                                    </form>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    @if($user->id !== Auth::id())
                                    <form action="{{ route('users.destroy', $user->id) }}" method="POST" 
                                          onsubmit="return confirm('Completely delete {{ $user->name }}?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-xs font-bold text-red-500 hover:text-red-700 uppercase tracking-tighter">
                                            Delete Account
                                        </button>
                                    </form>
                                    @else
                                    <span class="text-[10px] font-bold text-slate-300 uppercase tracking-widest">You (Current)</span>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="bg-white border border-slate-200 rounded-2xl shadow-sm mb-8 overflow-hidden">
                    <div class="p-6 border-b border-slate-100 bg-white flex justify-between items-center">
                        <h3 class="font-bold text-slate-700">Existing Roles</h3>
                        <span class="text-[10px] bg-slate-100 px-2 py-1 rounded-full font-bold text-slate-500 uppercase">
                            Total: {{ \Spatie\Permission\Models\Role::count() }}
                        </span>
                    </div>
                    
                    <table class="w-full text-left">
                        <thead>
                            <tr class="text-[10px] font-bold text-slate-400 uppercase tracking-widest border-b border-slate-50">
                                <th class="px-6 py-4">ID</th>
                                <th class="px-6 py-4">Role Name</th>
                                <th class="px-6 py-4 text-right">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach(\Spatie\Permission\Models\Role::all() as $role)
                            <tr class="border-b border-slate-50 hover:bg-slate-50/50 transition-colors">
                                <td class="px-6 py-4 text-sm text-slate-400">#{{ $role->id }}</td>
                                <td class="px-6 py-4 text-sm font-bold text-slate-700">{{ $role->name }}</td>
                                <td class="px-6 py-4 text-right">
                                    <div class="flex justify-end items-center gap-4">
                                        <a href="{{ route('roles.edit', $role->id) }}" class="text-xs font-bold text-blue-600 hover:text-blue-800 underline underline-offset-4">
                                            EDIT
                                        </a>

                                        <form action="{{ route('roles.destroy', $role->id) }}" method="POST" 
                                              onsubmit="return confirm('Delete the {{ $role->name }} role?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-xs font-bold text-red-500 hover:text-red-700 uppercase tracking-tighter">
                                                Delete
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="bg-white border border-slate-200 rounded-2xl shadow-sm p-8">
                    <h3 class="font-bold text-slate-700 mb-6">Create New Role</h3>
                    
                    <form action="{{ route('roles.store') }}" method="POST">
                        @csrf
                        <div class="mb-6">
                            <label class="block text-xs font-bold text-slate-400 uppercase mb-2">Role Name</label>
                            <input type="text" name="name" required
                                   class="w-full border-slate-200 rounded-xl py-3 px-4 text-sm focus:border-indigo-500 focus:ring-0 placeholder-slate-300"
                                   placeholder="e.g. Viewer">
                        </div>
                        
                        <button type="submit" 
                                style="background-color: #4f46e5 !important; color: white !important;"
                                class="w-full py-4 rounded-xl text-sm font-black uppercase tracking-widest shadow-lg">
                            SAVE ROLE
                        </button>
                    </form>
                </div>

            @endif

            <div class="mt-12 text-center text-slate-400 text-sm">
                Welcome Back, <span class="font-semibold text-slate-500">{{ Auth::user()->name }}</span>!
            </div>

        </div>
    </div>
</x-app-layout>