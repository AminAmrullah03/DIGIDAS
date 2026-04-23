@props(['active'])

@php
$classes = ($active ?? false)
            ? 'block w-full ps-3 pe-4 py-2 rounded-md text-start text-base font-medium bg-emerald-700 text-white transition duration-150 ease-in-out'
            : 'block w-full ps-3 pe-4 py-2 rounded-md text-start text-base font-medium text-emerald-100 hover:bg-emerald-500 hover:text-white transition duration-150 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
