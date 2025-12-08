<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Guaranty extends Model
{
    use softDeletes;
    protected $table = 'guaranties';
    protected $fillable = [
        'name'
    ];


    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'guaranty_product');
    }

    public function ProductDetails(): HasMany
    {
        return $this->hasMany(ProductDetails::class);
    }

}
