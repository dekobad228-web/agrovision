@props([
'href' => '/',
'size' => 'h3-500',
])

<a href="{{ $href }}" class="logo {{ $size }}">
    <div class="logo__block">
        <span class="logo__main">
            AGRO
        </span>
        <span class="logo__accent" data-text="VISION">
            VISION
        </span>
    </div>
</a>