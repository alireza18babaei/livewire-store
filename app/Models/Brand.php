<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Brand extends Model
{
    use SoftDeletes;

    protected $table = 'brands';
    protected $fillable = [
        'name',
        'slug',
        'image',
        'status'
    ];

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }


    protected static function booted(): void
    {
        static::deleting(static function ($brand) {
            $brand->products()->chunk(50, function ($products) {
                foreach ($products as $product) {
                    $product->delete();
                }
            });
        });

        static::restoring(static function ($brand) {
            foreach ($brand->products()->withTrashed()->cursor() as $product) {
                $product->restore();
            }
        });
    }
}
