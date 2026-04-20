<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Banner extends Component
{
    public static function name(): string
    {
        return 'banner';
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
        ];
    }

    public $data;

    public function __construct($data = [])
    {
        $this->data = $data;
    }

    public function render()
    {
        return view('components.blocks.banner');
    }
}
