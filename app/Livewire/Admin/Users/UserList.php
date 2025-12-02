<?php /** @noinspection ALL */

namespace App\Livewire\Admin\Users;

use App\Models\User;
use Illuminate\Contracts\Pagination\Paginator as PaginatorAlias;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithPagination;

class UserList extends Component
{
    use WithPagination;

    #[Validate('required|string')]
    public $name;

    #[Validate('string|email|nullable|unique:users,email')]
    public $email;

    #[Validate('nullable|max:13|min:11|string|unique:users,phone')]
    public $phone;

    #[Validate('required|string|min:6')]
    public $password;

    public $editIndex;
    public $search;
    public function createRow(): void
    {
        $this->validate();

        User::query()->create([
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'password' => Hash::make($this->password),
        ]);

        session()->flash('success', 'کاربر جدید با موفقیت اضافه شد.');
        $this->reset();
    }

    public function editRow($id)
    {
        $this->editIndex = $id;
        $user= User::query()->findOrFail($id);
        $this->name = $user->name;
        $this->phone = $user->phone;
        $this->email = $user->email;
    }

    public function updateRow()
    {
        $this->validate([
                'name' => 'required|string|min:6',
                'phone' => 'required|max:13|min:11|string|unique:users,phone|persian_numeric,' . $this->editIndex,
                'email' => 'required|string|email|unique:users,email,' . $this->editIndex,
                'password' => 'nullable|string|min:6|persian_numeric'
            ]);

        $user = User::query()->findOrFail($this->editIndex);
        $user->update([
            'name' => $this->name,
            'phone' => $this->phone,
            'email' => $this->email,
            'password' => $this->password ? Hash::make($this->password) : $user->password,
        ]);

        session()->flash('success', 'تغییرات با موفقیت اعمال شد!');
        $this->reset();
    }

    #[computed]
    public function users(): PaginatorAlias
    {
        return User::query()->select('id', 'name', 'email', 'phone')->paginate(10);
    }

    public function searchData()
    {
        $this->users = User::query()
            ->select('id', 'name', 'email', 'phone')
            ->where('name', 'like', '%' . $this->search . '%')
            ->orWhere('email', 'like', '%' . $this->search . '%')
            ->orWhere('phone', 'like', '%' . $this->search . '%')
            ->paginate(10);
    }


    #[Layout('layouts.admin.admin', [

            'title' => 'لیست کاربران',
            'breadcrumb' =>
                [
                    ['label' => 'لیست کاربران']
                ]
        ])]
    public function render(): View
    {
        return view('livewire.admin.users.user-list');
    }

}
