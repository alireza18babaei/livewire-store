<?php

namespace App\Livewire\Admin\Products;

use App\Models\Product;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\View\View;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class ProductList extends Component
{

    use WithPagination, withFileUploads;
    public $search;


    #[Computed]
    public function products(): LengthAwarePaginator
    {
        return Product::query()->with('category', 'brand', 'mainDetails')->latest()->paginate(10);
    }

    #[on('destroy_product')]
    public function destroyRow($product_id): void
    {
        Product::destroy($product_id);
    }

    public function searchData(): void
    {
        $this->products = Product::query()
            ->where('name', 'like', '%' . $this->search . '%')
            ->orWhere('description', 'like', '%' . $this->search . '%')
            ->with('category', 'brand', 'mainDetails')->paginate(10);
    }


    #[Layout('layouts.admin.admin', [

        'title' => 'دسته‌بندی محصولات',
        'breadcrumb' => [
            ['label' => 'دسته‌بندی محصولات'],
        ]


    ])]


    public function render(): View
    {
        return view('livewire.admin.products.product-list');
    }
}
