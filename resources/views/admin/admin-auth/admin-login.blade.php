
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">

    <title>Admin TCI UDAYANA</title>

    <!-- Bootstrap core CSS -->
    <link href="{{ asset('asset\vendor\mdbootstrap\css\bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('asset\vendor\mdbootstrap\css\main.css') }}" rel="stylesheet">
    <link href="{{ asset('css\app.css') }}" rel="stylesheet">

  </head>

  <body style="width:100vw;height:100vh;">
    <div class="container h-100">
        <div class="row justify-content-center align-items-center h-100">
            <div class="col-12 col-lg-4 text-center">
                <form class="form-signin" method="POST" action="{{ Route('admin.auth.login.post') }}" onsubmit="myButton.disabled = true; return true;">
                    @csrf
                    @method('POST')
                    <img class="mb-4" src="{{ asset('asset\image\main_asset\logo.png') }}" alt="" style="width:200px;">
                    <h1 class="h4 mb-3 font-weight-bold my-4">WELCOME WAH KOMO TCI</h1>
                    <label for="inputEmail" class="sr-only">Email address</label>
                    <input name="email" type="email" id="inputEmail" class="form-control my-2" placeholder="Email address" required autofocus>

                    <label for="inputPassword" class="sr-only">Password</label>
                    <input name="password" type="password" id="inputPassword" class="form-control my-2" placeholder="Password" required>

                    <div class="checkbox mb-3">
                        <label>
                        <input type="checkbox" value="1" name="rememberme"> Remember me
                        </label>
                    </div>
                    <div class="my-3">
                        {!! NoCaptcha::display() !!}
                        {!! NoCaptcha::renderJs() !!}
                        @error('g-recaptcha-response') <p class="text-danger"><small>Mohon Input Captcha !</small></p>@enderror
                    </div>
                    <button name="myButton" class="btn btn-lg btn-primary btn-block" type="submit">Sign in</button>
                    <p class="mt-5 mb-3 text-muted">&copy; RICHARD & ALSAN TECH 2021</p>
                </form>
            </div>
        </div>
    </div>

    <script type="text/javascript" src="{{ asset('asset\vendor\mdbootstrap\js\jquery.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('asset\vendor\mdbootstrap\js\popper.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('asset\vendor\mdbootstrap\js\bootstrap.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('asset\vendor\mdbootstrap\js\mdb.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js\app.js') }}"></script>
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
  </body>
</html>
