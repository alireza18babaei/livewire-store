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
            ->whereNotNull('parent_id')
            ->onlyTrashed()
            ->paginate(10, ['id', 'name', 'image', 'created_at', 'parent_id'], 'child_page'); // pageName = child_page
    }

    #[computed]
    public function mainCategories(): PaginatorAlias
    {
        return Category::query()
            ->with('parent')
            ->whereNull('parent_id')
            ->onlyTrashed()
            ->paginate(3, ['*'], 'main_page'); // pageName = main_page
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

    #[On('restore_main_category')]
    public function restoreMainRow($main_category_id): void
    {
        $category = Category::query()->withTrashed()->findOrFail($main_category_id);
        $category->restore();
        foreach ($category->child()->withTrashed()->get() as $child) {
            $child->restore();
        }
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
