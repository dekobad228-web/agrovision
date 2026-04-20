<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = User::firstOrCreate(
            ['email' => 'ek_polozkova@mail.ru'],
            [
                'name' => 'katsumi',
                'password' => bcrypt('5_Yr9UnTV9'),
            ]
        );

        if(!$admin->hasRole('admin')){
            $admin->assignRole('admin');
        }

        $this->command->info('Администратор успешно добавлен');
    }
}
