<li>        
    <a class="text-dark {{ isset($home) ? 'font-weight-bold' : '' }}" href="{{ Route('user.dashboard') }}">Home</a>
</li>
<li>
    <a class="text-dark {{ isset($pendaftaran) ? 'font-weight-bold' : '' }}" href="{{ Route('user.pendaftaran') }}">Pendaftaran</a>
</li>
<li  class="pr-2">
    <a class="text-dark {{ isset($kelas_saya) ? 'font-weight-bold' : '' }}" href="{{ Route('user.kelas.saya') }}">Kelas Saya</a>
</li>
<li>
    <a class="text-dark {{ isset($profile) ? 'font-weight-bold' : '' }}" href="{{ Route('user.profile.index') }}">Profile</a>
</li>

<li class="position-relative">
    <a class="text-dark {{ isset($notification) ? 'font-weight-bold' : '' }}" href="{{ Route('user.profile.index') }}"><i class="far fa-bell"></i><div class="badge badge-pill badge-danger position-absolute" style="right:-10px;top:-10px;">2</div></a>
</li>

<form action="{{ Route('user.post.logout') }}" method="post" id="form-logout-wide" style="display:none;">
    {{ csrf_field() }}
    {{ method_field('POST') }}
</form>

<li>
    <button type="submit" form="form-logout-wide" class="btn btn-outline-danger waves-effect">Log Out</button>
</li>