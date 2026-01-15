@props(['disabled' => false])

<input {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['class' => 'border-gray-300 focus:border-tumbas-light focus:ring-tumbas-light rounded-md shadow-sm']) !!}>
