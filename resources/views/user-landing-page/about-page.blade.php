@extends('layout.main-layout.main-layout')

@push('css')
<link href="{{ asset('asset\css\layout-css\layout-css.css') }}" rel="stylesheet">
<link href="{{ asset('asset\css\lading-page\about-page.css') }}" rel="stylesheet">
@endpush

@section('navigation-small')
    @include('user-landing-page.user-landing-page-nav.user-landing-page-nav-small',['about' => 'active'])
@endsection

@section('navigation-wide')
    @include('user-landing-page.user-landing-page-nav.user-landing-page-nav-wide',['about' => 'active'])
@endsection

@push('css')
<link href="{{ asset('asset\vendor\flipdown-master\dist\flipdown.min.css') }}" rel="stylesheet">
@endpush

@section('content')
<div class="container-fluid container-about">
    <div class="row about-row mt-5">
        <div class="col-12 d-xl-none">
            <h3 class="my-3 text-center">
            Tourism Confucius Institute Udayana University
            </h3>
        </div>
        <div class="col-xl-5 about-img px-4">
            <img src="{{ asset('asset\image\landing-page\about-page.jpeg') }}" alt="about-page.jpeg" class="z-depth-1 img-fluid"> 
        </div>

        <div class="col-xl-7 about-text px-4">
            <h3 class="about-heading d-none d-xl-block">
            Tourism Confucius Institute Udayana University
            </h3>
            <p>
            Bali is one of the preferred destinations of Chinese tourists. The number of direct Chinese tourist arrivals in Bali has significant increases from 129,121 tourists in 2008 to 310,904 tourists in 2012. On average, the growth of direct Chinese tourist arrival in Bali during period 2008-2015 was 35.2 % per year. In 2008, Chinese tourists were ranked as the fifth highest. But in 2012, they were second highest after Australian tourists. This position still remained until 2016, but since 2017 the Chinese tourists have become the 1st rank. Chinese tourists have now become the emerging tourist market in Bali and efforts need to be made to increase the numbers. As one of the world's main tourist destinations, Bali is known for having a unique cultural heritage, beautiful scenery, natural resources a friendly population, and a philosophy in preserving its culture, protecting the environment and maintaining a harmonious community relationship. Accordingly, Bali is known as one of the most popular tourist destinations in the world due to its cultural activities and natural scenery.Tourism has now become a driving force and leadin economic development of Bali Province with the primary economic focus shifing from agriculture to service provision.

            Owing to the fact that Bali as the most preferred tourist destination region, the local people in Bali are interested in developing their capabilities in Mandarin language which becomes intrinsic motivation to learn Chinese culture. They realize that it would be of great advantage in the global human resources supposing they could speak Chinese language. Accordingly, the local people in Bali have a strong demand for establishing a Confucius Institute at UNUD. They know that the program would undoubtedly give motivation to enhance their capabilities in Mandarin language and culture which support them to get a good job and position in tourism sector in Bali. Because of the growing demand of students and tourism stake-holders in Bali for Mandarin language ulture learing, Nanchang University and Un came to a partnership agreement by signing MoU by two parties on December 12nd 2017. This agreement was followed up by assigning LoI between the Dean of Tour- ism Faculty UNUD and the Dean of Tourism Faculty Nanchang University (NU) on April 18th 2018.
            </p>
        </div>

    </div>
</div>

@endsection

@push('js')
<script type="text/javascript" src="{{ asset('asset\vendor\flipdown-master\dist\flipdown.min.js') }}"></script>

<script>
    $(document).ready(function(){

        $('#navigation-button').click(function(){
            $('#navigation-block').toggleClass('active');
        })

        $('#navigation-button-close').click(function(){
            $('#navigation-block').toggleClass('active');
        })
        let flipdown = new FlipDown(1626111730,'flipdown');
            flipdown.start();
        let flipdown2 = new FlipDown(1626111730,'flipdown2');
            flipdown2.start();
        let flipdown3 = new FlipDown(1626111730,'flipdown3');
            flipdown3.start();
    });
</script>

    
@endpush