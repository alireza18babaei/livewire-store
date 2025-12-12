<?php

namespace App\Models;

use App\Enums\ProductStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes;

    protected $table = 'products';
    protected $fillable = [
        'name',
        'e_name',
        'slug',
        'description',
        'primary_image',
        'category_id',
        'brand_id',
        'status'
    ];


    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class);
    }

    public function productDetails(): HasMany
    {
        return $this->hasMany(ProductDetails::class);
    }

    public function colors(): BelongsToMany
    {
        return $this->belongsToMany(Color::class, 'color_product');
    }

    public function guaranties(): BelongsToMany
    {
        return $this->belongsToMany(Guaranty::class, 'guaranty_product');
    }

    public function categoryAttribute(): BelongsTo
    {
        return $this->belongsTo(CategoryAttribute::class);
    }
    public function properties(): HasMany
    {
        return $this->hasMany(ProductProperty::class);
    }

    public function mainDetails(): HasOne
    {
        return $this->hasOne(ProductDetails::class)
            ->where('status', ProductStatus::Active->value)
            ->where('count', '>=', 1)
            ->where('max_sell', '>=', 1)
            ->orderBy('price', 'asc');
    }

    protected static function booted(): void
    {
        static::deleted(static function ($product) {
            $product->productDetails()->delete();
        });
//
//        static::forceDeleted(static function ($product) {
//            $product->productDetails()->withTrashed()->forceDelete();
//        });

        static::restored(static function ($product) {
            $product->productDetails()->restore();
        });
    }
}
