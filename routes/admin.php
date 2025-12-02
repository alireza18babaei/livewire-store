<?php

use App\Livewire\Admin\Brands\BrandList;
use App\Livewire\Admin\Brands\TrashBrands;
use App\Livewire\Admin\Categories\CategoryList;
use App\Livewire\Admin\Categories\TrashCategories;
use App\Livewire\Admin\Colors\ColorList;
use App\Livewire\Admin\Colors\TrashColors;
use App\Livewire\Admin\Guaranties\GuarantyList;
use App\Livewire\Admin\Guaranties\TrashGuaranty;
use App\Livewire\Admin\Panel;
use App\Livewire\Admin\Products\CreateProductPrice;
use App\Livewire\Admin\Products\ProductCreate;
use App\Livewire\Admin\Products\ProductEdit;
use App\Livewire\Admin\Products\ProductList;
use App\Livewire\Admin\Products\ProductPrices;
use App\Livewire\Admin\Users\UserList;
use App\Livewire\TrashProduct;
use Illuminate\Support\Facades\Route;


Route::prefix('admin')->middleware(['auth'])->group(function () {
    Route::get('/', Panel::class)->name('panel');

//    users
    Route::get('/users', UserList::class)->name('admin.users.list');

//    categories
    Route::group(['prefix' => 'categories'], function () {
        Route::get('/', CategoryList::class)->name('admin.categories.list');
        Route::get('/trashed', TrashCategories::class)->name('admin.categories.trashed.list');
    });

//    brands
    Route::group(['prefix' => 'brands'], function () {
        Route::get('/', BrandList::class)->name('admin.brand.list');
        Route::get('/trashed', TrashBrands::class)->name('admin.brand.trashed.list');
    });


//    colors
    Route::group(['prefix' => 'colors'], function () {
        Route::get('/', ColorList::class)->name('admin.colors.list');
        Route::get('/trashed', TrashColors::class)->name('admin.colors.trashed.list');
    });


//    Guaranties
    Route::group(['prefix' => 'guaranties'], function () {
        Route::get('/', GuarantyList::class)->name('admin.guaranty.list');
        Route::get('/trashed', TrashGuaranty::class)->name('admin.guaranties.trashed.list');

    });
//    Products
    Route::group(['prefix' => 'products'], function () {
        Route::get('/', ProductList::class)->name('admin.product.list');
        Route::get('/create', ProductCreate::class)->name('admin.product.create');
        Route::get('/trashed', TrashProduct::class)->name('admin.product.trashed');
        Route::get('/edit/{product}', ProductEdit::class)->name('admin.product.edit');
        Route::get('/prices/{product}', ProductPrices::class)->name('admin.product.prices');
        Route::get('/prices/{product}/create', CreateProductPrice::class)->name('admin.product.prices.create');

    });
});


