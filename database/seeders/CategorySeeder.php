<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\CategoryAttribute;
use Illuminate\Database\Seeder;
use function makeSlug;

class CategorySeeder extends Seeder
{
    public function run(): void
    {

        $mainCount = 10;

        $subCount = 5;
        $categoryAttribute = 3;

        for ($i = 1; $i <= $mainCount; $i++) {
            $parentName = "دسته اصلی $i";
            $parent = Category::query()->create([
                'name' => $parentName,
                'slug' => makeSlug($parentName, 'Category'),
                'image' => 'default.jpg',
            ]);

            for ($j = 1; $j <= $subCount; $j++) {
                $childName = "زیر دسته $i-$j";
                $child = Category::query()->create([
                    'name' => $childName,
                    'slug' => makeSlug($childName, 'Category'),
                    'parent_id' => $parent->id,
                    'image' => 'default.jpg',
                ]);
            }
        }

        for ($t = 1; $t <= $categoryAttribute; $t++) {
            CategoryAttribute::query()->create([
                'name' => "ویژگی $t",
                'category_id' => $child->id,
            ]);
        }


    }
}
