<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\View;
use App\Enums\PageTheme;

class Page extends Model
{
    use HasFactory;

    protected $fillable = [
        'slug',
        'title',
        'is_published',
        'template',
        'theme'
    ];

    public $casts = [
        'is_published' => 'boolean',
        'theme' => PageTheme::class,
    ];

    public function blocks()
    {
        return $this->hasMany(PageBlock::class)->orderBy('position');
    }

    public function getThemeCss(): string
    {
        return $this->theme->css() ?? PageTheme::default()->css();
    }

    public function getTemplateViewAttribute(): string
    {
        $template = strstr($this->template ?? 'default', '.', true);

        $viewName = "web.pages.{$template}";

        if (View::exists($viewName)) {
            return $viewName;
        }

        return 'web.pages.default';
    }

    public function getBlockTheme(): array
    {
        $theme = $this->theme ?? PageTheme::default();

        if ($theme === PageTheme::Light) {
            return ['light' => $this->blocks, 'dark' => collect()];
        }
        if ($theme === PageTheme::Dark) {
            return ['light' => collect(), 'dark' => $this->blocks];
        }

        $total = $this->blocks->count();
        $half = ceil($total / 2);

        if ($theme === PageTheme::LightDark) {
            return ['light' => $this->blocks->take($half), 'dark' => $this->blocks->skip($half)];
        }

        if ($theme === PageTheme::DarkLight) {
            return ['dark' => $this->blocks->take($half), 'light' => $this->blocks->skip($half)];
        }

        return [
            'light' => $this->blocks,
            'dark'  => collect(),
        ];
    }
}
