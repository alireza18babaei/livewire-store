<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    /** @use HasFactory<\Database\Factories\CategoryFactory> */
    use HasFactory;
    use SoftDeletes;

    protected $table = 'categories';
    protected $fillable = [
        'name',
        'slug',
        'image',
        'status',
        'parent_id',
    ];

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(self::class, 'parent_id', 'id')
            ->withDefault(['name' => 'دسته‌بندی اصلی']);
    }

    public function child(): HasMany
    {
        return $this->hasMany(self::class, 'parent_id', 'id');
    }

    public static function getCategories(): array
    {
        $array = [];
        $categories = self::query()
            ->with('child')
            ->where('parent_id', null)
            ->select('id', 'name')
            ->get();
        foreach ($categories as $category1) {
            $array[$category1->id] = ' --- ' . $category1->name . ' --- ';
            foreach ($category1->child as $category2) {
                $array[$category2->id] = $category2->name;
            }
        }
        return $array;
    }


    protected static function booted(): void
    {

        static::deleting(static function ($category) {
            $category->child()->chunk(50, function($children) {
                foreach ($children as $child) {
                    $child->delete();
                }
            });

            $category->products()->chunk(50, function ($products) {
                foreach ($products as $product) {
                    $product->delete();
                }
            });
        });


        static::forceDeleted(static function ($category) {
            foreach ($category->child()->withTrashed()->cursor() as $child) {
                $child->forceDelete();
            }
        });



        static::restoring(static function ($category) {
            foreach ($category->parent()->withTrashed()->cursor() as $parent) {
                $parent->restore();
            }
            foreach ($category->products()->withTrashed()->cursor() as $product) {
                $product->restore();
            }
        });
    }

}




//    when we cal the method this function extended:
//    public static function boot(): void
//    {
//        parent::boot();
//        self::deleting(static function ($category) {
//            foreach ($category->child()->withTrashed()->get() as $child) {
//                $child->delete();
//            }
//        });
//
//        self::deleting(static function ($category) {
//            foreach ($category->child()->withTrashed()->get() as $child) {
//                $child->delete();
//            }
//        });
//
//        self::forceDeleting(static function ($category) {
//            foreach ($category->child()->withTrashed()->get() as $child) {
//                $child->forceDelete();
//            }
//        });
//
//
//
//        self::restoring(static function ($category) {
//            foreach ($category->child()->withTrashed()->get() as $child) {
//                $child->restore();
//            }
//        });
//    }
