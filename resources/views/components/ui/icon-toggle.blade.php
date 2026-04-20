@props([
'href' => '',
'icon' => 'help',
'bg' => 'default',
])

<a href="{{ $href }}" class="icon-toggle icon-toggle--{{ $bg }}">
    @include('icons.' . $icon)
</a>