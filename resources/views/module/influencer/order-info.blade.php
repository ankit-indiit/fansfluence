@extends('layout.master')
@section('content')
{{ Breadcrumbs::render('order-info', $influencer) }}
<section class="pt-5 pb-5 order-details-section section-full-height">
    <div class="container">
        @php
            $product = Session::get('product');
        @endphp
        <div class="d-flex mb-4">
            {{-- <h3 class="section-title">{!! bussIcon($influencer->id) !!} Personalized {{ $product['product'] }}  --}}
            <h3 class="section-title"> Personalized {{ $product['product'] }} 
                <span class="section-sb-title">
                @if ($product['mark'] != '')
                    ({{ $product['mark'] }})
                @endif
                @if ($product['product_type'] != '')
                    ({{ $product['product_type'] }})
                @endif
                </span>
            </h3>
        </div>
        <form
            class="row g-lg-4 g-3 order-details-form"
            action="{{ route('save.order-info') }}"
            method="post"
            id="paymentDetailForm"
        >
            @csrf
            <div class="col-md-6">
                <label for="" class="form-label">Who is this {{$product['product']}} for? <span>(Optional)</span></label>
                <input type="text" class="form-control" name="product_for" placeholder="Enter name">
            </div>
            <div class="col-md-6">
                <label for="" class="form-label thisFrom">Who is this {{$product['product']}} from? <span>(Optional)</span></label>
                <input type="text" class="form-control" name="product_from" placeholder="Smith">
                <div class="form-text text-end">Max 75 Characters</div>
            </div>
            @switch ($product['product'])
                @case('Photo')                    
                    @php
                        $data = $profileDetail->photo_question;                       
                    @endphp                    
                @break
                @case('Video')                    
                    @php
                        $data = $profileDetail->video_question;
                    @endphp
                @break
                @default                    
                    @php                       
                        $data = $profileDetail->post_question;
                    @endphp
                @break
            @endswitch
            <div class="col-12">
                <label for="" class="form-label">Details from {{$influencer->name}} to follow</label>
                <textarea type="text" class="form-control from-follow" name="to_follow" placeholder="Type here" readonly>{{@$data['desc']}}</textarea>
            </div>  
            <div class="col-12">
                <label for="" class="form-label toFollow">Details for {{ $influencer->name }} to follow</label>
                <textarea type="text" class="form-control" name="product_desc" placeholder="Type here"></textarea>
                <div class="form-text text-end">Max 750 Characters</div>
            </div>           
            @switch ($product['product'])
                @case('Photo')                    
                    @include('module.component.order-info-sec', [
                        'data' => $profileDetail->photo_question
                    ])
                @break
                @case('Video')                    
                    @include('module.component.order-info-sec', [
                        'data' => $profileDetail->video_question
                    ])
                @break
                @default                    
                    @include('module.component.order-info-sec', [
                        'data' => $profileDetail->post_question
                    ])
                @break
            @endswitch            
            <div class="col-12">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="visibility" id="gridCheck">
                    <label class="form-check-label" for="gridCheck" name="display_to">
                        Please don’t display this photo on {{ $influencer->name }}’s page
                    </label>
                </div>
            </div>            
            <div class="col-12 text-end mt-sm-5 mt-4">
                <button
                    type="submit"
                    class="btn custom-btn-main"
                    id="paymentDetailFormBtn"
                >
                    Continue To Payment
                </button>
            </div>
        </form>
    </div>
</section>
@endsection
@section('customScript')
<script src="{{ asset('assets/js/jquery.validate.min.js') }}"></script>
<script type="text/javascript">
    $(document).on('keyup', '.qus1', function(){
        if ($(this).val() != '') {
            $('.qus1').css({'border': '1px solid #E5E0EB'});
        }
    });

    $(document).on('keyup', '.qus2', function(){
        if ($(this).val() != '') {
            $('.qus2').css({'border': '1px solid #E5E0EB'});
        }
    });

    $("#paymentDetailForm").validate({
        rules: {           
            product_from: {
                required: {
                    depends: function (element) {
                        return $(".thisFrom").is(":filled");
                    }
                },
                maxlength: 75
            },
            product_desc: {
                required: {
                    depends: function (element) {
                        return $(".thisFrom").is(":filled");
                    }
                },
                maxlength: 750
            },              
        },
        messages: {
            product_from: {
                required: "Please enter name!",
                maxlength: "Max 75 characters required!"
            },
            product_desc: {
                required: "Please enter detail!",
                maxlength: "Max 750 characters required!"
            },
        },
        submitHandler: function(form) {
            if ($('.qus1').val() == '') {
                $('.qus1').css({'border': '2px solid red'});
                $('.qus1').focus();
                return false;
            }
            if ($('.qus2').val() == '') {
                $('.qus2').css({'border': '2px solid red'});
                $('.qus2').focus();
                return false;
            }
            $('#paymentDetailFormBtn').attr('disabled', true);
            $('#paymentDetailFormBtn').html('Processing <i class="fa fa-spinner fa-spin"></i>');
            form.submit();
            setTimeout(function(){                     
                formButton();
            }, 500)
        }, 
    });

    function formButton() {
        $('#paymentDetailFormBtn').attr('disabled', false);
        $('#paymentDetailFormBtn').html('Processing <i class="fa fa-check"></i>');
    }
</script>
@endsection