<div class="my-10">
  <a href="{{ route('admin.colors.list') }}"
    class="btn btn-primary  flex items-end justify-center gap-2 w-[300px] mb-4">
    <x-icons.menu/>
    لیست رنگ‌ها
  </a>

  <div class="table-responsive">
    <table>
      <thead>
        <tr>
          <th>ردیف</th>
          <th>نام رنگ</th>
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
              <button wire:click.prevent="$dispatch('hard_delete_color', { 'color_id' : {{ $color->id }} })"
                type="button" x-tooltip=" حذف دائم "
                class="text-red-500">
                <x-icons.close2/>
              </button>

              <button wire:click.prevent="$dispatch('rest_color', { 'color_id' : {{ $color->id }} })"
                type="button" x-tooltip="بازنشانی">
                <x-icons.reset/>
              </button>
            </td>
          </tr>
        @endforeach
      </tbody>
    </table>
  </div>
</div>


@script
<script>
    Livewire.on('hard_delete_color', (event) => {
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
                Livewire.dispatch('hard_destroy_color', {color_id: event.color_id})
                Swal.fire({
                    title: "حذف انجام شد!",
                    icon: "success"
                });
            }
        });
    })

    Livewire.on('rest_color', (event) => {
        Livewire.dispatch('restore_color', {color_id: event.color_id})
        Swal.fire({
            title: "عملیات موفق",
            icon: "success"
        });
    })

</script>
@endscript
