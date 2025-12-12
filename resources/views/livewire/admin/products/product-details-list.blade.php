@php use App\Enums\ProductStatus; @endphp
<div class="panel min-h-screen">
  {{--    message--}}
  <x-admin.message/>

  {{--  loading liveire component page--}}
  <x-admin.loading/>

  <div class="flex justify-between">
    <a href="{{ route('admin.product-details.trashed', $this->product->id) }}"
      class="btn btn-danger  flex items-end justify-center gap-2 w-[300px]">
      <x-icons.trash/>
      تنوع قیمت‌های حذف شده محصول
    </a>
    <a href="{{ route('admin.product.details.create', $this->product->id) }}"
      class="btn btn-primary flex justify-center gap-2 w-[300px]">
      <x-icons.add/>
      ایجاد قیمت جدید
    </a>
  </div>

  <div class="table-responsive">
    <table>
      <thead>
        <tr>
          <th>ردیف</th>
          <th>قیمت</th>
          <th>درصد تخفیف</th>
          <th>تعداد</th>
          <th>حداکثر فروش</th>
          <th>رنگ</th>
          <th>گارانتی</th>
          <th>وضعیت</th>
          <th>تاریخ ایحاد</th>
          <th class="text-center">عملیات</th>
        </tr>
      </thead>
      <tbody>
        @foreach($this->productDetails as $productDetail)
          <tr>
            <td>{{ $loop->iteration }}</td>
            <td class="whitespace-nowrap">{{ number_format($productDetail->price )}}</td>
            <td class="whitespace-nowrap">{{ number_format($productDetail->discount )}}</td>
            <td class="whitespace-nowrap">{{ $productDetail->count }}</td>
            <td class="whitespace-nowrap">{{ $productDetail->max_sell }}</td>
            <td class="whitespace-nowrap {{ $productDetail->color?->name ?: 'text-danger'}}">{{ $productDetail->color?->name ?: '--'}}</td>
            <td class="whitespace-nowrap {{ $productDetail->guaranty?->name ?: 'text-danger'}}">{{ $productDetail->guaranty?->name ?: '--'}}</td>
            <td class="whitespace-nowrap">
              @if($productDetail->status == ProductStatus::Active->value)
                <span type="button" class="btn btn-success">فعال</span>
              @elseif($productDetail->status == ProductStatus::Inactive->value)
                <span type="button" class="btn btn-danger">غیرفعال</span>
              @endif
            </td>
            {{--            <td class="whitespace-nowrap">{{ __("enums.$productDetail->status") }}</td>--}}
            <td class="whitespace-nowrap">{{ getJalaliDate($productDetail->created_at) }}</td>

            <td class="flex justify-center items-center  border-b border-[#ebedf2] p-3 dark:border-[#191e3a]">
              <a href="{{ route('admin.product.details.edit', $productDetail->id) }}" class="p-2" x-tooltip="ویرایش محصول">
                <x-icons.edit/>
              </a>
              <button wire:click.prevent="$dispatch('delete_product_details', { 'product_details_id' : {{ $productDetail->id }} })"
                type="button" x-tooltip="حذف"
                class="p-2 text-red-500">
                <x-icons.delete/>
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
    Livewire.on('delete_product_details', (event) => {
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
                Livewire.dispatch('destroy_product_details', {product_details_id: event.product_details_id})
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
</script>
@endscript

