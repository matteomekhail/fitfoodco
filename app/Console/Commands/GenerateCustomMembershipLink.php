<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use Stripe\Stripe;
use Stripe\Checkout\Session as StripeSession;

class GenerateCustomMembershipLink extends Command
{
    protected $signature = 'membership:generate-link {email}';
    protected $description = 'Generate a Stripe checkout link for Custom15 membership';

    public function handle()
    {
        $email = $this->argument('email');
        $user = User::where('email', $email)->first();

        if (!$user) {
            $this->error("User not found with email: {$email}");
            return 1;
        }

        Stripe::setApiKey(env('STRIPE_SECRET'));

        try {
            $session = StripeSession::create([
                'payment_method_types' => ['card'],
                'line_items' => [[
                    'price_data' => [
                        'currency' => 'aud',
                        'product_data' => [
                            'name' => 'Custom 15 Meals Membership',
                        ],
                        'recurring' => [
                            'interval' => 'week',
                            'interval_count' => 1,
                        ],
                        'unit_amount' => 13500,
                    ],
                    'quantity' => 1,
                ]],
                'mode' => 'subscription',
                'success_url' => url('/meals'),
                'cancel_url' => url('/'),
                'customer_email' => $user->email,
                'metadata' => [
                    'user_id' => $user->id,
                    'membership_type' => 'Custom15'
                ],
            ]);

            $this->info("Checkout link generated successfully:");
            $this->line($session->url);
            return 0;

        } catch (\Exception $e) {
            $this->error("Error generating checkout link: " . $e->getMessage());
            return 1;
        }
    }
} 