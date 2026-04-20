@php
    $theme = match ($currentPage?->theme?->value ?? 'default') {
        'light-dark' => 'light',
        'dark-light' => 'dark',
        'light' => 'light',
        'dark' => 'dark',
        'default' => 'light',
    };
@endphp
@if (isset($menus))
    <div class="{{ $theme }} menu">
        <div class="menu__block">
            @foreach ($menus['home']->items as $slug => $value)
                <a href="{{ $value->url === 'home' ? url('/') : route('page.index', $value->url) }}"
                    class="menu__el text-p2-400{{ $value->url === $currentPage->slug ? ' active' : '' }}">
                    {{ $value->title }}
                </a>
            @endforeach
        </div>
    </div>
@endif
