<div id="navbar-wrapper"
    class="sticky top-0 z-30 lg:bg-opacity-90 lg:fixed lg:backdrop-blur-lg w-full lg:h-40 flex items-center shadow-2xl"
    x-data="{ atTop: false }" :class="{ 'border-base-content/10': atTop, 'border-transparent': !atTop }"
    @scroll.window="atTop = (window.pageYOffset < 30) ? false: true"
    style="background-image: linear-gradient(to bottom, #FACB01 0%, #FAD961 100%);">
    <div class="container">
        <nav class="navbar px-0">
            <div class="navbar-start gap-2">
                <div class="flex-none lg:hidden">
                    <label for="my-drawer" aria-label="open sidebar" class="btn btn-square btn-ghost"
                        style="color: black !important;">
                        <i class="fas fa-bars text-xl text-black"></i> </label>
                </div>
                <!-- Navbar Brand logo -->
                <img class="w-50 md:w-40 lg:w-60 h-auto text-center tracking-tighter" src="/images/logo-removebg.webp"
                    alt="FitFoodCo" width="240" height="160" />
            </div>
    </div>
    <div class="navbar-center hidden lg:flex">
        <ul class="menu menu-horizontal menu-sm gap-2 px-1 lg:pl-80 text-black flex justify-between">
            <li class="font-medium"><a href="/admin">Admin</a></li>
            <li class="font-medium"><a wire:click="export">GetEmails</a></li>
            <li class="font-medium"><a href="/admin/membership">Membership</a></li>
            <li class="font-medium"><a href="/admin/uncooked">Uncooked</a></li>
            <li class="font-medium"><a href="/admin/undelivered">Undelivered</a></li>
            <li class="font-medium"><a href="/admin/cooked">Cooked</a></li>
            <li class="font-medium"><a href="/admin/delivered">Delivered</a></li>
        </ul>
    </div>
    </nav>

    <!-- sm screen menu (drawer) -->
    <div class="drawer">
        <input id="my-drawer" type="checkbox" class="drawer-toggle" />
        <div class="drawer-side">
            <label for="my-drawer" aria-label="close sidebar" class="drawer-overlay"
                style="background-color: transparent"></label>
            <ul class="menu min-h-full w-80 gap-2 p-4 text-neutral flex flex-col items-center z-50"
                style="background-image: radial-gradient(at top left, #FACB01 0%, #FAD961 50%, #FACB01 100%);">
                <li class="font-medium">
                    <img class="w-50 md:w-32 lg:w-48 h-auto tracking-tighter" src="/images/logo-removebg.webp"
                        alt="FitFoodCo" width="192" height="128" />
                </li>
                <li class="font-medium"><a href="/admin">Admin</a></li>
                <li class="font-medium"><a wire:click="export">GetEmails</a></li>
                <li class="font-medium"><a href="/admin/membership">Membership</a></li>
                <li class="font-medium"><a href="/admin/uncooked">Uncooked</a></li>
                <li class="font-medium"><a href="/admin/undelivered">Undelivered</a></li>
                <li class="font-medium"><a href="/admin/cooked">Cooked</a></li>
                <li class="font-medium"><a href="/admin/delivered">Delivered</a></li>
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
</script>
</div>
</div>
