<?php

namespace App\Livewire\Admin\Categories;

use App\Models\Category;
use Illuminate\Contracts\Pagination\Paginator as PaginatorAlias;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class TrashCategories extends Component
{

    use WithPagination, withFileUploads;


    #[computed]
    public function categories(): PaginatorAlias
    {
        return Category::query()
            ->with('parent')
            ->onlyTrashed()
            ->paginate(10);
    }

    #[on('hard_destroy_category')]
    public function hardDestroyRow($category_id): void
    {
        Category::query()->withTrashed()->findOrFail($category_id)->forceDelete();
    }

    #[On('restore_category')]
    public function restoreRow($category_id): void
    {
        Category::query()->withTrashed()->findOrFail($category_id)->restore();
    }


    #[Layout('layouts.admin.admin', [

        'title' => 'لیست دسته‌بندی‌ها',
        'breadcrumb' => [
            ['label' => 'لیست دسته‌بندی‌ها', 'link' => 'admin.categories.list'],
            ['label' => 'دسته‌بندی‌های حذف شده']
        ]
    ])]


    public function render()
    {
        return view('livewire.admin.categories.trash-categories');
    }
}
