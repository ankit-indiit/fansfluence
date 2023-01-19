@extends('layout.master')
@section('content')
{{ Breadcrumbs::render('paypal-payment', getUserById($order->orderDetail->influencer_id)) }}
<section class="pt-5 pb-5 order-details-section section-full-height">
    <div class="container">
        <div class="d-flex justify-content-center mb-4">
            {{-- <h3 class="section-title">{!! bussIcon($order->orderDetail->influencer_id) !!} Personalized {{ $order->product }}  --}}
            <h3 class="section-title"> Personalized {{ $order->product }} 
                <span class="section-sb-title">
                    @if ($order->mark != '')
                        ({{ $order->mark }})
                    @elseif ($order->product_type != '')
                        ({{ $order->product_type }})
                    @endif
                </span>
                <br>
                <span class="d-flex justify-content-center">${{ $order->product_price }}</span>
            </h3>
        </div>             
        <form action="{{ route('paypalTransaction') }}" method="post">
            @csrf
            <input type="hidden" name="price" value="{{ $order->product_price }}">
            <input type="hidden" name="order_id" value="{{ $order->id }}">
            <div class="paypalBtnSec">
                <div class="col-12 text-center mt-sm-5 mt-4">
                    <button class="btn custom-btn-main" type="submit">Make Payment</button>
                </div>
            </div>            
        </form>
    </div>
</section>
@endsection
@section('customScript')
<script src="{{ asset('assets/js/jquery.validate.min.js') }}"></script>
<script type="text/javascript" src="https://js.stripe.com/v2/"></script>
<script type="text/javascript">
       
</script>
@endsection