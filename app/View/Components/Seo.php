<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Seo extends Component
{
    public static function name(): string
    {
        return 'seo';
    }

    public static function label(): string
    {
        return 'SEO-блок';
    }

    public static function fields(): array
    {
        return [
            [
                'name' => 'title',
                'type' => 'text',
                'label' => 'Заголовок',
            ],
            [
                'name' => 'text',
                'type' => 'wysiwyg',
                'label' => 'Контент',
            ],
            [
                'name' => 'image',
                'type' => 'image',
                'label' => 'Изображение',
            ],
        ];
    }

    public $data;

    public function __construct($data = [])
    {
        $this->data = $data;
    }

    public function render()
    {
        return view('components.blocks.seo');
    }
}
