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
          <div wire:ignore>
            <label for="max_sell">دسته‌بندی</label>
            <select wire:model="category_id" id="brand-select">
              @foreach($categories as $key=>$value)
                <option {{$this->category_id == $key ? 'selected' : ''}}
                value="{{$key}}">{{$value}}</option>
              @endforeach
            </select>
          </div>
          @error('category_id') <p class="text-danger mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
          <div wire:ignore>
            <label for="max_sell">برند</label>
            <select wire:model="brand_id" id="category-select">
              @foreach($brands as $key=>$value)
                <option {{$this->brand_id == $key ? 'selected' : ''}}
                value="{{$key}}">{{$value}}</option>
              @endforeach
            </select>
          </div>
          @error('brand_id') <p class="text-danger mt-1">{{ $message }}</p> @enderror
        </div>

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
      <div wire:ignore>
        <label for="editor">توضیحات محصول</label>
        <textarea wire:model="description" id="editor" type="text"
          class="form-input resize-none border border-gray-300 h-40"></textarea>
        @error('description') <p class="text-danger mt-1">{{ $message }}</p> @enderror
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
