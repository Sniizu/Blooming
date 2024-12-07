@extends('layout')
@section('title','Change Password')
@section('style')
<link rel="stylesheet" href="{{ asset('/css/changePassword.css') }}"/>
@endsection


@section('content')
    <div class="container changePassword_deg">
        <form action="/changePassword" method="post" class="item-form" enctype="multipart/form-data">
            @csrf
            <h1 class="mb-1 mt-5 fw-bold">CHANGE PASSWORD</h1>
            <div class="form-group" style="margin-top: 25px">
            <input type="password" class="form-control" id="password" name="password" placeholder="Old Password">
            </div>
            <div class="form-group" style="margin-top: 25px">
            <input type="password" class="form-control" id="newpassword" name="newpassword" placeholder="New Password">
            </div>
            <div class="form-group" style="margin-top: 25px">
            <input type="password" class="form-control" id="confirmPassword" name="confirmPassword" placeholder="Confirm New Password">
            </div>
            <div class="button">
                <button type="submit" class="btn btn-primary mt-3 " >Change</button>
            </div>
            <br>
            @if($errors->any())
            <div class="alert alert-danger" role="alert">
                {{$errors->first()}}
            </div>
            @elseif (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
            @elseif (session('fail'))
            <div class="alert alert-danger">
                {{ session('fail') }}
            </div>
            @endif
        </form>
        <br>

       
    </div>
@endsection
