<div>
  <div class="panel min-h-scree">

    {{--    message--}}
    <x-admin.message/>

    {{--  loading liveire component page--}}
    <x-admin.loading/>

    <div class="mb-5">
      <h1 class="my-4 font-bold text-lg">ایجاد ویژگی محصول</h1>

      <div class=" flex justify-around items-center">
        <form class="space-y-10">
          <div class="grid grid-cols-1 gap-4 sm:grid-cols-4 py-4">
            <div>
              <label for="name">عنوان ویژگی محصول</label>
              <input wire:model="name" id="name" type="text" class="form-input">
              @error('name') <p class="text-danger mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
              <label for="category_attribute_select">دسته‌بندی ویژگی</label>
              <select wire:model="category_attribute_id" id="category_attribute_select" class="form-select text-white-dark">
                <option selected>انتخاب کنید</option>
                @foreach($categoriesAttributes as $key=>$value)
                  <option value="{{$key}}">{{$value}}</option>
                @endforeach
              </select>
              @error('category_attribute_id') <p class="text-danger mt-1">{{ $message }}</p> @enderror
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
{{--          <a href="{{ route('admin.categories.property.trashed.list', $this->product->id) }}"--}}
{{--            class="btn btn-danger  flex items-end justify-center gap-2 w-[300px]">--}}
{{--            <x-icons.trash/>--}}
{{--            ویژگی ‌های حذف شده محصول--}}
{{--          </a>--}}
        </div>
      </div>
    </div>

    <div class="table-responsive">
      <table>
        <thead>
          <tr>
            <th>ردیف</th>
            <th>عنوان ویژگی محصول</th>
            <th>عنوان ویژگی دسته بندی</th>
            <th>تاریخ ایجاد</th>
            <th class="text-center">عملیات</th>
          </tr>
        </thead>
        <tbody>
          @foreach($this->productProperties as $property)
            <tr>
              <td>{{ $loop->iteration }}</td>

              <td class="whitespace-nowrap max-w-max"> {{ $property->name }} </td>

              <td class="whitespace-nowrap max-w-max">
                {{ $property->categoryAttribute?->name }}
              </td>

              <td class="whitespace-nowrap">{{ getJalaliDate($property->created_at) }}</td>
              <td class="flex justify-center items-center gap-2">
                @if($editIndex && $property->id == $editIndex)
                  <label for="editBtn" class="cursor-pointer">
                    <x-icons.check size="22" class="text-emerald-500 self-start"/>
                  </label>
                @else
                  <button wire:click="editRow({{ $property->id }})" type="button" x-tooltip="آبدیت">
                    <x-icons.edit/>
                  </button>
                @endif
                <button wire:click.prevent="$dispatch('delete_property', { 'property_id' : {{ $property->id }} })"
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
      {{ $this->productProperties->links('layouts.admin.pagination') }}
    </ul>
  </div>
</div>

@script
<script>
    Livewire.on('delete_property', (event) => {
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
                Livewire.dispatch('destroy_property', {property_id: event.property_id})
                Swal.fire({
                    title: "حذف انجام شد!",
                    icon: "success"
                });
            }
        });
    })
</script>
@endscript
