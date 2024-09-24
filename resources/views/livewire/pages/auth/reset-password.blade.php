<?php

use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Locked;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component {
    #[Locked]
    public string $token = '';
    public string $email = '';
    public string $password = '';
    public string $password_confirmation = '';

    /**
     * Mount the component.
     */
    public function mount(string $token): void
    {
        $this->token = $token;

        $this->email = request()->string('email');
    }

    /**
     * Reset the password for the given user.
     */
    public function resetPassword(): void
    {
        $this->validate([
            'token' => ['required'],
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string', 'confirmed', Rules\Password::defaults()],
        ]);

        // Here we will attempt to reset the user's password. If it is successful we
        // will update the password on an actual user model and persist it to the
        // database. Otherwise we will parse the error and return the response.
        $status = Password::reset($this->only('email', 'password', 'password_confirmation', 'token'), function ($user) {
            $user
                ->forceFill([
                    'password' => Hash::make($this->password),
                    'remember_token' => Str::random(60),
                ])
                ->save();

            event(new PasswordReset($user));
        });

        // If the password was successfully reset, we will redirect the user back to
        // the application's home authenticated view. If there is an error we can
        // redirect them back to where they came from with their error message.
        if ($status != Password::PASSWORD_RESET) {
            $this->addError('email', __($status));

            return;
        }

        Session::flash('status', __($status));

        $this->redirect('/');
    }
}; ?>

<div class="space-y-6 px-6 lg:px-8 pb-4 sm:pb-6 xl:pb-8">
    <form wire:submit="resetPassword" class="p-6">
        @csrf
        <h3 class="text-xl font-bold">
            Reset Password for
            <span class="font-bold text-[#FACB01]">
                FitFoodCo
            </span>
        </h3>

        <!-- Email Address -->
        <div>
            <label for="email" class="text-sm font-medium text-black block mb-2">Your Email</label>
            <input type="email" name="email" id="email" wire:model.live="email" class="bg-gray-50 border border-gray-300 text-black sm:text-sm rounded-lg focus:ring-yellow-500 focus:border-yellow-500 block w-full p-2.5 mb-2 " placeholder="name@provider.com" required autofocus autocomplete="username" />
            @error('email')
                <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
        </div>

        <!-- Password -->
        <div>
            <label for="password" class="text-sm font-medium text-black block mb-2">Your Password</label>
            <input type="password" name="password" id="password" wire:model.live="password" class="bg-gray-50 border border-gray-300 text-black sm:text-sm rounded-lg focus:ring-yellow-500 focus:border-yellow-500 block w-full p-2.5 mb-2 " placeholder="••••••••" required autocomplete="new-password" />
            @error('password')
                <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
        </div>

        <!-- Confirm Password -->
        <div>
            <label for="password_confirmation" class="text-sm font-medium text-black block mb-2">Confirm Your Password</label>
            <input type="password" name="password_confirmation" id="password_confirmation" wire:model.live="password_confirmation" class="bg-gray-50 border border-gray-300 text-black sm:text-sm rounded-lg focus:ring-yellow-500 focus:border-yellow-500 block w-full p-2.5 mb-4 " placeholder="••••••••" required autocomplete="new-password" />
            @error('password_confirmation')
                <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
        </div>

        <button wire:click="resetPassword()" type="submit" class="transition-all duration-500 ease-in-out transform hover:scale-110 w-full text-black bg-gradient-to-r from-yellow-400 via-yellow-300 to-yellow-500 focus:ring-yellow-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">
            {{ __('Reset Password') }}
        </button>
    </form>
</div>
