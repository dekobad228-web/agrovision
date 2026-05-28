@props([
    'href' => null,
    'icon' => 'help',
    'type' => 'default',
    'color' => null,
    'bg' => null,
])
@php
    $tag = $href ? 'a' : 'div';

    if ($type === 'toggle') {
        $classes = 'icon-toggle';
        $classes .= $bg ? ' icon-toggle--' . $bg : '';
    } else {
        $classes = 'icon';
        $classes .= $color ? ' icon--' . $color : '';
    }
@endphp

<{{ $tag }} @if ($href) href="{{ $href }}" @endif class="{{ $classes }}">
    @include('icons.' . $icon)
</{{ $tag }}>
