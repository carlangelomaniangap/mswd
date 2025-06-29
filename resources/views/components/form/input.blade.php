@props([
    'disabled' => false,
    'withicon' => false,
    'blur' => false
])

@php
    $withiconClasses = $withicon ? 'pl-11 pr-4' : 'px-4';
    $blurClasses = $blur 
        ? 'backdrop-blur-sm bg-white/70 dark:bg-gray-900/70'
        : 'bg-white dark:bg-dark-eval-1';
@endphp

<input
    {{ $disabled ? 'disabled' : '' }}
    {!! $attributes->merge([
            'class' => $withiconClasses . 'py-2 border-gray-400 rounded-md focus:border-gray-400 focus:ring
            focus:ring-blue-500 focus:ring-offset-2 focus:ring-offset-white dark:border-gray-600 dark:bg-dark-eval-1
            dark:text-gray-300 dark:focus:ring-offset-dark-eval-1' . $blurClasses,
        ])
    !!}
>
