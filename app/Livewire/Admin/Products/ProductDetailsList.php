<?php

namespace App\Livewire\Admin\Products;

use App\Enums\ProductStatus;
use App\Models\Product;
use App\Models\ProductDetails;
use Illuminate\Pagination\LengthAwarePaginator;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;
use function view;

class ProductDetailsList extends Component
{
    use WithPagination;

    public Product $product;

    public function mount(Product $product): void
    {
        $this->product = $product;
    }

    #[Computed]
    public function productDetails(): LengthAwarePaginator
    {
        return ProductDetails::query()->with('color', 'guaranty')->where('product_id', $this->product->id)->latest()->paginate(10);
    }

    #[on('destroy_product_details')]
    public function destroyRow($product_details_id): void
    {
        if ($this->product->productDetails()->where('status', ProductStatus::Active->value)->count() > 1) {
            ProductDetails::destroy($product_details_id);
            $this->dispatch('success', message: 'حذف انجام شد');
        } else {
            $this->dispatch('error', message: 'حداقل یک جزئیات فعال باید موجود باشد');
        }

    }

    #[Layout('layouts.admin.admin', [

        'title' => 'قیمت‌های محصولات',
        'breadcrumb' => [
            ['label' => 'دسته‌بندی محصولات', 'link' => 'admin.product.list'],
            ['label' => 'لیست تنوع قیمت'],
        ]


    ])]

    public function render()
    {
        return view('livewire.admin.products.product-details-list');
    }
}
