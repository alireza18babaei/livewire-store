<?php

use App\Enums\ProductStatus;
use App\Models\Color;
use App\Models\Guaranty;
use App\Models\Product;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('product_details', function (Blueprint $table) {
            $table->id();
            $table->integer('price')->index();
            $table->integer('main_price')->index();
            $table->integer('discount')->default(0)->index();
            $table->integer('count')->default(1);
            $table->integer('max_sell')->default(0);
            $table->integer('viewed')->default(0);
            $table->integer('sold')->default(0)->index();
            $table->string('image');
            $table->string('status')->default(ProductStatus::Active->value);
            $table->foreignIdFor(Product::class)->constrained()->onDelete('cascade');
            $table->foreignIdFor(Color::class)->constrained();
            $table->foreignIdFor(Guaranty::class)->constrained();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_details');
    }
};
