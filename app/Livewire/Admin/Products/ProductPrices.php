<?php

namespace App\Livewire\Admin\Products;

use App\Models\Product;
use App\Models\ProductPrice;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\View\View;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class ProductPrices extends Component
{
    use WithPagination;

    public Product $product;

    public function mount(Product $product): void
    {
        $this->product = $product;
    }

    #[Computed]
    public function productPrices(): LengthAwarePaginator
    {
        return ProductPrice::query()->with('color', 'guaranty')->where('product_id', $this->product->id)->latest()->paginate(10);
    }

    #[on('destroy_product_price')]
    public function destroyRow($product_price_id): void
    {
        ProductPrice::destroy($product_price_id);
    }

    #[Layout('layouts.admin.admin', [

        'title' => 'قیمت‌های محصولات',
        'breadcrumb' => [
            ['label' => 'دسته‌بندی محصولات', 'link' => 'admin.product.list'],
            ['label' => 'لیست تنوع قیمت'],
        ]


    ])]


    public function render(): View
    {
        return view('livewire.admin.products.product-prices');
    }
}
