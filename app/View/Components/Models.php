<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Models extends Component
{
    public static function name(): string
    {
        return 'models';
    }

    public static function label(): string
    {
        return 'Модели';
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
                'name' => 'cards',
                'type' => 'repeater',
                'label' => 'Модели',
                'fields' => [
                    [
                        'name' => 'image',
                        'type' => 'image',
                        'label' => 'Изображение',
                    ],
                    [
                        'name' => 'name',
                        'type' => 'text',
                        'label' => 'Название тарифа',
                    ],
                    [
                        'name' => 'link',
                        'type' => 'text',
                        'label' => 'Ссылка',
                    ],
                    [
                        'name' => 'text',
                        'type' => 'wysiwyg',
                        'label' => 'Контент',
                    ],
                ]
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
        return view('components.blocks.models');
    }
}
