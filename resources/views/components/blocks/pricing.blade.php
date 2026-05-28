<section class="section-pricing">
    <div class="container">
        <div class="section-pricing__block">
            <div class="section-pricing__top">
                <h2 class="h2-400">
                    {{ $content['title'] }}
                </h2>
                <p class="p2-400">
                    {{ $content['description'] }}
                </p>
            </div>
            <div class="section-pricing__box">
                <div class="section-pricing__list">
                    @foreach($content['cards'] as $card)
                    <x-card.pricing :content="$card" />
                    @endforeach
                </div>
                <div class="section-pricing__bottom">
                    @foreach($content['adds'] as $add)
                    <div class="section-pricing__card">
                        <p class="p1-400 section-pricing__card-title">
                            {{ $add['title'] }}
                        </p>
                        @php
                        $description = explode(',', $add['description']);
                        @endphp
                        <p class="p2-400 section-pricing__card-description">
                            @foreach($description as $desc)
                            {{ $desc }}@if(!$loop->last)<br>@endif
                            @endforeach
                        </p>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>