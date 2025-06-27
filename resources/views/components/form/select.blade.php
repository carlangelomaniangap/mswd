@props([
    'disabled' => false,
    'withicon' => false,
    'size' => 'md' // default size
])

@php
    $withiconClasses = $withicon ? 'pl-11 pr-4' : 'px-4 pr-8';

    $sizeClasses = match($size) {
        'sm' => 'text-sm py-1.5',
        'lg' => 'text-lg py-3',
        default => 'text-base py-2',
    };
@endphp

<select
    {{ $disabled ? 'disabled' : '' }}
    {!! $attributes->merge([
        'class' => "$withiconClasses $sizeClasses w-full border-gray-400 rounded-md focus:border-gray-400 focus:ring
        focus:ring-blue-500 focus:ring-offset-2 focus:ring-offset-white dark:border-gray-600
        dark:bg-dark-eval-1 dark:text-gray-300 dark:focus:ring-offset-dark-eval-1",
    ]) !!}
>
    {{ $slot }}
</select>
