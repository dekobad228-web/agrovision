@props([
'content' => [],
])
<div class="card-pricing">
    <div class="card-pricing__background">
        <img src="{{ $content['icon']['url'] }}" class="card-pricing__icon" alt="{{ $content['icon']['name'] }}">
    </div>
    <div class="card-pricing__top">
        <h3 class="h3-400 card-pricing__name">
            {{ $content['name'] }}
        </h3>
        <h3 class="h3-400 card-pricing__price">
            {{ $content['price'] }}
        </h3>
    </div>
    <span class="card-pricing__line"></span>
    @php
    $list = explode(',', $content['list']);
    @endphp
    <div class="card-pricing__list">
        @foreach ($list as $el)
        <div class="card-pricing__el">
            <x-ui.icon icon="check" />
            <p class="p2-400">
                {{ $el }}
            </p>
        </div>
        @endforeach
    </div>
    <p class="p1-400 card-pricing__sign">
        {{ $content['sign'] }}
    </p>
</div>