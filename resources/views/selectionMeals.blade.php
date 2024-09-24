<!doctype html>
<html lang="en" class="relative scroll-smooth">

<head>
    <meta charset="utf-8" />
    <title>FitFoodCo</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <meta content="FitFoodCo Seriously Good Food!" name="description" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=5">
    <!-- Theme favicon -->
    <link rel="shortcut icon" href="/images/favicon.ico" />
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/theme-change@2.0.2/index.js" defer></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
        integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" defer />
    @livewireStyles
</head>

<body class="overflow-x-hidden font-body text-sm text-base-content antialiased ">

    @livewire('navbar')
    @livewire('MealSelectionModal')
    @livewire('sidebar-cart')
    @livewire('LoginRegisterModal')
    @livewire('UserDetailsModal')
    @include('components.footer')
    @livewireScripts
</body>

</html>
