<?php

namespace App\Livewire\Admin\Roles;

use Illuminate\Contracts\View\View;
use Illuminate\Pagination\LengthAwarePaginator;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use function session;

class RoleList extends Component
{
    #[Validate('required|string|unique:roles,name')]
    public $name;

    public $search;
    public $editIndex;
    public $permissions;

    public $selected_role;
    public $selected_permission = [];

    public function mount(): void
    {
        $this->permissions = Permission::query()->pluck('name')->toArray();
    }

    public function createRow(): void
    {
        $this->validate();
        Role::query()->create([
            'name' => $this->name,
        ]);

        session()->flash('success', 'عملیات با موفقیت انجام شد!');
        $this->reset('name');
    }

    public function editRow($id): void
    {
        $this->editIndex = $id;
        $role = Role::query()->findOrFail($id);
        $this->name = $role->name;

    }

    public function updateRow(): void
    {
        $role = Role::query()->findOrFail($this->editIndex);
        $role->update([
            'name' => $this->name,
        ]);

        session()->flash('success', 'تغییرات با موفقیت اعمال شد!');
        $this->reset();
    }

    public function setSelectRole($role_id)
    {
        $this->selected_role = Role::query()->findOrFail($role_id);
        $this->selected_permission = $this->selected_role->permissions()->pluck('name');
    }

    public function saveRolePermission()
    {
        $this->selected_role->syncPermissions($this->selected_permission);
        session()->flash('success', 'تغییرات با موفقیت اعمال شد!');
    }

    #[Computed]
    public function roles(): LengthAwarePaginator
    {
        return Role::query()->with('permissions')->select('name', 'id')->latest()->paginate(10);
    }

    #[On('destroy_role')]
    public function destroyRow($role_id): void
    {
        Role::destroy($role_id);
    }

    public function searchData(): void {
        $this->roles = Role::query()->where('name', 'like', '%' . $this->search . '%')->paginate(10);
    }

    #[Layout('layouts.admin.admin', [

        'title' => 'لیست نقش‌ها',
        'breadcrumb' => [
            ['label' => 'لیست نقش‌ها'],
        ]
    ])]

    public function render(): View
    {
        return view('livewire.admin.roles.role-list');
    }
}
