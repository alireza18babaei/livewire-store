@if(session()->has('success'))
  <div
    x-data="{ show: true }"
    x-show="show"
    x-init="$el.focus(); setTimeout(() => show = false, 2000)"
    tabindex="-1"
    x-transition
    class="flex items-center rounded bg-success-light p-3.5 text-success dark:bg-success-dark-light"
  >
    <span class="ltr:pr-2 rtl:pl-2">
        <strong class="ltr:mr-1 rtl:ml-1"></strong>{{ session('success') }}
    </span>
    <button
      @click="show = false"
      type="button"
      class="hover:opacity-80 ltr:ml-auto rtl:mr-auto"
    >
      <x-icons.close2/>
    </button>
  </div>
@endif

@if(session()->has('error'))
  <div
    x-data="{ show: true }"
    x-show="show"
    x-init="$el.focus(); setTimeout(() => show = false, 2000)"
    tabindex="-1"
    x-transition
    class="flex items-center rounded bg-danger p-3.5 text-red-900 dark:bg-success-dark-light"
  >
    <span class="ltr:pr-2 rtl:pl-2">
        <strong class="ltr:mr-1 rtl:ml-1"></strong>{{ session('error') }}
    </span>
    <button
      @click="show = false"
      type="button"
      class="hover:opacity-80 ltr:ml-auto rtl:mr-auto"
    >
      <x-icons.close2/>
    </button>
  </div>
@endif
