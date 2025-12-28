<x-guest-layout>
    <div class="w-full max-w-md">
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-2xl overflow-hidden">
            <!-- Header with gradient -->
            <div class="bg-gradient-to-r from-primary-500 to-secondary-500 p-8 text-center">
                <h1 class="text-3xl font-bold text-white">Welcome Back</h1>
                <p class="text-primary-100 mt-2 text-sm">Sign in to your account</p>
            </div>

            <!-- Session Status -->
            @if (session('status'))
                <div class="mx-6 mt-6">
                    <div class="bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 text-green-700 dark:text-green-400 px-4 py-3 rounded-lg">
                        {{ session('status') }}
                    </div>
                </div>
            @endif

            <!-- Form -->
            <form method="POST" action="{{ route('login') }}" class="p-8 space-y-6">
                @csrf

                <!-- Email Address -->
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        {{ __('Email') }}
                    </label>
                    <input 
                        id="email" 
                        type="email" 
                        name="email" 
                        value="{{ old('email') }}"
                        class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:border-primary-500 focus:ring-2 focus:ring-primary-200 dark:focus:ring-primary-800 transition duration-200 placeholder-gray-400" 
                        placeholder="your@email.com" 
                        required 
                        autofocus 
                        autocomplete="username"
                    />
                    @error('email')
                        <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Password -->
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        {{ __('Password') }}
                    </label>
                    <input 
                        id="password" 
                        type="password"
                        name="password"
                        class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:border-primary-500 focus:ring-2 focus:ring-primary-200 dark:focus:ring-primary-800 transition duration-200 placeholder-gray-400"
                        placeholder="••••••••"
                        required 
                        autocomplete="current-password"
                    />
                    @error('password')
                        <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Remember Me -->
                <div class="flex items-center">
                    <input 
                        id="remember_me" 
                        type="checkbox" 
                        name="remember"
                        class="h-4 w-4 text-primary-600 focus:ring-primary-500 border-gray-300 dark:border-gray-600 rounded transition duration-200"
                    />
                    <label for="remember_me" class="ml-2 block text-sm text-gray-700 dark:text-gray-300">
                        {{ __('Remember me') }}
                    </label>
                </div>

                <!-- Actions -->
                <div class="flex items-center justify-between pt-2">
                    <div class="flex flex-col space-y-2">
                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}" class="text-sm text-primary-600 dark:text-primary-400 hover:text-primary-800 dark:hover:text-primary-300 transition duration-200 font-medium">
                                {{ __('Forgot your password?') }}
                            </a>
                        @endif
                        <a href="{{ route('register') }}" class="text-sm text-primary-600 dark:text-primary-400 hover:text-primary-800 dark:hover:text-primary-300 transition duration-200 font-medium">
                            {{ __("Don't have an account?") }}
                        </a>
                    </div>
                    <button 
                        type="submit" 
                        class="px-6 py-3 bg-gradient-to-r from-primary-500 to-secondary-500 text-white font-semibold rounded-lg hover:from-primary-600 hover:to-secondary-600 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition duration-200 shadow-lg hover:shadow-xl transform hover:scale-105"
                    >
                        {{ __('Log in') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-guest-layout>