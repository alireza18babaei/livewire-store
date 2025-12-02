<?php

namespace App\Livewire\Admin\Colors;

use App\Models\Color;
use Illuminate\Pagination\LengthAwarePaginator;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithPagination;
use function session;

class ColorList extends Component
{

    use WithPagination;

    #[Validate('required|string|unique:colors,name')]
    public $name;

    #[Validate('required|string|unique:colors,code')]
    public $code = '';

    public $search;
    public $editIndex;

    public function createRow(): void
    {
        $this->validate();

        Color::query()->create([
            'name' => $this->name,
            'code' => $this->code,
        ]);

        session()->flash('success', 'رنگ با موفقیت اضافه شد.');
        $this->reset();
    }

    public function editRow($id): void
    {
        $this->editIndex = $id;
        $color = Color::query()->findOrFail($id);
        $this->name = $color->name;
        $this->code = $color->code;
    }

    public function updateRow(): void
    {
        $this->validate();


        $color = Color::query()->findOrFail($this->editIndex);
        $color->update([
            'name' => $this->name ?: $color->name,
            'code' => $this->code ?: $color->code,
        ]);

        session()->flash('success', 'تغییرات با موفقیت اعمال شد!');
        $this->reset();
    }

    #[Computed]
    public function colors(): LengthAwarePaginator
    {
        return Color::query()->select('name','id','code')->latest()->paginate(10);
    }

    #[on('destroy_color')]
    public function destroyRow($color_id): void
    {
        Color::destroy($color_id);
    }


    public function searchData(): void
    {
        $this->colors = Color::query()
            ->where('name', 'like', '%' . $this->search . '%')
            ->orWhere('code', 'like', '%' . $this->search . '%')
            ->paginate(10);
    }


    #[Layout('layouts.admin.admin', [

        'title' => 'لیست رنگ‌ها',
        'breadcrumb' => [
            ['label' => 'لیست رنگ‌ها'],
        ]
    ])]
    public function render()
    {
        return view('livewire.admin.colors.color-list');
    }
}
