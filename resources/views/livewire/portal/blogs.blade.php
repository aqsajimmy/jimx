<div>
    {{-- A good traveler has no fixed plans and is not intent upon arriving. --}}
    <x-slot name="pageTitle">
        <div>
            <div class="d-flex justify-content-between">
                <div></div>
                <div>
                    <h1 class="h3 mb-4 text-gray-800">{{ $title }}</h1>
                </div>
            </div>
        </div>
    </x-slot>

    <div class="container-fluid">
        <div class="row" wire:init="loadBlogs">

            <div wire:loading class="col-12 text-center">
                {{-- make placeholder here  --}}
                <div class="spinner-border text-light" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
            </div>
            @foreach ($articles as $index => $collection)
                <div class="col-lg-4 col-md-6 mb-4 animate__animated animate__fadeIn"
                    style="--animate-delay: {{ $index * 0.2 }}s" wire:loading.remove
                    wire:key="collection-{{ $collection->id }}">
                    <div x-data="{ show: false }" x-init="setTimeout(() => show = true, {{ $index * 200 }})" x-show="show" x-transition.duration.500ms
                        class="card h-100">
                        <div class="card-header d-flex align-items-center">
                            <div class="avatar text-bg-discovery avatar-lg fs-5">
                                <img src="{{ asset('assets/img/jimx.webp') }}" alt="" class="img-fluid">
                            </div>
                            <div class="ms-3">
                                <h6 class="mb-0 fs-sm">{{ $collection->author->name }}</h6>
                                <span class="text-muted fs-sm">{{ $collection->created_at->format('Y-m-d H:i') }}</span>
                            </div>
                        </div>
                        <img src="{{ $collection->image }}" class="card-img-top ld ld-zoom-in"
                            alt="{{ $collection->title }}" />
                        <div class="card-body">
                            <p class="card-text text-truncate">
                                {{ $collection->title }}
                            </p>
                        </div>
                        <div class="card-footer d-flex">
                            <a class="btn btn-link p-0 fw-bold" href="{{ route('portal.article', $collection->slug) }}"
                                wire:navigate>Read more</a>
                        </div>
                    </div>
                </div>
            @endforeach
            @if ($readyToLoad)
                {{ $articles->links() }}
            @else
                <div wire:loading class="col-12 text-center">
                    {{-- make placeholder here  --}}
                    <div class="spinner-border text-light" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>
            @endif
        </div>
    </div>

</div>
