<div class="my-10">
  <a href="{{ route('admin.categories.list') }}"
    class="btn btn-primary  flex items-end justify-center gap-2 w-[300px] mb-4">
    <x-icons.menu/>
    لیست دسته بندی ها
  </a>

  <div class="table-responsive">
    <table>
      <thead>
        <tr>
          <th>ردیف</th>
          <th>نام دسته‌بندی</th>
          <th>عکس</th>
          <th>دسته‌بندی والد</th>
          <th>تاریخ دسته‌بندی</th>
          <th class="text-center">عملیات</th>
        </tr>
      </thead>
      <tbody>
        @foreach($this->categories as $category)
          <tr>
            <td>{{ $loop->iteration }}</td>
            <td class="whitespace-nowrap">{{ $category->name }}</td>
            <td class="whitespace-nowrap flex items-center justify-center">
              <img src="{{ asset('images/categories/' . $category->image) }}" alt="image"
                class="object-cover w-12 h-12 mb-5 rounded-full"
              >
            </td>
            <td class="whitespace-nowrap">{{ $category->parent->name}}</td>
            <td class="whitespace-nowrap">{{ getJalaliDate($category->created_at) }}</td>
            <td class="border-b border-[#ebedf2] p-3 text-center dark:border-[#191e3a]">
              <button wire:click.prevent="$dispatch('hard_delete_category', { 'category_id' : {{ $category->id }} })"
                type="button" x-tooltip=" حذف دائم "
                class="text-red-500">
                <x-icons.close2/>
              </button>

              <button wire:click.prevent="$dispatch('rest_category', { 'category_id' : {{ $category->id }} })"
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
    Livewire.on('hard_delete_category', (event) => {
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
                Livewire.dispatch('hard_destroy_category', {category_id: event.category_id})
                Swal.fire({
                    title: "حذف انجام شد!",
                    icon: "success"
                });
            }
        });
    })

    Livewire.on('rest_category', (event) => {
        Livewire.dispatch('restore_category', {category_id: event.category_id})
        Swal.fire({
            title: "عملیات موفق",
            icon: "success"
        });
    })

</script>
@endscript
