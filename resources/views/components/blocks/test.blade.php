<section class="test">
    <div class="container">
        <div class="test__block">
            <h1 class="text-h1-400 test__title">
                {{ $content['title'] ?? 'Заголовок' }}
            </h1>
            <p class="text-p1-400 test__text">
                {{ $content['subtitle'] ?? 'Подзаголовок' }}
            </p>

            <x-ui.button :text="$content['button_text']" />
        </div>
    </div>
</section>