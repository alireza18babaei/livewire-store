<div class="panel" x-data="modal">

  {{--    message--}}
  <x-admin.message/>

  {{--  loading liveire component page--}}
  <x-admin.loading/>
  <div class="mb-5">
    <h1 class="my-4 font-bold text-lg">ایجاد کاربر</h1>
    <form class="space-y-10">
      <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 py-4">
        <div>
          <label for="name">نام و نام‌خانوادگی</label>
          <input wire:model="name" id="name" type="text" class="form-input">
          @error('name') <p class="text-danger mt-1">{{ $message }}</p> @enderror
        </div>
        <div>
          <label for="email">ایمیل</label>
          <input wire:model="email" id="email" type="email" class="form-input">
          @error('email') <p class="text-danger mt-1">{{ $message }}</p> @enderror
        </div>
      </div>
      <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 py-4">
        <div>
          <label for="number">مبایل</label>
          <input wire:model="phone" id="number" type="text" class="form-input">
          @error('phone') <p class="text-danger mt-1">{{ $message }}</p> @enderror
        </div>
        <div>
          <label for="gridPassword">رمز عبور</label>
          <input wire:model="password" id="gridPassword" type="Password" class="form-input">
          @error('password') <p class="text-danger mt-1">{{ $message }}</p> @enderror
        </div>
      </div>
      @if($editIndex)
        <button wire:click.prevent="updateRow" class="btn btn-primary !mt-6">ویرایش</button>
      @else
        <button wire:click.prevent="createRow" class="btn btn-success !mt-6">تایید</button>
      @endif
    </form>
  </div>

  <hr>

  <div class="my-10">
    <form @submit.prevent="$wire.searchData()">
      <div class="relative mb-5">
        <label for="search" class="sr-only">Search</label>
        <input type="text" id="search" x-model.debounce="$wire.search"
          @input.debounce.600ms="$wire.searchData()"
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

    <div class="table-responsive">
      <table>
        <thead>
          <tr>
            <th>ردیف</th>
            <th>نام و نام‌خانوادگی</th>
            <th>ایمیل</th>
            <th>مبایل</th>
            <th>نقش‌ها</th>
            <th>انتصاب نقش‌ها</th>
            <th class="text-center">عملیات</th>
          </tr>
        </thead>
        <tbody>
          @foreach($this->users as $user)
            <tr>
              <td>{{ $loop->iteration }}</td>
              <td class="whitespace-nowrap">{{ $user->name }}</td>
              <td class="whitespace-nowrap">{{ $user->email ?? '-' }}</td>
              <td class="whitespace-nowrap">{{ $user->phone ?? '-' }}</td>

              <td>
                <div class="grid grid-cols-3 gap-2">
                  @foreach($user->roles->pluck('name') as $permissionName)
                    <span
                      class="py-1 rounded border border-gray-300 bg-gray-100 text-center text-xs text-gray-700">{{ $permissionName }}</span>
                  @endforeach
                </div>
              </td>

              <td class="whitespace-nowrap flex justify-center">
                <button type="button" class="btn btn-info" wire:click="setSelectUser({{ $user->id }})" @click="toggle">لیست نقش‌ها</button>
              </td>

              <td class="border-b border-[#ebedf2] p-3 text-center dark:border-[#191e3a]">
                <button wire:click="editRow({{ $user->id }})" type="button" x-tooltip="Edit">
                  <x-icons.edit/>
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
      {{ $this->users->links('layouts.admin.pagination') }}
    </ul>
  </div>

  <div class="fixed inset-0 bg-[black]/60 z-[999] hidden overflow-y-auto" :class="open && '!block'">
    <div class="flex items-center justify-center min-h-screen px-4" @click.self="open = false">
      <div x-show="open" x-transition x-transition.duration.300  x-trap="open" class="panel border-0 p-0 rounded-lg overflow-hidden w-full max-w-lg my-8">
        <div class="p-5">
          <h5 class="font-bold text-lg m-4">لیست مجوزها</h5>
          <div class="dark:text-white-dark/70 text-base font-medium text-[#1f2937]">
            <p wire:loading >درحال دریافت اطلاعات...</p>
            <div wire:loading.remove class="p-5">
              @foreach($this->roles as $role)
                <label for="{{'role' . $loop->iteration}}" class="p-1">
                  <input wire:model="selected_role" value="{{ $role }}"
                    type="checkbox"
                    id="{{'role' . $loop->iteration}}"
                    class="form-checkbox outline-primary rounded-full"/>
                  <span>{{ $role }}</span>
                </label>
              @endforeach
            </div>
          </div>
          <div class="flex justify-end items-center mt-8">
            <button type="button" class="btn btn-outline-danger" @click="toggle">انصراف</button>
            <button type="button" class="btn btn-primary ltr:ml-4 rtl:mr-4" wire:click="saveUserRole()" @click="toggle">ذخیره</button>
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
</script>
@endscript
