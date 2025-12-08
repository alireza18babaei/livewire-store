<?php

namespace App\Livewire\Admin\Products;

use App\Models\Product;
use Illuminate\Contracts\View\View;
use Illuminate\Pagination\LengthAwarePaginator;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;
use function optional;
use function view;

class TrashProduct extends Component
{

    use WithPagination;


    #[computed]
    public function products(): LengthAwarePaginator
    {
        return Product::query()->with('category', 'brand')->onlyTrashed()->latest()->paginate(10);
    }


    #[on('hard_destroy_product')]
    public function hardDestroyRow($product_id): void
    {
        Product::query()->withTrashed()->findOrFail($product_id)->forceDelete();
    }

    #[on('restore_product')]
    public function restoreRow($product_id): void
    {
        $product = Product::withTrashed()->findOrFail($product_id);
        $product->restore();

        optional($product->brand()->withTrashed()->first())->restore();
        optional($product->category()->withTrashed()->first())->restore();
    }


    #[Layout('layouts.admin.admin', [

        'title' => 'لیست محصولات حذف شده',
        'breadcrumb' => [
            ['label' => 'لیست قیمت‌های محصول', 'link' => 'admin.product.trashed'],
            ['label' => 'قیمت‌های حذف شده محصول']
        ]
    ])]


    public function render(): View
    {
        return view('livewire.admin.products.trash-product');
    }
}
