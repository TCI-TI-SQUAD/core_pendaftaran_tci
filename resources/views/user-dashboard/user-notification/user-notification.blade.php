@extends('layout.main-layout.main-layout')

@push('css')
<link rel="stylesheet" href="{{ asset('plugins\swiper\swiper-bundle.min.css') }}">
<link href="{{ asset('asset\vendor\flipdown-master\dist\flipdown.min.css') }}" rel="stylesheet">
<link href="{{ asset('asset\css\layout-css\user-dashboard-layout.css') }}" rel="stylesheet">
@endpush

@section('navigation-wide')
    @include('user-dashboard.user-nav.top-nav-wide',['notification' => 'active'])
@endsection

@section('navigation-small')
    @include('user-dashboard.user-nav.top-nav-small',['notification' => 'active'])
@endsection

@section('content')
    <!-- CONTAINER -->
    <div class="container h-100 p-3">
        <div class="row">
            <div class="col-12">
                <h5 class="font-weight-bold text-center text-lg-left">USER NOTIFICATIONS</h5>
            </div>
            <div class="col-12 text-center text-lg-left">
                <a href="{{ route('user.notification.index',['unread']) }}" class="btn btn-info btn-sm @if(isset($filter)) @if($filter == 'unread') active @endif @endif">UNREAD</a>
                <a href="{{ route('user.notification.index',['read']) }}" class="btn btn-info btn-sm  @if(isset($filter)) @if($filter == 'read') active @endif @endif">READ</a>
                <a href="" class="btn btn-secondary btn-sm">MARK AS READ ALL</a>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-12 p-2 animated slideInUp" style="min-height:500px;">
            @if(isset($user_notifications))
                @if($user_notifications->count() > 0)
                    @foreach($user_notifications as $index => $user_notification)
                        @php $full_data = $user_notification->getFullDataAttribute() @endphp
                        <div class="@if(isset($full_data->color)) {!! $full_data->color !!} @endif rounded z-depth-1 my-3">
                            <div class="toast-header">
                                <p class="h1 m-2">@if(isset($full_data->icon)) {!! $full_data->icon !!} @endif</p>
                                <strong class="mr-auto ml-3 font-weight-bold">@if(isset($full_data->title)) {{ strtoupper($full_data->title) }} @endif</strong>
                                <small>@if(isset($full_data->datetime)) {{ $full_data->datetime }} @endif</small>
                                </button>
                            </div>
                            <div class="toast-body bg-white py-4">
                                @if(isset($full_data->message)) {!! $full_data->message !!} @endif
                            </div>
                            <div class="text-right">
                                <button class="btn btn-md btn-white m-2">MARK AS READ</button>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="h-100 d-flex flex-column align-items-center justify-content-center text-center">
                        <img src="{{ asset('asset\image\main_asset\nodata2.png') }}" alt="" style="width:200px;">
                        <h5 class="mt-5">TIDAK ADA NOTIFIKASI</h5>
                    </div>
                @endif
            @else
                <div class="h-100 d-flex flex-column align-items-center justify-content-center text-center">
                    <img src="{{ asset('asset\image\main_asset\nodata2.png') }}" alt="" style="width:200px;">
                    <h5 class="mt-5">TIDAK ADA NOTIFIKASI</h5>
                </div>
            @endif
            </div>
        </div>
    </div>
    <!-- END CONTAINER -->
@endsection

@push('js')
<script>
    $(document).ready(function(){

        $('#navigation-button').click(function(){
            $('#navigation-block').toggleClass('active');
        })

        $('#navigation-button-close').click(function(){
            $('#navigation-block').toggleClass('active');
        })

    });
</script>
@endpush