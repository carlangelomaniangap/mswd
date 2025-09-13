<nav
    aria-label="secondary"
    x-data="{ open: false }"
    class="sticky top-0 z-10 flex items-center justify-between px-4 py-4 sm:px-6 transition-transform duration-500 bg-white dark:bg-dark-eval-1"
    :class="{
        '-translate-y-full': scrollingDown,
        'translate-y-0': scrollingUp,
    }">

    <div class="flex items-center gap-3">
        <x-button
            type="button"
            class="md:hidden"
            icon-only
            variant="secondary"
            sr-text="Toggle dark mode"
            x-on:click="toggleTheme"
        >
            <x-heroicon-o-moon
                x-show="!isDarkMode"
                aria-hidden="true"
                class="w-6 h-6"
            />

            <x-heroicon-o-sun
                x-show="isDarkMode"
                aria-hidden="true"
                class="w-6 h-6"
            />
        </x-button>
    </div>

    <div class="flex items-center gap-3">
        <x-button
            type="button"
            class="hidden md:inline-flex"
            icon-only
            variant="secondary"
            sr-text="Toggle dark mode"
            x-on:click="toggleTheme"
        >
            <x-heroicon-o-moon
                x-show="!isDarkMode"
                aria-hidden="true"
                class="w-6 h-6"
            />

            <x-heroicon-o-sun
                x-show="isDarkMode"
                aria-hidden="true"
                class="w-6 h-6"
            />
        </x-button>

        <x-dropdown align="right" width="48">
            <x-slot name="trigger">
                <button
                    class="flex items-center p-2 text-sm font-medium text-gray-500 rounded-md transition duration-150 ease-in-out hover:text-gray-700 focus:outline-none focus:ring focus:ring-blue-500 focus:ring-offset-1 focus:ring-offset-white dark:focus:ring-offset-dark-eval-1 dark:text-gray-400 dark:hover:text-gray-200"
                >
                    <div>{{ Auth::user()->name }}</div>

                    <div class="ml-1">
                        <svg
                            class="w-4 h-4 fill-current"
                            xmlns="http://www.w3.org/2000/svg"
                            viewBox="0 0 20 20"
                        >
                            <path
                                fill-rule="evenodd"
                                d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                clip-rule="evenodd"
                            />
                        </svg>
                    </div>
                </button>
            </x-slot>

            <x-slot name="content">
                <!-- Profile -->
                <x-dropdown-link
                    :href="route('profile.edit')"
                >
                    {{ __('Profile') }}
                </x-dropdown-link>

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-dropdown-link
                        :href="route('logout')"
                        onclick="event.preventDefault(); this.closest('form').submit();"
                    >
                        {{ __('Log Out') }}
                    </x-dropdown-link>
                </form>
            </x-slot>
        </x-dropdown>
    </div>
</nav>

<!-- Mobile bottom bar -->
<div
    class="fixed inset-x-0 bottom-0 flex items-center justify-center gap-4 px-4 py-4 sm:px-6 transition-transform duration-500 bg-white md:hidden dark:bg-dark-eval-1"
    :class="{
        'translate-y-full': scrollingDown,
        'translate-y-0': scrollingUp,
    }"
>
    @auth
        @if (Auth::user()->role === 'admin')
            <a href="{{ route('admin.dashboard') }}">
                <x-application-logo aria-hidden="true" class="w-10 h-10" />

                <span class="sr-only">Dashboard</span>
            </a>
        @elseif (Auth::user()->role === 'pwd')
            <a href="{{ route('pwd.dashboard') }}">
                <x-application-logo aria-hidden="true" class="w-10 h-10" />

                <span class="sr-only">Dashboard</span>
            </a>
        @elseif (Auth::user()->role === 'aics')
            <a href="{{ route('aics.dashboard') }}">
                <x-application-logo aria-hidden="true" class="w-10 h-10" />

                <span class="sr-only">Dashboard</span>
            </a>
        @elseif (Auth::user()->role === 'senior_citizen')
            <a href="{{ route('senior_citizen.dashboard') }}">
                <x-application-logo aria-hidden="true" class="w-10 h-10" />

                <span class="sr-only">Dashboard</span>
            </a>
        @elseif (Auth::user()->role === 'solo_parent')
            <a href="{{ route('solo_parent.dashboard') }}">
                <x-application-logo aria-hidden="true" class="w-10 h-10" />

                <span class="sr-only">Dashboard</span>
            </a>
        @endif
    @endauth

    @auth
        @if (Auth::user()->role === 'admin')
            <x-sidebar.link
                title="Dashboard"
                href="{{ route('admin.dashboard') }}"
                :isActive="request()->routeIs('admin.dashboard')"
            >
                <x-slot name="icon">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m2.25 12 8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
                    </svg>
                </x-slot>
            </x-sidebar.link>

            <x-sidebar.link
                title="PWD Records"
                href="{{ route('admin.pwd') }}"
                :isActive="request()->routeIs('admin.pwd')"
            >
                <x-slot name="icon">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M18 18.72a9.094 9.094 0 0 0 3.741-.479 3 3 0 0 0-4.682-2.72m.94 3.198.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0 1 12 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 0 1 6 18.719m12 0a5.971 5.971 0 0 0-.941-3.197m0 0A5.995 5.995 0 0 0 12 12.75a5.995 5.995 0 0 0-5.058 2.772m0 0a3 3 0 0 0-4.681 2.72 8.986 8.986 0 0 0 3.74.477m.94-3.197a5.971 5.971 0 0 0-.94 3.197M15 6.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm6 3a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Zm-13.5 0a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Z" />
                    </svg>
                </x-slot>
            </x-sidebar.link>
            
            <x-sidebar.link
                title="AICS Records"
                href="{{ route('admin.aics') }}"
                :isActive="request()->routeIs('admin.aics')"
            >
                <x-slot name="icon">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12Z" />
                    </svg>
                </x-slot>
            </x-sidebar.link>

            <x-sidebar.link
                title="Senior Citizen Records"
                href="{{ route('admin.senior_citizen') }}"
                :isActive="request()->routeIs('admin.senior_citizen')"
            >
                <x-slot name="icon">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M18 7.5v3m0 0v3m0-3h3m-3 0h-3m-2.25-4.125a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0ZM3 19.235v-.11a6.375 6.375 0 0 1 12.75 0v.109A12.318 12.318 0 0 1 9.374 21c-2.331 0-4.512-.645-6.374-1.766Z" />
                    </svg>
                </x-slot>
            </x-sidebar.link>

            <x-sidebar.link
                title="Solo Parent Records"
                href="{{ route('admin.solo_parent') }}"
                :isActive="request()->routeIs('admin.solo_parent')"
            >
                <x-slot name="icon">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17.982 18.725A7.488 7.488 0 0 0 12 15.75a7.488 7.488 0 0 0-5.982 2.975m11.963 0a9 9 0 1 0-11.963 0m11.963 0A8.966 8.966 0 0 1 12 21a8.966 8.966 0 0 1-5.982-2.275M15 9.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                    </svg>
                </x-slot>
            </x-sidebar.link>

            <x-sidebar.link
                title="Reports"
                href="{{ route('admin.reports') }}"
                :isActive="request()->routeIs('admin.reports')"
            >
                <x-slot name="icon">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="square" d="M9 8v3a1 1 0 0 1-1 1H5m11 4h2a1 1 0 0 0 1-1V5a1 1 0 0 0-1-1h-7a1 1 0 0 0-1 1v1m4 3v10a1 1 0 0 1-1 1H6a1 1 0 0 1-1-1v-7.13a1 1 0 0 1 .24-.65L7.7 8.35A1 1 0 0 1 8.46 8H13a1 1 0 0 1 1 1Z"/>
                    </svg>
                </x-slot>
            </x-sidebar.link>

            <x-sidebar.link
                title="Manage Account"
                href="{{ route('admin.manage_account') }}"
                :isActive="request()->routeIs('admin.manage_account')"
            >
                <x-slot name="icon">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="square" d="M10 19H5a1 1 0 0 1-1-1v-1a3 3 0 0 1 3-3h2m10 1a3 3 0 0 1-3 3m3-3a3 3 0 0 0-3-3m3 3h1m-4 3a3 3 0 0 1-3-3m3 3v1m-3-4a3 3 0 0 1 3-3m-3 3h-1m4-3v-1m-2.121 1.879-.707-.707m5.656 5.656-.707-.707m-4.242 0-.707.707m5.656-5.656-.707.707M12 8a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                    </svg>
                </x-slot>
            </x-sidebar.link>
        @elseif (Auth::user()->role === 'pwd')
            <x-sidebar.link
                title="Dashboard"
                href="{{ route('pwd.dashboard') }}"
                :isActive="request()->routeIs('pwd.dashboard')"
            >
                <x-slot name="icon">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m2.25 12 8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
                    </svg>
                </x-slot>
            </x-sidebar.link>

            <x-sidebar.link
                title="PWD Records"
                href="{{ route('pwd.records') }}"
                :isActive="request()->routeIs('pwd.records')"
            >
                <x-slot name="icon">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M18 18.72a9.094 9.094 0 0 0 3.741-.479 3 3 0 0 0-4.682-2.72m.94 3.198.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0 1 12 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 0 1 6 18.719m12 0a5.971 5.971 0 0 0-.941-3.197m0 0A5.995 5.995 0 0 0 12 12.75a5.995 5.995 0 0 0-5.058 2.772m0 0a3 3 0 0 0-4.681 2.72 8.986 8.986 0 0 0 3.74.477m.94-3.197a5.971 5.971 0 0 0-.94 3.197M15 6.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm6 3a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Zm-13.5 0a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Z" />
                    </svg>
                </x-slot>
            </x-sidebar.link>
        @elseif (Auth::user()->role === 'aics')
            <x-sidebar.link
                title="Dashboard"
                href="{{ route('aics.dashboard') }}"
                :isActive="request()->routeIs('aics.dashboard')"
            >
                <x-slot name="icon">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m2.25 12 8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
                    </svg>
                </x-slot>
            </x-sidebar.link>

            <x-sidebar.link
                title="AICS Records"
                href="{{ route('aics.records') }}"
                :isActive="request()->routeIs('aics.records')"
            >
                <x-slot name="icon">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12Z" />
                    </svg>
                </x-slot>
            </x-sidebar.link>
        @elseif (Auth::user()->role === 'senior_citizen')
            <x-sidebar.link
                title="Dashboard"
                href="{{ route('senior_citizen.dashboard') }}"
                :isActive="request()->routeIs('senior_citizen.dashboard')"
            >
                <x-slot name="icon">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m2.25 12 8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
                    </svg>
                </x-slot>
            </x-sidebar.link>

            <x-sidebar.link
                title="Senior Citizen Records"
                href="{{ route('senior_citizen.records') }}"
                :isActive="request()->routeIs('senior_citizen.records')"
            >
                <x-slot name="icon">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12Z" />
                    </svg>
                </x-slot>
            </x-sidebar.link>
        @elseif (Auth::user()->role === 'solo_parent')
            <x-sidebar.link
                title="Dashboard"
                href="{{ route('solo_parent.dashboard') }}"
                :isActive="request()->routeIs('solo_parent.dashboard')"
            >
                <x-slot name="icon">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m2.25 12 8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
                    </svg>
                </x-slot>
            </x-sidebar.link>

            <x-sidebar.link
                title="Solo Parent Records"
                href="{{ route('solo_parent.records') }}"
                :isActive="request()->routeIs('solo_parent.records')"
            >
                <x-slot name="icon">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12Z" />
                    </svg>
                </x-slot>
            </x-sidebar.link>
        @endif
    @endauth
</div>
