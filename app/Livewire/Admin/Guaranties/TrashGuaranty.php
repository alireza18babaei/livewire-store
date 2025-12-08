<?php

namespace App\Livewire\Admin\Guaranties;

use App\Models\Guaranty;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\View\View;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class TrashGuaranty extends Component
{

    use WithPagination;

    #[computed]
    public function guaranties(): LengthAwarePaginator
    {
        return Guaranty::onlyTrashed()->latest()->paginate(10);
    }


    #[on('hard_destroy_guaranty')]
    public function hardDestroyRow($guaranty_id): void
    {
        try {
            Guaranty::withTrashed()->findOrFail($guaranty_id)->forceDelete();
            $this->dispatch('success', message: 'حذف انجام شد.');
        } catch (\Throwable $e) {
            if ($e->getCode() == '23000') {
                $this->dispatch('error', message: 'گارنتی مورد نظر به دلیل داشتن وابستگی قابل حذف نیست.');
            } else {
                $this->dispatch('error', message: 'خطایی رخ داد.');
            }
        }
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
