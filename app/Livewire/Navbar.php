<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Carts as Cart;
use Carbon\Carbon;

class Navbar extends Component
{
    public $cartItemCount;
    public $nextDeliveryDate;

    protected $listeners = ['cartUpdated' => 'updateCartItemCount'];

    public function updateCartItemCount()
    {
        if (auth()->check()) {
            // Utente autenticato: ottieni quantità dal database
            $userId = auth()->id();
            $cartItems = Cart::where('user_id', $userId)->get();
            $this->cartItemCount = $cartItems->sum('quantity');
        } else {
            // Utente guest: ottieni quantità dalla sessione
            $guestCart = session()->get('guest_cart', []);
            $this->cartItemCount = array_sum($guestCart);
        }
    }
    public function mount()
    {
        if (auth()->check()) {
            // Utente autenticato: ottieni quantità dal database
            $userId = auth()->id();
            $cartItems = Cart::where('user_id', $userId)->get();
            $this->cartItemCount = $cartItems->sum('quantity');
        } else {
            // Utente guest: ottieni quantità dalla sessione
            $guestCart = session()->get('guest_cart', []);
            $this->cartItemCount = array_sum($guestCart);
        }
        $this->nextDeliveryDate = $this->getNextDeliveryDay();
    }


    public function hydrate()
    {
        $this->nextDeliveryDate = $this->getNextDeliveryDay();
    }

    private function getNextDeliveryDay()
    {
        $now = now();
        $targetDate = Carbon::create(date('Y'), 3, 11, 0, 0, 0); // 11th of March of the current year

        // If we've passed the 11th of March this year, get the 11th of March next year
        if ($now->greaterThan($targetDate)) {
            $targetDate->addYear();
        }

        return $targetDate;
    }
    public function getRemainingTimeProperty()
    {
        $now = now();
        $diffInSeconds = $this->nextDeliveryDate->diffInSeconds($now);

        $days = floor($diffInSeconds / (60 * 60 * 24));
        $hours = floor(($diffInSeconds % (60 * 60 * 24)) / (60 * 60));
        $minutes = floor(($diffInSeconds % (60 * 60)) / 60);
        $seconds = $diffInSeconds % 60;

        return [
            'days' => sprintf('%02d', $days),
            'hours' => sprintf('%02d', $hours),
            'minutes' => sprintf('%02d', $minutes),
            'seconds' => sprintf('%02d', $seconds),
        ];
    }
    public function render()
    {
        return view('livewire.navbar');
    }
}
