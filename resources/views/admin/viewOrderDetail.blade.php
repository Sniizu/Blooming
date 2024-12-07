
@extends('layout')
@section('title','Order Detail')
@section('style')
<link rel="stylesheet" href="{{ asset('/css/viewOrder.css') }}"/>
@endsection

@section('content')
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
        <div class="d-flex justify-content-between align-items-center px-5  mt-5">
            <i class="fas fa-align-right primary-text fs-4 me-3" id="menu-toggle"></i>
            <a href="/viewOrder"><button type="button" class="btn btn-primary btn-md" >Back</button></a>
        </div>


        <div class="container-fluid px-4">
          <h1 class=" fw-bold text-center text-uppercase pt-4">Manage Order</h1>
          @if(session()->has('success'))
          <div class="alert alert-dark alert-dismissible fade show d-flex" role="alert">
            <span>{{session('success')}}</span>
            <button type="button" class="close bg-danger text-light border-1 border-danger ms-auto px-2 rounded" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          @endif

        <div class="mt-5 ">
                <div class="row">
                    <div class="col-md-6 col-sm-12 col-xs-12">
                        <div class="checkout-form mb-5">
                            <form method="POST" action="#">
                                @csrf

                                <h3 class="mb-3">Sender</h3>
                                <div class="form-group mb-3">
                                    <label for="email">Sender Email</label>
                                    <input type="email" class="form-control" id="email" name="email" placeholder="Email" value="{{ $orderDetail->sender_email }}" required disabled>
                                </div>

                                <div class="form-group mb-3">
                                    <label for="senderName">Sender Name</label>
                                    <input type="text" class="form-control me-3" id="senderName" name="senderName" value="{{ $orderDetail->sender_name }}" required disabled>
                                </div>

                                <div class="form-group mb-3">
                                    <label for="senderPhone">Sender Phone</label>
                                    <input type="number" class="form-control me-3 mb-3" id="senderPhone" name="senderPhone" value="{{ $orderDetail->sender_phone }}" required disabled>
                                </div>


                                <h3 class="mb-3">Delivery</h3>
                                <div class="form-group mb-3">
                                    <label for="recipientName">Recipient Name</label>
                                        <input type="text" class="form-control me-3" id="recipientName" name="recipientName"  value="{{ $orderDetail->receiver_name }}"required disabled>
                                </div>

                                <div class="form-group mb-3">
                                    <label for="recipientPhone">Recipient Phone</label>
                                    <input type="number" class="form-control me-3 mb-3" id="recipientPhone" name="recipientPhone" value="{{ $orderDetail->receiver_phone }}" required disabled>
                                </div>

                                <div class="form-group mb-3">
                                    <label for="deliveryOptions">Delivery Type</label>
                                    <input type="text" class="form-control me-3 mb-3" id="deliveryOptions" name="deliveryOptions" value="{{ $orderDetail->delivery_option }}" required disabled>
                                </div>

                                <div class="form-group mb-3">
                                    <label for="datepicker" class="form-label">Delivery Date</label>
                                    <input type="text" class="form-control" id="datepicker" name="datepicker" value="{{ $orderDetail->delivery_date }}" disabled>
                                </div>


                                <div class="form-group mb-3">
                                    <label for="deliveryTime" class="form-label">Delivery Time</label>
                                    <input type="text" class="form-control" id="deliveryTime" name="deliveryTime" value="{{ $orderDetail->delivery_time }}" disabled>
                                </div>

                                <div class="form-group mb-3">
                                    <label for="province">Province</label>
                                    <input type="text" class="form-control me-3 mb-3" id="province" name="province" value="{{ $orderDetail->province }}" required disabled>
                                </div>

                                <div class="form-group mb-3">
                                <label for="city">City</label>
                                    <div class="d-flex mb-3">
                                        <input type="text" class="form-control me-3" id="city" name="city" value="{{ $orderDetail->city }}" disabled >
                                        <input type="number" class="form-control" id="postalCode" name="postalCode" value="{{ $orderDetail->postal_code }}"  required disabled>
                                    </div>
                                </div>

                                <div class="form-group mb-3">
                                    <label for="deliveryAddress">Delivery Address</label>
                                    <textarea class="form-control" name="deliveryAddress" id="deliveryAddress"  cols="30" rows="5" required disabled>{{ $orderDetail->delivery_address }}" </textarea>
                                </div>

                            </form>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-12 col-xs-12">
                        <table class="table table-striped cart-table">
                            <thead class="table-dark">
                            <tr>
                                <th scope="col">No</th>
                                <th scope="col">Item Image</th>
                                <th scope="col">Item Name</th>
                                <th scope="col">Item Price</th>
                                <th scope="col">Item qty</th>
                                <th scope="col">Total Price</th>
                            </tr>
                            </thead>
                            <tbody>
                            @for ($i = 0; $i < count($orderDetail->transactionDetail()->get()); $i++)
                            <tr>
                                <th scope="row">{{$i+1}}</th>
                                <td>
                                    
                                    @if (Storage::disk('public')->exists($orderDetail->transactionDetail()->get()[$i]->item()->first()->image))
                                        <img src="{{Storage::url($orderDetail->transactionDetail()->get()[$i]->item()->first()->image)}}" alt="card-image" width="90" height="90">
                                    @else
                                    
                                    <img src="{{asset($orderDetail->transactionDetail()->get()[$i]->item()->first()->image)}}" alt="card-image" width="90" height="90">
                                    @endif
                                <td>{{$orderDetail->transactionDetail()->get()[$i]->item()->first()->name}}</td>
                                <td>Rp {{number_format($orderDetail->transactionDetail()->get()[$i]->item()->first()->price,0,',','.')}}</td>
                                <td class="qty">
                                    {{$orderDetail->transactionDetail()->get()[$i]->qty}}
                                </td>

                                <td class="total-price">Rp {{number_format($orderDetail->transactionDetail()->get()[$i]->qty*$orderDetail->transactionDetail()->get()[$i]->item()->first()->price,0,',','.')}}</td>
                              </tr>

                              @endfor
                            </tbody>
                          </table>
                          <div class="d-flex justify-content-between">
                              <h5>Sub Total</h5>
                              <h5><strong id="cart-sum" > Rp {{number_format( $orderDetail->subtotal,0,',','.') }}</strong></h5>
                          </div>
                          <div class="d-flex justify-content-between">
                            <h5 id="deliveryType">Delivery by Car</h5>
                            <h5><strong id="deliveryCost"> Rp {{ number_format($orderDetail->delivery_cost,0,',','.') }}</strong></h5>
                        </div>
                        <div class="d-flex justify-content-between">
                            <h5>Service 2%</h5>
                            <h5><strong id="serviceCost"> Rp {{ number_format($orderDetail->service_fee,0,',','.') }}</strong></h5>
                        </div>
                        <hr>
                        <div class="d-flex justify-content-between">
                            <h4>Total Price</h4>
                            <h4><strong id="totalPrice"> Rp {{ number_format($orderDetail->total_price,0,',','.') }}</strong></h4>
                        </div>
                    </div>
                </div>
        </div>

        </div>
    </div>
</div>
@endsection

@section('script')
<script>
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
</script>
@endsection
