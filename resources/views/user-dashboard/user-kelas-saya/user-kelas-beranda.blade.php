@extends('layout.main-layout.main-layout')

@push('css')
<link href="{{ asset('asset\css\user\user-kelas-beranda.css') }}" rel="stylesheet">
<link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css"/>
@endpush

@section('navigation-wide')
    @include('user-dashboard.user-nav.top-nav-wide',['kelas_saya' => 'active'])
@endsection

@section('navigation-small')
    @include('user-dashboard.user-nav.top-nav-small',['kelas_saya' => 'active'])
@endsection

@section('content')
    <!-- CONTAINER -->
    <div class="container h-100">

        <div class="row mt-2 order-2">
            <div class="col-12">
                <nav aria-label="breadcrumb">
                    <ul class="breadcrumb bg-white">
                        <li class="breadcrumb-item"><a href="#" class="text-secondary font-weight-bold">Kelas Saya</a></li>
                        <li class="breadcrumb-item">
                            <a href="#" class="text-dark">
                                Nama Kelas
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>

        <div class="row">
            <div class="col-12 col-lg-8 m-0 p-0" style="min-height:500px;">
                <div class="jumbotron p-0 m-2 d-flex flex-column justify-content-center border-secondary" style="border-top:10px solid;">
                    <h4 class="text-center mt-3">PENGAJAR</h4>
                    <div class="text-center mt-3">
                        <img src="{{ asset('storage\image_pengajar\default.jpg') }}" alt="GAMBAR PENGAJAR" class="img-thumbnail rounded z-depth-2" style="width:100px;height:100px;object-fit:cover;">
                    </div>

                    <h5 class="text-center mt-3 font-weight-bold">
                        Mis Kung Lao
                    </h5>

                    <p class="text-center">
                        Kelas HSK 1  
                    </p>

                    <p class="text-center ml-3 mr-3">
                        Lorem ipsum dolor sit amet consectetur adipisicing elit. Cum consequatur, fugit eaque ad maiores minus impedit quasi voluptate magni quis laborum aspernatur optio qui quam temporibus, necessitatibus in eum tenetur, porro aperiam voluptatibus dolor earum. Optio sequi illum quasi harum est commodi laborum iusto corrupti
                    </p>

                    <img src="{{ asset('asset\image\main_asset\kelas-footer.png') }}" alt="FOOTER KELAS" style="position:relative:bottom:0;width:100%;">
                    
                </div>
            </div>

            <div class="col-12 col-lg-4 p-2" style="min-height:400px;">
                <div class="swiper-container mySwiper h-100">
                    <div class="swiper-wrapper bg-danger position-absolute" style="bottom:0;top:0px;left:0;right:0;">
                        <div class="swiper-slide d-flex flex-column">
                            <h5 class="text-center text-lg-left text-white font-weight-bold p-2 m-0" style="background: rgb(89,15,16);background: linear-gradient(90deg, rgba(89,15,16,1) 0%, rgba(207,29,32,1) 100%);">PENGUMUMAN KELAS</h5>
                            <div class="card p-2 bg-danger  overflow-auto">
                            Lorem ipsum dolor sit amet consectadsasdadetur, adipisicing elit. Voluptas ipsum corrupti rerum voluptatibus laborum optio, voluptatum voluptate, distinctio, beatae odio tenetur illum numquam ea vitae aperiam voluptates mollitia totam architecto. Quasi voluptates corrupti maiores consequatur ipsum quae placeat reiciendis error! Totam explicabo perferendis unde, ducimus necessitatibus vel quae nihil laudantium aperiam sapiente quaerat nostrum vitae est facilis magnam suscipit obcaecati facere nulla assumenda! Voluptas quos soluta explicabo assumenda consequuntur, atque voluptatem repellat enim fugit deserunt non beatae. Eligendi ad deleniti alias sit incidunt rerum reprehenderit quasi provident suscipit ratione voluptatibus ullam, commodi quis aspernatur explicabo libero cum soluta ab! Obcaecati beatae autem, expedita cupiditate aliquid error quasi tenetur culpa deserunt, dolor quisquam non ipsam laboriosam quam eligendi? Hic fugit eius animi? Adipisci sapiente qui deleniti consequuntur alias culpa ab repellat nihil ad, ipsa commodi excepturi, et magnam reprehenderit ex, rem totam veniam error animi temporibus fuga soluta! Aperiam enim maxime beatae minima error fuga inventore? Dicta natus voluptas voluptate laborum! Fugit quos unde eaque, sapiente voluptas aut tempore. Porro corrupti eligendi voluptates accusamus magni libero ad facilis aliquam odit unde eos quo, modi, laboriosam dolorum nobis sunt earum impedit explicabo autem perspiciatis. Eius corporis iusto at, delectus consectetur eveniet totam END.
                            </div>
                        </div>
                    </div>
                    <div class="swiper-pagination"></div>
                </div>
        
            </div>
        </div>

        <div class="row p-0 m-0 order-1 mt-5">
            <div class="col-12 p-0">
                <ul class="nav nav-tabs z-depth-1" id="myTab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active font-weight-bold" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home"
                        aria-selected="true">DETAIL KELAS</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link font-weight-bold" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile"
                        aria-selected="false">JADWAL</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link font-weight-bold" id="contact-tab" data-toggle="tab" href="#contact" role="tab" aria-controls="contact"
                        aria-selected="false">LINK KELAS</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link font-weight-bold" id="pembayaran-tab" data-toggle="tab" href="#pembayaran" role="tab" aria-controls="contact"
                        aria-selected="false">PEMBAYARAN</a>
                    </li>
                </ul>
                <div class="tab-content jumbotron p-3 z-depth-1 border-secondary" style="border-left:10px solid;" id="myTabContent">
                    <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                        <div class="container">
                            <div class="row">
                                <div class="col">
                                    a
                                </div>
                                <div class="col">
                                    b
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">Food truck fixie
                        locavore, accusamus mcsweeney's marfa nulla single-origin coffee squid. Exercitation +1 labore velit,
                        blog sartorial PBR leggings next level wes anderson artisan four loko farm-to-table craft beer twee.
                        Qui photo booth letterpress, commodo enim craft beer mlkshk aliquip jean shorts ullamco ad vinyl cillum
                        PBR. Homo nostrud organic, assumenda labore aesthetic magna delectus mollit. Keytar helvetica VHS
                        salvia yr, vero magna velit sapiente labore stumptown. Vegan fanny pack odio cillum wes anderson 8-bit,
                        sustainable jean shorts beard ut DIY ethical culpa terry richardson biodiesel. Art party scenester
                        stumptown, tumblr butcher vero sint qui sapiente accusamus tattooed echo park.</div>
                    <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">Etsy mixtape
                        wayfarers, ethical wes anderson tofu before they sold out mcsweeney's organic lomo retro fanny pack
                        lo-fi farm-to-table readymade. Messenger bag gentrify pitchfork tattooed craft beer, iphone skateboard
                        locavore carles etsy salvia banksy hoodie helvetica. DIY synth PBR banksy irony. Leggings gentrify
                        squid 8-bit cred pitchfork. Williamsburg banh mi whatever gluten-free, carles pitchfork biodiesel fixie
                        etsy retro mlkshk vice blog. Scenester cred you probably haven't heard of them, vinyl craft beer blog
                        stumptown. Pitchfork sustainable tofu synth chambray yr.</div>
                    <div class="tab-pane fade" id="pembayaran" role="tabpanel" aria-labelledby="pembayaran-tab">PEMBAYARAN Etsy mixtape
                        wayfarers, ethical wes anderson tofu before they sold out mcsweeney's organic lomo retro fanny pack
                        lo-fi farm-to-table readymade. Messenger bag gentrify pitchfork tattooed craft beer, iphone skateboard
                        locavore carles etsy salvia banksy hoodie helvetica. DIY synth PBR banksy irony. Leggings gentrify
                        squid 8-bit cred pitchfork. Williamsburg banh mi whatever gluten-free, carles pitchfork biodiesel fixie
                        etsy retro mlkshk vice blog. Scenester cred you probably haven't heard of them, vinyl craft beer blog
                        stumptown. Pitchfork sustainable tofu synth chambray yr.</div>
                </div>
            </div>
        </div>
    </div>
    <!-- END COINTAINER -->
@endsection

@push('js')
<script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
<script>
        $(document).ready(function(){

            $('#navigation-button').click(function(){
                $('#navigation-block').toggleClass('active');
            })

            $('#navigation-button-close').click(function(){
                $('#navigation-block').toggleClass('active');
            })

            $(function () {
                $('[data-toggle="tooltip"]').tooltip()
            })
        });

        var swiper = new Swiper(".mySwiper", {
            slidesPerView: 1,
            spaceBetween: 10,
            freeMode: false,
            pagination: {
            el: ".swiper-pagination",
            clickable: true,
            },
        });
</script>
<script>
        // SWEETALERT2
        @if(Session::has('status'))
                Swal.fire({
                    icon:  @if(Session::has('icon')){!! '"'.Session::get('icon').'"' !!} @else 'question' @endif,
                    title: @if(Session::has('title')){!! '"'.Session::get('title').'"' !!} @else 'Oppss...'@endif,
                    text: @if(Session::has('message')){!! '"'.Session::get('message').'"' !!} @else 'Oppss...'@endif,
                });
            @endif
        // END
</script>
@endpush