@props(['blur' => false])

<main class="flex flex-col items-center flex-1 px-4 pt-6 sm:justify-center">
    {{-- <div>
        <a href="/">
            <x-application-logo class="w-20 h-20" />
        </a>
    </div> --}}

    <div class="{{ $blur 
        ? 'w-full px-6 py-4 my-6 overflow-hidden rounded-md shadow-md backdrop-blur-sm bg-white/65 dark:bg-gray-900/65' 
        : 'w-full px-6 py-4 my-6 overflow-hidden bg-white rounded-md shadow-md dark:bg-dark-eval-1' }} sm:max-w-md">
        {{ $slot }}
    </div>
</main>