<?php

namespace App\Livewire\Admin\Permissions;

use Illuminate\Contracts\View\View;
use Illuminate\Pagination\LengthAwarePaginator;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Spatie\Permission\Models\Permission;
use function session;

class PermissionList extends Component
{
    #[Validate('required|string|unique:permissions,name')]
    public $name;

    public $search;
    public $editIndex;

    public function createRow(): void
    {
        $this->validate();
        Permission::query()->create([
            'name' => $this->name,
        ]);

        session()->flash('success', 'عملیات با موفقیت انجام شد!');
        $this->reset();
    }

    public function editRow($id): void
    {
        $this->editIndex = $id;
        $permission = Permission::query()->findOrFail($id);
        $this->name = $permission->name;

    }

    public function updateRow(): void
    {
        $permission = Permission::query()->findOrFail($this->editIndex);
        $permission->update([
            'name' => $this->name,
        ]);

        session()->flash('success', 'تغییرات با موفقیت اعمال شد!');
        $this->reset();
    }

    #[Computed]
    public function permissions(): LengthAwarePaginator
    {
        return Permission::query()->select('name', 'id')->latest()->paginate(10);
    }

    #[On('destroy_permission')]
    public function destroyRow($permission_id): void
    {
        Permission::destroy($permission_id);
    }

    public function searchData(): void
    {
        $this->permissions = Permission::query()->where('name', 'like', '%' . $this->search . '%')->paginate(10);
    }

    #[Layout('layouts.admin.admin', [

        'title' => 'لیست مجوز‌ها',
        'breadcrumb' => [
            ['label' => 'لیست مجوز‌ها'],
        ]
    ])]
    public function render(): View
    {
        return view('livewire.admin.permissions.permission-list');
    }
}
