<?php

namespace App\Livewire;

use Illuminate\Http\Request;
use Livewire\Component;
use App\Models\User;
use App\Models\Product;
use App\Models\MealSelection; // Assumiamo che questa sia la tua nuova model
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Redirect;

class MealSelectionModal extends Component
{
    public $productQuantities = [];
    public $membershipMealLimit = 0;

    public function mount()
    {
        $user = auth()->user();
        if (!$user || $user->membership === null) {
            // Se l'utente non è autenticato o non ha una membership, reindirizzalo alla home page
            return Redirect::to('/');
        }

        $this->setMembershipMealLimit($user->membership);
        $this->loadUserMealSelections($user->id);
    }

    protected function setMembershipMealLimit($membership)
    {
        // Qui imposti il limite di selezioni in base alla membership
        // Ad esempio, puoi avere una mappatura hard-coded o recuperare questi dati da un database
        $limits = [
            'Gourmet' => 10,
            'Premium' => 15,
            'Deluxe' => 20,
        ];
        $this->membershipMealLimit = $limits[$membership] ?? 0;
    }

    protected function loadUserMealSelections($userId)
    {
        $selections = MealSelection::where('user_id', $userId)->get();
        foreach ($selections as $selection) {
            $this->productQuantities[$selection->product_id] = $selection->quantity;
        }
    }

    public function updateQuantity($productId, $change)
    {
        if (!isset ($this->productQuantities[$productId])) {
            $this->productQuantities[$productId] = 0;
        }

        $newQuantity = $this->productQuantities[$productId] + $change;
        $totalSelections = array_sum($this->productQuantities) + ($change > 0 ? $change : 0);

        if ($newQuantity >= 0 && $totalSelections <= $this->membershipMealLimit) {
            $this->productQuantities[$productId] = $newQuantity;

            // Qui, aggiorna o crea una nuova selezione nel database
            MealSelection::updateOrCreate(
                ['user_id' => auth()->id(), 'product_id' => $productId],
                ['quantity' => $newQuantity]
            );
        }
    }

    public function saveSelections()
    {
        // Reindirizza alla home page
        return redirect('/');
    }

    public function render()
    {
        return view('livewire.meal-selection-modal', [
            'products' => Cache::remember('products', 120, function () {
                return Product::all();
            }),
        ]);
    }
}
