<?php

namespace App\Livewire\Admin\Products;

use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithFileUploads;
use Throwable;
use function session;

class ProductImages extends Component
{

    use WithFileUploads;

    public Product $product;

    #[Validate(['images.*' => 'image|mimes:jpeg,png,jpg,gif,svg,webp'])]
    public $images =[];

    /**
     * @throws Throwable
     */
    public function saveImages()
    {
        if ($this->images) {
            foreach ($this->images as $image) {
                $imagesName = $image->hashName();
                $image->storeAs('images/products', $imagesName, 'public');

                DB::beginTransaction();

                ProductImage::query()->create([
                    'image' => $imagesName,
                    'product_id' => $this->product->id

                ]);

                DB::commit();
            }
            session()->flash('success', 'تصویر با موفقیت ذخیره شد');
            $this->reset('images');
        }
    }

    public function unsetImage($index): void
    {
        unset($this->images[$index]);
        $this->images = array_values($this->images);
    }

    #[On('destroy_image')]
    public function destroyRow($image_id): void
    {
        ProductImage::destroy($image_id);
    }


    #[Layout('layouts.admin.admin', [

        'title' => 'گالری عکس محصولات',
        'breadcrumb' => [
            ['label' => 'دسته‌بندی محصولات', 'link' => 'admin.product.list'],
            ['label' => 'گالری عکس محصولات'],
        ]


    ])]
    public function render()
    {
        return view('livewire.admin.products.product-images');
    }
}
