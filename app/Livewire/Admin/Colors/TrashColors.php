<?php

namespace App\Livewire\Admin\Colors;

use App\Models\Color;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class TrashColors extends Component
{
    use WithPagination;

    public $name;
    public $code;


    #[computed]
    public function colors()
    {
        return Color::onlyTrashed()->latest()->paginate(10);
    }


    #[on('hard_destroy_color')]
    public function hardDestroyRow($color_id): void
    {
        Color::query()->withTrashed()->findOrFail($color_id)->forceDelete();
    }

    #[on('restore_color')]
    public function restoreRow($color_id): void
    {
        Color::query()->withTrashed()->findOrFail($color_id)->restore();
    }


    #[Layout('layouts.admin.admin', [

        'title' => 'لیست رنگ‌ها',
        'breadcrumb' => [
            ['label' => 'لیست رنگ‌ها', 'link' => 'admin.colors.list'],
            ['label' => 'رنگ‌های حذف شده']
        ]
    ])]

    public function render()
    {
        return view('livewire.admin.colors.trash-colors');
    }
}
