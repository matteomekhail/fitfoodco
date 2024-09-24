<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Carts as Cart;
use App\Models\Product;
use Stripe\Stripe;
use Stripe\Checkout\Session;
use Auth;

class SidebarCart extends Component
{
    public $isOpen = false;
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

        // Get the items in the cart
        $cartItems = $this->getCartItems();

        $totalItems = $cartItems->sum('quantity');

        // Check if there are less than 5 items in the cart
        if ($totalItems < 5) {
            session()->flash('error', 'Minimum 5 items required');
            return;
        }

        // Configure Stripe
        Stripe::setApiKey(config('services.stripe.secret'));

        // Create an array to hold the line items
        $line_items = [];

        // Add each item in the cart as a line item
        foreach ($cartItems as $item) {
            $product = $item->product;

            // If total items are more than 20, set price to 10$
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
        }

        // Create the checkout session
        $session = Session::create([
            'payment_method_types' => ['card'],
            'line_items' => $line_items,
            'mode' => 'payment',
            'success_url' => url('/success'), // Make sure this URL conforms to your routing and application logic needs
            'cancel_url' => url('/'),
            'allow_promotion_codes' => auth()->user()->wholesale ? false : true,
            'shipping_address_collection' => [
                'allowed_countries' => ['AU', 'NZ'],
            ],
            'shipping_options' => Auth::user()->free_shipping ? [] : [
                [
                    'shipping_rate' => 'shr_1OmZMiK8KCvHYe8JDei4iY3J',
                ]
            ],
            'client_reference_id' => auth()->id(),
            'customer_email' => Auth::user()->email, // Add this line
        ]);
        return redirect()->away($session->url);
    }

    public function render()
    {
        $cartItems = $this->getCartItems();
        return view('livewire.sidebar-cart', ['cartItems' => $cartItems]);
    }
}
