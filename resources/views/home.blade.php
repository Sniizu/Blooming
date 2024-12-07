

@extends('layout')

@section('style')
<link rel="stylesheet" href="{{ asset('/css/home.css') }}"/>
@endsection

@section('title','Home')

@section('content')
    <section>
        <div class="container hero-content">
            <div id="home-carousel" class="carousel slide mt-5">
                <div class="carousel-indicators">
                  <button type="button" data-bs-target="#home-carousel" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                  <button type="button" data-bs-target="#home-carousel" data-bs-slide-to="1" aria-label="Slide 2"></button>
                  <button type="button" data-bs-target="#home-carousel" data-bs-slide-to="2" aria-label="Slide 3"></button>
                </div>
                <div class="carousel-inner">
                  <div class="carousel-item active c-item">
                    <img src="https://img.freepik.com/free-photo/beautiful-flowers-field_23-2150788819.jpg?size=626&ext=jpg&ga=GA1.1.553209589.1714176000&semt=ais" class="d-block w-100 c-image" alt="...">
                    <div class="carousel-caption caption-content ">
                        <p class="fs-5 text-uppercase">Warmth. Nostalgia. Togetherness. Give the gift of an experience</p>
                        <h1 class="display-1 fw-bolder text-capitalize">A Taste of Home</h1>
                        <a href="/showProduct"><button class="btn btn-primary px-5 py-2 fs-5 mt-4 btn-deg">Shop Now</button></a>
                    </div>
                </div>
                  <div class="carousel-item c-item">
                    <img src="https://img.freepik.com/free-photo/beautiful-flowers-field_23-2150788819.jpg?size=626&ext=jpg&ga=GA1.1.553209589.1714176000&semt=ais" class="d-block w-100 c-image" alt="...">
                    <div class="carousel-caption caption-content ">
                        <p class="fs-5 text-uppercase">Warmth. Nostalgia. Togetherness. Give the gift of an experience</p>
                        <h1 class="display-1 fw-bolder text-capitalize">A Taste of Home</h1>
                        <a href="/showProduct"><button class="btn btn-primary px-5 py-2 fs-5 mt-4 btn-deg">Shop Now</button></a>
                    </div>
                </div>
                  <div class="carousel-item c-item">
                    <img src="https://img.freepik.com/free-photo/beautiful-flowers-field_23-2150788819.jpg?size=626&ext=jpg&ga=GA1.1.553209589.1714176000&semt=ais" class="d-block w-100 c-image" alt="...">
                    <div class="carousel-caption caption-content ">
                        <p class="fs-5 text-uppercase">Warmth. Nostalgia. Togetherness. Give the gift of an experience</p>
                        <h1 class="display-1 fw-bolder text-capitalize">A Taste of Home</h1>
                        <a href="/showProduct"><button class="btn btn-primary px-5 py-2 fs-5 mt-4 btn-deg">Shop Now</button></a>
                    </div>
                </div>
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#home-carousel" data-bs-slide="prev">
                  <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                  <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#home-carousel" data-bs-slide="next">
                  <span class="carousel-control-next-icon" aria-hidden="true"></span>
                  <span class="visually-hidden">Next</span>
                </button>
              </div>

              <div class="product_catalog mb-5">
                @isset($category_1)
                <div class="product_category">
                  <div class="category_title">
                
                    <h2 class="text-uppercase">{{ $category_1[0]->category->name }}</h2>
                    <a href="/showProduct/{{  urlencode($category_1[0]->category->name) }}" class="ms-auto">View All</a>
                  </div>

                  <div class="row row-cols-2 row-cols-md-2 row-cols-xl-4 g-4 py-3">
                    @foreach ($category_1 as $category_1)
                    <div class="col mx-auto" >
                      <a href="/products/{{$category_1->id}}">
                        <div class="card ">
                          @if (Storage::disk('public')->exists($category_1->image))
                            <img src="{{Storage::url($category_1->image) }}" class="card-img-top img_product" alt="...">
                          @else
                            <img src="{{ asset($category_1->image) }}" class="card-img-top img_product" alt="...">
                          @endif
                          <div class="card-body">
                            <h5 class="card-title">{{ $category_1->name }}</h5>
                            <p class="card-text">Rp {{number_format($category_1->price,0,',','.')}} </p>
                          </div>
                        </div>
                      </a>
                    </div>
                    @endforeach

                  </div>
                </div>
                @endisset

                @isset($category_2)
                <div class="product_category">
                  <div class="category_title">
                    <h2 class="text-uppercase">{{ $category_2[0]->category->name }}</h2>
                    <a href="/showProduct/{{ urlencode($category_2[0]->category->name) }}" class="ms-auto">View All</a>
                  </div>
                  <div class="row row-cols-2 row-cols-md-2 row-cols-xl-4 g-4 py-3">
                   
                    @foreach ($category_2 as $category_2)
                    <div class="col mx-auto" >
                      <a href="/products/{{$category_2->id}}">
                        <div class="card ">
                          @if (Storage::disk('public')->exists($category_2->image))
                            <img src="{{Storage::url($category_2->image) }}" class="card-img-top img_product" alt="...">
                          @else
                            <img src="{{ asset($category_2->image) }}" class="card-img-top img_product" alt="...">
                          @endif
                          <div class="card-body">
                            <h5 class="card-title">{{ $category_2->name }}</h5>
                            <p class="card-text">Rp {{number_format($category_2->price,0,',','.')}} </p>
                          </div>
                        </div>
                      </a>
                    </div>
                    @endforeach

                  </div>
                </div>
                @endisset
                
        </div>
    </section>
@endsection
