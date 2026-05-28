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
            <x-ui.logo href="/" size="h3-500" />
            <div class="header__box">
                <x-ui.icon icon="help" type="toggle" bg="default" />
                <x-ui.icon icon="user" type="toggle" :href="route('login')" bg="gradient" />
            </div>
        </div>
    </div>
</header>