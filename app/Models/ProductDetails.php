<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductDetails extends Model
{

    use SoftDeletes;

    protected $table = 'product_details';
    protected $fillable = [
        'main_price',
        'price',
        'discount',
        'count',
        'max_sell',
        'viewed',
        'sold',
        'status',
        'image',
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
