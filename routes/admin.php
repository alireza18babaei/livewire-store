<?php

use App\Livewire\Admin\Brands\BrandList;
use App\Livewire\Admin\Brands\TrashBrands;
use App\Livewire\Admin\Categories\CategoryAttributes;
use App\Livewire\Admin\Categories\CategoryList;
use App\Livewire\Admin\Categories\TrashCategories;
use App\Livewire\Admin\Colors\ColorList;
use App\Livewire\Admin\Colors\TrashColors;
use App\Livewire\Admin\Guaranties\GuarantyList;
use App\Livewire\Admin\Guaranties\TrashGuaranty;
use App\Livewire\Admin\Panel;
use App\Livewire\Admin\Permissions\PermissionList;
use App\Livewire\Admin\Products\CreateProductDetail;
use App\Livewire\Admin\Products\EditProductDetails;
use App\Livewire\Admin\Products\ProductCreate;
use App\Livewire\Admin\Products\ProductDetailsList;
use App\Livewire\Admin\Products\ProductEdit;
use App\Livewire\Admin\Products\ProductImages;
use App\Livewire\Admin\Products\ProductList;
use App\Livewire\Admin\Products\ProductProperties;
use App\Livewire\Admin\Products\TrashProduct;
use App\Livewire\Admin\Products\TrashProductDetails;
use App\Livewire\Admin\Roles\RoleList;
use App\Livewire\Admin\Users\UserList;
use App\Livewire\CategoryAttributesTrashed;
use Illuminate\Support\Facades\Route;


Route::prefix('admin')->middleware(['auth'])->group(callback: function () {
Route::get('/', Panel::class)->name('panel');

//    users
Route::get('/users', UserList::class)->name('admin.users.list');

//    roles & permissions
Route::get('/roles', RoleList::class)->name('admin.roles.list');
Route::get('/permissions', PermissionList::class)->name('admin.permissions.list');


//    categories
Route::group(['prefix' => 'categories'], function () {
    Route::get('/', CategoryList::class)->name('admin.categories.list');
    Route::get('/trashed', TrashCategories::class)->name('admin.categories.trashed.list');
    Route::get('/{category}/attribute', CategoryAttributes::class)->name('admin.categories.attribute.list');
    Route::get('/{category}/attribute/trashed', CategoryAttributesTrashed::class)->name('admin.categories.attribute.trashed.list');
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
    Route::get('/images/{product}', ProductImages::class)->name('admin.product.images');
    Route::get('/edit/{product}', ProductEdit::class)->name('admin.product.edit');
    Route::get('/properties/{product}', ProductProperties::class)->name('admin.product.properties');
    Route::get('/details/{product}', ProductDetailsList::class)->name('admin.product.details');
    Route::get('/details/{product}/create', CreateProductDetail::class)->name('admin.product.details.create');
    Route::get('/details/{product_detail}/edit', EditProductDetails::class)->name('admin.product.details.edit');
    Route::get('/details/{product}/trashed', TrashProductDetails::class)->name('admin.product-details.trashed');

});
});




