@extends('layout.master')
@section('content')
<section class="pt-5 pb-5 account-section account-profile-section">
   <div class="container">
      <div class="d-flex mb-4">
         <h3 class="section-title">Account</h3>
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
               <div class="account-header">
                  <div class="account-avatar">
                     <img src="{{ Auth::user()->image }}" id="userProfileImage">
                     <div class="account-photo-edit">
                        <form action="" method="post" id="profilePicForm" enctype="multipart/form-data">
                           <input id="account-img-file-input" type="file" name="userProfilePic" class="account-img-file-input">
                           <input type="hidden" value="{{ Auth::user()->image_name }}" id="imageName" name="image_name">
                           <label for="account-img-file-input" id="influencerProfile">
                              <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-camera">
                                 <path d="M23 19a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h4l2-3h6l2 3h4a2 2 0 0 1 2 2z"></path>
                                 <circle cx="12" cy="13" r="4"></circle>
                              </svg>
                           </label>
                        </form>
                     </div>
                  </div>
               </div>
               {{ Form::open(['url' => route('updateInfluencerProfile'), 'id' => 'influencerProfileForm']) }}
                  <div class="profile-info-item">
                     <h4>Basic Information</h4>
                     <div class="form-group">
                        {{ Form::label('name', 'Name', ['class' => 'form-label']) }}
                        {{ Form::text('name', Auth::user()->name, ['class' => 'form-control', 'placeholder' => 'Enter Name']) }}
                     </div>  
                     <div class="form-group">
                        {{ Form::label('email', 'Email', ['class' => 'form-label']) }}
                        {{ Form::text('email', Auth::user()->email, ['class' => 'form-control', 'placeholder' => 'Enter Email', 'disabled']) }}
                     </div>                                          
                  </div>
                  <div class="profile-info-item">
                     <h4>Change Password</h4>
                     <div class="form-group">
                        {{ Form::label('current_password', 'Current Password', ['class' => 'form-label']) }}
                        {{ Form::password('current_password', [
                           "class" => "form-control",
                           "autocomplete" => "new-password"
                           ])
                        }}
                     </div> 
                     <div class="form-group">
                        {{ Form::label('new_password', 'New Password', ['class' => 'form-label']) }}
                        {{ Form::password('new_password', [
                           "class" => "form-control",
                           "autocomplete" => "off"
                           ])
                        }}
                     </div>
                     <div class="form-group">
                        {{ Form::label('confirm_password', 'Confirm  Password', ['class' => 'form-label']) }}
                        {{ Form::password('confirm_password', [
                           "class" => "form-control",
                           "autocomplete" => "off"
                           ])
                        }}
                     </div>                                          
                  </div>
                  <div class="profile-info-item">
                     <h4>Choose Theme</h4>
                     <div class="form-group">
                        {{ Form::select('theme', [
                              '' => 'Select Theme Color',
                              'light' => 'light',
                              'dark' => 'dark'
                           ], Auth::user()->theme, ['class' => 'form-control', 'id' => 'select-reason']); }}
                     </div>
                  </div>
                  <div class="mt-sm-5 mt-4">
                     {{ Form::button('Save', [
                           'class' => 'btn custom-btn-main w-100',
                           'id' => 'influencerProfileFormBtn',
                           'type' => 'submit',
                           'disabled' => 'disabled'
                        ])
                     }}
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
   $('.form-control').on('keyup', function() {
      $('#influencerProfileFormBtn').attr('disabled', false);
   });   
   
   $('#account-img-file-input').change(function(e) {
      var form = $('#profilePicForm')[0];
      var serializedData = new FormData(form);
      $.ajax({
         headers: {
            'X-CSRF-Token': $('input[name="_token"]').val()
         },
         type: 'post',
         url: "{{ route('uploadInfluencerProfile') }}",
         data: serializedData,
         dataType: 'json',
         processData: false,
         contentType: false,
         cache: false,   
         success: function(data) {
            toastr.options.timeOut = 4000;
            if (data.status == true) {
               $('#userProfileImage').attr('src', data.image);
               $('#imageName').val(data.image_name);
               toastr.success(data.message);
            } else {
               toastr.error(data.message);
            }        
         }
      });
   });

   $("#influencerProfileForm").validate({    
      rules: {
         name: {
            required: true,
         },
         email: {
            required: true,
         },
         new_password: {
            required: function(element) {
               return $('#current_password').is(':filled');
            },
            minlength: 5,
         },
         confirm_password: {
            required: function(element) {
               return $('#new_password').is(':filled');
            },
            minlength: 5,
            equalTo: '[name="new_password"]'
         },     
      },
      messages: {
         name: "Please enter name!",
         email: "Please enter email!",        
         new_password: {
            required: "Please enter new password!",  
            minlength: "Length must be at least 5 characters!",  
         },     
         confirm_password: {
            required: "Please enter confirm password!",  
            minlength: "Length must be at least 5 characters!",  
            equalTo: "Password and confirm password must be matched!",  
         },        
      },
      submitHandler: function(form) {
         var serializedData = $(form).serialize();
         $("#err_mess").html('');
         $('#influencerProfileFormBtn').attr('disabled');
         $('#influencerProfileFormBtn').html('Processing <i class="fa fa-spinner fa-spin"></i>');      
         $.ajax({
            headers: {
              'X-CSRF-Token': $('input[name="_token"]').val()
            },
            type: 'post',
            url: "{{ route('updateInfluencerProfile') }}",
            data: serializedData,
            dataType: 'json',
            success: function(data) {
               if (data.status == true) {
                  $('#influencerProfileFormBtn').html('Processing <i class="fa fa-check"></i>'); 
                  toastr.success(data.message);
                  setTimeout(function(){                     
                     window.location.reload();
                   }, 2500) 
               } else {
                  $('#influencerProfileFormBtn').html('Save'); 
                  toastr.error(data.message);               
               }
            }
         });
      return false;
      }
   });
</script>
@endsection