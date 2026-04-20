<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Page;

class PublicPage extends Seeder
{
    public function run(): void
    {
        $files = glob(resource_path('views/web/pages/*.blade.php'));

        foreach ($files as $file) {
            $slug = basename($file, '.blade.php');
            $content = file_get_contents($file);
            if (preg_match("/@section\(\s*'template_name'\s*,\s*'([^']+)'\s*\)/", $content, $matches)) {
                $templateName = $matches[1];
            }

            Page::firstOrCreate(
                ['slug' => $slug],
                ['title' => $templateName, 'is_published' => true]
            );
        }

        $this->command->info('Страницы успешно созданы!');
    }
}
