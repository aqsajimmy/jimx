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

    <div class="row">
        @forelse ($collection as $item)
            <div class="col-12 col-md-4 mb-8">
                <div class="card">
                    <div class="card-header d-flex align-items-center">
                        <span class="avatar text-bg-discovery avatar-lg fs-5">
                            <img src="{{ asset('assets/img/jimx.webp') }}" alt="" class="img-fluid">
                        </span>
                        <div class="ms-3">
                            <h6 class="mb-0 fs-sm">{{ $item->user->name }}</h6>
                            <span class="text-muted fs-sm">{{ $item->created_at->format('Y-m-d H:i') }}</span>
                        </div>
                    </div>
                    <img src="{{ $item->image }}" class="card-img-top ld ld-zoom-in" alt="Card image" />
                    <div class="card-body">
                        <p class="card-text">
                            {{-- for excerpt --}}
                            {{ \Illuminate\Support\Str::words($item->content, 10, '...') }}
                        </p>
                    </div>
                    <div class="card-footer d-flex">
                        <a class="btn btn-link p-0 me-auto fw-bold" href="{{ route('portal.article', $item->slug) }}"
                            wire:navigate><i class="fa-duotone fa-solid fa-download"></i> Download</a>
                        <button class="btn btn-subtle" type="button">
                            <i class="fas fa-heart fa-lg"></i>
                        </button>
                        <button class="btn btn-subtle" type="button">
                            <i class="fas fa-share fa-lg"></i>
                        </button>
                    </div>
                </div>
            </div>
        @empty
            <p>No items available.</p>
        @endforelse
    </div>

</div>
