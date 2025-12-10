<div>
  <div class="panel min-h-scree">

    {{--    message--}}
    <x-admin.message/>

    {{--  loading liveire component page--}}
    <x-admin.loading/>

    <div class="mb-5">
      <h1 class="my-4 font-bold text-lg">ایجاد ویژگی</h1>

      <div class=" flex justify-around items-center">
        <form class="space-y-10">
          <div class="grid grid-cols-1 gap-4 sm:grid-cols-4 py-4">
            <div>
              <label for="name">نام ویژگی</label>
              <input wire:model="name" id="name" type="text" class="form-input">
              @error('name') <p class="text-danger mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
              <button
                wire:click.prevent="createRow"
                class="btn btn-success !mt-6"
              >تایید
              </button>
            </div>
          </div>
        </form>
        <div>
          <a href="{{ route('admin.categories.attribute.trashed.list', $this->category->id) }}"
            class="btn btn-danger  flex items-end justify-center gap-2 w-[300px]">
            <x-icons.trash/>
            ویژگی‌های حذف شده
          </a>
        </div>
      </div>
    </div>

    <div class="table-responsive">
      <table>
        <thead>
          <tr>
            <th>ردیف</th>
            <th>عنوان ویژگی</th>
            <th>تاریخ ایجاد</th>
            <th class="text-center">عملیات</th>
          </tr>
        </thead>
        <tbody>
          @foreach($this->Attributes as $attribute)
            <tr>
              <td>{{ $loop->iteration }}</td>

              <td class="whitespace-nowrap max-w-max">
                @if($editIndex && $attribute->id == $editIndex)
                  <form>
                    <div>
                      <input wire:model="edit_name" id="edit_name" type="text" class=" max-w-max form-input py-0.5 !w-[800px]">
                      @error('edit_name') <p class="text-danger mt-1">{{ $message }}</p> @enderror
                    </div>
                    <input class="sr-only" id="editBtn" type="submit" wire:click.prevent="updateRow">
                  </form>
                @else
                  {{ $attribute->name }}
                @endif
              </td>

              <td class="whitespace-nowrap">{{ getJalaliDate($attribute->created_at) }}</td>
              <td class="flex justify-center items-center gap-2">
                @if($editIndex && $attribute->id == $editIndex)
                  <label for="editBtn" class="cursor-pointer">
                    <x-icons.check size="22" class="text-emerald-500 self-start"/>
                  </label>
                @else
                  <button wire:click="editRow({{ $attribute->id }})" type="button" x-tooltip="آبدیت">
                    <x-icons.edit/>
                  </button>
                @endif
                <button wire:click.prevent="$dispatch('delete_attribute', { 'attribute_id' : {{ $attribute->id }} })"
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
      {{ $this->Attributes->links('layouts.admin.pagination') }}
    </ul>
  </div>
</div>

@script
<script>
    Livewire.on('delete_attribute', (event) => {
        Swal.fire({
            title: "آیا از حذف مطمئن هستید؟",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "بله",
            cancelButtonText: 'خیر',
        }).then((result) => {
            if (result.isConfirmed) {
                Livewire.dispatch('destroy_attribute', {attribute_id: event.attribute_id})
                Swal.fire({
                    title: "حذف انجام شد!",
                    icon: "success"
                });
            }
        });
    })
</script>
@endscript

</div>
