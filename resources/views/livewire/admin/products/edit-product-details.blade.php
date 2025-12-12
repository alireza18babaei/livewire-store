<div class="panel min-h-screen">
  {{--    message--}}
  <x-admin.message/>

  {{--  loading liveire component page--}}
  <x-admin.loading/>

  <div class="mb-5">
    <h1 class="my-4 font-bold text-lg">ایجاد تنوع قیمت</h1>

  </div>

  <form class="space-y-10">
    <div class="space-y-10">

      <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 py-4">

        <div>
          <label for="prise">قیمت اصلی</label>
          <input wire:model="main_price" id="price" type="text" class="form-input">
          @error('price') <p class="text-danger mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
          <label for="discount">درصد تخفیف</label>
          <input wire:model="discount" id="discount" type="text" class="form-input">
          @error('discount') <p class="text-danger mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
          <label for="count">تعداد</label>
          <input wire:model="count" id="count" type="text" class="form-input">
          @error('count') <p class="text-danger mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
          <label for="max_sell">حداکثر فروش</label>
          <input wire:model="max_sell" id="max_sell" type="text" class="form-input">
          @error('max_sell') <p class="text-danger mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
          <div wire:ignore>
            <label for="max_sell">رنگ</label>
            <select wire:model="color_id" id="color-select">
              @foreach($colors as $key=>$value)
                <option value="{{$key}}" {{$this->color_id == $key ? 'selected' : ''}}>
                  {{$value}}</option>
              @endforeach
            </select>
          </div>
          @error('color_id') <p class="text-danger mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
          <div wire:ignore>
            <label for="max_sell">گارانتی</label>
            <select wire:model="guaranty_id" id="guaranty-select">
              @foreach($guaranties as $key=>$value)
                <option value="{{ $key }}" {{$this->guaranty_id == $key ? 'selected' : ''}}>
                  {{ $value }}</option>
              @endforeach
            </select>
          </div>
          @error('guaranty_id') <p class="text-danger mt-1">{{ $message }}</p> @enderror
        </div>
        <div>

          <div>
            <label for="status">وضعیت</label>
            <select wire:model="status" id="status" class="form-select text-white-dark">
              @foreach($products_status as $status)
                <option value="{{ $status->value }}" {{$this->status == $status->value  ? 'selected' : ''}}>
                  {{ __("enums.$status->value") }}</option>
              @endforeach
            </select>
            @error('status') <p class="text-danger mt-1">{{ $message }}</p> @enderror
          </div>
        </div>
      </div>
      <div>
        <button wire:click.prevent="updateRow" class="btn btn-success !mt-6">تایید</button>
      </div>
    </div>
  </form>
</div>

@assets
<link rel="stylesheet" type="text/css" href="{{ asset('panel/css/nice-select2.css') }}"/>
<script src="{{ asset('panel/js/nice-select2.js') }}"></script>
<script src="{{ asset('panel/js/ckeditor/ckeditor.js') }}"></script>
@endassets

@script
<script>
    let els = document.querySelectorAll('.selectize');
    els.forEach(function (select) {
        NiceSelect.bind(select);
    });

    let options = {searchable: true};
    NiceSelect.bind(document.getElementById('color-select'), options);
    NiceSelect.bind(document.getElementById('guaranty-select'), options);
</script>
@endscript
