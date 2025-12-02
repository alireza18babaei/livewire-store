<?php

use App\Enums\ProductStatus;
use App\Models\Brand;
use App\Models\Category;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name')->index();
            $table->string('e_name')->index();
            $table->integer('main_price')->index();
            $table->integer('price')->index();
            $table->integer('discount')->default(0)->index();
            $table->integer('count')->default(1);
            $table->integer('max_sell')->default(0);
            $table->integer('viewed')->default(0);
            $table->integer('sold')->default(0)->index();
            $table->string('slug')->unique();
            $table->string('primary_image');
            $table->string('description');
            $table->string('status')->default(ProductStatus::Active->value);
            $table->foreignIdFor(Category::class)->constrained()->onDelete('cascade');
            $table->foreignIdFor(Brand::class)->constrained();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
