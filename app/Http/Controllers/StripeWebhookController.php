<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Stripe\StripeClient;
use App\Models\Order;
use App\Models\Carts as Cart;
use App\Models\User;
use App\Models\OrderProduct;
use App\Models\Address;

class StripeWebhookController extends Controller
{
    private $stripe;

    public function __construct()
    {
        $this->stripe = new StripeClient(env('STRIPE_SECRET'));
    }

    public function handleWebhook(Request $request)
    {
        $payload = $request->all();
        $event = $payload['type'];
        $data = $payload['data']['object'];

        switch ($event) {
            case 'checkout.session.completed':
                if (isset($data['mode']) && $data['mode'] === 'subscription') {
                    $this->handleSubscriptionSessionCompleted($data);
                } else {
                    $this->handleCheckoutSessionCompleted($data);
                }
                break;
            case 'invoice.payment_failed':
                $this->handlePaymentFailed($data);
                break;
            default:
                break;
        }
        return response()->json(['status' => 'success']);
    }

    protected function handlePaymentFailed($invoice)
    {
        $user = User::where('stripe_id', $invoice['customer'])->first();

        if (!$user) {
            \Log::warning('Utente non trovato con Stripe ID: ' . $invoice['customer']);
            return;
        }

        $user->membership = null;
        $user->save();
    }

    protected function handleCheckoutSessionCompleted($session)
    {
        $order = new Order;
        $order->user_id = $session['client_reference_id'];
        $order->stripe_session_id = $session['id'];
        $order->total = $session['amount_total'];
        $order->save();

        $this->saveSessionLineItems($session['id'], $order->id);

        // Salva l'indirizzo
        if (isset($session['shipping_details']['address'])) {
            $address = new Address;
            $address->order_id = $order->id;
            $address->street = $session['shipping_details']['address']['line1'];
            $address->city = $session['shipping_details']['address']['city'];
            $address->state = $session['shipping_details']['address']['state'];
            $address->zip = $session['shipping_details']['address']['postal_code'];
            $address->save();
        }

        $this->clearCart($order->user_id);
    }
    protected function handleSubscriptionSessionCompleted($session)
    {
        $user = User::where('email', $session['customer_email'])->first();

        if (!$user) {
            \Log::warning('Utente non trovato con email: ' . $session['customer_email']);
            return response()->json(['error' => 'Utente non trovato'], 404);
        }

        $subscriptionId = $session['subscription'];
        if (!$subscriptionId) {
            \Log::error('ID sottoscrizione mancante nella sessione: ' . $session['id']);
            return response()->json(['error' => 'ID sottoscrizione mancante'], 400);
        }

        $subscription = $this->stripe->subscriptions->retrieve($subscriptionId);

        $productId = $subscription->items->data[0]->plan->product;
        $product = $this->stripe->products->retrieve($productId);

        $user->stripe_id = $subscription->customer;
        $user->membership = $this->mapProductNameToMembershipType($product->name);

        if (isset($session['shipping_details']['address'])) {
            $address = $session['shipping_details']['address'];
            $user->street = $address['line1'];
            $user->city = $address['city'];
            $user->state = $address['state'];
            $user->zip = $address['postal_code'];
            $user->save();
        }

        \App\Models\MealSelection::where('user_id', $user->id)->update(['status' => 'current']);

        return response()->json(['success' => 'Membership aggiornata correttamente']);
    }



    private function clearMealSelection($userId)
    {
        \App\Models\MealSelection::where('user_id', $userId)->update(['status' => 'past']);
    }

    private function mapProductNameToMembershipType($productName)
    {
        $plans = [
            'Gourmet Membership' => 'Gourmet',
            'Premium Membership' => 'Premium',
            'Deluxe Membership' => 'Deluxe',
        ];
        return $plans[$productName] ?? null;
    }

    protected function saveSessionLineItems($sessionId, $orderId)
    {
        $lineItems = $this->stripe->checkout->sessions->allLineItems($sessionId);

        foreach ($lineItems->autoPagingIterator() as $lineItem) {
            // Assumiamo che il nome del prodotto sia salvato nel campo 'description' dei line_items di Stripe.
            $productName = $lineItem->description;

            // Trova il product_id basato sul nome del prodotto.
            $product = \App\Models\Product::where('name', $productName)->first();

            if ($product) {
                $orderProduct = new OrderProduct;
                $orderProduct->order_id = $orderId;
                $orderProduct->product_id = $product->id;
                $orderProduct->quantity = $lineItem->quantity;
                $orderProduct->save();
            } else {
                // Gestisci il caso in cui il prodotto non viene trovato, ad esempio registrando un errore.
            }
        }
    }
    protected function clearCart($userId)
    {
        Cart::where('user_id', $userId)->delete();
    }
}
