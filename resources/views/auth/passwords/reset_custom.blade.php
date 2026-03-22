<x-guest-layout>
    <div class="max-w-md mx-auto mt-10 p-6 bg-white shadow rounded">
        <h2 class="text-xl font-bold mb-4">Reset Your Password</h2>

        <form method="POST" action="{{ route('password.reset.custom.post') }}">
            @csrf

            <!-- New Password -->
            <div class="mb-4">
                <x-input-label for="password" :value="__('New Password')" />
                <x-text-input id="password" class="block mt-1 w-full" 
                              type="password" name="password" 
                              required autocomplete="new-password" />
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <!-- Confirm Password -->
            <div class="mb-4">
                <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
                <x-text-input id="password_confirmation" class="block mt-1 w-full" 
                              type="password" name="password_confirmation" 
                              required autocomplete="new-password" />
                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
            </div>

            <div class="flex justify-end">
                <x-primary-button>{{ __('Reset Password') }}</x-primary-button>
            </div>
        </form>
    </div>
</x-guest-layout>