<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm rounded-[24px] border border-slate-100 p-8">
                
                <h2 class="text-xl font-bold text-slate-800 mb-6">Edit Role: {{ $role->name }}</h2>

               <form action="{{ route('roles.update', $role->id) }}" method="POST">
    @csrf
    @method('PUT')

                    <div class="mb-8">
                        <label class="block text-sm font-bold text-slate-700 uppercase mb-2">Role Name</label>
                        <input type="text" name="name" value="{{ old('name', $role->name) }}" 
                               class="w-full border-slate-200 rounded-xl p-3 focus:ring-indigo-500" required>
                    </div>

                    <h3 class="text-lg font-bold text-slate-800 mb-4">Update Permissions</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 mb-8">
                        @foreach($permissions as $permission)
                            <div class="flex items-center p-4 bg-slate-50 rounded-2xl border border-slate-100">
                                <input type="checkbox" name="permissions[]" value="{{ $permission->name }}" 
                                       id="perm-{{ $permission->id }}"
                                       {{ in_array($permission->name, $rolePermissions) ? 'checked' : '' }}
                                       class="w-5 h-5 text-indigo-600 border-slate-300 rounded">
                                <label for="perm-{{ $permission->id }}" class="ml-3 text-sm font-semibold text-slate-700 capitalize">
                                    {{ str_replace('.', ' ', $permission->name) }}
                                </label>
                            </div>
                        @endforeach
                    </div>

                    <div class="mt-8 pt-8 border-t flex flex-col items-center gap-4">
                        <button type="submit"
                                style="background:#4f46e5; color:white; padding:16px 40px; border-radius:16px; font-weight:900; border:none; cursor:pointer; box-shadow:0 10px 15px -3px rgba(79, 70, 229, 0.3); text-transform: uppercase; font-size: 14px; letter-spacing: 0.05em;">
                            UPDATE ROLE PERMISSIONS
                        </button>

                        <a href="{{ route('dashboard') }}" class="text-slate-500 font-semibold hover:text-slate-700 transition underline">
                            Cancel and Go Back
                        </a>
                    </div>

                </form>
            </div>
        </div>
    </div>
</x-app-layout>