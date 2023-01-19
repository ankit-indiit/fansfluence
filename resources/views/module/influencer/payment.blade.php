@extends('layout.master')
@section('content')
{{ Breadcrumbs::render('payment-detail', $influencer) }}
<section class="pt-5 pb-5 order-details-section section-full-height">
    <div class="container">
        <div class="d-flex mb-4">
            <h3 class="section-title">{{--{!! bussIcon($influencer->id) !!}--}} Payment Details</h3>            
        </div>
        
        <form 
            role="form" 
            action="{{ route('stripe.post') }}" 
            method="post" 
            class="require-validation"
            data-cc-on-file="false"
            data-stripe-publishable-key="{{ env('STRIPE_TEST_KEY') }}"
            id="payment-form"
        >
            @csrf
            <div class="col-md-12">
                <div class="payment-options d-flex mb-3">
                    <div class="form-check">
                        <input
                            class="form-check-input paymentCheckbox"
                            type="radio"
                            name="paymentCheckbox"
                            id="paypalCheckbox"
                            value="paypal"
                        >
                        <label class="form-check-label" for="paypalCheckbox">
                            <img src="{{ asset('assets/img/paypal-icon.svg') }}">
                        </label>
                    </div>
                    <div class="form-check">
                        <input
                            class="form-check-input paymentCheckbox"
                            type="radio"
                            name="paymentCheckbox"
                            id="stripeCheckbox"
                            value="stripe"
                            checked
                        >
                        <label class="form-check-label" for="stripeCheckbox">
                            <img src="{{ asset('assets/img/stripe-icon.svg') }}">
                        </label>
                    </div>                
                </div>
            </div>
            <div class="formSec">
                <div class='form-row row'>
                    <div class='col-md-6 form-group required'>
                        <label class='control-label'>Name on Card</label> 
                        <input
                            class='form-control' name="card_holder" size='4' type='text'>
                    </div>
                
                    <div class='col-md-6 form-group required'>
                        <label class='control-label'>Card Number</label>
                        <input
                            autocomplete='off' name="card_number" class='form-control card-number' size='20'
                            type='text'>
                    </div>
                
                    <div class='col-md-3 form-group expiration required mt-4'>
                        <label class='control-label'>Expiration Month</label>
                        <input
                            class='form-control card-expiry-month' name="exp_month" placeholder='MM' size='2'
                            type='text'>
                    </div>
                    <div class='col-md-3 form-group expiration required mt-4'>
                        <label class='control-label'>Expiration Year</label>
                        <input
                            class='form-control card-expiry-year' name="exp_year" placeholder='YYYY' size='4'
                            type='text'>
                    </div>
                    <div class='col-md-6 form-group cvc required mt-4'>
                        <label class='control-label'>CVC</label>
                        <input autocomplete='off'
                            class='form-control card-cvc' name="cvc" placeholder='ex. 311' size='4'
                            type='text'>
                    </div>
                </div>
                
                <input type="hidden" name="price" value="{{ Session::get('product')['product_price'] }}">
                <div class="row">
                    <div class='col-md-8 mt-sm-5 mt-4'>
                        <div class="error form-group hide-error">
                            <div class='alert-danger alert card-errors'>
                                Please correct the errors and try
                                again.
                            </div>                            
                        </div>
                    </div>
                    <div class="col-4 text-end mt-sm-5 mt-4">
                        <button class="btn custom-btn-main confirmPayment" type="submit" disabled="disabled">Send Request</button>
                    </div>
                </div>
            </div>
        </form>
        <form action="{{ route('paypalRequest') }}" id="paypalRequest" method="post">
            @csrf
            <input type="hidden" name="price" value="{{ Session::get('product')['product_price'] }}">
            <div class="paypalBtnSec d-none">
                <p class="text-center my-5 text-secondary">Once your request accepted by the influencer,<br> You will get the payment link on your registered<br> email to process with the payment.</p>
                <div class="col-12 d-flex justify-content-end">
                    <button
                        class="btn custom-btn-main paypalRequestBtn"
                        type="submit"
                    >
                        Send Request
                    </button>
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
    $(document).ready(function(){
        $('.confirmPayment').attr('disabled', false);
    });

    $(document).on('change', '.paymentCheckbox', function(){
        var method = $(this).val();
        if (method == 'paypal') {
            $('.formSec').addClass('d-none');
            $('.paypalBtnSec').removeClass('d-none');
        } 
        if (method == 'stripe') {
            $('.formSec').removeClass('d-none');
            $('.paypalBtnSec').addClass('d-none');
        }
    });

    // $("#payment-form").validate({    
    //     rules: {
    //         card_holder: {
    //             required: true,
    //         },
    //         card_number: {
    //             required: true,
    //             number: true,
    //             maxlength: 16
    //         },
    //         exp_month: {
    //             required: true,
    //             number: true,
    //             maxlength: 2
    //         },
    //         exp_year: {
    //             required: true,
    //             number: true,
    //             maxlength: 4
    //         },  
    //         cvc: {
    //             required: true,
    //             number: true,
    //             maxlength: 3
    //         },              
    //     },
    //     messages: {
    //         card_holder: "Please enter name!",
    //         card_number: {
    //             required: "Please enter card number!",
    //             number: "Only numeric values are allowed!",
    //             maxlength: "Card number can't be longer than 16 digits"
    //         },
    //         exp_month: {
    //             required: "Please enter expiration number!",
    //             number: "Only numeric values are allowed!",
    //             maxlength: "Expiration month can't be longer than 2 digits"
    //         },       
    //         exp_year: {
    //             required: "Please enter expiration number!",
    //             number: "Only numeric values are allowed!",
    //             maxlength: "Expiration year can't be longer than 4 digits"
    //         },     
    //         cvc: {
    //             required: "Please enter card number!",
    //             number: "Only numeric values are allowed!",
    //             maxlength: "CVC number can't be longer than 3 digits"
    //         },       
    //     },
    //     submitHandler: function(form, e) {
    //         e.preventDefault();
    //         var serializedData = new FormData(form);
    //         $('.confirmPayment').attr('disabled', true);
    //         $('.confirmPayment').html('Processing <i class="fa fa-spinner fa-spin"></i>');
    //         $.ajax({
    //             headers: {
    //               'X-CSRF-Token': $('input[name="_token"]').val()
    //             },
    //             type: 'post',
    //             url: "{{-- route('stripe.post') --}}",
    //             data: serializedData,
    //             dataType: 'json',
    //             processData: false,
    //             contentType: false,
    //             cache: false,
    //             success: function(data) {
    //                 if (data.status == true) {
    //                     $('.confirmPayment').attr('disabled', true);
    //                     $('.confirmPayment').html('Processing <i class="fa fa-spinner fa-spin"></i>');
    //                     $('.successMsg').html(data.message);
    //                     $("#successModel").modal("show");
    //                     $('.okMsgBtn').on('click', function(){
    //                         window.location.href = data.link;
    //                     });
    //                 } else {
    //                     $('.errorMsg').html(data.message);
    //                     $("#errorModel").modal("show");
    //                 }
    //             }
    //         });
    //         return false;            
    //     },  
    // });

    $("#paypalRequest").validate({    
        rules: {
                        
        },
        messages: {
           
        },
        submitHandler: function(form, e) {
            e.preventDefault();
            var serializedData = new FormData(form);
            $('.paypalRequestBtn').attr('disabled', true);
            $('.paypalRequestBtn').html('Processing <i class="fa fa-spinner fa-spin"></i>');
            $.ajax({
                headers: {
                  'X-CSRF-Token': $('input[name="_token"]').val()
                },
                type: 'post',
                url: "{{ route('paypalRequest') }}",
                data: serializedData,
                dataType: 'json',
                processData: false,
                contentType: false,
                cache: false,
                success: function(data) {
                    if (data.status == true) {
                        $('.paypalRequestBtn').attr('disabled', true);
                        $('.paypalRequestBtn').html('Processing <i class="fa fa-spinner fa-spin"></i>');
                        $('.successMsg').html(data.message);
                        $("#successModel").modal("show");
                        $('.okMsgBtn').on('click', function(){
                            window.location.href = data.link;
                        });
                    } else {
                        $('.errorMsg').html(data.message);
                        $("#errorModel").modal("show");
                    }
                }
             });
             return false;        
        },  
    });

    $(function() {
       
        var $form = $(".require-validation");
       
        $('form.require-validation').bind('submit', function(e) {
            var $form = $(".require-validation"),
            inputSelector = [
                'input[type=email]', 'input[type=password]',
                'input[type=text]', 'input[type=file]',
                'textarea'
            ].join(', '),
            $inputs = $form.find('.required').find(inputSelector),
            $errorMessage = $form.find('div.error'),
            valid = true;
            $errorMessage.addClass('hide-error');
      
            $('.has-error').removeClass('has-error');
            $inputs.each(function(i, el) {
              var $input = $(el);
              if ($input.val() === '') {
                $input.parent().addClass('has-error');
                $errorMessage.removeClass('hide-error');
                e.preventDefault();
              }
            });
       
            if (!$form.data('cc-on-file')) {
              e.preventDefault();
              Stripe.setPublishableKey($form.data('stripe-publishable-key'));
              Stripe.createToken({
                number: $('.card-number').val(),
                cvc: $('.card-cvc').val(),
                exp_month: $('.card-expiry-month').val(),
                exp_year: $('.card-expiry-year').val()
              }, stripeResponseHandler);
            }
      
      });
      
      function stripeResponseHandler(status, response) {
            if (response.error) {
                $('.error')
                    .removeClass('hide-error')
                    .find('.alert')
                    .text(response.error.message);
            } else {
                /* token contains id, last4, and card type */
                var token = response['id'];
                   
                $form.find('input[type=text]').empty();
                $form.append("<input type='hidden' name='stripeToken' value='" + token + "'/>");
                $form.get(0).submit();
            }
        }
    });    
</script>
@endsection