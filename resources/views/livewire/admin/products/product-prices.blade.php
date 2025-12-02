@php use App\Enums\ProductStatus; @endphp
<div class="panel min-h-screen">
  {{--    message--}}
  <x-admin.message/>

  {{--  loading liveire component page--}}
  <x-admin.loading/>

  <div class="flex justify-between">
    <a href="{{ route('admin.product.trashed') }}"
      class="btn btn-danger  flex items-end justify-center gap-2 w-[300px]">
      <x-icons.trash/>
      تنوع قیمت‌های حذف شده محصول
    </a>
    <a href="{{ route('admin.product.prices.create', $this->product->id) }}"
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
          <th>رنگ</th>
          <th>گارانتی</th>
          <th>وضعیت</th>
          <th>تاریخ ایحاد</th>
          <th class="text-center">عملیات</th>
        </tr>
      </thead>
      <tbody>
        @foreach($this->productPrices as $productPrice)
          <tr>
            <td>{{ $loop->iteration }}</td>
            <td class="whitespace-nowrap">{{ number_format($productPrice->price )}}</td>
            <td class="whitespace-nowrap">{{ number_format($productPrice->discount )}}</td>
            <td class="whitespace-nowrap">{{ $productPrice->count }}</td>
            <td class="whitespace-nowrap">{{ $productPrice->color->name}}</td>
            <td class="whitespace-nowrap">{{ $productPrice->guaranty->name}}</td>
            <td class="whitespace-nowrap">
              @if($productPrice->status == ProductStatus::Active->value)
                <span type="button" class="btn btn-success">فعال</span>
              @elseif($productPrice->status == ProductStatus::Inactive->value)
                <span type="button" class="btn btn-danger">غیرفعال</span>
              @endif
            </td>
{{--            <td class="whitespace-nowrap">{{ __("enums.$productPrice->status") }}</td>--}}
            <td class="whitespace-nowrap">{{ getJalaliDate($productPrice->created_at) }}</td>

            <td class="flex justify-center items-center  border-b border-[#ebedf2] p-3 dark:border-[#191e3a]">
              <a href="{{ route('admin.product.edit', $productPrice->id) }}" class="p-2" x-tooltip="ویرایش محصول">
                <x-icons.edit/>
              </a>
              <button wire:click.prevent="$dispatch('delete_product', { 'product_price_id' : {{ $productPrice->id }} })"
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
      {{ $this->productPrices->links('layouts.admin.pagination') }}
    </ul>
  </div>
</div>

@script
<script>
    Livewire.on('delete_product_price', (event) => {
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
                Livewire.dispatch('destroy_product_price', {product_price_id: event.product_price_id})
                Swal.fire({
                    title: "حذف انجام شد!",
                    icon: "success"
                });
            }
        });
    })
</script>
@endscript

