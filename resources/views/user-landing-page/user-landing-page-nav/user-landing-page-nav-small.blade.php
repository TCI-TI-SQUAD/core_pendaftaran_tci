            <div class="navigation-block-child mt-3">
                    <div class="text-center" style="margin:10px;width:50px;"><i class="fas fa-home"></i></div>
                    <div style="flex-grow:2;margin:10px;" class="{{ isset($home) ? 'font-weight-bold' : '' }}">Home</div>
            </div>
        
            <a href="{{ Route('user.about-page') }}" style="text-decoration:none;" class="text-dark">
            <div class="navigation-block-child mt-3">
                    <div class="text-center" style="margin:10px;width:50px;"><i class="fas fa-question"></i></div>
                    <div style="flex-grow:2;margin:10px;" class="{{ isset($about) ? 'font-weight-bold' : '' }}">About</div>
            </div>
            </a>
            
            <div class="navigation-block-child mt-3">
                    <div class="text-center" style="margin:10px;width:50px;"><i class="far fa-address-book"></i></div>
                    <div style="flex-grow:2;margin:10px;" class="{{ isset($contact) ? 'font-weight-bold' : '' }}">Contact</div>
            </div>

            <a href="{{ Route('user.login') }}" style="text-decoration:none;" class="text-dark">
                <div class="navigation-block-child mt-3">
                        <div class="text-center" style="margin:10px;width:50px;"><i class="fas fa-sign-in-alt"></i></div>
                        <div style="flex-grow:2;margin:10px;">Log In</div>
                </div>
            </a>

            <a href="{{ Route('user.register') }}" style="text-decoration:none;" class="text-dark">
                <div class="navigation-block-child mt-3">
                    <div class="text-center" style="margin:10px;width:50px;"><i class="far fa-registered"></i></div>
                    <div style="flex-grow:2;margin:10px;">Register</div>
                </div>
            </a>