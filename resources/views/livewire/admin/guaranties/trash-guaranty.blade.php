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
  <div class="flex justify-center">
    <ul class="inline-flex items-center justify-center space-x-1 rtl:space-x-reverse">
      {{ $this->guaranties->links('layouts.admin.pagination') }}
    </ul>
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
                // Swal.fire({
                //     title: "حذف انجام شد!",
                //     icon: "success"
                // });
            }
        });
    })
    Livewire.on('success', (event) => {
        Swal.fire({
            title: event.message,
            icon: "success"
        });
    });

    Livewire.on('error', (event) => {
        Swal.fire({
            title: event.message,
            icon: "error"
        });
    });



    Livewire.on('rest_guaranty', (event) => {
        Livewire.dispatch('restore_guaranty', {guaranty_id: event.guaranty_id})
        Swal.fire({
            title: "عملیات موفق",
            icon: "success"
        });
    })
</script>
@endscript
