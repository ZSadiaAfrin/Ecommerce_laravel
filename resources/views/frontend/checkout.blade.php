@extends('frontend.master')
@section('content')
    <section class="middle">
        <div class="container">

            <div class="row">
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                    <div class="text-center d-block mb-5">
                        <h2>Checkout</h2>
                    </div>
                </div>
            </div>

            <div class="row justify-content-between">

                <div class="col-12 col-lg-7 col-md-12">

                    <form action="{{route('order.store')}}" method="POST">
                        @csrf
                        <h5 class="mb-4 ft-medium">Billing Details</h5>
                        <div class="row mb-2">

                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                                <div class="form-group">
                                    <label class="text-dark">Full Name *</label>
                                    <input type="text" class="form-control" readonly
                                        value="{{ Auth::guard('customerlogin')->user()->name }}" />
                                </div>
                            </div>
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                <div class="form-group">
                                    <label class="text-dark">Email *</label>
                                    <input type="email" class="form-control" readonly
                                        value="{{ Auth::guard('customerlogin')->user()->email }}" />
                                </div>
                            </div>

                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                <div class="form-group">
                                    <label class="text-dark">Company</label>
                                    <input name="company" type="text" class="form-control"
                                        placeholder="Company Name (optional)" />
                                </div>
                            </div>
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                <div class="form-group">
                                    <label class="text-dark">Mobile Number *</label>
                                    <input type="hidden" name='customer_id'value="{{Auth::guard('customerlogin')->id()}}">
                                    <input name="billing_mobile" type="number" class="form-control"
                                        placeholder="Mobile Number" />
                                </div>
                            </div>
                        </div>
                        <h5 class="mb-4 ft-medium">Shipping Details</h5>
                        <div class="row mb-2">

                            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12">
                                <div class="form-group">
                                    <label class="text-dark">Full Name *</label>
                                    <input name="name" type="text" class="form-control"
                                        value="{{ Auth::guard('customerlogin')->user()->name }}" />
                                </div>
                            </div>
                            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-6 col-12">
                                <div class="form-group">
                                    <label class="text-dark">Email *</label>
                                    <input name="email" type="email" class="form-control"
                                        value="{{ Auth::guard('customerlogin')->user()->email }}" />
                                </div>
                            </div>
                            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-6 col-12">
                                <div class="form-group">
                                    <label class="text-dark">Mobile Number *</label>
                                    <input name="mobile" type="number" class="form-control" placeholder="Mobile Number" />
                                </div>
                            </div>


                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                                <div class="form-group">
                                    <label class="text-dark">Country *</label>
                                    <select class="custom-select country" name=country_id>
                                        <option value="">-- Select Country --</option>
                                        @foreach ($countries as $country)
                                            <option value="{{ $country->id }}">{{ $country->name }}</option>
                                        @endforeach


                                    </select>
                                </div>
                            </div>

                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                                <div class="form-group">
                                    <label class="text-dark">City *</label>
                                    <select class="custom-select  city" name=city_id>
                                        <option value="">-- Select City --</option>

                                    </select>
                                </div>
                            </div>
                            <div class="col-xl-8 col-lg-8 col-md-8 col-sm-12 col-12">
                                <div class="form-group">
                                    <label class="text-dark">Address *</label>
                                    <input name="address" type="text" class="form-control"
                                        value="{{ Auth::guard('customerlogin')->user()->address }}" />
                                </div>
                            </div>
                            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-6 col-12">
                                <div class="form-group">
                                    <label class="text-dark">ZIP / Postcode *</label>
                                    <input name="zip" type="text" class="form-control"
                                        placeholder="Zip / Postcode" />
                                </div>
                            </div>

                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                <div class="form-group">
                                    <label class="text-dark">Additional Information</label>
                                    <textarea name="notes" class="form-control ht-50"></textarea>
                                </div>
                            </div>

                        </div>

                </div>

                <!-- Sidebar -->
                <div class="col-12 col-lg-4 col-md-12">
                    <div class="d-block mb-3">
                        <h5 class="mb-4">Order Items ({{ $carts->count() }})</h5>
                        <ul class="list-group list-group-sm list-group-flush-y list-group-flush-x mb-4">

                            <li class="list-group-item">
                                @php
                                    $sub_total = 0;

                                @endphp
                                @foreach ($carts as $cart)
                                    <div class="row align-items-center">
                                        <div class="col-3">
                                            <!-- Image -->
                                            <a href="product.html"><img
                                                    src="{{ asset('uploads/product/preview') }}/{{ $cart->rel_to_product->preview }}"
                                                    alt="..." class="img-fluid"></a>
                                        </div>
                                        <div class="col d-flex align-items-center">
                                            <div class="cart_single_caption pl-2">
                                                <h4 class="product_title fs-md ft-medium mb-1 lh-1">
                                                    {{ $cart->rel_to_product->preview }}</h4>
                                                <p class="mb-1 lh-1"><span
                                                        class="text-dark">{{ $cart->rel_to_size->size_name }}</span></p>
                                                <p class="mb-3 lh-1"><span
                                                        class="text-dark">{{ $cart->rel_to_color->color_name }}</span></p>
                                                <h4 class="fs-md ft-medium mb-3 lh-1">
                                                    &#2547;{{ $cart->rel_to_product->after_discount }}</h4>
                                            </div>
                                        </div>
                                    </div>
                                    @php
                                        $sub_total += $cart->rel_to_product->after_discount * $cart->quantity;

                                    @endphp
                                @endforeach
                            </li>



                        </ul>
                    </div>

                    <div class="mb-4">
                        <div class="form-group">
                            <h6>Delivery Location</h6>
                            <ul class="no-ul-list">
                                <li>
                                    <input id="c1" class="radio-custom charge" name="charge" type="radio"
                                        value="60">
                                    <label for="c1" class="radio-custom-label">Inside City</label>
                                </li>
                                <li>
                                    <input id="c2" class="radio-custom charge" name="charge" type="radio"
                                        value="120">
                                    <label for="c2" class="radio-custom-label">Outside City</label>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="mb-4">
                        <div class="form-group">
                            <h6>Select Payment Method</h6>
                            <ul class="no-ul-list">
                                <li>
                                    <input id="c3" value="1" class="radio-custom" name="payment_method"
                                        type="radio">
                                    <label for="c3" class="radio-custom-label">Cash on Delivery</label>
                                </li>
                                <li>
                                    <input id="c4" value="2" class="radio-custom" name="payment_method"
                                        type="radio">
                                    <label for="c4" class="radio-custom-label">Pay With SSLCommerz</label>
                                </li>
                                <li>
                                    <input id="c5" value="3" class="radio-custom" name="payment_method"
                                        type="radio">
                                    <label for="c5" class="radio-custom-label">Pay With Stripe</label>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <div class="card mb-4 gray">
                        <div class="card-body">
                            <ul class="list-group list-group-sm list-group-flush-y list-group-flush-x">
                                <li class="list-group-item d-flex text-dark fs-sm ft-regular">
                                    <span>Subtotal</span> <span
                                        class="ml-auto text-dark ft-medium">&#2547;{{ $sub_total }}</span>
                                </li>
                                <li class="list-group-item d-flex text-dark fs-sm ft-regular">
                                    <span>Discount</span> <span
                                        class="ml-auto text-dark ft-medium">&#2547;{{ session('discount') }}</span>
                                </li>
                                <li class="list-group-item d-flex text-dark fs-sm ft-regular">
                                    <span>Charge</span> <span class="ml-auto text-dark ft-medium">&#2547;<span
                                            id="charge">0</span></span>
                                </li>
                                <li class="list-group-item d-flex text-dark fs-sm ft-regular">
                                    <span>Total</span> <span class="ml-auto text-dark ft-medium">&#2547;<span
                                            id="grand_total">{{ $sub_total - session('discount') }}</span></span>
                                </li>
                            </ul>
                        </div>
                    </div>


                    <input type="hidden" class="discount" name="discount" value="{{ session('discount') }}">
                    <input type="hidden" class="sub_total" name="sub_total" value="{{ $sub_total }}">

                    <button type="submit" class="btn btn-block btn-dark mb-3">Place Your Order</button>
                </form>
                </div>

            </div>

        </div>
    </section>
    <!-- ======================= Product Detail End ======================== -->

    <!-- ============================= Customer Features =============================== -->
    <section class="px-0 py-3 br-top">
        <div class="container">
            <div class="row">

                <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6">
                    <div class="d-flex align-items-center justify-content-start py-2">
                        <div class="d_ico">
                            <i class="fas fa-shopping-basket theme-cl"></i>
                        </div>
                        <div class="d_capt">
                            <h5 class="mb-0">Free Shipping</h5>
                            <span class="text-muted">Capped at $10 per order</span>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6">
                    <div class="d-flex align-items-center justify-content-start py-2">
                        <div class="d_ico">
                            <i class="far fa-credit-card theme-cl"></i>
                        </div>
                        <div class="d_capt">
                            <h5 class="mb-0">Secure Payments</h5>
                            <span class="text-muted">Up to 6 months installments</span>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6">
                    <div class="d-flex align-items-center justify-content-start py-2">
                        <div class="d_ico">
                            <i class="fas fa-shield-alt theme-cl"></i>
                        </div>
                        <div class="d_capt">
                            <h5 class="mb-0">15-Days Returns</h5>
                            <span class="text-muted">Shop with fully confidence</span>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6">
                    <div class="d-flex align-items-center justify-content-start py-2">
                        <div class="d_ico">
                            <i class="fas fa-headphones-alt theme-cl"></i>
                        </div>
                        <div class="d_capt">
                            <h5 class="mb-0">24x7 Fully Support</h5>
                            <span class="text-muted">Get friendly support</span>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>
@endsection
@section('footer_script')
    <script>
        $('.charge').click(function() {
            var charge = $(this).val();
            var discount = $('.discount').val();
            var sub_total = $('.sub_total').val();
            var total = sub_total - discount + parseInt(charge);
            $('#grand_total').html(total);
            $('#charge').html(charge);

        });
        //Select2
        $(document).ready(function() {
            $('.country').select2();
            $('.city').select2();
        });
    </script>

    <script>
        $('.country').change(function() {
            var country_id = $(this).val();

            //  alert(country_id);

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                type: 'POST',
                url: '/getCity',
                data: {
                    'country_id': country_id
                },

                success: function(data) {
                    $('.city').html(data);

                }
            });
        });
    </script>
@endsection
