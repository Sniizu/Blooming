<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title')</title>

    @include('style/css')
     <link rel="stylesheet" href="{{ asset('/css/layout.css') }}"/>
     <link rel="icon" type="image/svg" href="{{ asset('asset/icon_tab.svg') }}">
     <script defer src="{{ asset('js/script.js') }}"></script>
     @yield('style')

</head>
<body>

  <nav class="navbar navbar-expand-lg navbar-light">
    @if(optional(Session::get('user'))->role === 'admin')
      <a class="navbar-brand pe-4" href="{{ url('/dashboard') }}"><img width="250" src="{{ asset('/asset/logo.svg') }}" alt="#" /></a>
    @else
      <a class="navbar-brand pe-4" href="{{ url('/') }}"><img width="250" src="{{ asset('/asset/logo.svg') }}" alt="#" /></a>
    @endif
        <button class="navbar-toggler navbar-light mb-2 border-0" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
        
          <div class="collapse navbar-collapse " id="navbarSupportedContent">
          <ul class="navbar-nav mr-auto left pt-1">
            @if(optional(Session::get('user'))->role !== 'admin')
              <li class="nav-item">
                <a class="nav-link select_nav" href="/">HOME</a>
              </li>
              <li class="nav-item">
                <a class="nav-link select_nav" href="/showProduct">FLOWERS</a>
              </li>
              <li class="nav-item">
                <a class="nav-link select_nav" href="/aboutUs">ABOUT US</a>
              </li>
              <li class="nav-item">
                <a class="nav-link select_nav" href="/contact">CONTACT</a>
              </li>
            @endif
            @if(Session::get('user') && Session::get('user')['role']==='customer')
              <li class="nav-item">
                <a class="nav-link text-uppercase select_nav" href="/transactionHistory">Transaction History</a>
              </li>
              <li class="nav-item">
                <a class="nav-link text-uppercase select_nav" href="/customOrder">Custom Order</a>
              </li>
            @endif


        </ul>

          <ul class="navbar-nav ms-auto pt-1">
            @if(Session::get('user'))
            
            @if(Session::get('user')['role']==='customer')
            <li class="nav-item cart">
              <a class="nav-link icon" href="/cartList"><i class="fas fa-shopping-cart"></i></a>
              <span>{{ $cart_count }}</span>
            </li>
            @endif
            <li class="nav-item dropdown" style="padding-right:1em">
                <a class="nav-link dropdown-toggle icon" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  <i class="fas fa-user"></i>
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                <p class="nav-link text-uppercase">{{Session::get('user')['username']}}</p>
                <a class="nav-link" href="/editProfile">Edit Profile</a>
                <a class="nav-link" href="/changePassword">Change Password</a>
                <a class="nav-link " href="/logout">Logout</a>
                </div>
            </li>
            @else
            <li class="nav-item">
                <a class="nav-link select_nav" href="/login">LOGIN</a>
            </li>
            <li class="nav-item">
                <a class="nav-link select_nav" href="/register">REGISTER</a>
            </li>
            @endif
          </ul>

        </div>
    </nav>

    <div class="content">
        @yield('content')
    </div>
    
    <footer class="footer text-white pt-5 pb-4">
      <div class=" container text-md-left">
        <div class="row text-md-left">
          <div class="col-md-3 col-lg-3 col-xl-3 me-4 mt-3">
            <img src="{{ asset('asset/logo_white.svg') }}" width="250px" class="mb-2" alt="logo">
            <p style="margin-left:3px">Premier florist shop, curated bouquets, unforgettable moments, nature's grace, enchanting floral arrangements</p>
          </div>
          <div class="col-md-2 col-lg-2 col-xl-2 mx-auto mt-3">
            <h5 class="text-uppercase mb-3 font-weight-bold ">Store</h5>
            <h6 class=" mb-2 font-weight-bold ">Blooming Florist Jakarta</h6>
            <p>Ruko Cordoba Blok G No. 3 <br>Pantai Indah Kapuk</p>
            <h6 class="mb-2 font-weight-bold ">Blooming Florist Bandung</h6>
            <p>Ruko Puri Dago No. 10 <br>Antapani</p>
          </div>
          <div class="col-md-3 col-lg-3 col-xl-2 mx-auto mt-3 pe-0">
            <h5 class="text-uppercase mb-3 font-weight-bold ">Opening Hours</h5>
            <h6 class="mb-2 font-weight-bold ">Monday - Saturday</h6>
            <p>08:00 - 22:00</p>
            <h6 class="mb-2 font-weight-bold ">Sunday</h6>
            <p>10:00 - 17:00</p>
          </div>
          <div class="col-md-4 col-lg-3 col-xl-2 mx-auto mt-3">
            <h5 class="text-uppercase mb-3 font-weight-bold ">Contact</h5>
            <h6 class="mb-2 font-weight-bold ">Email</h6>
            <p>admin@mail.com</p>
            <h6 class="mb-2 font-weight-bold ">Whatsapp</h6>
            <p class="m-0">081231231234 (Jakarta)</p>
            <p>081231231234 (Bandung)</p>
          </div>
        </div>

        <hr class="mb-4">
        <div class="row align-items-center text-md-left">
            <div class="col-md-7 col-lg-8 me-auto">
              <h6>Copyright ©2024 All rights reserved by: 
                <a href="#" ><strong class="text-warning">The Provider</strong> </a>
              </h6>
            </div>
            <div class="col-md-5 col-lg-4">
                <div class="text-center text-md-right">
                  <ul class="list-unstyled list-inline">
                    <li class="list-inline-item">
                      <a href="https://www.facebook.com/" class="btn-floating btn-sm text-white" style="font-size:23px;"><i class="fab fa-facebook"></i></a>
                    </li>
                    <li class="list-inline-item">
                      <a href="https://twitter.com/" class="btn-floating btn-sm text-white" style="font-size:23px;"><i class="fab fa-twitter"></i></a>
                    </li>
                    <li class="list-inline-item">
                      <a href="https://www.instagram.com/" class="btn-floating btn-sm text-white" style="font-size:23px;"><i class="fab fa-instagram"></i></a>
                    </li>
                    <li class="list-inline-item">
                      <a href="https://www.tiktok.com/" class="btn-floating btn-sm text-white" style="font-size:23px;"><i class="fab fa-tiktok"></i></a>
                    </li>
                  </ul>
                </div>
            </div>
        </div>
      </div>
    </footer>

   @include('style/js')
   @yield('script')


</body>
</html>
