<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\ProductDetails;
use Illuminate\Database\Seeder;
use Random\RandomException;
use function discountPercent;
use function makeSlug;
use function random_int;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * @throws RandomException
     */
    public function run(): void
    {
        $count = 11;

        $categories = Category::query()
            ->whereNotNull('parent_id')
            ->pluck('id');

        for ($i = 1; $i <= $count; $i++) {
            $productName = "محصول-$i";
            $productEName = "product-$i";
            $price = random_int(200, 3000) * 1000;
            $discount = random_int(0, 40);

            Product::query()->create([
                'name' => $productName,
                'e_name' => $productEName,
                'slug' => makeSlug($productName, 'Product'),
                'primary_image' => 'default.png',
                'description' => "بهترین محصول از محصولات $i",
                'category_id' => $categories->random(),
                'brand_id' => random_int(1, 5),
            ]);

            ProductDetails::query()->create([
                'main_price' => $price,
                'price' => discountPercent($price, $discount),
                'discount' => $discount,
                'count' => random_int(10, 40),
                'max_sell' => random_int(40, 50),
                'product_id' => $i,
                'color_id' => random_int(1, 3),
                'guaranty_id' => random_int(1, 3),
            ]);
        }
    }
}
