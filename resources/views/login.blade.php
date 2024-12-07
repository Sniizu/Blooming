@extends('layout')
@section('title','Login')
@section('style')
    <link rel="stylesheet" href="{{ asset('/css/login.css') }}"/>
@endsection


@section('content')
    <div class="container login_deg mt-5">
  <form action="/login" method="post" >
    @csrf
    <h1 class="mb-1 mt-5 fw-bold">LOGIN</h1>
    <div class="form-group" style="margin-top: 25px">
      <input type="text" class="form-control" id="email" name="email" placeholder="Email" value="{{((Cookie::get('email') !== null) ? Cookie::get('email') : '')}}">
    </div>
    <div class="form-group">
      <input type="password" class="form-control" id="password" name="password" placeholder="Password" value="{{((Cookie::get('password') !== null) ? Cookie::get('password') : '')}}">
    </div>
    <div class="form-check mb-3 forget">
        <div>
          <input type="checkbox" class="form-check-input" id="remember" name="remember" {{Cookie::get('email') === null ? '':'checked'}}>
          <label class="form-check-label" for="remember" name="remember">Remember me</label>
        </div>
        <div>
          <a href="/forgetPassword">Forget password?</a>
        </div>
      </div>
      
      <div class="form-group register">
      <button type="submit" class="btn btn-primary mb-3">Login</button>
      <p>Don't have an account? <a href="/register">Register</a></p>
   </div>
    @if($errors->any())
    <div class="alert alert-danger" role="alert">
        {{$errors->first()}}
    </div>
    @elseif(session()->has('register_success'))
        <div class="alert alert-success mt-4">
            {{ session()->get('register_success') }}
        </div>
    @elseif(session()->has('failed'))
    <div class="alert alert-danger mt-4">
      {{ session()->get('failed') }}
  </div>
    @endif
  </form>
</div>

@endsection
