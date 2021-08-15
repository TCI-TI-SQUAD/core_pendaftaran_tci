@extends('admin.admin-layout.admin-layout')

@section('dashboard','active')

@section('page-name-header','Dashboard')

@section('breadcrumb-item')
<li class="breadcrumb-item"><a href="#">Admin</a></li>
<li class="breadcrumb-item active">Dashboard</li>
@endsection

@section('content')
<div class="row">
    <livewire:admin.dashboard.user-active-component />
    <livewire:admin.dashboard.pendaftaran-component />
    <livewire:admin.dashboard.kelas-active-component />
    <livewire:admin.dashboard.transaksi-menunggu-konfirmasi-component />
    <livewire:admin.dashboard.chart-instansi-user-component />
    <livewire:admin.dashboard.countdown-pengumuman-component />
    <livewire:admin.dashboard.register-hari-ini-component />
</div>
@endsection