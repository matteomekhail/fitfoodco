<div id="navbar-wrapper" class="sticky top-0 z-30 w-full lg:h-72 h-50 flex flex-col shadow-2xl" style="background-image: linear-gradient(to bottom, #FACB01 0%, #FAD961 100%);">
    <!-- Countdown section -->
    <div class="w-full bg-black text-white py-1 sm:py-2 text-center z-50">
        <p class="text-base sm:text-lg font-bold">Next delivery day:</p>
        @php
            $today = now();
            $january13 = Carbon\Carbon::create(2025, 1, 13);
        @endphp
        @if($today->lt($january13))
            <p class="text-[10px] sm:text-sm text-red-400 mb-0.5 sm:mb-1 px-2">Due to the Christmas holiday period, deliveries will resume from January 13th, 2025</p>
        @endif
        <div class="flex justify-center items-center gap-1 sm:gap-2 mb-1" wire:ignore>
            <div class="px-0.5 sm:px-2">
                <span id="days" class="text-sm sm:text-lg md:text-xl"></span>
                <div class="text-[8px] sm:text-xs md:text-sm">Days</div>
            </div>
            <div class="px-0.5 sm:px-2">
                <span id="hours" class="text-sm sm:text-lg md:text-xl"></span>
                <div class="text-[8px] sm:text-xs md:text-sm">Hours</div>
            </div>
            <div class="px-0.5 sm:px-2">
                <span id="minutes" class="text-sm sm:text-lg md:text-xl"></span>
                <div class="text-[8px] sm:text-xs md:text-sm">Minutes</div>
            </div>
            <div class="px-0.5 sm:px-2">
                <span id="seconds" class="text-sm sm:text-lg md:text-xl"></span>
                <div class="text-[8px] sm:text-xs md:text-sm">Seconds</div>
            </div>
        </div>
    </div>

    <!-- Main navbar content -->
    <div class="container flex-grow flex flex-col justify-between pb-4 sm:pb-6 lg:pb-8">
        <nav class="navbar px-0 pt-4">
            <div class="navbar-start gap-2">
                <div class="flex-none lg:hidden">
                    <label for="my-drawer" aria-label="open sidebar" class="btn btn-square btn-ghost"
                        style="color: black !important;">
                        <i class="fas fa-bars text-xl text-black"></i>
                    </label>
                </div>
                <!-- Navbar Brand logo -->
                <img class="w-50 md:w-40 lg:w-60 h-auto text-center tracking-tighter"
                    src="/images/logo-removebg.webp" alt="FitFoodCo" width="1200" height="80" />
                <div class="lg:hidden ml-auto relative flex justify-end "> <!-- Modifica qui per mobile -->
                    <div class="font-medium pt-1 text-black flex gap-8"> <!-- Aggiunto flex e gap -->
                        @if (Auth::check())
                            <button wire:click="$dispatch('openUserModal')" aria-label="User account">
                                <i class="fas fa-user"></i>
                            </button>
                        @else
                            <button wire:click="$dispatch('show-modal')" aria-label="User account">
                                <i class="fas fa-user"></i>
                            </button>
                        @endif
                        <button onclick="toggleSidebarEvent()" aria-label="Shopping cart">
                            <i class="fas fa-shopping-cart"></i>
                            @if ($cartItemCount > 0)
                                <span
                                    class="absolute right-0 bg-red-500 text-white rounded-full text-xs w-5 h-5 flex items-center justify-center"
                                    style="transform: translate(25%, -50%);"> <!-- Modifica posizionamento -->
                                    {{ $cartItemCount }}
                                </span>
                            @endif
                        </button>
                        @if (Auth::check() && Auth::user()->hasMembership())
                            <a href="/meals" aria-label="Meals">
                                <i class="fas fa-utensils"></i>
                            </a>
                        @endif
                    </div>
                </div>
            </div>
            <div class="navbar-center hidden lg:flex">
                <ul class="menu menu-horizontal menu-sm gap-2 px-1 lg:pl-80 text-black pt-20 flex justify-between items-center">
                    <li class="font-medium flex items-center">
                        <a href="https://fitco.au" class="flex items-center">
                            <img src="/images/Fit Co_Blue.svg" alt="FitCo" class="w-16 h-16">
                        </a>
                    </li>
                    <li class="font-medium flex items-center">
                        @if (Auth::check())
                            <button wire:click="$dispatch('openUserModal')" aria-label="User account" class="flex items-center">
                                <i class="fas fa-user"></i>
                            </button>
                        @else
                            <button wire:click="$dispatch('show-modal')" aria-label="User account" class="flex items-center">
                                <i class="fas fa-user"></i>
                            </button>
                        @endif
                    </li>
                    <li class="font-medium flex items-center relative">
                        <button onclick="toggleSidebarEvent()" aria-label="Open shopping cart" class="flex items-center">
                            <i class="fas fa-shopping-cart"></i>
                            @if ($cartItemCount > 0)
                                <span
                                    class="absolute -top-2 -right-2 bg-red-500 text-white rounded-full text-xs w-5 h-5 flex items-center justify-center">
                                    {{ $cartItemCount }}
                                </span>
                            @endif
                        </button>
                    </li>
                    @if (Auth::check() && Auth::user()->hasMembership())
                        <li class="font-medium flex items-center">
                            <a href="/meals" aria-label="Meals" class="flex items-center">
                                <i class="fas fa-utensils"></i>
                            </a>
                        </li>
                    @endif
                </ul>
            </div>
        </nav>

        <!-- sm screen menu (drawer) -->
        <div class="drawer">
            <input id="my-drawer" type="checkbox" class="drawer-toggle" />
            <div class="drawer-side">
                <label for="my-drawer" aria-label="close sidebar" class="drawer-overlay"
                    style="background-color: transparent"></label>
                <ul class="menu min-h-full w-full pt-40 gap-2 p-4 pb-20 text-neutral flex flex-col items-center z-50"
                    style="background-image: radial-gradient(at top left, #FACB01 0%, #FAD961 50%, #FACB01 100%);">
                    <li class="font-medium">
                        <img class="w-50 md:w-32 lg:w-48 h-auto tracking-tighter" src="/images/logo-removebg.webp"
                            alt="FitFoodCo" width="192" height="128" />
                    </li>
                        <a href="https://fitco.au" onclick="document.getElementById('my-drawer').checked = false;">
                            <img src="/images/Fit Co_Blue.svg" alt="FitCo" class="w-12 h-12"> <!-- Aumentato a w-12 h-12 -->
                        </a>
                    </li>
                    <li class="font-medium text-red-700"><a
                            onclick="document.getElementById('my-drawer').checked = false;">Close</a></li>
                </ul>
            </div>
        </div>
    </div>
    <script>
document.addEventListener('DOMContentLoaded', function () {
    function getNextDeliveryDate() {
        const oggi = new Date();
        const january13 = new Date('2025-01-13T23:59:59');
        
        // Forza il ritorno del 13 gennaio se siamo prima di quella data
        if (oggi < january13) {
            console.log("Prima del 13 gennaio - Target: 13 gennaio");
            return january13;
        }
        
        // Dopo il 13 gennaio, calcola il prossimo lunedì
        const prossimoLunedi = new Date(oggi);
        prossimoLunedi.setDate(oggi.getDate() + ((1 + 7 - oggi.getDay()) % 7 || 7));
        prossimoLunedi.setHours(23, 59, 59, 999);
        
        console.log("Dopo il 13 gennaio - Target: prossimo lunedì", prossimoLunedi);
        return prossimoLunedi;
    }

    function updateCountdown() {
        const now = new Date();
        const targetDate = getNextDeliveryDate();
        const distance = targetDate - now;

        const days = Math.floor(distance / (1000 * 60 * 60 * 24));
        const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
        const seconds = Math.floor((distance % (1000 * 60)) / 1000);

        document.getElementById('days').innerText = String(days).padStart(2, '0');
        document.getElementById('hours').innerText = String(hours).padStart(2, '0');
        document.getElementById('minutes').innerText = String(minutes).padStart(2, '0');
        document.getElementById('seconds').innerText = String(seconds).padStart(2, '0');
    }

    updateCountdown();
    setInterval(updateCountdown, 1000);
});


            function toggleSidebarEvent() {
                window.dispatchEvent(new CustomEvent('toggleSidebar'));
            }
        </script>
</div>
