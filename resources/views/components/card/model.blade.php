@props([
'content' => [],
])

<div class="card-model">
    <img src="{{ $content['image']['url'] }}" class="card-model__image" alt="{{ $content['image']['name'] }}">
    <div class="card-model__box">
        <h4 class="h4-400 card-model__name">
            {{ $content['name'] }}
        </h4>
        <div class="wysiwyg card-model__text">
            {!! $content['text'] !!}
        </div>
    </div>
</div>