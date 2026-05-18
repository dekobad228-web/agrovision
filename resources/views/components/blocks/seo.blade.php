<section class="section-seo">
    <div class="container">
        <div class="section-seo__block">
            <div class="section-seo__left">
                <h2 class="h2-400 section-seo__title">
                    {{ $content['title'] }}
                </h2>
                <div class="wysiwyg section-seo__text">
                    {!! $content['text'] !!}
                </div>
            </div>
            <div class="section-seo__right">
                <img src="{{ $content['image']['url'] }}" class="section-seo__image" alt="{{ $content['image']['name'] }}">
            </div>
        </div>
    </div>
</section>