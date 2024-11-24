<?php

namespace Database\Seeders;

use App\Models\City;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CitiesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $data = [
            'الرياض 🌟',
            'مكة المكرمة 🕌',
            'المدينة المنورة 🌴',
            'الشرقية 🐠',
            'عسير ⛰️',
            'الباحة 🌳',
            'الجوف 🏜️',
            'حائل 🐪',
            'تبوك ❄️',
            'جازان 🦀',
            'نجران 🌞',
            'القصيم 🌾',
            'الحدود الشمالية ❄️',
        ];

        foreach ($data as $name) {
            City::create([
                'name' => $name,
            ]);
        }
    }
}
