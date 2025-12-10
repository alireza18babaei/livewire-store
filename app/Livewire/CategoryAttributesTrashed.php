<?php

namespace App\Livewire;

use App\Models\Category;
use App\Models\CategoryAttribute;
use Illuminate\Contracts\View\View;
use Illuminate\Pagination\LengthAwarePaginator;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\Component;

class CategoryAttributesTrashed extends Component
{

    public Category $category;

    #[Computed]
    public function trashedAttributes(): LengthAwarePaginator
    {
        return CategoryAttribute::query()->onlyTrashed()->latest()->paginate(10);
    }

    #[On('hard_destroy_trashed_attribute')]
    public function detroyRow($trashed_attribute_id)
    {
        $this->trashedAttributes()->findOrFail($trashed_attribute_id)->forceDelete();
    }

    #[On('restore_trashed_attribute')]
    public function restoreRow($trashed_attribute_id)
    {
        $this->trashedAttributes()->findOrFail($trashed_attribute_id)->restore();
    }
    

    public function render(): View
    {
        return view('livewire.category-attributes-trashed')
            ->layout('layouts.admin.admin', [
            'title' => 'ویژگی‌های دسته‌بندی‌',
            'breadcrumb' => [
                ['label' => 'لیست دسته‌بندی‌ها‌', 'link' => 'admin.categories.list'],
                ['label' => 'ویژگی‌های دسته‌بندی‌' , 'link' => 'admin.categories.attribute.list', 'params' => [$this->category->id]],
                ['label' => 'لیست ویژگی‌های حذف شده دسته‌بندی'],
            ]
        ]);
    }
}
