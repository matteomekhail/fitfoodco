<div
    class="{{ $showModal ? 'overflow-x-hidden overflow-y-auto fixed h-modal md:h-full top-4 left-0 right-0 md:inset-0 z-50 flex items-center justify-center ' : '' }}">
    @if ($showModal)
        <div class="fixed inset-0 flex items-center justify-center z-50">
            <div class="absolute inset-0 bg-black opacity-50 z-50"></div>
            <div id="authentication-modal" aria-hidden="true" class="relative w-full max-w-md px-4 mx-auto z-50">
                <div class="bg-white rounded-lg shadow relative">
                    <div class="flex justify-end p-2">
                        <button type="button" wire:click="$set('showModal', false)"
                            class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-black rounded-lg text-sm p-1.5 ml-auto inline-flex items-center ">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"
                                xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd"
                                    d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                    clip-rule="evenodd"></path>
                            </svg>
                        </button>
                    </div>
                    @if ($form != 'login' && $form != 'forgot_password')
                        <!-- Registration form goes here -->
                        <form class="space-y-6 px-6 lg:px-8 pb-4 sm:pb-6 xl:pb-8" wire:submit="register">
                            @csrf
                            <h3 class="text-xl font-bold">
                                Register to
                                <span class="font-bold text-[#FACB01]">
                                    FitFoodCo
                                </span>
                            </h3>
                            <div>
                                <label for="first_name" class="text-sm font-medium text-black block mb-2">Your First
                                    Name</label>
                                <input type="text" name="first_name" id="first_name" wire:model.live="first_name"
                                    class="bg-gray-50 border border-gray-300 text-black sm:text-sm rounded-lg focus:ring-yellow-500 focus:border-yellow-500 block w-full p-2.5 "
                                    placeholder="John" required="">
                                @error('first_name')
                                    <span class="text-red-500 text-sm">{{ $message }}</span>
                                @enderror
                            </div>
                            <div>
                                <label for="last_name" class="text-sm font-medium text-black block mb-2">Your Last
                                    Name</label>
                                <input type="text" name="last_name" id="last_name" wire:model.live="last_name"
                                    class="bg-gray-50 border border-gray-300 text-black sm:text-sm rounded-lg focus:ring-yellow-500 focus:border-yellow-500 block w-full p-2.5 "
                                    placeholder="Doe" required="">
                                @error('last_name')
                                    <span class="text-red-500 text-sm">{{ $message }}</span>
                                @enderror
                            </div>
                            <div>
                                <label for="email" class="text-sm font-medium text-black block mb-2">Your
                                    email</label>
                                <input type="email" name="email" id="email" wire:model.live="email"
                                    class="bg-gray-50 border border-gray-300 text-black sm:text-sm rounded-lg focus:ring-yellow-500 focus:border-yellow-500 block w-full p-2.5 "
                                    placeholder="name@provider.com" required="">
                                @error('email')
                                    <span class="text-red-500 text-sm">{{ $message }}</span>
                                @enderror
                            </div>
                            <div>
                                <label for="password" class="text-sm font-medium text-black block mb-2 ">Your
                                    password</label>
                                <input type="password" name="password" id="password" wire:model.live="password"
                                    placeholder="••••••••"
                                    class="bg-gray-50 border border-gray-300 text-black sm:text-sm rounded-lg focus:ring-yellow-500 focus:border-yellow-500 block w-full p-2.5 "
                                    required="">
                                @error('password')
                                    <span class="text-red-500 text-sm">{{ $message }}</span>
                                @enderror
                            </div>
                            <div>
                                <label for="password_confirmation"
                                    class="text-sm font-medium text-black block mb-2 ">Confirm your password</label>
                                <input type="password" name="password_confirmation" id="password_confirmation"
                                    wire:model.live="password_confirmation" placeholder="••••••••"
                                    class="bg-gray-50 border border-gray-300 text-black sm:text-sm rounded-lg focus:ring-yellow-500 focus:border-yellow-500 block w-full p-2.5 "
                                    required="">
                                @error('password_confirmation')
                                    <span class="text-red-500 text-sm">{{ $message }}</span>
                                @enderror
                            </div>

                            <button wire:click="register()" type="submit"
                                class="transition-all duration-500 ease-in-out transform hover:scale-110 w-full text-black bg-gradient-to-r from-yellow-400 via-yellow-300 to-yellow-500 focus:ring-yellow-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">
                                Create your account
                            </button>
                            <div class="text-sm font-medium text-gray-500 ">
                                Already have an account? <a href="#" wire:click="$set('form', 'login')"
                                    class="text-[#FACB01] font-bold hover:underline ">Sign in</a>
                            </div>
                        </form>
                    @elseif ($form == 'forgot_password')
                        <!-- Forgot password form goes here -->
                        <form class="space-y-6 px-6 lg:px-8 pb-4 sm:pb-6 xl:pb-8" wire:submit="forgotPassword">
                            @csrf
                            <h3 class="text-xl font-bold">
                                Reset your password
                                <span class="font-bold text-[#FACB01]">
                                    FitFoodCo
                                </span>
                            </h3>
                            @if (session('message'))
                                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative"
                                    role="alert">
                                    <strong class="font-bold">Success!</strong> <br>
                                    <span class="block sm:inline">{{ session('message') }}</span>
                                </div>
                            @endif
                            <div>
                                <label for="email" class="text-sm font-medium text-black block mb-2">Your
                                    email</label>
                                <input type="email" name="email" id="email" wire:model.live="email"
                                    class="bg-gray-50 border border-gray-300 text-black sm:text-sm rounded-lg focus:ring-yellow-500 focus:border-yellow-500 block w-full p-2.5 "
                                    placeholder="name@provider.com" required="">
                                @error('email')
                                    <span class="text-red-500 text-sm">{{ $message }}</span>
                                @enderror
                            </div>
                            <button type="submit"
                                class="transition-all duration-500 ease-in-out transform hover:scale-110 w-full text-black bg-gradient-to-r from-yellow-400 via-yellow-300 to-yellow-500 focus:ring-yellow-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">
                                Send reset link
                            </button>
                            <div class="text-sm font-medium text-gray-500 ">
                                Remembered your password? <a href="#" wire:click="$set('form', 'login')"
                                    class="text-[#FACB01] font-bold hover:underline ">Sign in</a>
                            </div>
                        </form>
                    @else
                        <form class="space-y-6 px-6 lg:px-8 pb-4 sm:pb-6 xl:pb-8" wire:submit="login">
                            @csrf
                            <h3 class="text-xl font-bold">
                                Sign in to
                                <span class="font-bold text-[#FACB01]">
                                    FitFoodCo
                                </span>
                            </h3>
                            <div>
                                <label for="email" class="text-sm font-medium text-black block mb-2">Your
                                    email</label>
                                <input type="email" name="email" id="email" wire:model.live="email"
                                    class="bg-gray-50 border border-gray-300 text-black sm:text-sm rounded-lg focus:ring-yellow-500 focus:border-yellow-500 block w-full p-2.5 "
                                    placeholder="name@provider.com" required="">
                                @error('email')
                                    <span class="text-red-500 text-sm">{{ $message }}</span>
                                @enderror
                            </div>
                            <div>
                                <label for="password" class="text-sm font-medium text-black block mb-2 ">Your
                                    password</label>
                                <input type="password" name="password" id="password" placeholder="••••••••"
                                    wire:model.live="password"
                                    class="bg-gray-50 border border-gray-300 text-black sm:text-sm rounded-lg focus:ring-yellow-500 focus:border-yellow-500 block w-full p-2.5 "
                                    required="">
                                @error('password')
                                    <span class="text-red-500 text-sm">{{ $message }}</span>
                                @enderror

                            </div>
                            <div class="flex justify-between">
                                <div class="flex items-start">
                                    <div class="flex items-center h-5">
                                        <input id="remember" aria-describedby="remember" type="checkbox"
                                            wire:model.live="remember"
                                            class="bg-gray-50 border border-gray-300 focus:ring-3 focus:ring-yellow-300 h-4 w-4 rounded ">
                                    </div>
                                    <div class="text-sm ml-3">
                                        <label for="remember" class="font-medium text-black ">Remember
                                            me</label>
                                    </div>
                                </div>
                                <a href="#" class="text-sm text-[#FACB01] font-bold hover:underline "
                                    wire:click="$set('form', 'forgot_password')">Forgot
                                    Password?</a>
                            </div>
                            @if (session()->has('error'))
                                <div class="text-red-500 text-sm mb-4">{{ session('error') }}</div>
                            @endif
                            <button type="submit"
                                class="transition-all duration-500 ease-in-out transform hover:scale-110 w-full text-black bg-gradient-to-r from-yellow-400 via-yellow-300 to-yellow-500 focus:ring-yellow-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">
                                Login to your account
                            </button>
                            <div class="text-sm font-medium text-gray-500 ">
                                Not registered? <a href="#" wire:click="$set('form', 'register')"
                                    class="text-[#FACB01] font-bold hover:underline ">Create account</a>
                            </div>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    @endif
</div>
