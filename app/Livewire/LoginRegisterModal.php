<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Exception;
use App\Models\Carts;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;

class LoginRegisterModal extends Component
{
    public $showModal = false;
    public $form = 'login';
    public $first_name = '';
    public $last_name = '';
    public $email = '';
    public $password = '';
    public $password_confirmation = '';

    public $remember = false;

    protected $listeners = ['show-modal' => 'showModal'];

    public function showModal()
    {
        $this->showModal = true;
    }
    public function register()
    {
        try {
            $this->validate([
                'first_name' => 'required|string|max:255',
                'last_name' => 'required|string|max:255',
                'email' => 'required|email|unique:users',
                'password' => 'required|min:6|confirmed',
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('Validation error: ' . $e->getMessage());
            return;
        }

        $user = \App\Models\User::create([
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'email' => $this->email,
            'password' => Hash::make($this->password),
        ]);

        Auth::login($user);

        $this->mergeCart();

        $this->showModal = false;
        return redirect()->intended('/');
    }

    public function login()
    {
        try {
            $credentials = ['email' => $this->email, 'password' => $this->password];

            $this->validate([
                'email' => 'required|email',
                'password' => 'required',
            ]);

            if (!Auth::attempt($credentials)) {
                throw new Exception('Invalid credentials');
            }

            $this->mergeCart();

            // Authentication passed...
            $this->showModal = false;
            return redirect()->intended(url()->previous());

        } catch (Exception $e) {
            session()->flash('error', $e->getMessage());
            return;
        }
    }

    private function mergeCart()
    {
        $sessionCart = session('guest_cart', []);

        Log::info('Session cart: ' . print_r($sessionCart, true));

        foreach ($sessionCart as $productId => $quantity) {
            $cart = Carts::firstOrNew([
                'user_id' => Auth::id(),
                'product_id' => $productId,
            ]);

            $cart->quantity += $quantity;
            $cart->save();
        }

        // Clear the session cart
        session()->forget('guest_cart');
        session()->save();

        Log::info('Session after clearing cart: ' . print_r(session()->all(), true));
    }

    public function render()
    {
        return view('livewire.login-register-modal');
    }
    public function mount($shouldShowModal = false)
    {
        $this->showModal = $shouldShowModal;
    }

    public function forgotPassword()
    {
        $this->validate([
            'email' => 'required|email|exists:users,email',
        ]);

        $status = Password::sendResetLink(['email' => $this->email]);

        if ($status === Password::RESET_LINK_SENT) {
            session()->flash('message', 'We have e-mailed your password reset link!');
        } else {
            session()->flash('error', 'There was an error sending the password reset link.');
        }

    }

}
