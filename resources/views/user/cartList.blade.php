@extends('layout')

@section('title', 'Cart')

@section('style')
<link rel="stylesheet" href="{{ asset('/css/cart.css') }}"/>
@endsection

@section('content')
<div class="container hero-content">
  <h1 class="mt-5 mb-5 fw-bold text-center text-uppercase">My Cart</h1>
  @if($cartitems != null && count($cartitems->cartDetail) > 0)
    @if(session()->has('success'))
      <div class="alert alert-dark alert-dismissible fade show d-flex" role="alert">
        <span>{{ session('success') }}</span>
        <button type="button" class="close bg-danger text-light border-1 border-danger ms-auto px-2 rounded" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
    @endif
    <div class="table-responsive mb-5">
    <table class="table table-striped cart-table">
      <thead class="thead-dark">
        <tr>
          <th scope="col">No</th>
          <th scope="col">Item Image</th>
          <th scope="col">Item Name</th>
          <th scope="col">Item Price</th>
          <th scope="col">Item qty</th>
          <th scope="col">Detail Item</th>
          <th scope="col">Total Price</th>
          <th scope="col">Action</th>
        </tr>
      </thead>
      <tbody>
        @foreach($cartitems->cartDetail as $index => $cartDetail)
        <form method="post">
        @csrf
        <tr>
          <th scope="row">{{ $index + 1 }}</th>
          <td>
            @if (Storage::disk('public')->exists($cartDetail->item->image))
              <img src="{{ Storage::url($cartDetail->item->image) }}" alt="card-image" width="200" height="200">
            @else
              <img src="{{ asset($cartDetail->item->image) }}" alt="card-image" width="200" height="200">
            @endif
          <td>{{ $cartDetail->item->name }}</td>
          <td>Rp {{ number_format($cartDetail->item->price,0,',','.') }}</td>
          <td class="qty">
              {{ $cartDetail->qty }}
          </td>

          <td>
            @if($cartDetail->detail_item)

                <strong>Size</strong> <br>
                <li>{{ $cartDetail->detail_item->size }} <br></li>

                <strong>Flower</strong> <br>
                @foreach($cartDetail->detail_item->flower as $flower)
                <li>{{ $flower }} <br></li>
                @endforeach

                <strong>Filler</strong> <br>
                @if(isset($cartDetail->detail_item->fillers))
                  @foreach($cartDetail->detail_item->fillers as $filler)
                      <li>{{ $filler }}<br></li>
                  @endforeach
                  @else
                  <li>No fillers.</li>
              @endif

                <strong>Leaves</strong> <br>
                <li>{{ $cartDetail->detail_item->leaves }}<br></li>

                <strong>Paper</strong> <br>
                <li>{{ $cartDetail->detail_item->color }}<br></li>

                <strong>Ribbon</strong> <br>
                <li>{{ $cartDetail->detail_item->ribbon }}<br></li>

            @else
                <!-- Handle case when detail_item is null or invalid -->
            @endif
          </td>

          <td class="total-price">Rp  {{ number_format($cartDetail->qty * $cartDetail->item->price,0,',','.') }}</td>
          <td>
              <input type="hidden" name="cart_id" value="{{ $cartDetail->cart_id }}">
              <input type="hidden" name="item_id" value="{{ $cartDetail->item_id }}">
              <div id="action">
              <a href="/updateCartqty/{{ $cartDetail->item->id }}"><button type="button" class="btn btn-primary btn-sm">Update</button></a>
              <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteModal" data-cart-id="{{ $cartDetail->cart_id }}" data-item-id="{{ $cartDetail->item_id }}">Delete</button>

            </div>
          </td>
        </tr>
        </form>
        @endforeach
      </tbody>
    </table>
  </div>
    <div class="d-flex mb-5">
      <h4>Grand Total: <span class="grand-total">Rp {{ number_format($cartitems->sum,0,',','.') }}</span></h4>
      <a href="/checkOutForm" class="ms-auto"><button type="button" class="btn btn-primary btn-sm p-2">Check Out</button></a>
    </div>
  @else
    <h3 class="text-center pb-5 mt-5 pt-5">Cart is empty! Let’s go shopping :)</h3>
  @endif
</div>

<!-- Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="deleteModalLabel">Delete Cart</h5>
      </div>
      <div class="modal-body p-4">
        Are you sure you want to delete this item from the cart?
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        <form method="POST" id="deleteForm" action="/deleteCartItem">
          @csrf
          <input type="hidden" name="item_id" id="deleteItemId" value="">
          <input type="hidden" name="cart_id" id="deleteCartId" value="">
          <button type="submit" class="btn btn-danger">Delete</button>
        </form>
      </div>
    </div>
  </div>
</div>

@endsection

@section('script')
<script>
  document.addEventListener('DOMContentLoaded', function () {
    var deleteModal = document.getElementById('deleteModal');
    deleteModal.addEventListener('show.bs.modal', function (event) {
      var button = event.relatedTarget; // Button that triggered the modal
      var itemId = button.getAttribute('data-item-id'); // Extract info from data-* attributes
      var cartId = button.getAttribute('data-cart-id');
      var modalItemInput = deleteModal.querySelector('#deleteItemId');
      var modalCartInput = deleteModal.querySelector('#deleteCartId');
      modalItemInput.value = itemId;
      modalCartInput.value = cartId;
    });
  });
</script>


@endsection