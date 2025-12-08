<?php

namespace App\Livewire\Admin\Products;

use App\Models\Product;
use App\Models\ProductDetails;
use Illuminate\Contracts\View\View;
use Illuminate\Pagination\LengthAwarePaginator;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;
use function view;

class TrashProductDetails extends Component
{

    use WithPagination;


    public Product $product;

    public function mount(Product $product)
    {
        $this->product = $product;
    }

    #[computed]
    public function productDetails(): LengthAwarePaginator
    {
        return $this->product->productDetails()
            ->onlyTrashed()
            ->latest()
            ->paginate(10);

    }


    #[on('hard_destroy_product_detail')]
    public function hardDestroyRow($product_detail_id): void
    {
        try {
            $this->product->productDetails()->onlyTrashed()->findOrFail($product_detail_id)->forceDelete();
            $this->dispatch('success', message: 'حذف انجام شد.');
        } catch (\Throwable $e) {
            if ($e->getCode() == '23000') {
                $this->dispatch('error', message: 'گارنتی مورد نظر به دلیل داشتن وابستگی قابل حذف نیست.');
            } else {
                $this->dispatch('error', message: 'خطایی رخ داد.');
            }
        }
    }

    #[on('restore_product_detail')]
    public function restoreRow($product_detail_id): void
    {
        ProductDetails::query()->withTrashed()->findOrFail($product_detail_id)->restore();
    }


    public function render(): View
    {
        return view('livewire.admin.products.trash-product-details')
            ->layout('layouts.admin.admin', [
                'title' => 'لیست قیمت‌های محصول حذف شده',
                'breadcrumb' => [
                    ['label' => 'دسته‌بندی محصولات', 'link' => 'admin.product.list'],
                    ['label' => 'لیست تنوع قیمت', 'link' => 'admin.product.details', 'params' => ['product' => $this->product->id]],
                    ['label' => 'لیست قیمت‌های محصول حذف شده']
                ]
            ]);
    }
}
