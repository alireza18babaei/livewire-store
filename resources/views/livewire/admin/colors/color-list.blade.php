<div class="panel min-h-screen">

  {{--    message--}}
  <x-admin.message/>

  {{--  loading liveire component page--}}
  <x-admin.loading/>

  <div class="mb-5">
    <h1 class="my-4 font-bold text-lg">ایجاد رنگ</h1>

    <form class="space-y-10">
      <div class="grid grid-cols-1 gap-4 sm:grid-cols-4 py-4">
        <div>
          <label for="name">نام رنگ</label>
          <input wire:model="name" id="name" type="text" class="form-input">
          @error('name') <p class="text-danger mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
          <div>
            <label for="colorpicker">کد رنگ</label>
            <div x-data="{ code: @entangle('code') }" class="relative inline-block">
              <!-- input color مخفی -->
              <input type="color" wire:model="code" id="colorpicker" class="sr-only">

              <label for="colorpicker"
                class="w-6 h-6 rounded absolute top-1/2 right-2 -translate-y-1/2 cursor-pointer flex items-center justify-center"
                :style="'background-color:' + code">

                <svg x-show="!code"
                  xmlns="http://www.w3.org/2000/svg"
                  viewBox="0 0 24 24"
                  width="18" height="18"
                  fill="currentColor"
                  class="pointer-events-none">
                  <path
                    d="M12 2C17.5222 2 22 5.97778 22 10.8889C22 13.9556 19.5111 16.4444 16.4444 16.4444H14.4778C13.5556 16.4444 12.8111 17.1889 12.8111 18.1111C12.8111 18.5333 12.9778 18.9222 13.2333 19.2111C13.5 19.5111 13.6667 19.9 13.6667 20.3333C13.6667 21.2556 12.9 22 12 22C6.47778 22 2 17.5222 2 12C2 6.47778 6.47778 2 12 2ZM10.8111 18.1111C10.8111 16.0843 12.451 14.4444 14.4778 14.4444H16.4444C18.4065 14.4444 20 12.851 20 10.8889C20 7.1392 16.4677 4 12 4C7.58235 4 4 7.58235 4 12C4 16.19 7.2226 19.6285 11.324 19.9718C10.9948 19.4168 10.8111 18.7761 10.8111 18.1111ZM7.5 12C6.67157 12 6 11.3284 6 10.5C6 9.67157 6.67157 9 7.5 9C8.32843 9 9 9.67157 9 10.5C9 11.3284 8.32843 12 7.5 12ZM16.5 12C15.6716 12 15 11.3284 15 10.5C15 9.67157 15.6716 9 16.5 9C17.3284 9 18 9.67157 18 10.5C18 11.3284 17.3284 12 16.5 12ZM12 9C11.1716 9 10.5 8.32843 10.5 7.5C10.5 6.67157 11.1716 6 12 6C12.8284 6 13.5 6.67157 13.5 7.5C13.5 8.32843 12.8284 9 12 9Z"></path>
                </svg>
              </label>

              <input type="text" x-model="code" class="form-input pr-10">
            </div>
          </div>
          @error('code') <p class="text-danger mt-1">{{ $message }}</p> @enderror
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
    <div class="flex justify-between items-center">
      <form @submit.prevent="$wire.searchData()">
        <div class="relative">
          <label for="search" class="sr-only">Search</label>
          <input type="text" id="search" x-model="$wire.search"
            @input.debounce.800ms="$wire.searchData()"
            class="mt-0.5 pr-10 w-[300px] rounded border-gray-300 pe-10 shadow-sm sm:text-sm">
          <span class="absolute inset-y-0 right-2 grid w-8 place-content-center">
            <button type="submit" aria-label="Submit"
              class="rounded-full p-1.5 text-gray-700 transition-colors hover:bg-gray-100">
              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                stroke="currentColor" class="size-4"><path stroke-linecap="round" stroke-linejoin="round"
                  d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z"></path></svg>
            </button>
          </span>
        </div>
      </form>
      <div>
        <a href="{{ route('admin.colors.trashed.list') }}"
          class="btn btn-danger  flex items-end justify-center gap-2 w-[300px]">
          <x-icons.trash/>
          رنگ های حذف شده
        </a>
      </div>
    </div>

    <div class="table-responsive">
      <table>
        <thead>
          <tr>
            <th>ردیف</th>
            <th>نام رنگ</th>
            <th>کد رنگ</th>
            <th>تاریخ ایجاد رنگ</th>
            <th class="text-center">عملیات</th>
          </tr>
        </thead>
        <tbody>
          @foreach($this->colors as $color)
            <tr>
              <td>{{ $loop->iteration }}</td>
              <td class="whitespace-nowrap">{{ $color->name }}</td>
              <td class="whitespace-nowrap text-right flex items-center gap-2">
                {{ $color->code }}
                <span class="w-4 h-4 rounded border border-gray-300" style="background-color: {{ $color->code }}"></span>
              </td>
              <td class="whitespace-nowrap">{{ getJalaliDate($color->created_at) }}</td>
              <td class="border-b border-[#ebedf2] p-3 text-center dark:border-[#191e3a]">
                <button wire:click="editRow({{ $color->id }})" type="button" x-tooltip="آبدیت">
                  <x-icons.edit/>
                </button>
                <button wire:click.prevent="$dispatch('delete_color', { 'color_id' : {{ $color->id }} })"
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
      {{ $this->colors->links('layouts.admin.pagination') }}
    </ul>
  </div>
</div>

@script
<script>
    Livewire.on('delete_color', (event) => {
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
                Livewire.dispatch('destroy_color', {color_id: event.color_id})
                Swal.fire({
                    title: "حذف انجام شد!",
                    icon: "success"
                });
            }
        });
    })
</script>
@endscript

