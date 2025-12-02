@props([
    'label',
    'items' => [],
    'wireModel',
    'placeholder' => '',
    'selected' => '',
])

<div
  x-data="{
    open: false,
    search: '',
      selected: @entangle($wireModel).defer || '{{ $selected }}',
    items: @js(collect($items)->map(fn($v,$k)=>['value'=>$k,'label'=>$v])->values()),

    normalize(txt) {
      if (!txt) return '';
      const persianNumbers = ['۰','۱','۲','۳','۴','۵','۶','۷','۸','۹'];
      const englishNumbers = ['0','1','2','3','4','5','6','7','8','9'];

      return txt
          .toString()
          .toLowerCase()
          .replace(/ي/g,'ی')
          .replace(/ك/g,'ک')
          .replace(/\s+/g,'')
          .split('')
          .map(c => {
              const idx = persianNumbers.indexOf(c);
              return idx > -1 ? englishNumbers[idx] : c;
          })
          .join('');
    },

    get filtered() {
        let s = this.normalize(this.search);
        return this.items.filter(i => this.normalize(i.label).includes(s));
    }
  }"
  class="relative w-full"
>
  <label class="block mb-1">{{ $label }}</label>

  <button
    @click="open = !open"
    class="w-full border rounded px-3 py-2 text-right bg-white text-black h-10 flex items-center justify-between"
    type="button"
  >
    <span x-text="
        selected
            ? items.find(i => i.value == selected)?.label
            : '{{$placeholder}}'
    "></span>
    <!-- SVG در سمت چپ آخر -->
    <svg width="16" height="16" class="rotate-90" viewBox="0 0 24 24" fill="none"
      xmlns="http://www.w3.org/2000/svg">
      <path d="M9 5L15 12L9 19" stroke="currentColor" stroke-width="1.5"
        stroke-linecap="round" stroke-linejoin="round"/>
    </svg>
  </button>

  <div
    x-show="open"
    @click.away="open = false"
    x-transition
    class="absolute z-50 mt-1 w-full bg-white border rounded shadow text-black"
  >
    <div class="relative">
      <input
        type="text"
        x-model="search"
        placeholder="جستجو…"
        class="fa2en w-full border-b px-10 py-2 border border-gray-300 rounded focus:outline-none"
      >
    </div>

    <ul class="max-h-56 overflow-y-auto scrollbar-none">
      <template x-for="item in filtered" :key="item.value">
        <li
        @click="
          selected = item.value;
          $wire.set('{{ $wireModel }}', item.value);
          open = false;
          search = '';
      "

          class="px-3 py-2 hover:bg-gray-100 cursor-pointer"
          x-text="item.label"
        ></li>
      </template>
    </ul>
  </div>

  @error($wireModel)
  <p class="text-red-600 mt-1">{{ $message }}</p>
  @enderror
</div>
