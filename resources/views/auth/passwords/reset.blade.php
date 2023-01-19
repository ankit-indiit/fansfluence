@extends('layout.master')
@section('content')
<section class="pt-5 pb-5 account-section login-section">
   <div class="container">
      <div class="d-flex mb-4">
         <h3 class="section-title">Reset Password</h3>
      </div>
      <div class="row account-box">
         <div class="col-lg-6 col-md-12 account-bg-img ">
            <div class="account-box-info">
               <h2>Let’s Connect</h2>
               <p>Fansfluence focuses on providing a way for ordinary people and business to contact influencers for personalized videos, pictures, and social media post.</p>
            </div>
         </div>
         <div class="col-lg-6">
            <div class="account-box-form">
               <form method="POST" action="{{ route('password.update') }}" id="passwordUpdate">
                    @csrf
                    <input type="hidden" name="token" value="{{ $token }}">
                    <div class="row mb-3">
                        <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Email Address') }}</label>

                        <div class="col-md-6">
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $email ?? old('email') }}" autocomplete="email" readonly autofocus>

                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="password" class="col-md-4 col-form-label text-md-end">{{ __('Password') }}</label>

                        <div class="col-md-6">
                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" autocomplete="new-password">

                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="password-confirm" class="col-md-4 col-form-label text-md-end">{{ __('Confirm Password') }}</label>

                        <div class="col-md-6">
                            <input id="password-confirm" type="password" class="form-control" name="password_confirmation" autocomplete="new-password">
                        </div>
                    </div>

                    <div class="row mb-0">
                        <div class="text-center">
                            <button type="submit" class="btn custom-btn-main" id="passwordUpdateBtn" style="width: 326px;">
                                {{ __('Reset Password') }}
                            </button>
                        </div>
                    </div>
                    <p class="text-center my-4">
                        <span class="text-secondary">Back to </span>
                        <a class="text-danger" href="{{ route('login') }}">Sign In</a>
                    </p>       
                </form>                   
            </div>
         </div>
      </div>
   </div>    
</section>
@endsection
@section('customScript')
<script src="{{ asset('assets/js/jquery.validate.min.js') }}"></script>
<script type="text/javascript">   
    $("#passwordUpdate").validate({    
        rules: {        
            email: {
                required: true,
            },
            password: {
                required: true,
                minlength: 5,
            },
            password_confirmation: {
                required: true,
                minlength: 5,
                equalTo: '[name="password"]'
            },     
        },
        messages: {
            email: "Please enter email!",        
            password: {
                required: "Please enter password!",  
                minlength: "Length must be at least 5 characters!",  
            },     
            password_confirmation: {
                required: "Please enter confirm password!",  
                minlength: "Length must be at least 5 characters!",  
                equalTo: "Password and confirm password must be matched!",  
            },        
        },        
        submitHandler: function(form) {
            $('#passwordUpdateBtn').attr('disabled', true);
            $('#passwordUpdateBtn').html('Processing <i class="fa fa-spinner fa-spin"></i>');
            form.submit();
            setTimeout(function(){                     
                formButton();
            }, 2000)
        } 
    });

    function formButton() {
        $('#passwordUpdateBtn').attr('disabled', false);
        $('#passwordUpdateBtn').html('Processing <i class="fa fa-check"></i>');
        console.log('working');
    }
</script>
@endsection

{{-- @extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Reset Password') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('password.update') }}">
                        @csrf

                        <input type="hidden" name="token" value="{{ $token }}">

                        <div class="row mb-3">
                            <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Email Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $email ?? old('email') }}" required autocomplete="email" autofocus>

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="password" class="col-md-4 col-form-label text-md-end">{{ __('Password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-end">{{ __('Confirm Password') }}</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                            </div>
                        </div>

                        <div class="row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Reset Password') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection --}}
