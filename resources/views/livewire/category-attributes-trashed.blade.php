<div class="my-10">
  <a href="{{ route('admin.categories.attribute.list', $this->category->id) }}"
    class="btn btn-primary  flex items-end justify-center gap-2 w-[300px] mb-4">
    <x-icons.menu/>
    لیست دسته بندی ها
  </a>

  <div class="table-responsive">
    <table>
      <thead>
        <tr>
          <th>ردیف</th>
          <th>نام ویژگی</th>
          <th>تاریخ دسته‌بندی</th>
          <th class="text-center">عملیات</th>
        </tr>
      </thead>
      <tbody>
        @foreach($this->trashedAttributes as $trashedAttribute)
          <tr>
            <td>{{ $loop->iteration }}</td>
            <td class="whitespace-nowrap">{{ $trashedAttribute->name }}</td>
            <td class="whitespace-nowrap">{{ getJalaliDate($trashedAttribute->created_at) }}</td>
            <td class="border-b border-[#ebedf2] p-3 text-center dark:border-[#191e3a]">
              <button wire:click.prevent="$dispatch('hard_delete_trashed_attribute', { 'trashed_attribute_id' : {{ $trashedAttribute->id }} })"
                type="button" x-tooltip=" حذف دائم "
                class="text-red-500">
                <x-icons.close2/>
              </button>

              <button wire:click.prevent="$dispatch('rest_trashed_attribute', { 'trashed_attribute_id' : {{ $trashedAttribute->id }} })"
                type="button" x-tooltip="بازنشانی">
                <x-icons.reset/>
              </button>
            </td>
          </tr>
        @endforeach
      </tbody>
    </table>
  </div>
  <div class="flex justify-center">
    <ul class="inline-flex items-center justify-center space-x-1 rtl:space-x-reverse">
      {{ $this->trashedAttributes->links('layouts.admin.pagination') }}
    </ul>
  </div>
</div>


@script
<script>
    Livewire.on('hard_delete_trashed_attribute', (event) => {
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
                Livewire.dispatch('hard_destroy_trashed_attribute', {trashed_attribute_id: event.trashed_attribute_id})
                Swal.fire({
                    title: "حذف انجام شد!",
                    icon: "success"
                });
            }
        });
    })

    Livewire.on('rest_trashed_attribute', (event) => {
        Livewire.dispatch('restore_trashed_attribute', {trashed_attribute_id: event.trashed_attribute_id})
        Swal.fire({
            title: "عملیات موفق",
            icon: "success"
        });
    })

</script>
@endscript
