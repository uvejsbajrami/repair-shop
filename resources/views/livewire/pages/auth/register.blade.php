<?php

use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component
{
    public string $name = '';
    public string $email = '';
    public string $password = '';
    public string $password_confirmation = '';

    /**
     * Handle an incoming registration request.
     */
    public function register(): void
    {
        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'string', 'confirmed', Rules\Password::defaults()],
        ]);

        $validated['password'] = Hash::make($validated['password']);

        event(new Registered($user = User::create($validated)));

        Auth::login($user);

        $this->redirect(route('dashboard', absolute: false), navigate: true);
    }
}; ?>

<div>
    <h2 class="text-2xl font-bold text-gray-800 text-center mb-6">Create Account</h2>

    <form wire:submit="register">
        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Name')" class="text-gray-700 font-semibold" />
            <x-text-input wire:model="name" id="name"
                class="block mt-1 w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-600 focus:ring-1 focus:ring-blue-600"
                type="text" name="name" required autofocus autocomplete="name"
                placeholder="Your name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" class="text-gray-700 font-semibold" />
            <x-text-input wire:model="email" id="email"
                class="block mt-1 w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-600 focus:ring-1 focus:ring-blue-600"
                type="email" name="email" required autocomplete="username"
                placeholder="your@email.com" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" class="text-gray-700 font-semibold" />
            <x-text-input wire:model="password" id="password"
                class="block mt-1 w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-600 focus:ring-1 focus:ring-blue-600"
                type="password"
                name="password"
                required autocomplete="new-password"
                placeholder="Create a password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" class="text-gray-700 font-semibold" />
            <x-text-input wire:model="password_confirmation" id="password_confirmation"
                class="block mt-1 w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-600 focus:ring-1 focus:ring-blue-600"
                type="password"
                name="password_confirmation" required autocomplete="new-password"
                placeholder="Confirm your password" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="mt-6">
            <button type="submit"
                class="w-full py-3 bg-blue-600 text-white rounded-lg font-semibold hover:bg-blue-700 transition shadow-lg">
                {{ __('Register') }}
            </button>
        </div>

        <div class="text-center mt-6 text-sm">
            <span class="text-gray-600">Already have an account?</span>
            <a class="text-blue-600 hover:text-blue-700 hover:underline ml-1" href="{{ route('login') }}" wire:navigate>
                {{ __('Log in') }}
            </a>
        </div>
    </form>
</div>
