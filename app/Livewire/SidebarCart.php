<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Carts as Cart;
use App\Models\Product;
use App\Models\Gym;
use Stripe\Stripe;
use Stripe\Checkout\Session;
use Illuminate\Support\Facades\Auth;

class SidebarCart extends Component
{
    public $isOpen = false;
    public $isPickup = false;
    public $selectedGym = null;
    protected $listeners = ['toggleSidebar' => 'toggleCartSidebar', 'updateQuantity' => 'refreshItem'];

    public function getCartItems()
    {
        if (auth()->check()) {
            $userId = auth()->id();
            return Cart::with('product')->where('user_id', $userId)->get();
        } else {
            $guestCart = session()->get('guest_cart', []);
            $cartItems = [];
            foreach ($guestCart as $productId => $quantity) {
                $product = Product::find($productId);
                if ($product) {
                    $cartItems[] = (object) [
                        'product_id' => $productId,
                        'quantity' => $quantity,
                        'product' => $product,
                    ];
                }
            }
            return $cartItems;
        }
    }

    public function refreshItem()
    {
        $this->cartItems = $this->getCartItems();
    }

    public function toggleCartSidebar()
    {
        $this->isOpen = !$this->isOpen;
    }

    public function checkout()
    {
        if (!auth()->check()) {
            $this->dispatch('show-modal');
            return;
        }

        $cartItems = $this->getCartItems();
        $totalItems = $cartItems->sum('quantity');

        if ($totalItems < 5) {
            session()->flash('error', 'Minimum 5 items required');
            return;
        }

        if ($this->isPickup && !$this->selectedGym) {
            session()->flash('error', 'Please select a gym for pickup');
            return;
        }

        Stripe::setApiKey(config('services.stripe.secret'));

        $line_items = [];
        $total_amount = 0;

        foreach ($cartItems as $item) {
            $product = $item->product;
            $price = auth()->user()->{"10Dollars"} ? 10 : (auth()->user()->wholesale ? 9 : ($totalItems > 20 ? 10 : $product->price));

            $line_items[] = [
                'price_data' => [
                    'currency' => 'aud',
                    'product_data' => [
                        'name' => $product->name,
                    ],
                    'unit_amount' => $price * 100,
                ],
                'quantity' => $item->quantity,
            ];

            $total_amount += $price * $item->quantity;
        }

        // Aggiungiamo le informazioni di ritiro alla fine
        $gym_stripe_account = null;
        if ($this->isPickup && $this->selectedGym) {
            $gym = Gym::find($this->selectedGym);
            if ($gym) {
                $line_items[] = [
                    'price_data' => [
                        'currency' => 'aud',
                        'product_data' => [
                            'name' => "Pickup Information\nGym: {$gym->name}\nAddress: {$gym->address}",
                        ],
                        'unit_amount' => 0,
                    ],
                    'quantity' => 1,
                ];
                $gym_stripe_account = $gym->stripe_account_id; // Assicurati di avere questo campo nel modello Gym
            }
        }

        $sessionParams = [
            'payment_method_types' => ['card'],
            'line_items' => $line_items,
            'mode' => 'payment',
            'success_url' => url('/success'),
            'cancel_url' => url('/'),
            'allow_promotion_codes' => !auth()->user()->wholesale,
            'client_reference_id' => auth()->id(),
            'customer_email' => Auth::user()->email,
            'metadata' => [
                'is_pickup' => $this->isPickup ? 'true' : 'false',
                'gym_id' => $this->isPickup ? $this->selectedGym : null,
            ],
        ];

        if ($gym_stripe_account) {
            $sessionParams['payment_intent_data'] = [
                'application_fee_amount' => intval($total_amount * 0.95 * 100), // 95% trattenuto come commissione
                'transfer_data' => [
                    'destination' => $gym_stripe_account, // L'account della palestra riceverà il 5%
                ],
            ];
        }

        if (!$this->isPickup) {
            $sessionParams['shipping_address_collection'] = [
                'allowed_countries' => ['AU', 'NZ'],
            ];
            if (!Auth::user()->free_shipping) {
                $sessionParams['shipping_options'] = [
                    [
                        'shipping_rate' => 'shr_1OmZMiK8KCvHYe8JDei4iY3J',
                    ]
                ];
            }
        }

        $session = Session::create($sessionParams);
        return redirect()->away($session->url);
    }

    public function render()
    {
        $gyms = Gym::all();
        $cartItems = $this->getCartItems();
        return view('livewire.sidebar-cart', [
            'cartItems' => $cartItems,
            'gyms' => $gyms,
        ]);
    }
}
