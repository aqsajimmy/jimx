<nav class="navbar navbar-expand-lg navbar-dark sticky-top">
    <div class="container-fluid">
        <a class="navbar-brand ld ld-float-ltr-in" href="{{ route('portal.home') }}">JIMX <span class="ld ld-blur">⚡</span></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link @if (request()->routeIs('portal.home')) active @endif" aria-current="page"
                        href="{{ route('portal.home') }}" wire:navigate>Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" wire:current="active" aria-current="page" href="{{ route('portal.about') }}"
                        wire:navigate>About</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" wire:current="active" aria-current="page" href="{{ route('portal.blogs') }}"
                        wire:navigate>Blogs</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" wire:current="active" aria-current="page"
                        href="{{ route('portal.website-templates') }}" wire:navigate>Web Templates</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" wire:current="active" aria-current="page" href="{{ route('portal.contact') }}"
                        wire:navigate>Contact</a>
                </li>
            </ul>
            <div>
                <a href="{{ route('login') }}" wire:navigate class="btn btn-outline-discovery rounded-4 ld ld-float-rtl-in">Login</a>
            </div>
        </div>
    </div>
</nav>
