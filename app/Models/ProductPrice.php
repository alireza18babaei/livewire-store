<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductPrice extends Model
{
    protected $table = 'product_prices';
    protected $fillable = [
        'main_price',
        'price',
        'discount',
        'count',
        'max_sell',
        'viewed',
        'sold',
        'status',
        'product_id',
        'color_id',
        'guaranty_id',
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function color(): BelongsTo
    {
        return $this->belongsTo(Color::class);
    }

    public function guaranty(): BelongsTo
    {
        return $this->belongsTo(Guaranty::class);
    }

}
