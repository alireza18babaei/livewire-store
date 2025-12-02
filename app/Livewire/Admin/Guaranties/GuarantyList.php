<?php

namespace App\Livewire\Admin\Guaranties;

use App\Models\Guaranty;
use Illuminate\Pagination\LengthAwarePaginator;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Livewire\Attributes\Validate;
use Livewire\Component;
use function session;

class GuarantyList extends Component
{
    #[Validate('required|string|unique:guaranties,name')]
    public $name;

    public $search;
    public $editIndex;

    public function createRow(): void
    {
        $this->validate();
        Guaranty::query()->create([
            'name' => $this->name,
        ]);

        session()->flash('success', 'عملیات با موفقیت انجام شد!');
        $this->reset();
    }

    public function editRow($id): void
    {
        $this->editIndex = $id;
        $guaranty = Guaranty::query()->findOrFail($id);
        $this->name = $guaranty->name;

    }

    public function updateRow(): void
    {
        $guranty = Guaranty::query()->findOrFail($this->editIndex);
        $guranty->update([
            'name' => $this->name,
        ]);

        session()->flash('success', 'تغییرات با موفقیت اعمال شد!');
        $this->reset();
    }

    #[Computed]
    public function guaranties(): LengthAwarePaginator
    {
        return Guaranty::query()->select('name', 'id')->latest()->paginate(10);
    }

    #[On('destroy_guaranty')]
    public function destroyRow($guaranty_id): void
    {
        Guaranty::destroy($guaranty_id);
    }

    public function searchData(): void {
        $this->guaranties = Guaranty::query()->where('name', 'like', '%' . $this->search . '%')->paginate(10);
    }

    #[Layout('layouts.admin.admin', [

        'title' => 'لیست گارانتی‌ها',
        'breadcrumb' => [
            ['label' => 'لیست گارانتی‌ها'],
        ]
    ])]
    public function render()
    {
        return view('livewire.admin.guaranties.guaranty-list');
    }
}
