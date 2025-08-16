<div>
    {{-- Knowing others is intelligence; knowing yourself is true wisdom. --}}
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
        <div class="col-12 text-start">
            <span class="inquiry-text">
                for inquiry
                <em class="text-discovery animate__animated animate__fadeIn">
                    <strong>whang_zhu[at]yahoo.com</strong>
                </em>
            </span>
        </div>
    </div>
    <style>
        .inquiry-text {
            font-size: clamp(1.5rem, 5vw, 6rem);
            /* min 1.5rem, naik sesuai lebar layar, max 6rem */
            word-break: break-word;
            /* biar email ga kepanjangan */
        }
    </style>

</div>
