@extends('layout.auth.user-login-template')

@section('form')
<img src="{{ asset('asset\image\user-login\temple.png') }}" alt="">
            <div class="form-container animated fadeInUp">
                <form action="{{ Route('user.post.login') }}" method="POST" onsubmit="myButton.disabled = true; return true;">
                {{ csrf_field() }}
                {{ method_field('post') }}
                <h4 class="font-weight-bold text-center mt-5">
                    @if(isset($jam))
                        @if($jam >= 0 && $jam < 10)
                            Selamat Pagi !
                        @elseif($jam >= 10 && $jam < 15)
                            Selamat Siang !
                        @elseif($jam >= 15 && $jam < 18)
                            Selamat Sore !
                        @elseif($jam >= 18 && $jam < 24)
                            Selamat Malam !
                        @else
                            Selamat Datang
                        @endif
                    @endif
                </h4>

                <label for="exampleForm2" class="mt-5">Email</label>
                <input name="email" type="text" id="exampleForm2" class="form-control mt-1 @if($errors->has('email')){{ 'border border-danger' }}@endif" minlength="5" maxlength="50">
                @if($errors->has('email'))<small class="text-danger">{{ $errors->first('email') }}</small>@endif

                <label class="mt-3" for="exampleForm2">Password</label>
                <input name="password" type="text" id="exampleForm2" class="form-control mt-1 @if($errors->has('email')){{ 'border border-danger' }}@endif" minlength="5" maxlength="100">
                @if($errors->has('password'))<small class="text-danger">{{ $errors->first('password') }}</small>@endif

                <div class="row mt-3">
                    <div class="col m-2">
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="defaultUnchecked" value="1" name="remember_me">
                            <label class="custom-control-label" for="defaultUnchecked">Remember me</label>
                        </div>
                    </div>
                    <div class="col m-2">
                        <a href="">
                            <p class="w-100 text-right"><u>Lupa Password ?</u></p>
                        </a>
                    </div>
                </div>

                <button name="myButton" class="btn btn-block btn-success mt-5" type="submit">LOGIN</button>
                <a class="btn btn-block btn-danger mt-1" href="{{ route('user.landing-page') }}">BACK</a>

                <p class="text-center mt-4">Dont have an account ? <a href="{{ route('user.register') }}">Register Here</a></p>
                <p class="text-center mt-1">Visit us on</p>

                <div class="d-flex justify-content-center mb-4">
                    @if(isset($social_medias))
                        @foreach($social_medias as $social_media)
                            <a  data-toggle="tooltip" title="{{ $social_media->keterangan }}" href="{{ $social_media->link }}" class="m-1"><img style="height:30px;width:30px;position:relative;" src="{{ url('asset\image\social-media',[$social_media->social_media_image]) }}" alt="social_media_image"></a>
                        @endforeach
                    @endif
                </div>

                </form>
            </div>
@endsection

@push('bottom_source')
<script>
    // SWEETALERT2
    
    @if(Session::has('status'))
        Swal.fire({
            icon:  @if(Session::has('icon')){!! '"'.Session::get('icon').'"' !!} @else 'question' @endif,
            title: @if(Session::has('title')){!! '"'.Session::get('title').'"' !!} @else 'Oppss...'@endif,
            text: @if(Session::has('message')){!! '"'.Session::get('message').'"' !!} @else 'Oppss...'@endif,
        });
    @endif
</script>
@endpush