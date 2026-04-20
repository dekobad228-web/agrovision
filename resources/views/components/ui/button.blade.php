@props([
'href' => null,
'type' => 'button',
'text' => '',
'size' => 'text-p2-400',
'variant' => 'default',
])

@php
if(empty($text)) {
    return;
}
$tag = is_null($href) ? 'button' : 'a';
$variantClasses = match($variant) {
'default' => "button",
'danger' => "button button--danger",
'success' => "button button--success",
}
@endphp

<{{ $tag }}
    @if($href)
        href="{{ $href }}"
    @else
        type="{{ $type }}"
    @endif
    class="{{ $variantClasses }} {{ $size }}">
    {{ $text }}
</{{ $tag }}>