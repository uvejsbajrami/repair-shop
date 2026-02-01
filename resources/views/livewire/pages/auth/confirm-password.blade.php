<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component
{
    public string $password = '';

    /**
     * Confirm the current user's password.
     */
    public function confirmPassword(): void
    {
        $this->validate([
            'password' => ['required', 'string'],
        ]);

        if (! Auth::guard('web')->validate([
            'email' => Auth::user()->email,
            'password' => $this->password,
        ])) {
            throw ValidationException::withMessages([
                'password' => __('auth.password'),
            ]);
        }

        session(['auth.password_confirmed_at' => time()]);

        $this->redirectIntended(default: route('dashboard', absolute: false), navigate: true);
    }
}; ?>

<div>
    <h2 class="text-2xl font-bold text-gray-800 text-center mb-6">Confirm Password</h2>

    <div class="mb-4 text-sm text-gray-600">
        {{ __('This is a secure area of the application. Please confirm your password before continuing.') }}
    </div>

    <form wire:submit="confirmPassword">
        <!-- Password -->
        <div>
            <x-input-label for="password" :value="__('Password')" class="text-gray-700 font-semibold" />
            <x-text-input wire:model="password"
                id="password"
                class="block mt-1 w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-600 focus:ring-1 focus:ring-blue-600"
                type="password"
                name="password"
                required autocomplete="current-password"
                placeholder="Enter your password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div class="mt-6">
            <button type="submit"
                class="w-full py-3 bg-blue-600 text-white rounded-lg font-semibold hover:bg-blue-700 transition shadow-lg">
                {{ __('Confirm') }}
            </button>
        </div>
    </form>
</div>
