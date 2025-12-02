@php
  if (! isset($scrollTo)) {
      $scrollTo = 'body';
  }

  $scrollIntoViewJsSnippet = ($scrollTo !== false)
      ? <<<JS
          (\$el.closest('{$scrollTo}') || document.querySelector('{$scrollTo}')).scrollIntoView()
      JS
      : '';
@endphp

<div>
  @if ($paginator->hasPages())
    <nav role="navigation" aria-label="Pagination Navigation" class="flex justify-center">
      <ul class="inline-flex items-center justify-center space-x-1 rtl:space-x-reverse">
        {{-- Previous Page Link --}}
        <li>
          @if ($paginator->onFirstPage())
            <span
              class="flex justify-center rounded border-2 border-[#e0e6ed] px-3.5 py-2 font-semibold text-gray-400 cursor-not-allowed dark:border-[#191e3a] dark:text-gray-600">
                            {!! __('pagination.previous') !!}
                        </span>
          @else
            <button type="button" wire:click.prevent="previousPage('{{ $paginator->getPageName() }}')"
              x-on:click="{{ $scrollIntoViewJsSnippet }}" wire:loading.attr="disabled"
              class="flex justify-center rounded border-2 border-[#e0e6ed] px-3.5 py-2 font-semibold text-dark transition hover:border-primary hover:text-primary dark:border-[#191e3a] dark:text-white-light dark:hover:border-primary">
              {!! __('pagination.previous') !!}
            </button>
          @endif
        </li>

        {{-- Pagination Elements --}}
        @foreach ($elements as $element)
          {{-- "Three Dots" Separator --}}
          @if (is_string($element))
            <li>
              <span
                class="flex justify-center rounded border-2 border-[#e0e6ed] px-3.5 py-2 font-semibold text-dark dark:border-[#191e3a] dark:text-white-light">{{ $element }}</span>
            </li>
          @endif

          {{-- Array Of Links --}}
          @if (is_array($element))
            @foreach ($element as $page => $url)
              <li wire:key="paginator-{{ $paginator->getPageName() }}-page{{ $page }}">
                @if ($page == $paginator->currentPage())
                  <span aria-current="page"
                    class="flex justify-center rounded border-2 border-primary px-3.5 py-2 font-semibold text-primary transition dark:border-primary dark:text-white-light">
                                        {{ $page }}
                                    </span>
                @else
                  <button type="button" wire:click.prevent="gotoPage({{ $page }}, '{{ $paginator->getPageName() }}')"
                    x-on:click="{{ $scrollIntoViewJsSnippet }}"
                    class="flex justify-center rounded border-2 border-[#e0e6ed] px-3.5 py-2 font-semibold text-dark transition hover:border-primary hover:text-primary dark:border-[#191e3a] dark:text-white-light dark:hover:border-primary"
                    aria-label="{{ __('Go to page :page', ['page' => $page]) }}">
                    {{ $page }}
                  </button>
                @endif
              </li>
            @endforeach
          @endif
        @endforeach

        {{-- Next Page Link --}}
        <li>
          @if ($paginator->hasMorePages())
            <button type="button" wire:click.prevent="nextPage('{{ $paginator->getPageName() }}')"
              x-on:click="{{ $scrollIntoViewJsSnippet }}" wire:loading.attr="disabled"
              class="flex justify-center rounded border-2 border-[#e0e6ed] px-3.5 py-2 font-semibold text-dark transition hover:border-primary hover:text-primary dark:border-[#191e3a] dark:text-white-light dark:hover:border-primary">
              {!! __('pagination.next') !!}
            </button>
          @else
            <span
              class="flex justify-center rounded border-2 border-[#e0e6ed] px-3.5 py-2 font-semibold text-gray-400 cursor-not-allowed dark:border-[#191e3a] dark:text-gray-600">
                            {!! __('pagination.next') !!}
                        </span>
          @endif
        </li>
      </ul>
    </nav>
  @endif
</div>
