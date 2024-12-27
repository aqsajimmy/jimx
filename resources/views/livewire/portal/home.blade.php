<div>
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
    <div>
        <div class="d-flex justify-content-between row">
            <div class="d-flex justify-content-center align-items-center col-lg-6">
                <p>
                    Hi, I'm <em class="text-discovery"><strong>Jimmy</strong></em>, a software engineer here to assist with all your
                    digital needs.
                </p>
            </div>
            <div class="col-lg-6">
                <img src="{{ asset('assets/img/jimx.webp') }}" alt="JIMX" class="img-fluid ld ld-float-ttb-in float-end"
                    style="width: 450px; height: 450px;">
            </div>
        </div>
    </div>
</div>
