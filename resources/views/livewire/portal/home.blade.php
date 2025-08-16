<div class="commonPages">
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
    <div class="container py-5">
        <div class="row align-items-center">
            <!-- Text Section -->
            <div class="col-lg-6 col-12 text-center text-lg-start mb-4 mb-lg-0">
                <h1 class="display-3 fw-bold text-light animate__animated animate__fadeIn">
                    Hi, I'm <em class="text-discovery"><strong>Jimmy</strong></em><br>
                    <small class="fw-normal d-block mt-3">Bringing clarity to your problems with effective software
                        solutions.</small>
                </h1>
            </div>

            <!-- Image Section -->
            <div class="col-lg-6 col-md-12 col-sm-12 text-center text-lg-end">
                <img src="{{ asset('assets/img/jimx.webp') }}" alt="JIMX"
                    class="img-fluid animate__animated animate__fadeIn"
                    style="max-width: 100%; height: auto; max-height: 450px;">
            </div>
        </div>
    </div>

</div>
