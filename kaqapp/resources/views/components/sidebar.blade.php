<nav class="p-4">
    @php
      $hasCategories = isset($categories) && $categories && $categories->count();
      $hasAnyTypes = $hasCategories && $categories->flatMap(fn ($c) => $c->qrCodeTypes ?? collect())->count();
    @endphp

    @if($hasCategories && $hasAnyTypes)
      @foreach($categories as $category)
        @php $types = $category->qrCodeTypes ?? collect(); @endphp
        @if($types->count())
            <div class="mb-6">

                <div class="cursor-pointer sidebar-toggle mb-1 flex justify-between items-center text-black hover:text-brand ">
                    <h5 class="text-sm uppercase tracking-wide">
                        {{ $category->name }}
                    </h5>
                    <i class="bi bi-plus-lg text-xs"></i>
                </div>

                <div class="flex flex-col gap-1 hidden sidebar-content">
                    @foreach($types as $type)
                    <a href="#" data-id="{{ $type->id }}"
                        class="px-3 py-2 rounded-md text-xs text-black hover:text-brand hover:underline">
                        {{ $type->name }}
                    </a>
                    @endforeach
                </div>

            </div>
        @endif
        @endforeach
    @else
      <h5 class="mb-2">QR Types</h5>
      <p class="text-gray-500">No categories / types yet. Add some QR code types to start.</p>
    @endif
</nav>