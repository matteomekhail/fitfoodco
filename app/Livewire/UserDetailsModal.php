<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Stripe\Stripe;
use Stripe\Service;

class UserDetailsModal extends Component
{
    public $isOpen = false;
    public $user;
    public $street;
    public $city; // Aggiungi questa linea
    public $state;
    public $zip;
    public $editable = [
        'street' => false,
        'city' => false,
        'state' => false,
        'zip' => false,
    ];

    public function unsubscribe()
    {
        // Ensure the user object is not null
        if (!$this->user) {
            throw new \Exception("User object not found.");
        }

        // Attempt to delete meal selections associated with the user
        try {
            $mealSelections = $this->user->mealSelections();
            if ($mealSelections) {
                $mealSelections->update(['status' => 'past']);
            } else {
                throw new \Exception("Meal selections method returned null.");
            }
        } catch (\Exception $e) {
            throw new \Exception("Error while updating meal selections: " . $e->getMessage());
        }

        // Initialize Stripe client
        $stripe = new \Stripe\StripeClient(env('STRIPE_SECRET'));

        try {
            // Retrieve all subscriptions for the user from Stripe
            $subscriptions = $stripe->subscriptions->all(['customer' => $this->user->stripe_id]);

            // Check if there are any active subscriptions and cancel them
            if (!empty($subscriptions->data)) {
                foreach ($subscriptions->data as $subscription) {
                    if ($subscription->status !== 'canceled') {
                        $stripe->subscriptions->cancel($subscription->id);
                    }
                }
            } else {
                throw new \Exception("No active subscriptions found.");
            }
        } catch (\Stripe\Exception\ApiErrorException $e) {
            // Handle Stripe API errors
            throw new \Exception("Stripe API error: " . $e->getMessage());
        } catch (\Exception $e) {
            // Handle general errors during subscription cancellation
            throw new \Exception("Failed to cancel subscriptions: " . $e->getMessage());
        }

        // Set user's membership status to null and attempt to save
        $this->user->membership = null;
        if (!$this->user->save()) {
            throw new \Exception("Failed to save user data.");
        }
    }

    protected $listeners = ['openUserModal' => 'openModal'];

    public function openModal()
    {
        $this->isOpen = true;
        $this->user = Auth::user();
        $this->street = $this->user->street;
        $this->city = $this->user->city; // Aggiungi questa linea
        $this->state = $this->user->state; // Aggiungi questa linea
        $this->zip = $this->user->zip; // Aggiungi questa linea
    }

    public function saveField($field)
    {
        $this->user->$field = $this->$field;
        $this->user->save();
        $this->editable[$field] = false;
    }

    public function logout()
    {
        auth()->logout();
        return redirect('/');
    }
    public function enableEdit($field)
    {
        $this->editable[$field] = true;
    }

    public function render()
    {
        return view('livewire.user-details-modal');
    }
}
