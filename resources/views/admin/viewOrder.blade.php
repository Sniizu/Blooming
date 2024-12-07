
@extends('layout')
@section('title','Manage Order')
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
        <div class="d-flex align-items-center px-5  mt-5">
            <i class="fas fa-align-right primary-text fs-4 me-3" id="menu-toggle"></i>
        </div>


        <div class="container-fluid px-4">
          <h1 class=" fw-bold text-center text-uppercase">Manage Order</h1>
          @if(session()->has('success'))
          <div class="alert alert-dark alert-dismissible fade show d-flex" role="alert">
            <span>{{session('success')}}</span>
            <button type="button" class="close bg-danger text-light border-1 border-danger ms-auto px-2 rounded" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          @endif

          <div class="table-responsive">
            <table class="table table-striped table-hover align-middle mt-4 order-table">
                <thead class="table-dark">
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Sender Name</th>
                        <th scope="col">Recipient Name</th>
                        <th scope="col">Total Price</th>
                        <th scope="col">Delivery Date</th>
                        <th scope="col">Delivery Type</th>
                        <th scope="col">Delivery Time</th>
                        <th scope="col">Delivery Status</th>
                        <th scope="col">Payment Status</th>
                        <th scope="col">View Detail</th>
                        <th scope="col">Update Delivery</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($orders as $order)
                        <tr>
                            <td scope="row">{{ $loop->iteration }}</td>
                            <td>{{ $order->sender_name }}</td>
                            <td>{{ $order->receiver_name }}</td>
                            <td>Rp  {{ number_format($order->total_price,0,',','.') }}</td>
                            <td>{{ $order->delivery_date }}</td>
                            <td>{{ $order->delivery_option }}</td>
                            <td>{{ $order->delivery_time }}</td>
                            @if($order->delivery_status == 'Delivered')
                                <td style="color:green;"><strong>{{ $order->delivery_status }}</strong></td>
                            @else
                                <td>{{ $order->delivery_status }}</td>
                            @endif
                            @if($order->payment_status == 'Paid')
                                <td style="color:blue;"><strong>{{ $order->payment_status }}</strong></td>
                            @else
                                <td>{{ $order->payment_status }}</td>
                            @endif

                            
                            <td>
                                <a href="/viewOrderDetail/{{ $order->id }}"><button type="button" class="btn btn-primary btn-md" >Detail</button></a>
                            </td>
                            <td>
                                @if($order->delivery_status == 'Delivered')
                                    <button type="button" class="btn  btn-md btn_delivered" disabled>Delivered</button>
                                @else
                                <button type="button" class="btn btn-md btn_delivery" data-bs-toggle="modal" data-bs-target="#deliveryModal{{ $order->id }}">
                                    Deliver
                                </button>

                                <div class="modal fade" id="deliveryModal{{ $order->id }}" tabindex="-1" aria-labelledby="deliveryModalLabel{{ $order->id }}" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="deliveryModalLabel{{ $order->id }}">Confirm Delivery</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                Are you sure you want to deliver this product?
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                <a href="/runUpdateDeliver/{{ $order->id }}" class="btn btn_delivery">Confirm Delivery</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endif

                            </td>
                        </tr>


                    @endforeach
                </tbody>
            </table>
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
