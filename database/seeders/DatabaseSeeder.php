<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\MasterClass;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

use App\Models\CreativeActivity;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $instructor = User::create([
            'name' => 'Иванова Ольга Ивановна',
            'email' => 'instructor@example.com',
            'password' => Hash::make('password'),
            'role' => 'instructor',
            'phone' => '89123456765',
            'photo_path' => 'img/driver-page.png',
        ]);

        $instructor2 = User::create([
            'name' => 'Петров Петр Петрович',
            'email' => 'instructor2@example.com',
            'password' => Hash::make('password'),
            'role' => 'instructor',
            'phone' => '89007776655',
            'photo_path' => 'img/driver-page.png',
        ]);
        
        User::create([
            'name' => 'Посетитель',
            'email' => 'visitor@example.com',
            'password' => Hash::make('password'),
            'role' => 'visitor',
            'phone' => '89123456765',
        ]);

        User::create([
            'name' => 'Тимофеев Никита Александрович',
            'email' => 'user@example.com',
            'password' => Hash::make('password'),
            'role' => 'visitor',
            'phone' => '89001112233',
        ]);

        $activities = [
            'Архитектурное моделирование' => 'архитектурное-моделирование.txt',
            'Кулинария' => 'кулинария.txt',
            'Резьба по дереву' => 'резьба-по-дереву.txt',
        ];

        foreach ($activities as $title => $filename) {
            $path = base_path("database/data/{$filename}");
            $description = file_exists($path) ? file_get_contents($path) : "Описание для {$title}";

            CreativeActivity::create([
                'title' => $title,
                'description' => $description,
            ]);
        }
        $activity = CreativeActivity::where('title', 'Архитектурное моделирование')->first();
        if ($activity) {
            $slots = ['09:00-11:00', '11:00-13:00', '15:00-17:00'];
            foreach ($slots as $slot) {
                MasterClass::create([
                    'instructor_id' => $instructor->id,
                    'activity_id' => $activity->id,
                    'title' => 'Моделирование моделей транспорта',
                    'description' => 'Мастер-класс «Моделирование моделей транспорта» научит основам моделирования различных видов транспортных средств. Ученики строят, испытывают и запускают модели судов, самолетов и автомобилей.',
                    'date' => '2026-06-05',
                    'time_slot' => $slot,
                    'capacity' => 10,
                    'cost' => 500,
                ]);
            }

            MasterClass::create([
                'instructor_id' => $instructor2->id,
                'activity_id' => $activity->id,
                'title' => 'Другой мастер-класс (Петров)',
                'description' => 'Этот мастер-класс не должна видеть Ольга Ивановна в своем списке.',
                'date' => '2026-06-10',
                'time_slot' => '11:00-13:00',
                'capacity' => 5,
                'cost' => 1000,
            ]);
        }
    }
}
