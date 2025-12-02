<?php

namespace Database\Seeders;

use App\Models\Color;
use Illuminate\Database\Seeder;

class ColorsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Color::create([
            'name' => 'قرمز',
            'code' => '#eb3232',
        ]);

        Color::create([
            'name' => 'زرد',
            'code' => '#f7f726',
        ]);

        Color::create([
            'name' => 'سبز',
            'code' => '#54cf4e',
        ]);

        Color::create([
            'name' => 'آبی',
            'code' => '#442cf1',
        ]);
    }
}
