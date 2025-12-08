<?php

namespace App\Livewire\Admin\Products;

use App\Enums\ProductStatus;
use App\Models\Color;
use App\Models\Guaranty;
use App\Models\ProductDetails;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithFileUploads;
use function discountPercent;
use function faNumConvert;
use function session;
use function view;

class EditProductDetails extends Component
{


    use withFileUploads;


    public $name;

    public $e_name;

    public $main_price;

    public $discount, $count, $max_sell;

    public $image;

    public $description;

    public $status;

    public $search;

    public $guaranty_id;


    public $color_id;

    public ProductDetails $product_detail;

    public $guaranties;
    public $products_status;
    public $colors;

    public function mount(ProductDetails $product_detail): void
    {
        $this->product_detail = $product_detail;
        $this->main_price = $product_detail->main_price;
        $this->discount = $product_detail->discount;
        $this->count = $product_detail->count;
        $this->max_sell = $product_detail->max_sell;
        $this->guaranty_id = $product_detail->guaranty_id;
        $this->color_id = $product_detail->color_id;
        $this->status = $product_detail->status;


        $this->colors = Color::query()->pluck('name', 'id');
        $this->guaranties = Guaranty::query()->pluck('name', 'id');
        $this->products_status = ProductStatus::cases();
    }


    public function updateRow()
    {
        $this->validate([
            'main_price' => 'required',
            'discount' => 'integer',
            'count' => 'required',
            'max_sell' => 'required',
            'image' => 'nullable|file|mimes:jpeg,jpg,png,webp',
        ]);

        $discount = faNumConvert($this->discount);
        $main_price = faNumConvert($this->main_price);
        if ($discount > 99) {
            throw ValidationException::withMessages([
                'discount' => 'مقدار وارد شده صحیح نیست!'
            ]);
        }

        if ($this->image) {
            $imageName = $this->image->hashName();
            $this->image->storeAs('images/products', $imageName, 'public');
        }

        ProductDetails::query()->find($this->product_detail->id)->update([
            'price' => faNumConvert(discountPercent($main_price, $discount)),
            'main_price' => faNumConvert($main_price),
            'discount' => faNumConvert($discount),
            'count' => faNumConvert($this->count),
            'max_sell' => faNumConvert($this->max_sell),
            'image' => $this->image ? $imageName : $this->product_detail->image,
            'status' => $this->status ?: $this->product_detail->status,
            'guaranty_id' => $this->guaranty_id,
            'color_id' => $this->color_id,
        ]);

        session()->flash('success', 'محصول با موفقیت بروزرسانی شد!');
        $this->redirectRoute('admin.product.details', $this->product_detail->product_id);


    }


    #[Layout('layouts.admin.admin', [

        'title' => 'ویرایش محصول',
        'breadcrumb' => [
            ['label' => 'دسته‌بندی محصولات', 'link' => 'admin.product.list'],
            ['label' => 'ویرایش محصول']
        ]
    ])]
    public function render()
    {
        return view('livewire.admin.products.edit-product-details');
    }
}
