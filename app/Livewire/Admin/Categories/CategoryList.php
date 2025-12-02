<?php

namespace App\Livewire\Admin\Categories;

use App\Models\Category;
use Illuminate\Contracts\Pagination\Paginator as PaginatorAlias;
use Illuminate\Contracts\View\View as ViewAlias;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use function makeSlug;
use function session;

class CategoryList extends Component
{

    use WithPagination, withFileUploads;

    #[Validate('required|string')]
    public $name;

    #[Validate('nullable|file|mimes:jpeg,jpg,png,web')]
    public $image;

    public $parent_id;

    public $search;

    public $editIndex;

    public function createRow(): void
    {
        $this->validate();

        if($this->image){
            $imageName = $this->image->hashName();
            $this->image->storeAs('images/categories', $imageName, 'public');

        }

        Category::query()->create([
            'name' => $this->name,
            'slug' => makeSlug($this->name, 'Category'),
            'image' => $this->image ? $imageName : null,
            'parent_id' => $this->parent_id,
        ]);

        session()->flash('success', 'دسته بندی با موفقیت اضافه شد.');
        $this->reset();
    }

    public function editRow($id): void
    {
        $this->editIndex = $id;
        $category= Category::query()->findOrFail($id);
        $this->name = $category->name;
        $this->parent_id = $category->parent_id;
    }

    public function updateRow(): void
    {
        $this->validate();

        if($this->image){
            $imageName = $this->image->hashName();
            $this->image->storeAs('images/categories', $imageName, 'public');
        }

        $category = Category::query()->findOrFail($this->editIndex);
        $category->update([
            'name' => $this->name ?? $category->name,
            'slug' => makeSlug($this->name, 'Category'),
            'image' => $this->image ? $imageName : $category->image,
            'parent_id' => $this->parent_id ?? $category->parent_id,
        ]);

        session()->flash('success', 'تغییرات با موفقیت اعمال شد!');
        $this->reset();
    }

    #[Computed]
    public function categories(): PaginatorAlias
    {
        return Category::query()->with('parent')->latest()->paginate(10);
    }

    #[on('destroy_category')]
    public function destroyRow($category_id): void
    {
        Category::destroy($category_id);
    }

    public function searchData()
    {
        $this->categories = Category::query()
            ->where('name', 'like', '%' . $this->search . '%')
            ->with('parent')->paginate(10);
    }


    #[Layout('layouts.admin.admin', [

        'title' => 'لیست دسته‌بندی‌ها',
        'breadcrumb' => [
            ['label' => 'لیست دسته‌بندی‌ها'],
        ]
    ])]

    public function render(): ViewAlias
    {
//      $categories = Category::query()->pluck('name', 'id');

        $categories = Category::getCategories();

        return view('livewire.admin.categories.category-list', compact('categories'));
    }
}
