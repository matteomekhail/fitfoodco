<section class="py-8 lg:pt-72 lg:pb-20" id="home">
    <div class="container">
        @php
            $meals = [];

            // Supponiamo che $orders contenga gli ordini filtrati in base alla richiesta (uncooked, cooked, ecc.)
            foreach ($orders as $order) {
                foreach ($order->orderProducts as $orderProduct) {
                    // Aggiungi le quantità di orderProducts all'array meals
        if (
            (request('filter') == 'cooked' && $orderProduct->is_cooked) ||
            (request('filter') == 'uncooked' && !$orderProduct->is_cooked) ||
            (request('filter') == 'delivered' && $orderProduct->is_delivered) ||
            (request('filter') == 'undelivered' && !$orderProduct->is_delivered) ||
            !request('filter')
        ) {
            $productName = $orderProduct->product->name;
            $meals[$productName] = ($meals[$productName] ?? 0) + $orderProduct->quantity;
        }
    }
}

// Ora, aggiungi le quantità di meal_selections all'array meals
            use App\Models\MealSelection;
            $mealSelections = MealSelection::with('user')->get();

            foreach ($mealSelections as $mealSelection) {
                if ($mealSelection->status == 'current' && $mealSelection->user && $mealSelection->user->membership) {
                    $productName = $mealSelection->product->name;
                    $meals[$productName] = ($meals[$productName] ?? 0) + $mealSelection->quantity;
                }
            }

            $totalMeals = array_sum($meals);
        @endphp

        @if (request('filter') == 'uncooked' && count($meals) > 0)
            <div class="bg-white rounded-lg shadow-lg p-6 border border-gray-200 mb-20">
                <h4 class="text-2xl font-semibold mb-4 text-gray-700">Meals to Cook: {{ $totalMeals }}</h4>
                <ul class="list-disc pl-5">
                    @foreach ($meals as $meal => $quantity)
                        <li class="text-lg mb-2">
                            <span class="font-semibold text-gray-800">{{ $meal }}:</span>
                            <span class="text-gray-600">{{ $quantity }}</span>
                        </li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="flex items-center justify-center mb-20 w-full">
            <button class="btn btn-sm btn-outline-secondary print-btn text-center">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                    class="bi bi-printer" viewBox="0 0 16 16">
                    <path d="M4 10h8v2H4z" />
                    <path d="M4 4h8v2H4z" />
                    <path
                        d="M2 2a2 2 0 0 0-2 2v4a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V4a2 2 0 0 0-2-2H2zm0 2h12v4H2V4zm3 8v4h6v-4H5zm-1 0a1 1 0 0 1 1-1h6a1 1 0 0 1 1 1v4a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1v-4z" />
                </svg>
            </button>
        </div>

        @foreach ($orders as $order)
            @php
                $displayOrder = false;
                $uncookedOrder = false;
                foreach ($order->orderProducts as $orderProduct) {
                    if (
                        (request('filter') == 'cooked' && $orderProduct->is_cooked) ||
                        (request('filter') == 'uncooked' && !$orderProduct->is_cooked) ||
                        (request('filter') == 'delivered' && $orderProduct->is_delivered) ||
                        (request('filter') == 'undelivered' && !$orderProduct->is_delivered) ||
                        !request('filter')
                    ) {
                        $displayOrder = true;
                        if (!$orderProduct->is_cooked) {
                            $uncookedOrder = true;
                        }
                        break;
                    }
                }
            @endphp
            @if ($displayOrder)
                <div class="card mb-4 shadow-sm {{ $uncookedOrder ? 'uncooked-order' : '' }}">
                    <div class="card-header text-2xl py-3 text-black flex flex-col items-center justify-center"
                        style="background-image: linear-gradient(to bottom, #FACB01 0%, #FAD961 100%);">
                        <h4 class="my-0 fw-normal">Order #{{ $order->id }}</h4>
                        <div class="flex justify-center mt-2">
                            <button class="btn btn-sm btn-outline-secondary mx-1"
                                wire:click="setAllCooked({{ $order->id }})">Everything Cooked</button>
                            <button class="btn btn-sm btn-outline-secondary mx-1"
                                wire:click="setAllUncooked({{ $order->id }})">Everything Uncooked</button>
                            <button class="btn btn-sm btn-outline-secondary mx-1"
                                wire:click="setAllDelivered({{ $order->id }})">Everything Delivered</button>
                            <button class="btn btn-sm btn-outline-secondary mx-1"
                                wire:click="setAllUndelivered({{ $order->id }})">Everything Undelivered</button>
                        </div>
                    </div>
                    <div class="card-body">
                        @if ($order->user)
                            <h5 class="card-title"><strong>Customer Name:</strong> {{ $order->user->first_name }}
                                {{ $order->user->last_name }}</h5>
                        @else
                            <h5 class="card-title"><strong>Customer Name:</strong> Information not available</h5>
                        @endif
                        <p class="card-text"><strong>Order Date:</strong>
                            {{ $order->created_at->toFormattedDateString() }}
                        </p>
                        @if ($order->address)
                            <p class="card-text"><strong>Address:</strong> {{ $order->address->street }},
                                {{ $order->address->city }}, {{ $order->address->state }}, {{ $order->address->zip }}
                            </p>
                        @else
                            <p class="card-text"><strong>Address:</strong> Not available</p>
                        @endif
                        <p class="card-text"><strong>Products:</strong></p>
                        @php
                            $totalQuantity = $order->orderProducts->sum('quantity');
                            $totalLabels = ceil($totalQuantity / 10);
                        @endphp
                        <p class="card-text">Number of Labels: {{ $totalLabels }}</p>
                        <div class="flex flex-wrap space-x-4">
                            @foreach ($order->orderProducts as $orderProduct)
                                @if (
                                    (request('filter') == 'cooked' && $orderProduct->is_cooked) ||
                                        (request('filter') == 'uncooked' && !$orderProduct->is_cooked) ||
                                        (request('filter') == 'delivered' && $orderProduct->is_delivered) ||
                                        (request('filter') == 'undelivered' && !$orderProduct->is_delivered) ||
                                        !request('filter'))
                                    <div class="card m-2" style="width: 18rem;">
                                        <img src="../{{ $orderProduct->product->image }}" class="card-img-top"
                                            alt="{{ $orderProduct->product->name }}">
                                        <div class="card-body flex flex-col">
                                            <h5 class="card-title mb-auto">{{ $orderProduct->product->name }}</h5>
                                            <p class="card-text">Quantity: {{ $orderProduct->quantity }}</p>
                                            <div class="flex justify-between items-center mt-4">
                                                <button class="btn btn-sm btn-outline-secondary"
                                                    wire:click="setCooked({{ $orderProduct->id }})">
                                                    {{ $orderProduct->is_cooked ? 'Cooked' : 'Not Cooked' }}
                                                </button>
                                                <button class="btn btn-sm btn-outline-secondary"
                                                    wire:click="setDelivered({{ $orderProduct->id }})">
                                                    {{ $orderProduct->is_delivered ? 'Delivered' : 'Not Delivered' }}
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif
        @endforeach
        @if (request()->is('admin/membership'))
            @php
                $usersMeals = $mealSelections->groupBy('user_id');
            @endphp

            @foreach ($usersMeals as $userId => $userMeals)
                @php
                    $user = $userMeals->first()->user;
                @endphp

                @if ($user)
                    <div class="card mb-4 shadow-lg rounded-lg overflow-hidden">
                        <div
                            class="card-header bg-gradient-to-r {{ $userMeals->first()->status == 'past' ? 'bg-red-500' : 'bg-black' }} text-2xl py-3 text-white">
                            <h4 class="my-0 font-bold text-center">{{ $user->first_name }} {{ $user->last_name }}
                                {{ $userMeals->first()->status == 'past' ? '(Past)' : '' }} Membership Details</h4>
                        </div>
                        <div class="card-body bg-white p-4">
                            <h5 class="card-title text-lg"><strong>Membership Level:</strong>
                                {{ $user->membership ?? 'Not Available' }}</h5>
                            <p class="card-text">
                                <strong>Address:</strong>
                                @if ($user)
                                    {{ $user->street }}, {{ $user->city }},
                                    {{ $user->state }}, {{ $user->zip }}
                                @else
                                    Not available
                                @endif
                            </p>
                            <p class="card-text"><strong>Selected Meals:</strong></p>
                            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                                @foreach ($userMeals as $mealSelection)
                                    <div class="bg-gray-100 rounded overflow-hidden shadow-md">
                                        <img src="{{ asset('' . $mealSelection->product->image) }}"
                                            class="w-full h-48 object-cover" alt="{{ $mealSelection->product->name }}">
                                        <div class="p-3">
                                            <h5 class="font-bold">{{ $mealSelection->product->name }}</h5>
                                            <p class="text-sm">Quantity: {{ $mealSelection->quantity }}</p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @else
                    <p>User information not available</p>
                @endif
            @endforeach
        @endif
    </div>
</section>
