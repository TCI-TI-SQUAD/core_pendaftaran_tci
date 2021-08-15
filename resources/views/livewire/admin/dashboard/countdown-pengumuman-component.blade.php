@push('css')
    <link rel="stylesheet" href="{{ asset('plugins\swiper\swiper-bundle.min.css') }}">
    <link href="{{ asset('asset\vendor\flipdown-master\dist\flipdown.min.css') }}" rel="stylesheet">
@endpush

<div class="col-12 col-xl-8">
    <div class="swiper-container mySwiper pb-4 h-100">
        <div class="swiper-wrapper">
            @if(isset($pendaftarans))
                @if(count($pendaftarans) > 0)
                    @foreach($pendaftarans as $index => $pendaftaran)
                        <div class="swiper-slide d-flex justify-content-center align-items-center">
                                <div class="m-3">
                                    <h5 class="text-center m-3"><b>{{ $pendaftaran['nama_pendaftaran'] }}</b></h5>
                                    <div id="flipdown{{ $index }}" class="flipdown"></div>
                                </div>
                        </div>
                    @endforeach
                @else
                    <div class="swiper-slide d-flex justify-content-center align-items-center">
                            <div class="m-3">
                                <h5 class="text-center m-3"><b>Belum Ada Pendaftaran</b></h5>
                            </div>
                    </div>
                @endif
            @else
                <div class="swiper-slide d-flex justify-content-center align-items-center">
                        <div class="m-3">
                            <h5 class="text-center m-3"><b>Belum Ada Pendaftaran</b></h5>
                        </div>
                </div>
            @endif
        </div>
    </div>
</div>

@push('js')
    <script src="{{ asset('plugins\swiper\swiper-bundle.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('asset\vendor\flipdown-master\dist\flipdown.min.js') }}"></script>
    <script>
        @if(isset($pendaftarans))
            @if(count($pendaftarans) > 0)
                @foreach($pendaftarans as $index => $pendaftaran)
                let flipdown{{ $index }} = new FlipDown({{ date_timestamp_get(date_create($pendaftaran['tanggal_selesai_pendaftaran'])) }},'flipdown{{ $index }}');
                    flipdown{{ $index }}.start();

                    var swiper = new Swiper(".mySwiper", {
                        spaceBetween: 30,
                        centeredSlides: true,
                        autoplay: {
                        delay: 3000,
                        disableOnInteraction: false,
                        },
                        pagination: {
                        el: ".swiper-pagination",
                        clickable: true,
                        },
                    });
                @endforeach
            @endif
        @endif
    </script>
@endpush