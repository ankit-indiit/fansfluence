@extends('layout.master')
@section('content')
<section class="pt-5 pb-5 account-section login-section">
   <div class="container">
      <div class="d-flex mb-4">
         <h3 class="section-title">Login</h3>
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
               {{ Form::open(['url' => route('userLogin'), 'id' => 'loginUserForm']) }}
               <div class="account-head">
                  <h2>Welcome!</h2>
                  <h3>Log Into Your Account</h3>
               </div>
               <div class="form-group">
                  {{ Form::label('email', 'Email', ['class' => 'form-label']) }}
                  {{ Form::text('email', old('email'), ['class' => 'form-control', 'id' => '', 'placeholder' => 'Enter Email']) }}
               </div>
               <div class="form-group">
                  {{ Form::label('password', 'Password', ['class' => 'form-label']) }}
                  {{ Form::password('password', ["class" => "form-control", "autocomplete" => "off", 'placeholder' => 'Enter Password']) }}
               </div>
                <div class="checkbox form-group">
                    <div class="form-check float-start mb-0">
                        <input class="form-check-input" type="checkbox" name="remember" id="rememberme" {{ old('remember') ? 'checked' : '' }}>
                        <label class="form-check-label" for="rememberme">
                            {{ __('Remember Me') }}
                        </label>
                    </div>
                    @if (Route::has('password.request'))
                        <a class="float-end forgot-password" href="{{ route('password.request') }}">
                            {{ __('Forgot Password?') }}
                        </a>
                    @endif 
                </div>
               <div class="mt-sm-5">
                    {{ Form::button('Login', [
                        'class' => 'btn custom-btn-main w-100',
                        'id' => 'loginUserBtn',
                        'type' => 'submit'
                    ]) }}
               </div>
               <div class="text-center mt-4">
                  <p>Don't have an account? 
                    <a class="text-danger" href="{{ route('register') }}">Sign up here</a>
                </p>
               </div>
            {{ Form::close() }}   
            </div>
         </div>
      </div>
   </div>
</section>
@endsection
@section('customScript')
<script src="{{ asset('assets/js/jquery.validate.min.js') }}"></script>
<script type="text/javascript">
  $("#loginUserForm").validate({    
      rules: {         
         email: {
            required: true,
         },
         password: {
            required: true,
         },                    
      },
      messages: {
         email: "Please enter email!",
         password: {
            required: "Please enter password!",  
         },            
      },
      submitHandler: function(form) {
         var serializedData = $(form).serialize();
         $("#err_mess").html('');
         $('#loginUserBtn').attr('disabled', true);
         $('#loginUserBtn').html('Processing <i class="fa fa-spinner fa-spin"></i>');      
         $.ajax({
            headers: {
              'X-CSRF-Token': $('input[name="_token"]').val()
            },
            type: 'post',
            url: "{{ route('userLogin') }}",
            data: serializedData,
            dataType: 'json',
            success: function(data) {
               if (data.status == true) {
                    $('#loginUserBtn').attr('disabled', false);
                    $('#loginUserBtn').html('Processing <i class="fa fa-check"></i>'); 
                    toastr.success(data.message);
                    setTimeout(function() {
                        window.location.href = "{{ route('home') }}";
                    }, 2000);
                } else {
                    $('#loginUserBtn').attr('disabled', false);
                    $('#loginUserBtn').html('Login'); 
                    toastr.error(data.message);
                }
            }
         });
      return false;
      }
   });
</script>
@endsection
{{-- @extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Login') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="row mb-3">
                            <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Email Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

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
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6 offset-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                    <label class="form-check-label" for="remember">
                                        {{ __('Remember Me') }}
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Login') }}
                                </button>

                                @if (Route::has('password.request'))
                                    <a class="btn btn-link" href="{{ route('password.request') }}">
                                        {{ __('Forgot Your Password?') }}
                                    </a>
                                @endif
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection --}}
