<section id="menu" class="py-5 z-10" style="background: linear-gradient(to bottom, #000 0%, #000 95%);" id="menu">
    <div class="container mx-auto px-2 sm:px-0">
        <div class="mt-4 grid grid-cols-2 gap-4 sm:grid-cols-2 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
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
            @foreach ($products as $product)
                <div
                    class="bg-gradient-to-r from-gray-300 to-white transform transition-all duration-300 ease-in-out hover:scale-105 rounded-xl">
                    <div class="w-full h-64 overflow-hidden relative rounded-tl-xl rounded-tr-xl">
                        <!-- Immagine per dispositivi più grandi -->
                        <img src="{{ $product->image }}" alt="{{ $product->name }} image"
                            class="w-full h-full object-cover absolute product-image desktop-image" loading="lazy">
                        <!-- Immagine cropped per dispositivi mobili -->
                        <img src="{{ Str::replaceLast('.webp', 'cropped.webp', $product->image) }}"
                            alt="{{ $product->name }} image"
                            class="w-full h-full object-cover absolute product-image mobile-image" loading="lazy">
                    </div>
                    <div class="text-center text-black p-2">
                        <p class="capitalize my-1">
                            <strong>{{ $product->name }}</strong>
                        </p>
                        @php
                            $totalQuantity = collect($productQuantities)->sum();
                        @endphp
                        <span class="font-bold focus:ring-[#FAD961]">
                            @if (auth()->user() && auth()->user()->{"10Dollars"})
                                $ 10
                            @elseif (auth()->user() && auth()->user()->wholesale)
                                $ 9
                            @elseif ($totalQuantity > 20)
                                <del class="text-red-500">$ {{ $product->price }}</del> $ 10
                            @else
                                $ {{ $product->price }}
                            @endif
                        </span>
                        <div class="mt-3">
                            <p><strong>Calories:</strong> {{ $product->calories }} CAL</p>
                            <p><strong>Protein:</strong> {{ $product->protein }} P</p>
                            <p><strong>Fats:</strong> {{ $product->fats }} F</p>
                            <p><strong>Carbs:</strong> {{ $product->carbs }} C</p>
                        </div>
                        <div class="mt-3 flex justify-center items-center focus:ring-[#FAD961]">
                            <button wire:click="updateQuantity({{ $product->id }}, -1)"
                                class="bg-[#FACB01] text-black hover:text-gray-300 focus:ring-[#FAD961] py-2 px-4 rounded-full shadow-lg transition-all duration-300 ease-in-out transform hover:-translate-y-1 hover:scale-110 focus:outline-none">-</button>
                            <span
                                class="mx-4 text-2xl font-bold text-black shadow-text">{{ $productQuantities[$product->id] ?? 0 }}</span>
                            <button wire:click="updateQuantity({{ $product->id }}, 1)"
                                class="bg-[#FACB01] text-black hover:text-gray-300 focus:ring-[#FAD961] py-2 px-4 rounded-full shadow-lg transition-all duration-300 ease-in-out transform hover:-translate-y-1 hover:scale-110 focus:outline-none">+</button>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="flex min-h-screen items-center justify-center">
            <section class="px-40">
                <div class="mb-24 text-center">
                    <h3
                        class="block antialiased font-sans font-semibold relative mb-5 mt-10 text-center text-2xl leading-tight tracking-normal text-white">
                        We’ve got answers </h3>
                    <h1
                        class="block antialiased font-sans relative my-5 text-center text-4xl font-bold leading-tight tracking-normal text-white md:text-5xl">
                        Frequently Asked Questions </h1>
                </div>
                <div class="grid grid-cols-12 ">
                    <div class="col-span-12 lg:col-start-4 lg:col-span-6">
                        <h5
                            class="block antialiased tracking-normal font-sans text-xl leading-snug text-inherit mt-6 mb-1 font-semibold !text-white">
                            Are FitFoodCo meals Halal? </h5>
                        <div
                            class="block antialiased font-sans text-base leading-relaxed mb-4 font-normal text-gray-300">
                            Yes</div>
                        <hr class="my-6 border-blue-gray-50">
                        {{-- <h5
                            class="block antialiased tracking-normal font-sans text-xl leading-snug text-inherit mt-6 mb-1 font-semibold !text-white">
                            Can you use Tailwind CSS with Angular? </h5>
                        <div
                            class="block antialiased font-sans text-base leading-relaxed mb-4 font-normal text-gray-300">
                            Yes, you can surely use the Tailwind CSS framework with Angular. Tailwind CSS is a popular
                            utility-first CSS framework that can be integrated into Angular projects. It provides a set
                            of pre-designed utility classes that can help streamline your styling and layout efforts
                            when building Angular applications. Check our documentation that explains how you can easily
                            integrate them. </div>
                        <hr class="my-6 border-blue-gray-50">
                        <h5
                            class="block antialiased tracking-normal font-sans text-xl leading-snug text-inherit mt-6 mb-1 font-semibold !text-white">
                            What is Tailwind CSS in Angular? </h5>
                        <div
                            class="block antialiased font-sans text-base leading-relaxed mb-4 font-normal text-gray-300">
                            Tailwind CSS in Angular refers to the integration of the Tailwind CSS framework into Angular
                            applications. It allows Angular developers to leverage Tailwind's utility classes to style
                            and design user interfaces. </div>
                        <hr class="my-6 border-blue-gray-50">
                        <h5
                            class="block antialiased tracking-normal font-sans text-xl leading-snug text-inherit mt-6 mb-1 font-semibold !text-white">
                            Is Tailwind CSS faster than CSS? </h5>
                        <div
                            class="block antialiased font-sans text-base leading-relaxed mb-4 font-normal text-gray-300">
                            Tailwind CSS and traditional CSS serve different purposes. Tailwind CSS is not inherently
                            faster or slower than CSS; instead, it focuses on providing utility classes to expedite the
                            development process. Whether Tailwind CSS is faster for your project depends on factors like
                            your familiarity with the framework and your project's specific requirements. </div>
                        <hr class="my-6 border-blue-gray-50">
                        <h5
                            class="block antialiased tracking-normal font-sans text-xl leading-snug text-inherit mt-6 mb-1 font-semibold !text-white">
                            Is Tailwind CSS good to use? </h5>
                        <div
                            class="block antialiased font-sans text-base leading-relaxed mb-4 font-normal text-gray-300">
                            Yes, Tailwind CSS is considered a valuable tool in web development, and it's becoming more
                            and more popular nowadays. It offers a structured approach to styling, streamlining the
                            design process and making it easier to maintain and scale projects. </div>
                        <hr class="my-6 border-blue-gray-50">
                        <h5
                            class="block antialiased tracking-normal font-sans text-xl leading-snug text-inherit mt-6 mb-1 font-semibold !text-white">
                            Is Tailwind CSS good for Angular? </h5>
                        <div
                            class="block antialiased font-sans text-base leading-relaxed mb-4 font-normal text-gray-300">
                            Tailwind CSS can be a great choice for styling Angular applications. Its utility classes can
                            help maintain consistency and speed up development. However, the suitability of Tailwind CSS
                            for Angular depends on your project's requirements and your team's familiarity with both
                            technologies. It's often a matter of personal or team preference, so consider your specific
                            context when deciding whether to use it with Angular. </div> --}}
                    </div>
                </div>
            </section>

        </div>

</section>
