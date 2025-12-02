<?php

namespace App\Livewire\Admin\Brands;

use App\Models\Brand;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class TrashBrands extends Component
{
    use WithPagination;

    #[computed]
    public function brands()
    {
        return Brand::onlyTrashed()->latest()->paginate(10);
    }


    #[on('hard_destroy_brand')]
    public function hardDestroyRow($brand_id): void
    {
        Brand::query()->withTrashed()->findOrFail($brand_id)->forceDelete();
    }

    #[on('restore_brand')]
    public function restoreRow($brand_id): void
    {
        Brand::query()->withTrashed()->findOrFail($brand_id)->restore();
    }


    #[Layout('layouts.admin.admin', [

        'title' => 'لیست برندها',
        'breadcrumb' => [
            ['label' => 'لیست برندها', 'link' => 'admin.brand.list'],
            ['label' => 'برندهای حذف شده']
        ]
    ])]
    public function render()
    {
        return view('livewire.admin.brands.trash-brands');
    }
}
