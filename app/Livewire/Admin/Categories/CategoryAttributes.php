<?php

namespace App\Livewire\Admin\Categories;

use App\Models\Category;
use App\Models\CategoryAttribute;
use Illuminate\Contracts\Pagination\Paginator as PaginatorAlias;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use function session;

class CategoryAttributes extends Component
{

    use WithPagination, withFileUploads;



    public $name, $edit_name;

    public Category $category;

    public $editIndex;




    public function createRow(): void
    {
        $this->validate([
            'name' => 'required',
        ]);
        CategoryAttribute::query()->create([
            'name' => $this->name,
            'category_id' => $this->category->id,
        ]);

        session()->flash('success', 'ویژگی دسته بندی با موفقیت ایجاد شد.');
        $this->reset(['editIndex', 'name']);
    }

    public function editRow($id): void
    {
        $this->editIndex = $id;
        $category_attribute= CategoryAttribute::query()->findOrFail($id);
        $this->edit_name = $category_attribute->name;
    }

    public function updateRow(): void
    {
        $this->validate([
            'edit_name' => 'required',
        ]);

        $category_attribute = CategoryAttribute::query()->findOrFail($this->editIndex);
        $category_attribute->update([
            'name' => $this->edit_name ?? $category_attribute->name,
        ]);

        session()->flash('success', 'تغییرات با موفقیت اعمال شد!');
        $this->reset('editIndex');
    }

    #[Computed]
    public function Attributes(): PaginatorAlias
    {
        return CategoryAttribute::query()->latest()->paginate(10);
    }

    #[on('destroy_attribute')]
    public function destroyRow($attribute_id): void
    {
        CategoryAttribute::destroy($attribute_id);
    }


    #[Layout('layouts.admin.admin', [

        'title' => 'ویژگی‌های دسته‌بندی‌',
        'breadcrumb' => [
            ['label' => 'لیست دسته‌بندی‌ها‌', 'link' => 'admin.categories.list'],
            ['label' => 'ویژگی‌های دسته‌بندی‌'],
        ]
    ])]

    public function render(): View
    {
        return view('livewire.admin.categories.category-attributes');
    }
}
