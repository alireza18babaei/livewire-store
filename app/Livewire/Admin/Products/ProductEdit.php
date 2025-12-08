<?php

namespace App\Livewire\Admin\Products;

use AllowDynamicProperties;
use App\Enums\ProductStatus;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Illuminate\View\View;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithFileUploads;
use Mews\Purifier\Facades\Purifier;
use function makeSlug;
use function session;
use function view;

#[AllowDynamicProperties]
class ProductEdit extends Component
{

    use withFileUploads;


    public $name;

    public $e_name;

    public $description;

    public $status;

    public $search;

    public $category_id;

    public $brand_id;

    public Product $product;

    public $categories;
    public $products_status;
    public $brands;

    public function mount(Product $product): void
    {
        $this->product = $product;
        $this->name = $product->name;
        $this->e_name = $product->e_name;
        $this->category_id = $product->category_id;
        $this->brand_id = $product->brand_id;
        $this->description = $product->description;
        $this->status = $product->status;


        $this->categories = Category::query()
            ->whereNotNull('parent_id')
            ->pluck('name', 'id');
        $this->brands = Brand::query()->pluck('name', 'id');
        $this->products_status = ProductStatus::cases();
    }


    public function updateRow(): void
    {
        $this->validate([
            'name' => 'required|string|unique:products,name,' . $this->product->id,
            'e_name' => 'required|string|unique:products,e_name,' . $this->product->id,
            'description' => 'required|string',
        ]);

        Product::query()->find($this->product->id)->update([
            'name' => $this->name,
            'e_name' => $this->e_name,
            'slug' => makeSlug($this->name, 'Product'),
            'description' => Purifier::clean($this->description),
            'status' => $this->status ?: $this->product->status,
            'category_id' => $this->category_id,
            'brand_id' => $this->brand_id,
        ]);

        session()->flash('success', 'محصول با موفقیت بروزرسانی شد!');
        $this->redirectRoute('admin.product.list');
    }


    #[Layout('layouts.admin.admin', [

        'title' => 'ویرایش محصول',
        'breadcrumb' => [
            ['label' => 'دسته‌بندی محصولات', 'link' => 'admin.product.list'],
            ['label' => 'ویرایش محصول']
        ]
    ])]
    public function render(): View
    {
        return view('livewire.admin.products.product-edit');
    }
}
