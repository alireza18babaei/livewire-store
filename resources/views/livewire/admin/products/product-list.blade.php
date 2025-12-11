@php use App\Enums\ProductStatus; @endphp

<div class="panel min-h-screen">

  {{--    message--}}
  <x-admin.message/>

  {{--  loading liveire component page--}}
  <x-admin.loading/>

  <div class="my-10 space-y-5">
    <div class="flex justify-between items-center">
      <form @submit.prevent="$wire.searchData()">
        <div class="relative">
          <label for="search" class="sr-only">Search</label>
          <input type="text" id="search" x-model="$wire.search"
            @input.debounce.800ms="$wire.searchData()"
            class="mt-0.5 pr-10 w-[300px] rounded border-gray-300 pe-10 shadow-sm sm:text-sm">
          <span class="absolute inset-y-0 right-2 grid w-8 place-content-center">
            <button type="submit" aria-label="Submit"
              class="rounded-full p-1.5 text-gray-700 transition-colors hover:bg-gray-100">
              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                stroke="currentColor" class="size-4"><path stroke-linecap="round" stroke-linejoin="round"
                  d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z"></path></svg>
            </button>
          </span>
        </div>
      </form>
    </div>

    <div class="flex justify-between">
      <a href="{{ route('admin.product.trashed') }}"
        class="btn btn-danger  flex items-end justify-center gap-2 w-[300px]">
        <x-icons.trash/>
        محصول‌های حذف شده
      </a>

      <a href="{{ route('admin.product.create') }}"
        class="btn btn-primary flex  justify-center gap-2 w-[300px]">
        <x-icons.add/>
        ایجاد محصول
      </a>
    </div>

    <div class="table-responsive">
      <table>
        <thead>
          <tr>
            <th>ردیف</th>
            <th>نام محصول</th>
{{--            <th>product name</th>--}}
            <th>قیمت</th>
            <th>درصد تخفیف</th>
            <th>تعداد</th>
            <th>حداکثر فروش</th>
            <th>عکس</th>
{{--            <th>توضیحات</th>--}}
            <th>وضعیت</th>
            <th>دسته‌بندی</th>
            <th>برند</th>
            <th>تنوع قیمت</th>
            <th>ویژگی‌ها</th>
            <th>تاریخ ایجاد</th>
            <th class="text-center">عملیات</th>
          </tr>
        </thead>
        <tbody>
          @foreach($this->products as $product)
            <tr>
              <td>{{ $loop->iteration }}</td>
              <td class="whitespace-nowrap">{{ $product->name }}</td>
{{--              <td class="whitespace-nowrap">{{ $product->e_name }}</td>--}}
              <td class="whitespace-nowrap">{{ number_format($product->mainDetails->price )}}</td>
              <td class="whitespace-nowrap">{{ $product->mainDetails->discount}}</td>
              <td class="whitespace-nowrap">{{ $product->mainDetails->count }}</td>
              <td class="whitespace-nowrap">{{ $product->mainDetails->max_sell }}</td>
              <td class="whitespace-nowrap w-[80px] flex items-center justify-center">
                <img src="{{ asset('images/products/' . $product->mainDetails->image) }}" alt="image"
                  class="object-cover w-12 h-12 mb-5 rounded-full">
              </td>
{{--              <td class="whitespace-nowrap">{!! clean($product->description) !!}</td>--}}
              <td class="whitespace-nowrap">
                @if($product->status == ProductStatus::Active->value)
                  <span type="button" class="btn btn-success">فعال</span>
                @elseif($product->status == ProductStatus::Inactive->value)
                  <span type="button" class="btn btn-danger">غیرفعال</span>
                @endif
              </td>
              <td class="whitespace-nowrap {{ $product->category?->name ?: 'text-danger' }}">{{ $product->category?->name ?: 'حذف شده' }}</td>
              <td class="whitespace-nowrap {{ $product->brand?->name ?: 'text-danger' }}">{{ $product->brand?->name ?: 'حذف شده' }}</td>
              <td class="whitespace-nowrap">
                <a href="{{ route('admin.product.details', $product->id) }}" class="btn btn-outline-info">تنوع قیمت</a>
              </td>
              <td class="whitespace-nowrap">
                <a href="{{ route('admin.product.properties', $product->id) }}" class="btn btn-outline-secondary">ویژگی محصول</a>
              </td>
              <td class="whitespace-nowrap">{{ getJalaliDate($product->created_at) }}</td>

              <td class="flex justify-center items-center  border-b border-[#ebedf2] p-3 dark:border-[#191e3a]">
                <a href="{{ route('admin.product.edit', $product->id) }}" class="p-2" x-tooltip="ویرایش محصول">
                  <x-icons.edit/>
                </a>
                <button wire:click.prevent="$dispatch('delete_product', { 'product_id' : {{ $product->id }} })"
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
  </div>
  <div class="flex justify-center">
    <ul class="inline-flex items-center justify-center space-x-1 rtl:space-x-reverse">
      {{ $this->products->links('layouts.admin.pagination') }}
    </ul>
  </div>
</div>

@script
<script>
    Livewire.on('delete_product', (event) => {
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
                Livewire.dispatch('destroy_product', {product_id: event.product_id})
                Swal.fire({
                    title: "حذف انجام شد!",
                    icon: "success"
                });
            }
        });
    })
</script>
@endscript

