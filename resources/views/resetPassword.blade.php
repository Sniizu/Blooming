@extends('layout')
@section('title','Reset Password')
@section('style')
<link rel="stylesheet" href="{{ asset('/css/changePassword.css') }}"/>
@endsection


@section('content')
    <div class="container p-5">
        <form action="/resetPassword" method="post" class="item-form" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="token" value="{{ $token }}">
            <h1 class="mb-1 mt-5 fw-bold text-uppercase">Reset Password</h1>
            <div class="form-group" style="margin-top: 25px">
            <input type="password" class="form-control" id="password" name="password" placeholder="Old Password">
        </div>
        <div class="form-group" style="margin-top: 25px">
            <input type="password" class="form-control" id="newpassword" name="newpassword" placeholder="New Password">
        </div>
        <div class="form-group" style="margin-top: 25px">
            <input type="password" class="form-control" id="confirmPassword" name="confirmPassword" placeholder="Confirm New Password">
        </div>
        <div class="button mb-3">
        <button type="submit" class="btn btn-primary mt-3" >Save</button>
        </div>
        @if($errors->any())
        <div class="alert alert-danger" role="alert">
            {{$errors->first()}}
        </div>
        @elseif (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
        @elseif (session('failed'))
        <div class="alert alert-danger">
            {{ session('failed') }}
        </div>
        @endif
        <br>
        </form>
        <br>
    </div>
@endsection
