<?php

namespace App\Livewire\Admin\Products;

use Illuminate\Contracts\View\View;
use Livewire\Attributes\Layout;
use Livewire\Component;

class ProductProperties extends Component
{

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
