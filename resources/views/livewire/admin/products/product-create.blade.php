<div class="panel min-h-screen">

  {{--    message--}}
  <x-admin.message/>

  {{--  loading liveire component page--}}
  <x-admin.loading/>

  <div class="mb-5">
    <h1 class="my-4 font-bold text-lg">ایجاد محصول</h1>

  </div>

  <form class="space-y-10">
    <div class="space-y-10">

      <div x-data="{ preview: '' }" class="w-full flex justify-center items-center">
        <label for="ctnFile" class="relative cursor-pointer w-[300px] h-[250px]" aria-label="انتخاب تصویر">
          <div x-show="!preview" class="absolute inset-0 flex items-center justify-center">
            <x-icons.image size="30" class="text-gray-400"/>
          </div>
          <img :src="preview" width="300" height="250"
            class="border w-full h-full border-gray-300 rounded-md bg-contain"
            loading="lazy" decoding="async">
          <input id="ctnFile" type="file" wire:model="primary_image"
            @change="preview = URL.createObjectURL($event.target.files[0])"
            class="sr-only">
          @error('primary_image') <p class="text-danger mt-1">{{ $message }}</p> @enderror
        </label>
      </div>

      <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 py-4">
        <div>
          <label for="name">نام محصول</label>
          <input wire:model="name" id="name" type="text" class="form-input">
          @error('name') <p class="text-danger mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
          <label for="e_name">product e_name</label>
          <input wire:model="e_name" id="e_name" type="text" class="form-input">
          @error('e_name') <p class="text-danger mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
          <label for="prise">قیمت</label>
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

        <div wire:ignore>
          <label for="max_sell">دسته‌بندی</label>
          <select wire:model="category_id" id="brand-select">
            <option disabled selected hidden>انتخاب کنید</option>
            @foreach($categories as $key=>$value)
              <option value="{{ $key }}">{{ $value }}</option>
            @endforeach
          </select>
        </div>


        <div wire:ignore>
          <label for="max_sell">برند</label>
          <select wire:model="brand_id" id="category-select">
            <option disabled selected hidden>انتخاب کنید</option>
            @foreach($brands as $key=>$value)
              <option value="{{$key}}">{{$value}}</option>
            @endforeach
          </select>
        </div>

        <div>
          <label for="status">وضعیت</label>
          <select wire:model="status" id="status" class="form-select text-white-dark">
            @foreach($products_status as $status)
              <option value="{{ $status->value }}">{{ __("enums.$status->value") }}</option>
            @endforeach
          </select>
          @error('status') <p class="text-danger mt-1">{{ $message }}</p> @enderror
        </div>
      </div>
      <div wire:ignore>
        <label for="description">توضیحات محصول</label>
        <textarea wire:model="description" id="editor" type="text"
          class="form-input resize-none border border-gray-300 h-40"></textarea>
        @error('description') <p class="text-danger mt-1">{{ $message }}</p> @enderror
      </div>

      <div>
        <button wire:click.prevent="createRow" class="btn btn-success !mt-6">تایید</button>
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
    NiceSelect.bind(document.getElementById('brand-select'), options);
    NiceSelect.bind(document.getElementById('category-select'), options);

    ClassicEditor
        .create(document.querySelector('#editor'), {
            toolbar: {
                items: [
                    'heading', '|',
                    'bold', 'italic', 'link', '|',
                    'fontSize', 'fontColor', '|',
                    'blockQuote', 'insertTable',
                    'undo', 'redo', 'codeBlock'
                ]
            },
            language: {
                ui: 'fa',
                content: 'fa'
            },
            table: {
                contentToolbar: ['tableColumn', 'tableRow', 'mergeTableCells']
            }
        })
        .then(editor => {
            // setting the internal value
            const initialDescription = @js($this->description);
            if (initialDescription) {
                editor.setData(initialDescription);
            }

            //Listening to changes
            editor.model.document.on('change:data', () => {
              @this.
                set('description', editor.getData(), false)
            })

            console.log('Editor loaded!');
        })
        .catch(error => {
            console.error(error);
        });
</script>
@endscript
