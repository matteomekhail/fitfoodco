<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'FitFoodCo') }} - Coming Soon</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700;800;1000&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
        integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-body antialiased overflow-x-hidden">
    <div class="min-h-screen bg-[#FACB01] flex flex-col justify-center items-center p-6">
        <div class="max-w-md w-full bg-[#EFE9E4] rounded-lg p-8 text-center">
            <div class="mb-6">
                <!-- Logo -->
                <img src="/images/logo-removebg.webp" alt="FitFoodCo Logo" class="h-32 mx-auto">
            </div>
            
            <h2 class="text-2xl font-bold text-black mb-4">We're Currently Closed</h2>
            
            <p class="text-black mb-6">
                Thank you for visiting our website. We are temporarily closed for maintenance and improvements.
                We'll be back <span class="font-bold text-purple-600">soon</span> with a <span class="font-bold text-blue-600">better</span> experience for you!
            </p>
            
            <div class="border-t border-gray-300 pt-6 mt-6">
                <p class="text-sm text-gray-700">
                    If you have any questions, please contact us at:
                    <a href="mailto:info@fitfoodco.com" class="text-green-700 hover:underline font-bold">
                        info@fitfoodco.com
                    </a>
                </p>
            </div>
        </div>
        
        <div class="mt-8 text-sm text-[#F8F8FF] font-medium">
            &copy; {{ date('Y') }} FitFoodCo. All rights reserved.
        </div>
    </div>
</body>
</html> 