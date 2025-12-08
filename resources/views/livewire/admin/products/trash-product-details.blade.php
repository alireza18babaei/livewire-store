<div class="my-10">
  <a href="{{ route('admin.product.details', $this->product->id) }}"
    class="btn btn-primary  flex items-end justify-center gap-2 w-[300px] mb-4">
    <x-icons.menu/>
    لیست قیمت‌های حذف شده محصول
  </a>

  <div class="table-responsive">
    <table>
      <thead>
        <tr>
          <th>ردیف</th>
          <th>عکس</th>
          <th>قیمت</th>
          <th>درصد تخفیف</th>
          <th>تعداد</th>
          <th>حداکثر فروش</th>
          <th>رنگ</th>
          <th>گارانتی</th>
          <th>تاریخ ایحاد</th>
          <th class="text-center">عملیات</th>
        </tr>
      </thead>
      <tbody>
        @foreach($this->productDetails as $productDetail)
          <tr>
            <td>{{ $loop->iteration }}</td>
            <td class="whitespace-nowrap w-[80px] flex items-center justify-center">
              <img src="{{ asset('images/products/' . $productDetail->image) }}" alt="image"
                class="object-cover w-12 h-12 mb-5 rounded-full">
            </td>
            <td class="whitespace-nowrap">{{ number_format($productDetail->price )}}</td>
            <td class="whitespace-nowrap">{{ number_format($productDetail->discount )}}</td>
            <td class="whitespace-nowrap">{{ $productDetail->count }}</td>
            <td class="whitespace-nowrap">{{ $productDetail->max_sell }}</td>
            <td class="whitespace-nowrap {{ $productDetail->product_detail?->name ?: 'text-danger'}}">{{ $productDetail->product_detail?->name ?: 'حذف شده'}}</td>
            <td class="whitespace-nowrap {{ $productDetail->guaranty?->name ?: 'text-danger'}}">{{ $productDetail->guaranty?->name ?: 'حذف شده'}}</td>
            {{--            <td class="whitespace-nowrap">{{ __("enums.$productDetail->status") }}</td>--}}
            <td class="whitespace-nowrap">{{ getJalaliDate($productDetail->created_at) }}</td>
            <td class="border-b border-[#ebedf2] p-3 text-center dark:border-[#191e3a]">
              <button wire:click.prevent="$dispatch('hard_delete_product_detail', { 'product_detail_id' : {{ $productDetail->id }} })"
                type="button" x-tooltip=" حذف دائم "
                class="text-red-500">
                <x-icons.close2/>
              </button>

              <button wire:click.prevent="$dispatch('rest_product_detail', { 'product_detail_id' : {{ $productDetail->id }} })"
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
      {{ $this->productDetails->links('layouts.admin.pagination') }}
    </ul>
  </div>
</div>


@script
<script>
    Livewire.on('hard_delete_product_detail', (event) => {
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
                Livewire.dispatch('hard_destroy_product_detail', {product_detail_id: event.product_detail_id})
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


    Livewire.on('rest_product_detail', (event) => {
        Livewire.dispatch('restore_product_detail', {product_detail_id: event.product_detail_id})
        Swal.fire({
            title: "عملیات موفق",
            icon: "success"
        });
    })

</script>
@endscript
