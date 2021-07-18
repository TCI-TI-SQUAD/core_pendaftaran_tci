<a href="{{ Route('user.dashboard') }}" class="text-dark">
<div class="navigation-block-child mt-3">
        <div class="text-center" style="margin:10px;width:50px;"><i class="fas fa-home"></i></div>
        <div style="flex-grow:2;margin:10px;" class="{{ isset($home) ? 'font-weight-bold' : '' }}">Home</div>
    </div>
</a>

<a href="{{ Route('user.pendaftaran') }}" class="text-dark">
<div class="navigation-block-child mt-3">
        <div class="text-center" style="margin:10px;width:50px;"><i class="fas fa-question"></i></div>
        <div style="flex-grow:2;margin:10px;"  class="{{ isset($pendaftaran) ? 'font-weight-bold' : '' }}">Pendaftaran</div>
    </div>
</a>

<div class="navigation-block-child mt-3">
        <div class="text-center" style="margin:10px;width:50px;"><i class="far fa-address-book"></i></div>
        <div style="flex-grow:2;margin:10px;"  class="{{ isset($kelas_saya) ? 'font-weight-bold' : '' }}">Kelas Saya</div>
</div>

<a href="" style="text-decoration:none;" class="text-dark">
    <div class="navigation-block-child mt-3">
            <div class="text-center" style="margin:10px;width:50px;"><i class="fas fa-sign-in-alt"></i></div>
            <div style="flex-grow:2;margin:10px;"  class="{{ isset($profile) ? 'font-weight-bold' : '' }}">Profile</div>
    </div>
</a>

<form action="{{ Route('user.post.logout') }}" method="post" id="form-logout" style="display:none;">
    {{ csrf_field() }}
    {{ method_field('POST') }}
</form>

<a style="text-decoration:none;" class="text-dark" onclick="document.getElementById('form-logout').submit()">
    <div class="navigation-block-child mt-3">
        <div class="text-center" style="margin:10px;width:50px;"><i class="far fa-registered"></i></div>
        <div style="flex-grow:2;margin:10px;">Log Out</div>
    </div>
</a>