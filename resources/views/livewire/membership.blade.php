<section class="py-5 bg-gradient-to-b from-[#FACB01] via-purple-500 to-black">
    <div class="container mx-auto px-4 py-5 bg-transparent">
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-3 xl:grid-cols-3 gap-6">
            <!-- Card 1 -->
            <div
                class="card shadow-2xl transform hover:scale-105 transition duration-500 rounded-lg h-auto bg-orange-300 p-6">
                <div class="card-body flex flex-col justify-center items-center">
                    <div class="text-center mb-4">
                        <i class="fas fa-utensils fa-3x mb-4 text-orange-800"></i>
                        <h2 class="text-2xl mb-2 text-orange-800 font-serif">Gourmet Membership</h2>
                        <p class="mb-2 text-lg text-orange-800">Enjoy 10 gourmet meals a week with a 5% discount.</p>
                    </div>
                    @if (Auth::check())
                        @if (Auth::user()->hasMembership())
                            @if (Auth::user()->membership == 'Gourmet')
                                <button
                                    class="btn mt-4 self-center bg-orange-800 hover:bg-orange-500 text-white transition-all duration-500 ease-in-out rounded-full py-3 px-6 text-sm tracking-wider border-none focus:outline-none">Current
                                    Membership</button>
                            @elseif (Auth::user()->membership == 'Deluxe' || Auth::user()->membership == 'Premium')
                                <button wire:click="subscribe('Gourmet')"
                                    class="btn mt-4 self-center bg-orange-800 hover:bg-orange-500 text-white transition-all duration-500 ease-in-out rounded-full py-3 px-6 text-sm tracking-wider border-none focus:outline-none">Downgrade</button>
                            @else
                                <button wire:click="subscribe('Gourmet')"
                                    class="btn mt-4 self-center bg-orange-800 hover:bg-orange-500 text-white transition-all duration-500 ease-in-out rounded-full py-3 px-6 text-sm tracking-wider border-none focus:outline-none">Upgrade</button>
                            @endif
                        @else
                            <button wire:click="subscribe('Gourmet')"
                                class="btn mt-4 self-center bg-orange-800 hover:bg-orange-500 text-white transition-all duration-500 ease-in-out rounded-full py-3 px-6 text-sm tracking-wider border-none focus:outline-none">Subscribe
                                now</button>
                        @endif
                    @else
                        <button wire:click="subscribe('Gourmet')"
                            class="btn mt-4 self-center bg-orange-800 hover:bg-orange-500 text-white transition-all duration-500 ease-in-out rounded-full py-3 px-6 text-sm tracking-wider border-none focus:outline-none">Subscribe
                            now</button>
                    @endif
                </div>
            </div>
            <!-- Card 2 -->
            <div
                class="card shadow-2xl transform hover:scale-105 transition duration-500 rounded-lg h-auto bg-yellow-300 p-6">
                <div class="card-body flex flex-col justify-center items-center">
                    <div class="text-center mb-4">
                        <i class="fas fa-utensils fa-3x mb-4 text-yellow-800"></i>
                        <h2 class="text-2xl mb-2 text-yellow-800 font-serif">Premium Membership</h2>
                        <p class="mb-2 text-lg text-yellow-800">Offers 15 meals a week with a 10% discount.</p>
                    </div>
                    @if (Auth::check())
                        @if (Auth::user()->hasMembership())
                            @if (Auth::user()->membership == 'Premium')
                                <button
                                    class="btn mt-4 self-center bg-yellow-800 hover:bg-yellow-500 text-white transition-all duration-500 ease-in-out rounded-full py-3 px-6 text-sm tracking-wider border-none focus:outline-none">Current
                                    Membership</button>
                            @elseif (Auth::user()->membership == 'Deluxe')
                                <button wire:click="subscribe('Premium')"
                                    class="btn mt-4 self-center bg-yellow-800 hover:bg-yellow-500 text-white transition-all duration-500 ease-in-out rounded-full py-3 px-6 text-sm tracking-wider border-none focus:outline-none">Downgrade</button>
                            @elseif (Auth::user()->membership == 'Gourmet')
                                <button wire:click="subscribe('Premium')"
                                    class="btn mt-4 self-center bg-yellow-800 hover:bg-yellow-500 text-white transition-all duration-500 ease-in-out rounded-full py-3 px-6 text-sm tracking-wider border-none focus:outline-none">Upgrade</button>
                            @endif
                        @else
                            <button wire:click="subscribe('Premium')"
                                class="btn mt-4 self-center bg-yellow-800 hover:bg-yellow-500 text-white transition-all duration-500 ease-in-out rounded-full py-3 px-6 text-sm tracking-wider border-none focus:outline-none">Subscribe
                                now</button>
                        @endif
                    @else
                        <button wire:click="subscribe('Premium')"
                            class="btn mt-4 self-center bg-yellow-800 hover:bg-yellow-500 text-white transition-all duration-500 ease-in-out rounded-full py-3 px-6 text-sm tracking-wider border-none focus:outline-none">Subscribe
                            now</button>
                    @endif
                </div>
            </div>
            <!-- Card 3 -->
            <div
                class="card shadow-2xl transform hover:scale-105 transition duration-500 rounded-lg h-auto bg-red-300 p-6">
                <div class="card-body flex flex-col justify-center items-center">
                    <div class="text-center mb-4">
                        <i class="fas fa-utensils fa-3x mb-4 text-red-800"></i>
                        <h2 class="text-2xl mb-2 text-red-800 font-serif">Deluxe Membership</h2>
                        <p class="mb-2 text-lg text-red-800">Offers 20 meals a week and each meal only costs $10.</p>
                    </div>
                    @if (Auth::check())
                        @if (Auth::user()->hasMembership())
                            @if (Auth::user()->membership == 'Deluxe')
                                <button
                                    class="btn mt-4 self-center bg-red-800 hover:bg-red-500 text-white transition-all duration-500 ease-in-out rounded-full py-3 px-6 text-sm tracking-wider border-none focus:outline-none">Current
                                    Membership</button>
                            @elseif (Auth::user()->membership == 'Gourmet' || Auth::user()->membership == 'Premium')
                                <button wire:click="subscribe('Deluxe')"
                                    class="btn mt-4 self-center bg-red-800 hover:bg-red-500 text-white transition-all duration-500 ease-in-out rounded-full py-3 px-6 text-sm tracking-wider border-none focus:outline-none">Upgrade</button>
                            @endif
                        @else
                            <button wire:click="subscribe('Deluxe')"
                                class="btn mt-4 self-center bg-red-800 hover:bg-red-500 text-white transition-all duration-500 ease-in-out rounded-full py-3 px-6 text-sm tracking-wider border-none focus:outline-none">Subscribe
                                now</button>
                        @endif
                    @else
                        <button wire:click="subscribe('Deluxe')"
                            class="btn mt-4 self-center bg-red-800 hover:bg-red-500 text-white transition-all duration-500 ease-in-out rounded-full py-3 px-6 text-sm tracking-wider border-none focus:outline-none">Subscribe
                            now</button>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>
