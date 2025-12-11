<?php

namespace App\Livewire\Admin\Products;

use App\Models\Product;
use App\Models\ProductProperty;
use Illuminate\Contracts\View\View;
use Illuminate\Pagination\LengthAwarePaginator;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Validate;
use Livewire\Component;
use function session;

class ProductProperties extends Component
{
    public $product;

    #[Validate('required|string')]
    public $name, $category_attribute_id;
    public $categoriesAttributes;

    public $editIndex;

    public function mount(Product $product)
    {
        $this->product = $product;
        $this->categoriesAttributes = $this->product->category->categoryAttributes()->pluck('name', 'id');
    }

    public function createRow(): void
    {
        $this->validate();
        ProductProperty::query()->create([
            'name' => $this->name,
            'product_id' => $this->product->id,
            'category_attribute_id' => $this->category_attribute_id
        ]);

        session()->flash('success', 'ویژگی با موفقیت ایجاد شد.');
        $this->reset(['editIndex', 'name']);
    }

    #[Computed]
    public function productProperties(): LengthAwarePaginator
    {
        return ProductProperty::query()
            ->whereIn(
                'category_attribute_id',
                $this->product->category->categoryAttributes()->pluck('id')->toArray()
            )
            ->where('product_id', $this->product->id)
            ->latest()->paginate(10);
    }

    #[Layout('layouts.admin.admin', [

        'title' => 'ویژگی‌های محصول',
        'breadcrumb' => [
            ['label' => 'لیست محصول‌ها‌', 'link' => 'admin.product.list'],
            ['label' => 'ویژگی‌های محصول'],
        ]
    ])]

    public function render(): View
    {
        return view('livewire.admin.products.product-properties');
    }
}
