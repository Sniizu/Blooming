@extends('layout')
@section('title','Check Out')


@section('style')
<link rel="stylesheet" href="{{ asset('/css/checkOutForm.css') }}"/>
<link href="https://cdn.jsdelivr.net/npm/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css" rel="stylesheet">
@endsection

@section('content')
<div class="container hero-content">
    <div class="text-center">
        <h1 class="mb-1 mt-5 fw-bold">CHECK OUT</h1>
    </div>

    <div class="mt-5 ">
            <div class="row">
                <div class="col-md-6 col-sm-12 col-xs-12">
                    <div class="checkout-form mb-5">
                        @if(Session::has('message'))
                            <p class="alert alert-success">{{ Session::get('message') }}</p>
                        @endif
                        <form method="POST" action="/checkout">
                            @csrf

                            <h3 class="mb-3">Sender</h3>
                            <div class="form-group mb-3">
                                <label for="email">Sender Email <span class="required">*</span></label>
                                <input type="email" class="form-control" id="email" name="email" placeholder="Email" value="{{Session::get('user')['email']}}" >
                                <div id="emailValidationMessage" class="text-danger"></div>

                                @error('email')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="form-group mb-3">
                                <label for="senderName">Sender Name <span class="required">*</span></label>
                                <input type="text" class="form-control me-3" id="senderName" name="senderName" placeholder="Sender Name" >
                                <div id="senderNameValidationMessage" class="text-danger"></div>

                                @error('senderName')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="form-group mb-3">
                                <label for="senderPhone">Sender Phone <span class="required">*</span></label>
                                <input type="number" class="form-control me-3 mb-3" id="senderPhone" name="senderPhone" placeholder="08XXXXXXXXXX" >
                                <div id="senderPhoneValidationMessage" class="text-danger"></div>
                                @error('senderPhone')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>


                            <h3 class="mb-3">Delivery</h3>
                            <div class="form-group mb-3">
                                <label for="recipientName">Recipient Name <span class="required">*</span></label>
                                    <input type="text" class="form-control me-3" id="recipientName" name="recipientName" placeholder="Recipient Name" >
                                    <div id="recipientNameValidationMessage" class="text-danger"></div>

                                    @error('recipientName')
                                    <p class="text-danger">{{ $message }}</p>
                                    @enderror
                            </div>

                            <div class="form-group mb-3">
                                <label for="recipientNumber">Recipient Phone <span class="required">*</span></label>
                                <input type="number" class="form-control me-3 mb-3" id="recipientNumber" name="recipientNumber" placeholder="08XXXXXXXXXX"  >
                                <div id="recipientNumberValidationMessage" class="text-danger"></div>
                                @error('recipientNumber')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="form-group mb-3">
                                <label for="deliveryOptions">Delivery Options</label>
                                <div class="d-flex">
                                    <input type="radio" class="me-2 form-check-input" id="car" name="deliveryOption" value="car" checked onclick="setDeliveryCost('car')">
                                    <label for="car" class="me-3 fs-6">Car (More Safety)</label>

                                    <input type="radio" class="me-2 form-check-input" id="motorcycle" name="deliveryOption" value="motorcycle" onclick="setDeliveryCost('motorcycle')">
                                    <label for="motorcycle" class="me-3 fs-6">Motorcycle</label>
                                </div>
                                <div id="deliveryOptionValidationMessage" class="text-danger"></div>

                                @error('deliveryOption')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="form-group mb-3">
                                <label for="datepicker" class="form-label">Delivery Date <span class="required">*</span></label>
                                <input type="text" class="form-control" id="datepicker" name="datepicker" placeholder="Select date" >
                                
                                <div id="datepickerValidationMessage" class="text-danger"></div>

                                @error('datepicker')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="form-group mb-3">
                                <label for="deliveryTime">Delivery Time <span class="required">*</span></label>
                                <select name="deliveryTime" id="deliveryTime" class="form-control">
                                    <option value="9am - 2pm">9am - 2pm</option>
                                    <option value="3pm - 5pm">3pm - 5pm</option>
                                </select>
                                <div id="deliveryTimeValidationMessage" class="text-danger"></div>

                                @error('deliveryTime')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="form-group mb-3">
                                <label for="province">Province <span class="required">*</span></label>
                                <input type="text" class="form-control me-3 mb-3" id="province" name="province" placeholder="Province" >
                                <div id="provinceValidationMessage" class="text-danger"></div>

                                @error('province')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="form-group mb-3">
                            <label for="city">City <span class="required">*</span></label>
                                <div class="d-flex mb-3">
                                    <input type="text" class="form-control me-3" id="city" name="city" placeholder="City" >
                                    <input type="number" class="form-control" id="postalCode" name="postalCode" placeholder="Postal Code" >
                                </div>
                                <div id="cityValidationMessage" class="text-danger"></div>
                                <div id="postalCodeValidationMessage" class="text-danger"></div>

                                @error('city')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                                @error('postalCode')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="form-group mb-3">
                                <label for="deliveryAddress">Delivery Address <span class="required">*</span></label>
                                <textarea class="form-control" name="deliveryAddress" id="deliveryAddress"  placeholder="Delivery Address" cols="30" rows="5" ></textarea>
                                <div id="deliveryAddressValidationMessage" class="text-danger"></div>

                                @error('deliveryAddress')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>

                            <h3 class="mb-3">Payment</h3>
                            <div class="form-group mb-3">
                                <ul class="accordion">
                                    <li>
                                        <input type="radio" name="paymentMethod" class="ms-3 mt-3 va form-check-input" id="va" value="Bank Transfer" checked>
                                        <label for="va">Bank Transfer BCA</label>
                                        <div class="detailPayment">
                                            <h5 class="mt-2 text-center">Make a transfer to our BCA account</h5>
                                            <h4  class=" text-center">PT Blooming Florist</h4>
                                            <h4  class=" text-center">BCA - 123 12345 123</h4>
                                        </div>
                                    </li>

                                    <li>
                                        <input type="radio" name="paymentMethod" class="ms-3 mt-3 qris form-check-input" id="qris" value="E-Wallet" >
                                        <label for="qris">Payment By QRIS</label>
                                        <div class="detailPayment">
                                            <div class="text-center">
                                                <h5 class="mt-2">Make a Payment to our QRIS</h5>
                                                <img width="250" src="{{ asset('/asset/QrCode.svg') }}" alt="#" /></a>
                                            </div>
                                        </div>
                                    </li>

                                </ul>
                                <div id="paymentMethodValidationMessage" class="text-danger"></div>

                                @error('paymentMethod')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>


                            <button type="submit" class="btn btn-primary">Complete Order</button>

                            <input type="hidden" name="cart_id" value="{{ $cart_items->id }}">
                            <input type="hidden" id="subTotalInput" name="subTotal">
                            <input type="hidden" id="deliveryPriceInput" name="deliveryPrice">
                            <input type="hidden" id="serviceCostInput" name="serviceCost">
                            <input type="hidden" id="totalPriceInput" name="totalPrice">

                        </form>
                    </div>
                </div>
                <div class="col-md-6 col-sm-12 col-xs-12">
                    <table class="table table-striped cart-table">
                        <thead class="thead-dark">
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
                        @for ($i = 0; $i < count($cart_items->cartDetail()->get()); $i++)
                        <tr>
                            <th scope="row">{{$i+1}}</th>
                            <td>
                                @if (Storage::disk('public')->exists($cart_items->cartDetail()->get()[$i]->item()->first()->image))
                                <img src="{{Storage::url($cart_items->cartDetail()->get()[$i]->item()->first()->image)}}" alt="card-image" width="90" height="90">
                                @else
                                <img src="{{asset($cart_items->cartDetail()->get()[$i]->item()->first()->image)}}" alt="card-image" width="90" height="90">
                                @endif
                            <td>{{$cart_items->cartDetail()->get()[$i]->item()->first()->name}}</td>
                            <td>Rp {{ number_format($cart_items->cartDetail()->get()[$i]->item()->first()->price,0,',','.')}}</td>
                            <td class="qty">
                                {{$cart_items->cartDetail()->get()[$i]->qty}}
                            </td>

                            <td class="total-price">Rp {{number_format($cart_items->cartDetail()->get()[$i]->qty*$cart_items->cartDetail()->get()[$i]->item()->first()->price,0,',','.')}}</td>
                          </tr>

                          @endfor
                        </tbody>
                      </table>
                      <div class="d-flex justify-content-between">
                          <h5>Sub Total</h5>
                          <h5><strong id="cart-sum" data-sum="{{ $cart_items->sum }}"> Rp {{number_format($cart_items->sum,0,',','.')}}</strong></h5>
                      </div>
                      <div class="d-flex justify-content-between">
                        <h5 id="deliveryType">Delivery by Car</h5>
                        <h5><strong id="deliveryCost"> Rp 40.000</strong></h5>
                    </div>
                    <div class="d-flex justify-content-between">
                        <h5>Service 2%</h5>
                        <h5><strong id="serviceCost"> Rp 0</strong></h5>
                    </div>
                    <hr>
                    <div class="d-flex justify-content-between mb-5">
                        <h4>Total Price</h4>
                        <h4><strong id="totalPrice"> Rp 0</strong></h4>
                    </div>
                </div>
            </div>
    </div>
</div>

<div id="loadingModal" class="modal">
    <div class="modal-content">
        <div class="loader" id="loader"></div>
        <p id="modalMessage" class="modalMessage">Checking Payment...</p>
    </div>
</div>
@endsection

@section('script')
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
<script async>
  // Initialize datepicker
  $(document).ready(function(){
    $('#datepicker').datepicker({
        format: 'dd MM yyyy',
        autoclose: true,
        startDate: '+0d',
        endDate: '+5m',
        todayBtn: "linked",
        clearBtn: true,
    });


    var deliveryPrice  = 40000;
    calculateServiceCost(deliveryPrice);
    });

document.querySelector('form').addEventListener('submit', function(event) {
    event.preventDefault(); // Prevent form submission if validation fails
    
    if (!validateForm()) {
        return false;
    }
    
    var modal = document.getElementById('loadingModal');
    var loader = document.getElementById('loader');
    var modalMessage = document.getElementById('modalMessage');
    modal.style.display = 'flex';

    // Simulate a payment check process with a timeout
    setTimeout(function() {
        // Hide the loader and show the success message
        loader.style.display = 'none';
        modalMessage.innerHTML  = '<div><i class="fas fa-check-circle check-icon" style="color: #63E6BE;"></i></div> Payment Success!';

        // Further delay to close the modal and submit the form
        setTimeout(function() {
            modal.style.display = 'none';
            event.target.submit();
        }, 2000); // Adjust the time as needed for the success message display
    }, 4000); // Adjust the time as needed
});

     function setDeliveryCost(option) {
        var deliveryCost = document.getElementById('deliveryCost');
        var deliveryType = document.getElementById('deliveryType');
        var deliveryPrice;
        if (option === 'car') {
            deliveryPrice = 40000;
            deliveryCost.innerHTML = new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(deliveryPrice);
            deliveryType.innerHTML = 'Delivery by Car';
        } else if (option === 'motorcycle') {
            deliveryPrice = 20000;
            deliveryCost.innerHTML = new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(deliveryPrice);
            deliveryType.innerHTML = 'Delivery by Motorcycle';
        }
        calculateServiceCost(deliveryPrice);
    }

    function calculateServiceCost(deliveryPrice) {
        var subTotalString = document.getElementById('cart-sum').getAttribute('data-sum');
        var subTotal = parseFloat(subTotalString);
        deliveryPrice = parseFloat(deliveryPrice);

        if (isNaN(subTotal) || isNaN(deliveryPrice)) {
        console.error('Invalid subTotal or deliveryPrice:', subTotalString, deliveryPrice);
        return;
    }
        var serviceCost = Math.round((subTotal + deliveryPrice) * 0.02);

        document.getElementById('serviceCost').innerHTML = new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(serviceCost);

        calculateTotalPrice(subTotal,deliveryPrice,serviceCost);
    }

    function calculateTotalPrice(subTotal,deliveryPrice,serviceCost) {
        var totalPrice = parseFloat(subTotal + deliveryPrice + serviceCost);
        if (isNaN(totalPrice) ) {
            console.error('Invalid totalPrice', totalPrice);
            return;
        }

    document.getElementById('totalPrice').innerHTML = new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(totalPrice);
    document.getElementById('subTotalInput').value = subTotal.toFixed(0);
        document.getElementById('deliveryPriceInput').value = deliveryPrice.toFixed(0);
        document.getElementById('serviceCostInput').value = serviceCost.toFixed(0);
        document.getElementById('totalPriceInput').value = totalPrice.toFixed(0);
    }

 
     // Select the input field and validation message element
     const senderPhoneInput = document.getElementById('senderPhone');
    const recipientNumberInput = document.getElementById('recipientNumber');
    const senderPhoneValidationMessage = document.getElementById('senderPhoneValidationMessage');
    const recipientPhoneValidationMessage = document.getElementById('recipientPhoneValidationMessage');

   //Validate Form
function validateForm() {
    var isValid = true;
    var firstErrorField = null; // To store the first field with validation error

    // Validate email
    var email = document.getElementById('email').value.trim();
    if (!validateEmail(email)) {
        isValid = false;
        displayValidationError('email', 'Please enter a valid email address.');
        if (firstErrorField === null) {
            firstErrorField = 'email';
        }
    } else {
        hideValidationError('email');
    }

    // Validate senderName
    var senderName = document.getElementById('senderName').value.trim();
    if (senderName === '') {
        isValid = false;
        displayValidationError('senderName', 'Sender Name is required.');
        if (firstErrorField === null) {
            firstErrorField = 'senderName';
        }
    } else {
        hideValidationError('senderName');
    }

    // Validate senderPhone
    var senderPhone = document.getElementById('senderPhone').value.trim();
    if (!validatePhoneNumber(senderPhone)) {
        isValid = false;
        displayValidationError('senderPhone', 'Sender Phone must start with "08" and have 10 to 13 digits.');
        if (firstErrorField === null) {
            firstErrorField = 'senderPhone';
        }
    } else {
        hideValidationError('senderPhone');
    }

    // Validate recipientName
    var recipientName = document.getElementById('recipientName').value.trim();
    if (recipientName === '') {
        isValid = false;
        displayValidationError('recipientName', 'Recipient Name is required.');
        if (firstErrorField === null) {
            firstErrorField = 'recipientName';
        }
    } else {
        hideValidationError('recipientName');
    }

    // Validate recipientNumber
    var recipientNumber = document.getElementById('recipientNumber').value.trim();
    if (!validatePhoneNumber(recipientNumber)) {
        isValid = false;
        displayValidationError('recipientNumber', 'Recipient Phone must start with "08" and have 10 to 13 digits.');
        if (firstErrorField === null) {
            firstErrorField = 'recipientNumber';
        }
    } else {
        hideValidationError('recipientNumber');
    }

    // Validate deliveryOption
    var deliveryOption = document.querySelector('input[name="deliveryOption"]:checked');
    if (!deliveryOption) {
        isValid = false;
        displayValidationError('deliveryOption', 'Please select a delivery option.');
        if (firstErrorField === null) {
            firstErrorField = 'deliveryOption';
        }
    } else {
        hideValidationError('deliveryOption');
    }

    // Validate datepicker (delivery date)
    var deliveryDate = document.getElementById('datepicker').value.trim();
    if (deliveryDate === '') {
        isValid = false;
        displayValidationError('datepicker', 'Delivery Date is required.');
        if (firstErrorField === null) {
            firstErrorField = 'datepicker';
        }
    } else {
        hideValidationError('datepicker');
    }

    // Validate deliveryTime
    var deliveryTime = document.getElementById('deliveryTime').value.trim();
    if (deliveryTime === '') {
        isValid = false;
        displayValidationError('deliveryTime', 'Please select a delivery time.');
        if (firstErrorField === null) {
            firstErrorField = 'deliveryTime';
        }
    } else {
        hideValidationError('deliveryTime');
    }

    // Validate province
    var province = document.getElementById('province').value.trim();
    if (province === '') {
        isValid = false;
        displayValidationError('province', 'Province is required.');
        if (firstErrorField === null) {
            firstErrorField = 'province';
        }
    } else {
        hideValidationError('province');
    }

    // Validate city
    var city = document.getElementById('city').value.trim();
    if (city === '') {
        isValid = false;
        displayValidationError('city', 'City is required.');
        if (firstErrorField === null) {
            firstErrorField = 'city';
        }
    } else {
        hideValidationError('city');
    }

    // Validate postalCode
    var postalCode = document.getElementById('postalCode').value.trim();
    if (postalCode === '') {
        isValid = false;
        displayValidationError('postalCode', 'Postal Code is required.');
        if (firstErrorField === null) {
            firstErrorField = 'postalCode';
        }
    } else if (postalCode.length > 7) {
        isValid = false;
        displayValidationError('postalCode', 'Postal Code should not exceed 7 characters.');
        if (firstErrorField === null) {
            firstErrorField = 'postalCode';
        }
    } else {
        hideValidationError('postalCode');
    }

    // Validate deliveryAddress
    var deliveryAddress = document.getElementById('deliveryAddress').value.trim();
    if (deliveryAddress === '') {
        isValid = false;
        displayValidationError('deliveryAddress', 'Delivery Address is required.');
        if (firstErrorField === null) {
            firstErrorField = 'deliveryAddress';
        }
    } else {
        hideValidationError('deliveryAddress');
    }

    // Validate paymentMethod
    var paymentMethod = document.querySelector('input[name="paymentMethod"]:checked');
    if (!paymentMethod) {
        isValid = false;
        displayValidationError('paymentMethod', 'Please select a payment method.');
        if (firstErrorField === null) {
            firstErrorField = 'paymentMethod';
        }
    } else {
        hideValidationError('paymentMethod');
    }

    // Scroll to the first error field if validation fails
    if (firstErrorField) {
        scrollToField(firstErrorField);
    }

    return isValid;
}

// Function to scroll to the specified field
function scrollToField(fieldId) {
    var element = document.getElementById(fieldId);
    if (element) {
        element.scrollIntoView({ behavior: 'smooth', block: 'center' });
        element.classList.add('highlight-error');
    }
}


function validateEmail(email) {
    // Regular expression for email validation
    var re = /\S+@\S+\.\S+/;
    return re.test(email);
}

function validatePhoneNumber(phoneNumber) {
    // Regular expression for phone number validation
    var re = /^08[0-9]{8,11}$/;
    return re.test(phoneNumber);
}

function displayValidationError(fieldId, message) {
    // Display error message for the specified field
    var validationMessage = document.getElementById(fieldId + 'ValidationMessage');
    if (validationMessage) {
        validationMessage.textContent = message;
    }
    var inputField = document.getElementById(fieldId);
    if (inputField) {
        inputField.classList.add('highlight-error');
    }
}

function hideValidationError(fieldId) {
    // Clear error message and remove highlight for the specified field
    var validationMessage = document.getElementById(fieldId + 'ValidationMessage');
    if (validationMessage) {
        validationMessage.textContent = '';
    }
    var inputField = document.getElementById(fieldId);
    if (inputField) {
        inputField.classList.remove('highlight-error');
    }
}

document.querySelectorAll('input, select, textarea').forEach(function(input) {
    input.addEventListener('input', function() {
        var fieldId = input.id;
            if (fieldId === 'senderPhone' || fieldId === 'recipientNumber') {
                // Validate phone number dynamically
                var phoneNumber = input.value.trim();
                if (!validatePhoneNumber(phoneNumber)) {
                    displayValidationError(fieldId, 'Phone number must start with "08" and have 10 to 13 digits.');
                } else {
                    hideValidationError(fieldId);
                }
            }else if(fieldId === 'email'){
                var email = input.value.trim();
                if (!validateEmail(email)) {
                    displayValidationError(fieldId, 'Please enter a valid email address.');
                } else {
                    hideValidationError(fieldId);
                }
            } else {
                hideValidationError(fieldId); // Hide error for other fields on input change
            }
    });
});

$('#datepicker').on('changeDate', function(e) {
        if (e.date) {
            hideValidationError('datepicker'); // Call hideValidationError when date is selected
        }
    });

</script>
@endsection
