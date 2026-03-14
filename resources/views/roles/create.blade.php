<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create New Role') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm rounded-[24px] border border-slate-100 p-8">
                
                <form action="{{ route('roles.store') }}" method="POST">
                    @csrf

                    <div class="mb-8">
                        <label for="name" class="block text-sm font-bold text-slate-700 uppercase tracking-wide mb-2">Role Name</label>
                        <input type="text" name="name" id="name" 
                               class="w-full border-slate-200 rounded-xl focus:ring-blue-500 focus:border-blue-500 shadow-sm p-3" 
                               placeholder="e.g. Sales Manager" required>
                    </div>

                    <h3 class="text-lg font-bold text-slate-800 mb-4">Assign Permissions</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 mb-8">
                        @foreach($permissions as $permission)
                            <div class="flex items-center p-4 bg-slate-50 rounded-2xl border border-slate-100 hover:bg-slate-100 transition cursor-pointer">
                                <input type="checkbox" name="permissions[]" value="{{ $permission->name }}" 
                                       id="perm-{{ $permission->id }}"
                                       class="w-5 h-5 text-blue-600 border-slate-300 rounded focus:ring-blue-500">
                                <label for="perm-{{ $permission->id }}" class="ml-3 text-sm font-semibold text-slate-700 capitalize cursor-pointer">
                                    {{ str_replace('.', ' ', $permission->name) }}
                                </label>
                            </div>
                        @endforeach
                    </div>

                  <div style="margin-top:30px;padding-top:20px;border-top:1px solid #e5e7eb;display:flex;justify-content:space-between;align-items:center;">

    <a href="{{ route('dashboard') }}" 
       style="color:#64748b;font-weight:600;text-decoration:underline;">
        ← Back to Dashboard
    </a>

    <button type="submit"
        style="background:#2563eb;color:white;padding:12px 28px;border-radius:10px;font-weight:700;border:none;cursor:pointer;box-shadow:0 6px 14px rgba(0,0,0,0.1);">
        Save Role
    </button>

</div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>