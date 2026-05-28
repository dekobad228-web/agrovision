@php
$theme = match($currentPage?->theme?->value ?? 'default') {
'light-dark' => 'dark',
'dark-light' => 'light',
'light' => 'light',
'dark' => 'dark',
'default' => 'light'
};
@endphp

<footer class="{{ $theme }} footer">
    <div class="container">
        <div class="footer__block">
            <p class="p2-400 footer__copyright">
                © Все права защищены, 2026
            </p>
            <a href="/privacy-policy" class="p2-400 footer__link">
                Политика обработки персональных данных
            </a>
        </div>
    </div>
</footer>