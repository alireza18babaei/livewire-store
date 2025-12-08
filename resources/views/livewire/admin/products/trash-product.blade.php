<div class="my-10">
  <a href="{{ route('admin.product.list') }}"
    class="btn btn-primary  flex items-end justify-center gap-2 w-[300px] mb-4">
    <x-icons.menu/>
    لیست محصول‌ها
  </a>

  <div class="table-responsive">
    <table>
      <thead>
        <tr>
          <th>ردیف</th>
          <th>نام محصول</th>
          <th>product name</th>
          <th>دسته بندی</th>
          <th>برند</th>
          <th>تاریخ ایجاد محصول</th>
          <th class="text-center">عملیات</th>
        </tr>
      </thead>
      <tbody>
        @foreach($this->products as $product)
          <tr>
            <td>{{ $loop->iteration }}</td>
            <td class="whitespace-nowrap">{{ $product->name }}</td>
            <td class="whitespace-nowrap text-right flex items-center justify-center gap-2">
              {{ $product->e_name }}
            </td>
            <td class="whitespace-nowrap {{ $product->category?->name ?? 'text-danger' }}">{{ $product->category?->name ?? 'حذف شده' }}</td>
            <td class="whitespace-nowrap {{ $product->brand?->name ?? 'text-danger' }}">{{ $product->brand?->name ?? 'حذف شده' }}</td>
            <td class="whitespace-nowrap">{{ getJalaliDate($product->created_at) }}</td>
            <td class="border-b border-[#ebedf2] p-3 text-center dark:border-[#191e3a]">
              <button wire:click.prevent="$dispatch('hard_delete_product', { 'product_id' : {{ $product->id }} })"
                type="button" x-tooltip=" حذف دائم "
                class="text-red-500">
                <x-icons.close2/>
              </button>

              <button wire:click.prevent="$dispatch('rest_product', { 'product_id' : {{ $product->id }} })"
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
      {{ $this->products->links('layouts.admin.pagination') }}
    </ul>
  </div>
</div>


@script
<script>
    Livewire.on('hard_delete_product', (event) => {
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
                Livewire.dispatch('hard_destroy_product', {product_id: event.product_id})
                Swal.fire({
                    title: "حذف انجام شد!",
                    icon: "success"
                });
            }
        });
    })

    Livewire.on('rest_product', (event) => {
        Livewire.dispatch('restore_product', {product_id: event.product_id})
        Swal.fire({
            title: "عملیات موفق",
            icon: "success"
        });
    })

</script>
@endscript
