
{{--  you can write: wire:loading.delay.class.remove="hidden" or wire:loading.class.delay.300ms.remove="hidden" and... --}}
{{--If you have a file input, don't delay it because it will cause infinite loading--}}
{{--You can have two loading files so that you can have delay--}}
<div class="fixed inset-0 z-[999] overflow-y-auto pointer-events-none bg-black/5 hidden"
  wire:loading.class.remove="hidden">
  <div class="w-full h-full flex items-center justify-center text-blue-600">
    <x-icons.loading1/>
  </div>
</div>

