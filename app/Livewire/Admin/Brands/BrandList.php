<?php

namespace App\Livewire\Admin\Brands;

use App\Models\Brand;
use Illuminate\Contracts\Pagination\Paginator as PaginatorAlias;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use function makeSlug;
use function session;

class BrandList extends Component
{


    use WithPagination, withFileUploads;

    #[Validate('required|string|unique:brands,name')]
    public $name;

    #[Validate('nullable|file|mimes:jpeg,jpg,png')]
    public $image;

    public $search;

    public $editIndex;

    public function createRow(): void
    {
        $this->validate();

        if($this->image){
            $imageName = $this->image->hashName();
            $this->image->storeAs('images/brands', $imageName, 'public');

        }

        Brand::query()->create([
            'name' => $this->name,
            'slug' => makeSlug($this->name, 'Brand'),
            'image' => $this->image ? $imageName : null,
        ]);

        session()->flash('success', 'برند با موفقیت اضافه شد.');
        $this->reset();
    }

    public function editRow($id): void
    {
        $this->editIndex = $id;
        $brand= Brand::query()->findOrFail($id);
        $this->name = $brand->name;
    }

    public function updateRow(): void
    {
        $this->validate();

        if($this->image){
            $imageName = $this->image->hashName();
            $this->image->storeAs('images/brands', $imageName, 'public');
        }

        $brand = Brand::query()->findOrFail($this->editIndex);
        $brand->update([
            'name' => $this->name ?? $brand->name,
            'slug' => makeSlug($this->name, 'Brand'),
            'image' => $this->image ? $imageName : $brand->image,
        ]);

        session()->flash('success', 'تغییرات با موفقیت اعمال شد!');
        $this->reset();
    }

    #[Computed]
    public function brands(): PaginatorAlias
    {
        return Brand::query()->latest()->paginate(10);
    }

    #[on('destroy_brand')]
    public function destroyRow($brand_id): void
    {
        Brand::destroy($brand_id);
    }

    public function searchData()
    {
        $this->brands = Brand::query()
                ->where('name', 'like', '%' . $this->search . '%')
            ->paginate(10);
    }


    #[Layout('layouts.admin.admin', [

        'title' => 'لیست برند‌ها',
        'breadcrumb' => [
            ['label' => 'لیست برند‌ها'],
        ]
    ])]

    public function render()
    {
        return view('livewire.admin.brands.brand-list');
    }
}
