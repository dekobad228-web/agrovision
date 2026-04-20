<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Album;

class AlbumSeeder extends Seeder
{
    public function run(): void
    {
        $albums = [
            [
                'title' => 'Изображения',
                'slug' => 'images',
                'is_system' => true,
                'position' => 0,
            ],
            [
                'title' => 'Видео',
                'slug' => 'videos',
                'is_system' => true,
                'position' => 0,
            ],
            [
                'title' => '3D Модели',
                'slug' => 'models',
                'is_system' => true,
                'position' => 0,
            ],
        ];

        foreach ($albums as $album) {
            Album::updateOrCreate(
                ['slug' => $album['slug']],
                [
                    'title'     => $album['title'],
                    'is_system' => $album['is_system'],
                    'position'  => $album['position'],
                    'user_id'   => 1,
                ]
            );
        }
    }
}
