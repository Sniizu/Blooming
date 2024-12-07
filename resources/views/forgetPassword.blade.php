@extends('layout')
@section('title','Forget Password')
@section('style')
    <link rel="stylesheet" href="{{ asset('/css/forgetPassword.css') }}"/>
@endsection


@section('content')
<div class="container login_deg mt-5">
  <form action="/forgetPassword" method="POST" >
    @csrf
    <h1 class="mb-1 mt-5 mb-2 fw-bold ">FORGET PASSWORD</h1>
    <h5 class="subhead text-center">Please enter your email and we'll send you a link to reset your password </h5>
    <div class="form-group" style="margin-top: 25px">
      <input type="text" class="form-control" id="email" name="email" placeholder="Email">
    </div>
    
    <button type="submit" class="btn btn-primary mb-3">Submit</button>
    @if($errors->any())
    <div class="alert alert-danger" role="alert">
        {{$errors->first()}}
    </div>
    @elseif(session()->has('success'))
        <div class="alert alert-success mt-4">
            {{ session()->get('success') }}
        </div>
    @endif

  </form>
</div>

@endsection
