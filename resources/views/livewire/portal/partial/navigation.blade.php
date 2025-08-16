<nav x-data="{ scrolled: false }" x-init="window.addEventListener('scroll', () => scrolled = window.scrollY > 10)" :class="{ 'navbar-blur': scrolled }" id="mainNavbar"
    class="navbar navbar-expand-lg navbar-dark sticky-top transition">

    <div class="container-fluid">
        <!-- Brand -->
        <a class="navbar-brand fw-bold animate__animated animate__fadeIn" href="{{ route('portal.home') }}">
            JIMX <span class="ld ld-blur">⚡</span>
        </a>

        <!-- Toggler -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Nav Content -->
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                @php
                    $navLinks = [
                        ['label' => 'Home', 'route' => 'portal.home'],
                        ['label' => 'About', 'route' => 'portal.about'],
                        ['label' => 'Blogs', 'route' => 'portal.blogs'],
                        ['label' => 'Web Templates', 'route' => 'portal.website-templates'],
                        ['label' => 'Contact', 'route' => 'portal.contact'],
                    ];
                @endphp

                @foreach ($navLinks as $link)
                    <li class="nav-item">
                        <a class="nav-link @if (request()->routeIs($link['route'])) active text-decoration-underline underline-offset-4 @endif"
                            href="{{ route($link['route']) }}" wire:navigate>
                            {{ $link['label'] }}
                        </a>
                    </li>
                @endforeach
            </ul>

            <!-- Login Button -->
            <div>
                <a href="{{ route('login') }}" wire:navigate
                    class="btn btn-outline-discovery rounded-4 ld ld-float-rtl-in">
                    Login
                </a>
            </div>
        </div>
    </div>
</nav>
