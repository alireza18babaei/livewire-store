<?php

namespace App\Livewire\Admin\Products;

use App\Enums\ProductStatus;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Color;
use App\Models\Guaranty;
use App\Models\Product;
use App\Models\ProductDetails;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithFileUploads;
use Mews\Purifier\Facades\Purifier;
use Throwable;
use function discountPercent;
use function faNumConvert;
use function makeSlug;
use function session;

class ProductCreate extends Component
{

    use WithFileUploads;

    #[Validate('required|string|unique:products,name')]
    public $name;

    #[Validate('required|string|unique:products,e_name')]
    public $e_name;

    #[Validate('required|file|mimes:jpeg,jpg,png')]
    public $primary_image;


    #[Validate('required')]
    public $main_price,$count,$max_sell;


    #[Validate('required')]
    public  $discount;


    #[Validate('required|string')]
    public $description;

    #[Validate('required')]
    public $category_id;


    public $brand_id, $color_id;


    public $guaranty_id;
    public $status;

    public $search;

    public $categories;
    public $products_status;
    public $brands;
    public $colors;
    public $guaranty;
    public function mount(): void
    {
        $this->categories = Category::query()
            ->whereNotNull('parent_id')
            ->pluck('name', 'id');
        $this->brands = Brand::query()->pluck('name', 'id');
        $this->colors = Color::query()->pluck('name', 'id');
        $this->guaranty = Guaranty::query()->pluck('name', 'id');
        $this->products_status = ProductStatus::cases();
    }

    /**
     * @throws Throwable
     */
    public function createRow(): void
    {
        $this->validate();

        $discount = faNumConvert($this->discount);
        $main_price = faNumConvert($this->main_price);
        if ($discount > 99) {
            throw ValidationException::withMessages([
                'discount' => 'مقدار وارد شده صحیح نیست!'
            ]);
        }

        if ($this->primary_image) {
            $imageName = $this->primary_image->hashName();
            $this->primary_image->storeAs('images/products', $imageName, 'public');
        }


        DB::beginTransaction();
        $product = Product::query()->create([
            'name' => $this->name,
            'e_name' => $this->e_name,
            'slug' => makeSlug($this->name, 'Product'),
            'primary_image' => $imageName,
            'description' => Purifier::clean($this->description),
            'category_id' => $this->category_id,
            'brand_id' => $this->brand_id,
        ]);
        ProductDetails::query()->create([
            'main_price' => $main_price,
            'price' => faNumConvert(discountPercent($main_price, $discount)),
            'discount' => $discount,
            'count' => faNumConvert($this->count),
            'max_sell' => faNumConvert($this->max_sell),
            'status' => $this->status ?: ProductStatus::Active->value,
            'product_id' => $product->id,
            'color_id' => $this->color_id,
            'guaranty_id' => $this->guaranty_id,
        ]);

        DB::commit();

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
