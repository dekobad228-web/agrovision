@php
$theme = match($currentPage?->theme?->value ?? 'default') {
'light-dark' => 'light',
'dark-light' => 'dark',
'light' => 'light',
'dark' => 'dark',
'default' => 'light'
};
@endphp

<header class="{{ $theme }} header">
    <div class="container">
        <div class="header__block">
            <x-ui.logo href="/" size="text-h3-500" />
            <div class="header__box">
                <x-ui.icon-toggle icon="help" bg="default" />
                <x-ui.icon-toggle :href="route('login')" icon="user" bg="gradient" />
            </div>
        </div>
    </div>
</header>