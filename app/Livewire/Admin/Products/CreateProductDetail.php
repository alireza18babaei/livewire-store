<?php

namespace App\Livewire\Admin\Products;

use App\Enums\ProductStatus;
use App\Models\Color;
use App\Models\Guaranty;
use App\Models\Product;
use App\Models\ProductDetails;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithFileUploads;
use function discountPercent;
use function faNumConvert;
use function session;
use function view;

class CreateProductDetail extends Component
{

    use WithFileUploads;

    #[Validate('required')]
    public $discount, $count, $max_sell, $main_price;

    public $color_id;

    public $guaranty_id;

    #[Validate('required|file|mimes:jpeg,jpg,png')]
    public $image;

    public Product $product;
    public $status;
    public $search;
    public $colors;
    public $guaranty;
    public $products_status;


    public function mount(Product $product): void
    {
        $this->product = $product;
        $this->colors = Color::query()->pluck('name', 'id');
        $this->guaranty = Guaranty::query()->pluck('name', 'id');
        $this->products_status = ProductStatus::cases();
    }

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

        if ($this->image) {
            $imageName = $this->image->hashName();
            $this->image->storeAs('images/products', $imageName, 'public');
        }

        $exist = ProductDetails::query()
            ->where('color_id', $this->color_id)
            ->where('guaranty_id', $this->guaranty_id)
            ->where('product_id', $this->product->id)
            ->exists();
        if ($exist) {
            session()->flash('error', 'این مشخصات قبلا ثبت شده است!');
        } else {
            ProductDetails::query()->create([
                'main_price' => $main_price,
                'price' => discountPercent($main_price, $discount),
                'discount' => faNumConvert($this->discount),
                'count' => faNumConvert($this->count),
                'max_sell' => faNumConvert($this->max_sell),
                'status' => $this->status ?: ProductStatus::Active->value,
                'image' => $imageName,
                'product_id' => $this->product->id,
                'color_id' => $this->color_id,
                'guaranty_id' => $this->guaranty_id,
            ]);
            $checkColor = $this->product->colors()->where('color_id', $this->color_id)->exists();
            if (!$checkColor) {
                $this->product->colors()->attach($this->color_id);
            }

            $checkGuaranty = $this->product->guaranties()->where('guaranty_id', $this->guaranty_id)->exists();
            if (!$checkGuaranty) {
                $this->product->guaranties()->attach($this->guaranty_id);
            }



            session()->flash('success', 'قیمت جدید با موفقیت ذخیره شد!');
            $this->redirectRoute('admin.product.details', ['product' => $this->product->id]);
        }
    }


    public function render()
    {
        return view('livewire.admin.products.create-product-detail')
            ->layout('layouts.admin.admin', [
                'title' => 'لیست تنوع قیمت',
                'breadcrumb' => [
                    ['label' => 'دسته‌بندی محصولات', 'link' => 'admin.product.list'],
                    ['label' => 'لیست تنوع قیمت', 'link' => 'admin.product.details', 'params' => ['product' => $this->product->id]],
                    ['label' => 'ایجاد قیمت جدید برای محصول'],
                ]
            ]);
    }

}


//sdffsasdf
