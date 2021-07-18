                    <li>        
                        <a class="text-dark {{ isset($home) ? 'font-weight-bold' : '' }}" href="{{ route('user.landing-page') }}">Home</a>
                    </li>
                    <li>
                        <a class="text-dark {{ isset($about) ? 'font-weight-bold' : '' }}" href="{{ route('user.about-page') }}">About</a>
                    </li>
                    <li  class="border-right pr-2">
                        <a class="text-dark {{ isset($contact) ? 'font-weight-bold' : '' }}" href="">Contact</a>
                    </li>
                    <li>
                        <a class="text-dark" href="{{ Route('user.login') }}">Log In</a>
                    </li>
                    <li>
                        <a href="{{ Route('user.register') }}">
                            <button type="button" class="btn btn-outline-success btn-register waves-effect">Register Here</button>
                        </a>
                    </li>