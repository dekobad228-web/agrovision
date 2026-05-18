<section class="section-models">
    <div class="container">
        <div class="section-models__block">
            <h2 class="h2-400 section-models__title">
                {{ $content['title'] }}
            </h2>
            <div class="section-models__list">
                @foreach($content['cards'] as $card)
                <x-card.model :content="$card" />
                @endforeach
            </div>
        </div>
    </div>
</section>