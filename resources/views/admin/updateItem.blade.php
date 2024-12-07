
@extends('layout')
@section('title','Update Item')
@section('style')
<link rel="stylesheet" href="{{ asset('/css/addItem.css') }}"/>
@endsection

@section('content')
@if(Session::get('user')['role'] === 'admin')
<div class="d-flex" id="wrapper">
    <!-- Sidebar -->
    <div class="bg-white" id="sidebar-wrapper">
        
        <div class="list-group list-group-flush my-3">
           
            <a href="/dashboard" class="list-group-item list-group-item-action bg-transparent nav-link select_nav"><i
                    class="fas fa-th-large me-2"></i>Dashboard</a>
            <a href="/viewOrder" class="list-group-item list-group-item-action bg-transparent  nav-link select_nav"><i
              class="fas fa-truck-loading me-2"></i>Manage Order</a>
            <a href="/viewItem" class="list-group-item list-group-item-action bg-transparent  nav-link select_nav"><i
                    class="fas fa-boxes me-2"></i>Manage Item</a>
            <a href="/addItem" class="list-group-item list-group-item-action bg-transparent   nav-link select_nav"><i
              class="fas fa-box me-2"></i>Add Item</a>
            <a href="/viewCategory" class="list-group-item list-group-item-action bg-transparent  nav-link select_nav"><i
              class="fas fa-layer-group me-2"></i>Manage Category</a>
            <a href="/addCategory" class="list-group-item list-group-item-action bg-transparent   nav-link select_nav"><i
                        class="fas fa-plus me-2"></i>Add Category</a>
        
        
        </div>
    </div>
    <div id="page-content-wrapper">
        <div class="d-flex align-items-center  px-5  mt-5">
            <i class="fas fa-align-right primary-text fs-4 me-3" id="menu-toggle"></i>
            <div class="flex-grow-1"></div>
            <a href="/viewItem"><button class="btn btn-primary btn-md">Back</button></a>
        </div>
    

        <div class="container-fluid px-4">
          <form action="/updateItem/{{$product->id}}" method="post" class="item-form" enctype="multipart/form-data">
            @method('put')
            @csrf
          
            <h1 class=" fw-bold text-center text-uppercase mt-4">Update Item</h1>
          
                <div class="form-group">
                  <label for="id">Item ID</label>
                  <input type="hidden" id="id" name="id" class="form-control" value="{{$product->id}}"> 
                  <div class="unchanged">
                    {{$product->id}}
                  </div>
                </div>
          
                <div class="form-group">
                  <label for="name">Item Name</label>
                  <input type="text" id="name" name="name" class="form-control" value="{{$product->name}}">
                  @error('name')
                  <p class="text-danger">{{ $message }}</p>
                  @enderror
              </div>
          
              <div class="form-group">
                <label for="price">Price (IDR)</label>
                <input type="text" id="price" name="price" class="form-control" value="{{ $product->price}}">
                @error('price')
                <p class="text-danger">{{ $message }}</p>
                @enderror
            </div>
          
            <div class="form-group">
              <label for="category">Category</label>
              <select name="category_id" id="category" class="form-control">
                  <option value="select">Select a category</option>
                  @foreach($category as $c)
                      @if($product->category_id === $c->id)
                       <option value="{{ $c->id }}" selected>{{ $c->name }}</option>
                      @else
                        <option value="{{ $c->id }}">{{ $c->name }}</option>
                      @endif
                  @endforeach
              </select>
              @error('category_id')
                <p class="text-danger">{{ $message }}</p>
              @enderror
          </div>
          
          <div class="form-group">
            <div class="update-image mb-3">
              <label for="image">Update Image</label> <br>
              <input type="file" class="form-control" name="image" id="image">
            </div>
            <div class="update-image">
              <label for="">Old Image File</label>
              <div class="unchanged unchanged-img mb-2">
                {{$product->image}}
              </div>
            </div>
            @error('image')
            <p class="text-danger">{{ $message }}</p>
            @enderror
          </div>
          
              <div class="preview">
                @if (Storage::disk('public')->exists($product->image))
                  <img id="preview-image" src="{{Storage::url($product->image) }}"
                  alt="preview image" style="max-height: 120px">
                @else
                  <img id="preview-image" src="{{ asset($product->image) }}"
                  alt="preview image" style="max-height: 120px">
                @endif
              </div>
          
          
              <div class="form-group">
                <label for="desc">Description</label>
                <textarea class="form-control" cols="30" rows="5" name="description" id="desc">{{  $product->description }}</textarea> 
                @error('description')
                <p class="text-danger">{{ $message }}</p>
                @enderror
            </div>
          
            <div class="button mt-3 mb-5">
              
              <button type="submit" class="btn btn-primary  ">Update Item</button>
            </div>
          </form>

        </div>
    </div>
</div>
@else
<div class="container">
    <h2 class="text-center mt-4 mb-3">Access Denied</h2>
    <p class="text-center">Please login as admin to access this page</p>
    <a href="/login"><p  class="text-center">if you are an admin, login here 👈</p> </a>
  </div>
@endif
@endsection

@section('script')
<script>
    $(document).ready(function () {
            var el = document.getElementById("wrapper");
            var toggleButton = document.getElementById("menu-toggle");

            function setInitialIcon() {
                  if (window.innerWidth >= 768) {
                      toggleButton.classList.remove("fa-align-left");
                      toggleButton.classList.add("fa-align-right");
                  } else {
                      toggleButton.classList.remove("fa-align-right");
                      toggleButton.classList.add("fa-align-left");
                  }
              }

              window.onload = setInitialIcon;
              window.onresize = setInitialIcon;

            toggleButton.onclick = function () {
                el.classList.toggle("toggled");
                if (toggleButton.classList.contains("fa-align-left")) { 
                    toggleButton.classList.remove("fa-align-left");
                    toggleButton.classList.add("fa-align-right");
                } else {
                    toggleButton.classList.remove("fa-align-right");
                    toggleButton.classList.add("fa-align-left");
                }
            };

            $('#image').change(function () {
                const reader = new FileReader();
                reader.onload = (e) => {
                    $('#preview-image').attr('src', e.target.result);
                };
                reader.readAsDataURL(this.files[0]);
            });
        });
</script>
@endsection