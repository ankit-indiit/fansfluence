@extends('layout.master')
@section('content')
<section class="pt-5 pb-5 account-section login-section">
   <div class="container">
      <div class="d-flex mb-4">
         <h3 class="section-title">Sign Up</h3>
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
               {{ Form::open(['url' => route('userRegister'), 'id' => 'registerUserForm']) }}
                  <div class="account-head">
                     <h2>Welcome!</h2>
                     <h3>Create Acccount</h3>
                  </div>
                  <div class="form-group">
                     {{ Form::label('name', 'Name', ['class' => 'form-label']) }}
                     {{ Form::text('name', old('name'), ['class' => 'form-control', 'placeholder' => 'Enter Name']) }}
                  </div>
                  <div class="form-group">
                     {{ Form::label('email', 'Email', ['class' => 'form-label']) }}
                     {{ Form::email('email', '', ['class' => 'form-control', 'placeholder' => 'Enter Email']) }}
                  </div>
                  <div class="form-group">
                     {{ Form::label('password', 'Password', ['class' => 'form-label']) }}
                     {{ Form::password('password', ["class" => "form-control", "autocomplete" => "off", 'placeholder' => 'Enter Password']) }}
                  </div>
                  <div class="form-group">
                     {{ Form::label('confirm_password', 'Confirm Password', ['class' => 'form-label']) }}
                     {{ Form::password('confirm_password', ["class" => "form-control", "autocomplete" => "off", 'placeholder' => 'Enter Confirm Password']) }}
                  </div>
                  <div class="checkbox form-group">
                     <div class="form-check float-start mb-0">
                        <input class="form-check-input" type="checkbox" name="terms" id="rememberme">
                        <label class="form-check-label" for="rememberme">
                           I agree with the <a href="javascript:void(0);">Terms &amp; Conditions</a>
                        </label>
                        <span class="terms"></span>
                     </div>                        
                  </div>
                  <div class="mt-sm-5">
                     {{ Form::button('Sign Up', [
                        'class' => 'btn custom-btn-main w-100',
                        'id' => 'registerUserBtn',
                        'type' => 'submit'
                     ]) }}
                  </div>
                  <div class="text-center mt-4">
                     <p>Already have an account? 
                        <a class="text-danger" href="{{ route('login') }}">Sign In</a>
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
   $("#registerUserForm").validate({    
      rules: {
         name: {
            required: true,
         },
         email: {
            required: true,
         },
         password: {
            required: true,
            minlength: 5,
         }, 
         confirm_password: {
            required: true,
            minlength: 5,
            equalTo: '[name="password"]'
         },
         terms: {
            required: true,                
         },         
      },
      messages: {
         name: "Please enter name!",
         email: "Please enter email!",
         password: {
            required: "Please enter password!",  
            minlength: "Length must be at least 5 characters!",  
         },
         confirm_password: {
            required: "Please enter confirm password!",  
            minlength: "Length must be at least 5 characters!",  
            equalTo: "Password and confirm password must be matched!",  
         },
         terms: {
            required: "Please choose terms & conditions!",  
         },
      },
      errorPlacement: function (error, element) {
         if (element.attr("name") == "terms") {
            error.appendTo($("."+element.attr("name")));
         } else {
            error.insertAfter(element);
         }
      },
      submitHandler: function(form) {
         var serializedData = $(form).serialize();
         $("#err_mess").html('');
         $('#registerUserBtn').attr('disabled', true);
         $('#registerUserBtn').html('Processing <i class="fa fa-spinner fa-spin"></i>');      
         $.ajax({
            headers: {
               'X-CSRF-Token': $('input[name="_token"]').val()
            },
            type: 'post',
            url: "{{ route('userRegister') }}",
            data: serializedData,
            dataType: 'json',
            success: function(data) {
               if (data.status == true) {
                  $('#registerUserBtn').attr('disabled', false);
                  $('#registerUserBtn').html('Processing <i class="fa fa-check"></i>'); 
                  toastr.success(data.message);
                  setTimeout(function() {
                     window.location.href = "{{ route('login') }}";
                  }, 2000);
               } else {
                  $('#registerUserBtn').attr('disabled', false);
                  $('#registerUserBtn').html('Sign Up'); 
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
                <div class="card-header">{{ __('Register') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <div class="row mb-3">
                            <label for="name" class="col-md-4 col-form-label text-md-end">{{ __('Name') }}</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Email Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

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
                                    {{ __('Register') }}
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
