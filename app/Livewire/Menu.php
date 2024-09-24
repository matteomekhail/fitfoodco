<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Product;
use App\Models\Carts as Cart;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;


class Menu extends Component
{
    public $productQuantities = [];
    protected $listeners = ['updateQuantity' => 'updateQuantity'];
    public function mount()
    {
        if (auth()->check()) {
            // Utente autenticato: ottieni quantità dal database
            $userId = auth()->id();
            $cartItems = Cart::with('product')->where('user_id', $userId)->get();

            foreach ($cartItems as $cartItem) {
                $this->productQuantities[$cartItem->product_id] = $cartItem->quantity;
            }
        } else {
            // Utente guest: ottieni quantità dalla sessione
            $guestCart = session()->get('guest_cart', []);

            foreach ($guestCart as $productId => $quantity) {
                $this->productQuantities[$productId] = $quantity;
            }
        }
    }
    public function updateQuantity($productId, $change)
    {
        if (auth()->check()) {
            $this->updateAuthenticatedUserCart($productId, $change);
            // Aggiorna la quantità per gli utenti autenticati
            $cartItem = Cart::where('user_id', auth()->id())->where('product_id', $productId)->first();
            $this->productQuantities[$productId] = $cartItem ? $cartItem->quantity : 0;
        } else {
            $this->updateGuestUserCart($productId, $change);
            // Aggiorna la quantità per gli utenti guest
            $guestCart = session()->get('guest_cart', []);
            $this->productQuantities[$productId] = $guestCart[$productId] ?? 0;
        }
        $this->dispatch('cartUpdated');
    }

    private function updateAuthenticatedUserCart($productId, $change)
    {
        try {
            $userId = auth()->id();
            $cartItem = Cart::where('user_id', $userId)->where('product_id', $productId)->first();

            if ($cartItem) {
                $cartItem->quantity += $change;
                if ($cartItem->quantity > 0) {
                    $cartItem->save();
                } else {
                    $cartItem->delete();
                }
            } else if ($change > 0) {
                Cart::updateOrCreate(
                    ['user_id' => auth()->id(), 'product_id' => $productId],
                    ['quantity' => DB::raw("GREATEST(quantity + $change, 0)")]
                )->where('quantity', 0)->delete();
            }
        } catch (\Exception $e) {
            Log::error("Errore nell'aggiornamento del carrello utente autenticato: " . $e->getMessage());
            session()->flash('error', 'Non è stato possibile aggiornare il carrello.');
        }
    }

    private function updateGuestUserCart($productId, $change)
    {
        try {
            $guestCart = session()->get('guest_cart', []);
            $currentQuantity = $guestCart[$productId] ?? 0;
            $newQuantity = max($currentQuantity + $change, 0);

            if ($newQuantity > 0) {
                $guestCart[$productId] = $newQuantity;
            } else {
                unset($guestCart[$productId]);
            }

            session()->put('guest_cart', $guestCart);
        } catch (\Exception $e) {
            Log::error("Errore nell'aggiornamento del carrello utente guest: " . $e->getMessage());
            session()->flash('error', 'Non è stato possibile aggiornare il carrello.');
        }
    }

    public $open = false;
    public $selectedProduct = null;

    public function showProduct($productId)
    {
        $this->selectedProduct = Product::find($productId);
        $this->open = true;
    }

    public function render()
    {
        // Modifica qui per includere i prodotti ordinati per best seller
        $products = Product::withCount(['orderProducts as total_sold' => function ($query) {
            $query->select(DB::raw("SUM(quantity)"));
        }])->orderBy('total_sold', 'desc')->get();

        return view('livewire.menu', [
            'products' => $products,
        ]);
    }

}
