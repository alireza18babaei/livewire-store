<div class="panel min-h-screen" x-data="modal">

  {{--    message--}}
  <x-admin.message/>

  {{--  loading liveire component page--}}
  <x-admin.loading/>

  <div class="mb-5">
    <h1 class="my-4 font-bold text-lg">ایجاد نقش</h1>

    <form class="space-y-10">
      <div class="grid grid-cols-1 gap-4 sm:grid-cols-4 py-4">
        <div>
          <label for="name">نام نقش</label>
          <input wire:model="name" id="name" type="text" class="form-input">
          @error('name') <p class="text-danger mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
          @if($editIndex)
            <button wire:click.prevent="updateRow" class="btn btn-primary !mt-6">ویرایش</button>
          @else
            <button
              wire:click.prevent="createRow"
              class="btn btn-success !mt-6"
            >تایید
            </button>
          @endif
        </div>
      </div>
    </form>
  </div>

  <div class="my-10 space-y-5">
    <form @submit.prevent="$wire.searchData()">
      <div class="relative">
        <label for="search" class="sr-only">Search</label>
        <input type="text" id="search" x-model="$wire.search"
          @input.debounce.800ms="$wire.searchData()"
          class="mt-0.5 pr-10 w-[300px] rounded border-gray-300 pe-10 shadow-sm sm:text-sm">
        <span class="absolute inset-y-0 right-2 grid w-8 place-content-center">
            <button type="submit" aria-label="Submit"
              class="rounded-full p-1.5 text-gray-700 transition-roles hover:bg-gray-100">
              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                stroke="currentColor" class="size-4"><path stroke-linecap="round" stroke-linejoin="round"
                  d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z"></path></svg>
            </button>
          </span>
      </div>
    </form>

    <div class="table-responsive">
      <table>
        <thead>
          <tr>
            <th>ردیف</th>
            <th>نام نقش</th>
            <th>مجوزها</th>
            <th>انتصاب مجوز</th>
            <th>تاریخ ایجاد نقش</th>
            <th class="text-center">عملیات</th>
          </tr>
        </thead>
        <tbody>
          @foreach($this->roles as $role)
            <tr>
              <td>{{ $loop->iteration }}</td>
              <td class="whitespace-nowrap">{{ $role->name }}</td>

              <td>
                <div class="grid grid-cols-3 gap-2">
                  @foreach($role->permissions->pluck('name') as $permissionName)
                    <span class="py-1 rounded border border-gray-300 bg-gray-100 text-center text-xs text-gray-700">{{ $permissionName }}</span>
                  @endforeach
                </div>
              </td>

              <td class="whitespace-nowrap flex justify-center">
                <button type="button" class="btn btn-info" wire:click="setSelectRole({{ $role->id }})" @click="toggle">لیست مجوزها</button>
              </td>
              <td class="whitespace-nowrap">{{ getJalaliDate($role->created_at) }}</td>
              <td class="border-b border-[#ebedf2] p-3 text-center dark:border-[#191e3a]">
                <button wire:click="editRow({{ $role->id }})" type="button" x-tooltip="آبدیت">
                  <x-icons.edit/>
                </button>
                <button wire:click.prevent="$dispatch('delete_role', {'role_id' : {{$role->id}} })"
                  type="button" x-tooltip="حذف"
                  class="text-red-500">
                  <x-icons.delete/>
                </button>
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
  <div class="flex justify-center">
    <ul class="inline-flex items-center justify-center space-x-1 rtl:space-x-reverse">
      {{ $this->roles->links('layouts.admin.pagination') }}
    </ul>
  </div>


  <div class="fixed inset-0 bg-[black]/60 z-[999] hidden overflow-y-auto" :class="open && '!block'">
    <div class="flex items-center justify-center min-h-screen px-4" @click.self="open = false">
      <div x-show="open" x-trap="open" x-transition x-transition.duration.300 class="panel border-0 p-0 rounded-lg overflow-hidden w-full max-w-lg my-8">
        <div class="p-5">
          <h5 class="font-bold text-lg m-4">لیست مجوزها</h5>
          <div class="dark:text-white-dark/70 text-base font-medium text-[#1f2937]">
            <p wire:loading >درحال دریافت اطلاعات...</p>
            <div wire:loading.remove class="p-5">
              @foreach($this->permissions as $permissions)
                <label for="{{ 'permission' . $loop->iteration }}" class="p-1">
                  <input wire:model="selected_permission" value="{{ $permissions }}"
                    type="checkbox"
                    id="{{'permission' . $loop->iteration}}"
                    class="form-checkbox outline-primary rounded-full"/>
                  <span>{{ $permissions }}</span>
                </label>
              @endforeach
            </div>
          </div>
          <div class="flex justify-end items-center mt-8">
            <button type="button" class="btn btn-outline-danger" @click="toggle">انصراف</button>
            <button type="button" class="btn btn-primary ltr:ml-4 rtl:mr-4" wire:click="saveRolePermission()" @click="toggle">ذخیره</button>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

@script
<script>
    document.addEventListener("alpine:init", () => {
        Alpine.data("modal", (initialOpenState = false) => ({
            open: initialOpenState,

            toggle() {
                this.open = !this.open;
            },
        }));
    });

    Livewire.on('delete_role', (event) => {
        Swal.fire({
            title: "آیا از حذف مطمئن هستید؟",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            cancelButtonText: 'خیر',
            confirmButtonText: "بله",
        }).then((result) => {
            if (result.isConfirmed) {
                Livewire.dispatch('destroy_role', {role_id: event.role_id})
                Swal.fire({
                    title: "حذف انجام شد!",
                    icon: "success"
                });
            }
        });
    });
</script>
@endscript

