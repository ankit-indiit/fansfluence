@extends('layout.master')
@section('content')
<section class="pt-5 pb-5 account-section login-section">
   <div class="container">
      <div class="d-flex mb-4">
         <h3 class="section-title">Forgot Password?</h3>
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
               {{ Form::open(['url' => route('password.email'), 'id' => 'passwordEmail']) }}
               <div class="account-head">
                    <h2>Welcome!</h2>
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @else
                        <h3>Forgot Password?</h3>
                    @endif
               </div>
               <div class="form-group">
                    {{ Form::label('email', 'Email', ['class' => 'form-label']) }}
                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                    @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
               </div>
               <div class="mt-sm-5">
                    {{ Form::button('Send Reset Password Link', [
                        'class' => 'btn custom-btn-main w-100',
                        'id' => 'passwordEmailBtn',
                        'type' => 'submit'
                    ]) }}
               </div>
                <p class="text-center my-4">
                    <span class="text-secondary">Back to </span>
                    <a class="text-danger" href="{{ route('login') }}">Sign In</a>
                </p>
            {{ Form::close() }}   
            </div>
         </div>
      </div>
   </div>
    {{-- @if (session('status'))
        <script type="text/javascript">
            toastr.success("{{ session('status') }}");
        </script>
    @endif --}}
</section>
@endsection
@section('customScript')
<script src="{{ asset('assets/js/jquery.validate.min.js') }}"></script>
<script type="text/javascript">   
    $("#passwordEmail").validate({    
        rules: {        
            email: {
                required: true,
            },           
        },
        messages: {
            email: "Please enter email!",                 
        },        
        submitHandler: function(form) {
            $('#passwordEmailBtn').attr('disabled', true);
            $('#passwordEmailBtn').html('Processing <i class="fa fa-spinner fa-spin"></i>');
            form.submit();
            setTimeout(function(){                     
                formButton();
            }, 2500) 
        } 
    });

    function formButton() {
        $('#passwordEmailBtn').attr('disabled', false);
        $('#passwordEmailBtn').html('Processing <i class="fa fa-check"></i>');
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
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('password.email') }}">
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

                        <div class="row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Send Password Reset Link') }}
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
