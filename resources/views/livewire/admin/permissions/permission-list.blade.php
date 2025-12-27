<div class="panel min-h-screen">

  {{--    message--}}
  <x-admin.message/>

  {{--  loading liveire component page--}}
  <x-admin.loading/>

  <div class="mb-5">
    <h1 class="my-4 font-bold text-lg">ایجاد مجوز</h1>

    <form class="space-y-10">
      <div class="grid grid-cols-1 gap-4 sm:grid-cols-4 py-4">
        <div>
          <label for="name">نام مجوز</label>
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
              class="rounded-full p-1.5 text-gray-700 transition-permissions hover:bg-gray-100">
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
            <th>نام مجوز</th>
            <th>تاریخ ایجاد مجوز</th>
            <th class="text-center">عملیات</th>
          </tr>
        </thead>
        <tbody>
          @foreach($this->permissions as $permission)
            <tr>
              <td>{{ $loop->iteration }}</td>
              <td class="whitespace-nowrap">{{ $permission->name }}</td>
              <td class="whitespace-nowrap">{{ getJalaliDate($permission->created_at) }}</td>
              <td class="border-b border-[#ebedf2] p-3 text-center dark:border-[#191e3a]">
                <button wire:click="editRow({{ $permission->id }})" type="button" x-tooltip="آبدیت">
                  <x-icons.edit/>
                </button>
                <button wire:click.prevent="$dispatch('delete_permission', {'permission_id' : {{$permission->id}} })"
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
      {{ $this->permissions->links('layouts.admin.pagination') }}
    </ul>
  </div>
</div>

@script
<script>
    Livewire.on('delete_permission', (event) => {
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
                Livewire.dispatch('destroy_permission', {permission_id: event.permission_id})
                Swal.fire({
                    title: "حذف انجام شد!",
                    icon: "success"
                });
            }
        });
    });
</script>
@endscript

