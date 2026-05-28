<?php

namespace App\Enums;

enum PageTheme: string
{
    case Light = 'light';
    case Dark = 'dark';
    case LightDark = 'light-dark';
    case DarkLight = 'dark-light';

    public function admin(): string
    {
        return match ($this) {
            self::Light => 'Светлая тема',
            self::Dark => 'Темная тема',
            self::LightDark => 'Светлая тема -> Темная тема (50/50)',
            self::DarkLight => 'Темная тема -> Светлая тема (50/50)',
        };
    }

    public function css(): string
    {
        return match ($this) {
            self::Light => 'theme-light',
            self::Dark => 'theme-dark',
            self::LightDark => 'theme-light-dark',
            self::DarkLight => 'theme-dark-light',
        };
    }

    public static function default(): string
    {
        return self::Light;
    }
}
