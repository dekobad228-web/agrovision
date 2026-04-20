<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Test extends Component
{
    public static function name(): string
    {
        return 'test';
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
                'name' => 'media',
                'type' => 'text',
                'label' => 'Изображение'
            ],
            [
                'name' => 'subtitle',
                'type' => 'textarea',
                'label' => 'Подзаголовок',
            ],
            [
                'name' => 'button_text',
                'type' => 'text',
                'label' => 'Текст кнопки',
            ],
            [
                'name' => 'button_link',
                'type' => 'text',
                'label' => 'Ссылка',
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
        return view('components.blocks.test');
    }
}
