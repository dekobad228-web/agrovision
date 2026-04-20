<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Menu;

class MenuHome extends Seeder
{
    public function run(): void
    {
        Menu::firstOrCreate(
            ['name' => 'Главное меню'],
            ['slug' => 'home'],
        );

        $this->command->info('Главное меню успешно создано!');
    }
}
