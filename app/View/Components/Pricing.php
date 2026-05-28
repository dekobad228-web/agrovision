<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Pricing extends Component
{
    public static function name(): string
    {
        return 'pricing';
    }

    public static function label(): string
    {
        return 'Тарифы';
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
                'name' => 'description',
                'type' => 'textarea',
                'label' => 'Описание',
            ],
            [
                'name' => 'cards',
                'type' => 'repeater',
                'label' => 'Тарифы',
                'fields' => [
                    [
                        'name' => 'icon',
                        'type' => 'image',
                        'label' => 'Иконка',
                    ],
                    [
                        'name' => 'name',
                        'type' => 'text',
                        'label' => 'Название тарифа',
                    ],
                    [
                        'name' => 'price',
                        'type' => 'text',
                        'label' => 'Цена',
                    ],
                    [
                        'name' => 'list',
                        'type' => 'textarea',
                        'label' => 'Список преимуществ через запятую',
                    ],
                    [
                        'name' => 'sign',
                        'type' => 'text',
                        'label' => 'Приписка',
                    ],
                ]
            ],
            [
                'name' => 'adds',
                'type' => 'repeater',
                'label' => 'Дополнительно',
                'fields' => [
                    [
                        'name' => 'title',
                        'type' => 'text',
                        'label' => 'Заголовок',
                    ],
                    [
                        'name' => 'description',
                        'type' => 'textarea',
                        'label' => 'Описание через запятую',
                    ],
                ]
            ]
        ];
    }

    public $data;

    public function __construct($data = [])
    {
        $this->data = $data;
    }

    public function render()
    {
        return view('components.blocks.pricing');
    }
}
