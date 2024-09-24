<?php

namespace App\Livewire;

use Livewire\Component;
use Stripe\Stripe;
use Stripe\Checkout\Session as StripeSession;
use Auth;

class Membership extends Component
{
    public function render()
    {
        return view('livewire.membership');
    }

    public function checkout($plan)
    {
        Stripe::setApiKey(env('STRIPE_SECRET'));

        $session = StripeSession::create([
            'payment_method_types' => ['card'],
            'line_items' => [
                [
                    'price_data' => [
                        'currency' => 'aud',
                        'product_data' => [
                            'name' => $this->getPlanName($plan),
                        ],
                        'recurring' => [
                            'interval' => 'week',
                            'interval_count' => 1,
                        ],
                        'unit_amount' => $this->getPlanPrice($plan),
                    ],
                    'quantity' => 1,
                ]
            ],
            'mode' => 'subscription',
            'shipping_address_collection' => [
                'allowed_countries' => ['AU', 'NZ'],
            ],
            'success_url' => url('/meals'),
            'cancel_url' => Url('/'),
            'customer_email' => Auth::user()->email,
        ]);

        return redirect($session->url, 303);
    }

    private function getPlanName($plan)
    {
        $plans = [
            'Gourmet' => 'Gourmet Membership',
            'Premium' => 'Premium Membership',
            'Deluxe' => 'Deluxe Membership',
        ];

        return $plans[$plan] ?? 'Unknown Plan';
    }

    private function getPlanPrice($plan)
    {
        $prices = [
            'Gourmet' => 11352,
            'Premium' => 16132,
            'Deluxe' => 20000,
        ];

        return $prices[$plan] ?? 0;
    }

    public function subscribe($plan)
    {
        if (!auth()->check()) {
            $this->dispatch('show-modal');
        } else {
            $this->checkout($plan);
        }
    }
}
