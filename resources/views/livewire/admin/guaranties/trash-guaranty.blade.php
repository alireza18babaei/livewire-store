<div class="my-10">
  <a href="{{ route('admin.guaranty.list') }}"
    class="btn btn-primary  flex items-end justify-center gap-2 w-[300px] mb-4">
    <x-icons.menu/>
    لیست گارانتی‌ها
  </a>

  <div class="table-responsive">
    <table>
      <thead>
        <tr>
          <th>ردیف</th>
          <th>نام گارانتی</th>
          <th>تاریخ ایجاد گارانتی</th>
          <th class="text-center">عملیات</th>
        </tr>
      </thead>
      <tbody>
        @foreach($this->guaranties as $guaranty)
          <tr>
            <td>{{ $loop->iteration }}</td>
            <td class="whitespace-nowrap">{{ $guaranty->name }}</td>
            <td class="whitespace-nowrap text-right flex items-center gap-2">
              {{ $guaranty->code }}
              <span class="w-4 h-4 rounded border border-gray-300" style="background-guaranty: {{ $guaranty->code }}"></span>
            </td>
            <td class="whitespace-nowrap">{{ getJalaliDate($guaranty->created_at) }}</td>
            <td class="border-b border-[#ebedf2] p-3 text-center dark:border-[#191e3a]">
              <button wire:click.prevent="$dispatch('hard_delete_guaranty', { 'guaranty_id' : {{ $guaranty->id }} })"
                type="button" x-tooltip=" حذف دائم "
                class="text-red-500">
                <x-icons.close2/>
              </button>

              <button wire:click.prevent="$dispatch('rest_guaranty', { 'guaranty_id' : {{ $guaranty->id }} })"
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
    Livewire.on('hard_delete_guaranty', (event) => {
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
                Livewire.dispatch('hard_destroy_guaranty', {guaranty_id: event.guaranty_id})
                Swal.fire({
                    title: "حذف انجام شد!",
                    icon: "success"
                });
            }
        });
    })

    Livewire.on('rest_guaranty', (event) => {
        Livewire.dispatch('restore_guaranty', {guaranty_id: event.guaranty_id})
        Swal.fire({
            title: "عملیات موفق",
            icon: "success"
        });
    })

</script>
@endscript
