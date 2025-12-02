// resources/views/components/breadcrumb.blade.php
<nav aria-label="breadcrumb">
  <ol class="flex space-x-2 rtl:space-x-reverse mb-4">
    @foreach($items as $item)
      <li class="before:content-['/'] ltr:before:mr-1 rtl:before:ml-1">
        @if(isset($item['link']))
          <a href="{{ route($item['link']) }}">{{ $item['label'] }}</a>
        @else
          {{ $item['label'] }}
        @endif
      </li>
    @endforeach
  </ol>
</nav>
