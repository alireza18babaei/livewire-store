<?php

namespace App\Livewire\Admin\Guaranties;

use App\Models\Guaranty;
use Illuminate\View\View;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class TrashGuaranty extends Component
{

    use WithPagination;

    public $name;
    public $code;


    #[computed]
    public function guaranties()
    {
        return Guaranty::onlyTrashed()->latest()->paginate(10);
    }


    #[on('hard_destroy_guaranty')]
    public function hardDestroyRow($guaranty_id): void
    {
        Guaranty::query()->withTrashed()->findOrFail($guaranty_id)->forceDelete();
    }

    #[on('restore_guaranty')]
    public function restoreRow($guaranty_id): void
    {
        Guaranty::query()->withTrashed()->findOrFail($guaranty_id)->restore();
    }


    #[Layout('layouts.admin.admin', [

        'title' => 'لیست گارانتی‌ها',
        'breadcrumb' => [
            ['label' => 'لیست گارانتی‌ها', 'link' => 'admin.guaranty.list'],
            ['label' => 'گارانتی‌های حذف شده']
        ]
    ])]

    public function render(): View
    {
        return view('livewire.admin.guaranties.trash-guaranty');
    }
}
