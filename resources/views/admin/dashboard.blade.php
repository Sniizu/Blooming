
@extends('layout')
@section('title','Dashboard')
@section('style')
<link rel="stylesheet" href="{{ asset('/css/dashboard.css') }}"/>
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

            <h1 class=" fw-bold text-center text-uppercase">Dashboard</h1>
            <div class="row g-3 my-2">
                <div class="col-md-4">
                    <div class="p-3 bg-white shadow-sm d-flex justify-content-around align-items-center rounded">
                        <div>
                            <h3 class="fs-2">{{ $product_count }}</h3>
                            <p class="fs-5">Products</p>
                        </div>
                        <i class="fas fa-gift fs-1 primary-text border rounded-full secondary-bg p-3"></i>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="p-3 bg-white shadow-sm d-flex justify-content-around align-items-center rounded">
                        <div>
                            <h3 class="fs-2">{{ $sales_count }}</h3>
                            <p class="fs-5">Sales</p>
                        </div>
                        <i
                            class="fas fa-hand-holding-usd fs-1 primary-text border rounded-full secondary-bg p-3"></i>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="p-3 bg-white shadow-sm d-flex justify-content-around align-items-center rounded">
                        <div>
                            <h3 class="fs-2">{{ $delivery_count }}</h3>
                            <p class="fs-5">Delivery</p>
                        </div>
                        <i class="fas fa-truck fs-1 primary-text border rounded-full secondary-bg p-3"></i>
                    </div>
                </div>
            </div>

            <div class="row my-5">
                <h3 class="fs-4 mb-3">Recent Orders</h3>
                <div class="col">
                    <div class="table-responsive">
                        <table class="table table-striped bg-white rounded shadow-sm  table-hover">
                            <thead >
                                <tr>
                                    <th scope="col" width="50">#</th>
                                    <th scope="col">Transaction ID</th>
                                    <th scope="col">Reciever Name</th>
                                    <th scope="col">Reciever Address</th>
                                    <th scope="col">Delivery Status</th>
                                    <th scope="col">Payment Status</th>

                                </tr>
                            </thead>

                            <tbody>
                                @foreach($order as $order )
                                <tr>
                                    <th scope="row">{{ $loop->iteration }}</th>
                                    <td>{{ $order->id }}</td>
                                    <td>{{ $order->receiver_name }}</td>
                                    <td>{{ $order->delivery_address }}</td>
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
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
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