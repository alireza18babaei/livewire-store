<?php

namespace App\Livewire\Admin\Products;

use App\Enums\ProductStatus;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Illuminate\View\View;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithFileUploads;
use Mews\Purifier\Facades\Purifier;
use function discountPercent;
use function faNumConvert;
use function makeSlug;
use function session;

class ProductCreate extends Component
{

    use withFileUploads;

    #[Validate('required|string|unique:products,name')]
    public $name;

    #[Validate('required|string|unique:products,e_name')]
    public $e_name;


    #[Validate('required')]
    public $main_price,$discount,$count,$max_sell;

    #[Validate('required|file|mimes:jpeg,jpg,png,web')]
    public $primary_image;

    #[Validate('required|string')]
    public $description;

    #[Validate('required')]
    public $category_id, $brand_id;

    public $status;

    public $search;

    public $categories;
    public $products_status;
    public $brands;
    public function mount()
    {
        $this->categories = Category::query()
            ->whereNotNull('parent_id')
            ->pluck('name', 'id');
        $this->brands = Brand::query()->pluck('name', 'id');
        $this->products_status = ProductStatus::cases();
    }

    public function createRow(): void
    {

        $this->validate();

        if ($this->primary_image) {
            $imageName = $this->primary_image->hashName();
            $this->primary_image->storeAs('images/products', $imageName, 'public');
        }

        Product::query()->create([
            'name' => $this->name,
            'e_name' => $this->e_name,
            'price' => faNumConvert(discountPercent($this->main_price, $this->discount)),
            'main_price' => faNumConvert($this->main_price),
            'discount' => faNumConvert($this->discount),
            'count' => faNumConvert($this->count),
            'max_sell' => faNumConvert($this->max_sell),
            'slug' => makeSlug($this->name, 'Product'),
            'primary_image' => $imageName,
            'description' => Purifier::clean($this->description),
            'status' => $this->status ?: ProductStatus::Active->value,
            'category_id' => $this->category_id,
            'brand_id' => $this->brand_id,
        ]);

        session()->flash('success', 'محصول با موفقیت ذخیره شد!');
        $this->redirectRoute('admin.product.list');
    }


    #[Layout('layouts.admin.admin', [

        'title' => 'ایجاد محصول',
        'breadcrumb' =>
            [
                ['label' => 'دسته‌بندی محصولات', 'link' => 'admin.product.list'],
                ['label' => 'ایجاد محصول']
            ]
    ])]
    public function render(): View
    {
        return view('livewire.admin.products.product-create');
    }
}
