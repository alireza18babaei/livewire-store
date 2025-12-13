<div class="panel min-h-screen space-y-5">
  {{--    message--}}
  <x-admin.message/>

  <div class="mb-5">
    <h1 class="my-4 font-bold text-lg">گالری تصاویر</h1>

  </div>

  <form class="space-y-10" wire:submit="saveImages">
    <input wire:model="images" id="ctnFile" type="file" multiple
      class="p-0 w-[400px] rtl:file-ml-5 form-input file:border-0 file:bg-primary/90 file:py-2 file:px-4 file:font-semibold file:text-white file:hover:bg-primary ltr:file:mr-5">
    @error('images') <p class="text-danger mt-1"> {{ $message }}</p> @enderror
    <button type="submit" class="btn btn-success !mt-6">تایید</button>
  </form>

  @if($this->images)
    <section class="bg-gray-100 p-10 min-h-[200px] w-full rounded
    border border-gray-300 shadow-lg">
      <h3 class="mb-5 p-2 bg-warning text-white rounded">عکس‌های بارگذاری شده</h3>
      <div class="flex flex-wrap items-center justify-center gap-2">
        @foreach($this->images as $index => $image)
          <div class="relative h-[200px] w-1/4 rounded">
            <img src="{{ $image->temporaryUrl() }}"
              class="w-full h-full rounded object-cover">
            <button
              type="button"
              wire:click="unsetImage({{ $index }})"
              class="absolute top-2 left-2 rounded text-red-600 hover:text-white hover:bg-red-600 transition">
              <x-icons.close2/>
            </button>
          </div>
        @endforeach
      </div>
    </section>
  @endif

  @if(count($product->images))
    <section class="bg-gray-100 p-10 w-full rounded
    border border-gray-300 shadow-lg">
      <h3 class="mb-5 p-2 bg-primary text-white rounded">عکس‌های ذخیره شده</h3>
      <div class="flex flex-wrap items-center justify-center gap-2">
        @foreach($product->images as $image)
          <div class="relative h-[200px] w-1/4 rounded">
            <img src="{{ asset('images/products/' . $image->image) }}" alt=""
              class="w-full h-full rounded object-cover">
            <button
              wire:click="dispatch('delete_image', { image_id: {{ $image->id }} })"
              class="absolute top-2 left-2 cursor-pointer rounded text-red-600 hover:text-black hover:bg-red-600 transition">
              <x-icons.close2/>
            </button>
          </div>
        @endforeach
      </div>
    </section>
  @endif
</div>

@script
<script>
    Livewire.on('delete_image', (event) => {
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
                Livewire.dispatch('destroy_image', {image_id: event.image_id})
            }
        });
    })
</script>
@endscript
