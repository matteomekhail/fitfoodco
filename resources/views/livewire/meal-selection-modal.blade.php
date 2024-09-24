<section id="menu" class="lg:py-5" style="background: linear-gradient(to bottom, #000 0%, #000 75%, #FACB01 100%);">
    <style>
        .mobile-image {
            display: none;
            object-position: center;
            /* Posizione di default */
            /* Default scale */
        }

        /* Media query per dispositivi con larghezza fino a 640px */
        @media (max-width: 640px) {

            /* Nascondi l'immagine per dispositivi più grandi */
            .desktop-image {
                display: none;
            }

            /* Mostra l'immagine "cropped" per dispositivi mobili */
            .mobile-image {
                display: block;
            }
        }
    </style>
    <div class="container mx-auto px-2 sm:px-0 lg:pt-64">
        <h1 class="text-4xl font-bold text-center text-white py-4">Select your weekly meals!</h1>
        <!-- Mostra il limite di selezione basato sulla membership -->
        <div class="text-center text-white mb-8">
            <p>You can select up to {{ $this->membershipMealLimit }} meals. You have selected
                {{ array_sum($this->productQuantities) }} so far.</p>
        </div>
        <div class="mt-4 grid grid-cols-2 gap-4 sm:grid-cols-2 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
            @foreach ($products as $product)
                <div
                    class="bg-gradient-to-r from-gray-300 to-white transform transition-all duration-300 ease-in-out hover:scale-105 rounded-xl">
                    <div class="w-full h-64 overflow-hidden relative rounded-tl-xl rounded-tr-xl">
                        <!-- Immagine per dispositivi più grandi -->
                        <img src="{{ $product->image }}" alt="{{ $product->name }} image"
                            class="w-full h-full object-cover absolute desktop-image" loading="lazy">
                        <!-- Immagine cropped per dispositivi mobili -->
                        <img src="{{ Str::replaceLast('.webp', 'cropped.webp', $product->image) }}"
                            alt="{{ $product->name }} image" class="w-full h-full object-cover absolute mobile-image"
                            loading="lazy">
                    </div>
                    <div class="text-center text-black p-2">
                        <p class="capitalize my-1">
                            <strong>{{ $product->name }}</strong>
                        </p>
                        <span class="font-bold">$ {{ $product->price }}</span>
                        <div class="mt-3">
                            <p><strong>Calories:</strong> {{ $product->calories }} CAL</p>
                            <p><strong>Protein:</strong> {{ $product->protein }} P</p>
                            <p><strong>Fats:</strong> {{ $product->fats }} F</p>
                            <p><strong>Carbs:</strong> {{ $product->carbs }} C</p>
                        </div>
                        <div class="mt-3 flex justify-center items-center">
                            <button wire:click="updateQuantity({{ $product->id }}, -1)"
                                class="bg-[#FACB01] text-black py-2 px-4 rounded-full transition-all duration-300 ease-in-out">-</button>
                            <span
                                class="mx-4 text-2xl font-bold text-black">{{ $this->productQuantities[$product->id] ?? 0 }}</span>
                            <button wire:click="updateQuantity({{ $product->id }}, 1)"
                                class="bg-[#FACB01] text-black py-2 px-4 rounded-full transition-all duration-300 ease-in-out">+</button>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="text-center mt-8">
            <button wire:click="saveSelections"
                class="bg-[#FACB01] text-black py-6 px-24 text-xl rounded-full transition-all duration-300 ease-in-out">
                Save
            </button>
        </div>
    </div>
</section>
