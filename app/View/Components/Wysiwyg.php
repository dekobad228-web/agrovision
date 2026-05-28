<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Wysiwyg extends Component
{
    public static function name(): string
    {
        return 'wysiwyg';
    }

    public static function label(): string
    {
        return 'Визуальный редактор';
    }

    public static function fields(): array
    {
        return [
            [
                'name' => 'text',
                'type' => 'wysiwyg',
                'label' => 'Контент',
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
        return view('components.blocks.wysiwyg');
    }
}
