<div id="navbar-wrapper"
    class="sticky top-0 z-30 lg:bg-opacity-90 lg:fixed lg:backdrop-blur-lg w-full lg:h-60 h-48 flex items-center shadow-2xl"
    x-data="{ atTop: false }" :class="{ 'border-base-content/10': atTop, 'border-transparent': !atTop }"
    @scroll.window="atTop = (window.pageYOffset < 30) ? false: true"
    style="background-image: linear-gradient(to bottom, #FACB01 0%, #FAD961 100%);">
    <div
        class="sticky top-0 z-30 lg:bg-opacity-90 lg:fixed lg:backdrop-blur-lg w-full lg:h-60 h-48 flex items-center shadow-2xl">
        <div class="w-full bg-black text-white py-2 text-center fixed top-0 z-50">
            <p class="text-lg font-bold">Next delivery day:</p>
            <div class="flex justify-center text-xl font-bold" wire:ignore>
                <div class="px-1">
                    <span id="days"></span>
                    <div class="text-sm">Days</div>
                </div>
                <div class="px-1">
                    <span id="hours"></span>
                    <div class="text-sm">Hours</div>
                </div>
                <div class="px-1">
                    <span id="minutes"></span>
                    <div class="text-sm">Minutes</div>
                </div>
                <div class="px-1">
                    <span id="seconds"></span>
                    <div class="text-sm">Seconds</div>
                </div>
            </div>
        </div>
        <div class="container">
            <nav class="navbar px-0">
                <div class="navbar-start pt-20 gap-2">
                    <div class="flex-none lg:hidden">
                        <label for="my-drawer" aria-label="open sidebar" class="btn btn-square btn-ghost"
                            style="color: black !important;">
                            <i class="fas fa-bars text-xl text-black"></i> </label>
                    </div>
                    <!-- Navbar Brand logo -->
                    <img class="w-50 md:w-40 lg:w-60 h-auto text-center tracking-tighter"
                        src="/images/logo-removebg.webp" alt="FitFoodCo" width="240" height="160" />
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
                    <ul class="menu menu-horizontal menu-sm gap-2 px-1 lg:pl-80 text-black pt-20 flex justify-between">
                        <li class="font-medium"><a href="/">Home</a></li>
                        <li class="font-medium"><a href="/#services">Menu</a></li>
                        <li class="font-medium pt-1 relative">
                            @if (Auth::check())
                                <button wire:click="$dispatch('openUserModal')" aria-label="User account">
                                    <i class="fas fa-user"></i>
                                </button>
                            @else
                                <button wire:click="$dispatch('show-modal')" aria-label="User account">
                                    <i class="fas fa-user"></i>
                                </button>
                            @endif
                        </li>
                        <li class="font-medium pt-1 relative">
                            <button onclick="toggleSidebarEvent()" aria-label="Open shopping cart">
                                <i class="fas fa-shopping-cart"></i>
                                @if ($cartItemCount > 0)
                                    <span
                                        class="absolute right-0 bg-red-500 text-white rounded-full text-xs w-5 h-5 flex items-center justify-center"
                                        style="top: -6px;">
                                        {{ $cartItemCount }}
                                    </span>
                                @endif
                            </button>
                        </li>
                        @if (Auth::check() && Auth::user()->hasMembership())
                            <li class="font-medium pt-1 relative">
                                <a href="/meals" aria-label="Meals">
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
                    <ul class="menu min-h-full w-full pt-40 gap-2 p-4 text-neutral flex flex-col items-center z-50"
                        style="background-image: radial-gradient(at top left, #FACB01 0%, #FAD961 50%, #FACB01 100%);">
                        <li class="font-medium">
                            <img class="w-50 md:w-32 lg:w-48 h-auto tracking-tighter" src="/images/logo-removebg.webp"
                                alt="FitFoodCo" width="192" height="128" />
                        </li>
                        <li class="font-medium"><a href="/"
                                onclick="document.getElementById('my-drawer').checked = false;">Home</a></li>
                        <li class="font-medium"><a href="/#menu"
                                onclick="document.getElementById('my-drawer').checked = false;">Menu</a></li>
                        <li class="font-medium text-red-700"><a
                                onclick="document.getElementById('my-drawer').checked = false;">Close</a></li>
                    </ul>
                </div>
            </div>

        </div>
        <script>
            document.querySelector('a[href="/#menu"]').addEventListener('click', function(e) {
                e.preventDefault();
                window.scrollTo({
                    top: document.querySelector('#menu').offsetTop + 100, // 100 is the offset from the top
                    behavior: 'smooth'
                });
            });

            function toggleSidebarEvent() {
                window.dispatchEvent(new CustomEvent('toggleSidebar'));
            }

            function getNextDeliveryDate() {
                const oggi = new Date();
                const giorniFinoALunedi = (1 + 7 - oggi.getDay()) % 7;
                const prossimoLunedi = new Date(oggi);
                prossimoLunedi.setDate(oggi.getDate() + giorniFinoALunedi);
                prossimoLunedi.setHours(23, 59, 59, 999);
                return prossimoLunedi;
            }

            function updateCountdown() {
                const now = new Date();
                const targetDate = getNextDeliveryDate();
                const distance = targetDate - now;

                // Calcolo giorni, ore, minuti e secondi
                const days = Math.floor(distance / (1000 * 60 * 60 * 24));
                const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                const seconds = Math.floor((distance % (1000 * 60)) / 1000);

                // Visualizza il risultato
                document.getElementById('days').innerText = days;
                document.getElementById('hours').innerText = hours;
                document.getElementById('minutes').innerText = minutes;
                document.getElementById('seconds').innerText = seconds;
            }

            // Aggiorna il countdown ogni 1 secondo
            setInterval(updateCountdown, 1000);

            // Aggiorna il countdown ogni 1 secondo
            setInterval(updateCountdown, 1000);
        </script>
    </div>
</div>
