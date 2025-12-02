<div class="panel">

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
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4"><path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z"></path></svg>
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
              <td class="border-b border-[#ebedf2] p-3 text-center dark:border-[#191e3a]">
                <button wire:click="editRow({{ $user->id }})" type="button" x-tooltip="Edit">
                  <x-icons.edit/>
                </button>
                <button type="button" x-tooltip="Delete">
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
      {{ $this->users->links('layouts.admin.pagination') }}
    </ul>
  </div>
</div>
