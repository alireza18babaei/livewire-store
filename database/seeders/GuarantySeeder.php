<?php

namespace Database\Seeders;

use App\Models\Guaranty;
use Illuminate\Database\Seeder;

class GuarantySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Guaranty::query()->create([
            'name' => 'گارانتی ۱'
        ]);
        Guaranty::query()->create([
            'name' => 'گارانتی ۲'
        ]);
        Guaranty::query()->create([
            'name' => 'گارانتی ۳'
        ]);
    }
}
