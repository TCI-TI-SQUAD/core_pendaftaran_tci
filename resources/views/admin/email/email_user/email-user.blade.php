@extends('admin.email.email_layout.email-layout')

@section('title',$data['title'])
@section('subject',$data['subject'])

@section('content')
    {!!$data['message']!!}
@endsection