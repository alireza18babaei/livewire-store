<?php

namespace App\Livewire\Admin\Products;

use App\Enums\ProductStatus;
use App\Models\Color;
use App\Models\Guaranty;
use App\Models\Product;
use App\Models\ProductPrice;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithFileUploads;
use function discountPercent;
use function faNumConvert;
use function session;
use function view;

class CreateProductPrice extends Component
{

    use withFileUploads;

    #[Validate('required')]
    public $main_price;

    #[Validate('required')]
    public $discount, $count, $max_sell;

    #[Validate('required')]
    public $guaranty_id, $color_id;

    public Product $product;
    public $status;
    public $search;
    public $colors;
    public $guaranty;
    public $products_status;
    public $price;


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
        $exist = ProductPrice::query()
            ->where('color_id', $this->color_id)
            ->where('guaranty_id', $this->guaranty_id)
            ->where('product_id', $this->product->id)
            ->exists();
        if ($exist) {
            session()->flash('error', 'این مشخصات قبلا ثبت شده است!');
        }else{
            ProductPrice::query()->create([
                'main_price' => faNumConvert($this->main_price),
                'price' => discountPercent($this->main_price, $this->discount),
                'discount' => faNumConvert($this->discount),
                'count' => faNumConvert($this->count),
                'max_sell' => faNumConvert($this->max_sell),
                'status' => $this->status ?: ProductStatus::Active->value,
                'product_id' => $this->product->id,
                'color_id' => $this->color_id,
                'guaranty_id' => $this->guaranty_id,
            ]);
            $this->product->colors()->attach($this->color_id);
            $this->product->guaranties()->attach($this->guaranty_id);

            session()->flash('success', 'قیمت جدید با موفقیت ذخیره شد!');
            $this->redirectRoute('admin.product.prices', ['product' => $this->product->id]);
        }
    }


    public function render()
    {
        return view('livewire.admin.products.create-product-price')
            ->layout('layouts.admin.admin', [
                'title' => 'لیست تنوع قیمت',
                'breadcrumb' => [
                    ['label' => 'دسته‌بندی محصولات', 'link' => 'admin.product.list'],
                    ['label' => 'لیست تنوع قیمت', 'link' => 'admin.product.prices', 'params' => ['product' => $this->product->id]],
                    ['label' => 'ایجاد قیمت جدید برای محصول'],
                ]
            ]);
    }

}
