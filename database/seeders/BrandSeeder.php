<?php

namespace Database\Seeders;

use App\Models\Brand;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use function makeSlug;

class BrandSeeder extends Seeder
{
    public function run(): void
    {

        $count = 10;

        for ($i = 1; $i <= $count; $i++) {
            $brandtName = "برند-$i";
            Brand::create([
                'name' => $brandtName,
                'slug' => makeSlug($brandtName, 'Brand'),
                'image' => 'default.jpg',
            ]);
        }
    }
}
