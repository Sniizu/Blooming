@extends('layout')
@section('title','Register')
@section('style')
    <link rel="stylesheet" href="{{ asset('/css/register.css') }}"/>
@endsection

@section('content')
<div class="container register_deg mt-5">
  
<form action="/register" method="post" >
    @csrf

    <h1 class="mb-1 mt-5 fw-bold">REGISTER</h1>
    @if($errors->any())
  <div class="alert alert-danger mt-4" role="alert">
      {{$errors->first()}}
  </div>

  @elseif(session()->has('success_message'))
      <div class="alert alert-success">
          {{ session()->get('success_message') }}
      </div>
    @endif
    <div class="form-group" style="margin-top: 25px">
        <input type="text" class="form-control" id="fullname" name="fullname" placeholder="Fullname">
      </div>
    <div class="form-group">
      <input type="text" class="form-control" id="email" name="email" placeholder="Email">
    </div>
    <div class="form-group">
      <input type="password" class="form-control" id="password" name="password" placeholder="Password">
    </div>
    <div class="form-group">
        <input type="password" class="form-control" id="confirmPassword" name="confirmPassword"placeholder="Confirm Password">
      </div>

      <div class="form-group login">
      <button type="submit" class="btn btn-primary mb-3">Register</button>
      <p>Already have an account? <a href="/login">Login</a></p>
     
    </div>

</form>
</div>

@endsection
