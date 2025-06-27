<x-guest-layout>
    <x-auth-card>
        <!-- Session Status -->
        <x-auth-session-status class="mb-4" :status="session('status')" />

        <!-- Validation Errors -->
        <x-auth-validation-errors class="mb-4" :errors="$errors" />

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="grid gap-6">
                <!-- Email Address -->
                <div class="space-y-2">
                    <x-form.label
                        for="email"
                        :value="__('Email')"
                    />

                    <x-form.input-with-icon-wrapper>
                        <x-slot name="icon">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-5 text-gray-400">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 0 1-2.25 2.25h-15a2.25 2.25 0 0 1-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25m19.5 0v.243a2.25 2.25 0 0 1-1.07 1.916l-7.5 4.615a2.25 2.25 0 0 1-2.36 0L3.32 8.91a2.25 2.25 0 0 1-1.07-1.916V6.75" />
                            </svg>


                        </x-slot>

                        <x-form.input
                            withicon
                            id="email"
                            class="block w-full"
                            type="email"
                            name="email"
                            :value="old('email')"
                            placeholder="{{ __('Email') }}"
                            required
                            autofocus
                        />
                    </x-form.input-with-icon-wrapper>
                </div>

                <!-- Password -->
                <div class="space-y-2">
                    <x-form.label
                        for="password"
                        :value="__('Password')"
                    />

                    <x-form.input-with-icon-wrapper>
                        <x-slot name="icon">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-5 text-gray-400">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 1 0-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 0 0 2.25-2.25v-6.75a2.25 2.25 0 0 0-2.25-2.25H6.75a2.25 2.25 0 0 0-2.25 2.25v6.75a2.25 2.25 0 0 0 2.25 2.25Z" />
                            </svg>

                        </x-slot>

                        <x-form.input
                            withicon
                            id="password"
                            class="block w-full"
                            type="password"
                            name="password"
                            required
                            autocomplete="current-password"
                            placeholder="{{ __('Password') }}"
                        />
                    </x-form.input-with-icon-wrapper>
                </div>

                <!-- Remember Me -->
                <div class="flex items-center justify-between">
                    <label for="remember_me" class="inline-flex items-center">
                        <input
                            id="remember_me"
                            type="checkbox"
                            class="text-purple-500 border-gray-300 rounded focus:border-purple-300 focus:ring focus:ring-purple-500 dark:border-gray-600 dark:bg-dark-eval-1 dark:focus:ring-offset-dark-eval-1"
                            name="remember"
                        >

                        <span class="ml-2 text-sm text-gray-600 dark:text-gray-400">
                            {{ __('Remember me') }}
                        </span>
                    </label>

                    @if (Route::has('password.request'))
                        <a class="text-sm text-blue-500 hover:underline" href="{{ route('password.request') }}">
                            {{ __('Forgot your password?') }}
                        </a>
                    @endif
                </div>

                <div>
                    <x-button class="justify-center w-full gap-2">
                        <span>{{ __('Log in') }}</span>
                    </x-button>
                </div>
            </div>
        </form>
    </x-auth-card>
</x-guest-layout>
