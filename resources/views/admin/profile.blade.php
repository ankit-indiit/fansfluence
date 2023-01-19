@extends('admin.layout.master')
@section('content')
<div class="page-wrapper">
   <div class="content container-fluid">
      <div class="row">
         <div class="col-md-12">
            <div class="card card-table">
               <div class="card-header d-flex justify-content-between align-items-center">
                  <h4 class="card-title">Admin Profile</h4>
                  <a href="{{ URL::previous() }}" class="btn btn-default btnwhite">Back</a>
               </div>
               <div class="card-body">
                  <div class="padBox">
                     <form action="{{ route('admin.updateProfile') }}" id="adminProfileForm" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                           <div class="col-md-12">
                              <div class="form-group">
                                 <h1>Admin Information</h1>
                              </div>
                           </div>
                           <div class="col-md-12">
                              <div class="form-group">
                                 <label>Name</label>
                                 <input class="form-control" name="name" type="text" value="{{ @$admin->name }}" placeholder="Enter Name">
                              </div>
                           </div>
                           <div class="col-md-12">
                              <div class="form-group">
                                 <label>Email</label>
                                 <input class="form-control" name="email" type="text" value="{{ @$admin->email }}" placeholder="Enter Email">
                              </div>
                           </div>
                           <div class="col-md-12">
                              <div class="form-group">
                                 <label>Image</label>
                                 <input type="file" class="form-control userImage" name="user_image">
                              </div>
                              @if (isset(Auth::guard('admin')->user()->image))
                                 <img class="preUserImage pb-4" src="{{ url('/user').'/'.@Auth::guard('admin')->user()->image }}" width="100" alt="">
                              @else
                                 <img src="" class="d-none preUserImage" width="100" height="100">
                              @endif
                           </div>                           
                           <div class="col-md-12">
                              <div class="form-group">
                                 <label>Password</label>
                                 <input class="form-control" name="password" type="password" placeholder="Enter Password" id="password">
                              </div>
                           </div>
                           <div class="col-md-12">
                              <div class="form-group">
                                 <label>Confirm Password</label>
                                 <input class="form-control" name="confirm_password" type="password" placeholder="Enter Confirm Password" id="confirm_password">
                              </div>
                           </div>             
                        </div>
                        <input type="hidden" name="id" value="{{ @$admin->id }}">
                        <div class="mt-2">
                           <button class="btn btn-primary" id="adminProfileFormBtn" type="submit">Submit</button>
                        </div>
                     </form>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
@endsection
@section('customScript')
<script type="text/javascript">
   function readURL(input) {
       if (input.files && input.files[0]) {
           var reader = new FileReader();
           reader.onload = function (e) {
               $('.preUserImage').removeClass('d-none');
               $('.preUserImage').attr('src', e.target.result);
           }
           reader.readAsDataURL(input.files[0]);
       }
   }
   $(".userImage").change(function(){
       readURL(this);
   });

   $("#adminProfileForm").validate({
      rules: {
         name: {
           required: true,
         },
         email: {
           required: true,
         },
         // user_image: {
         //   required: true,
         // },         
         // password: {
         //    required: true,
         //    minlength: 5,
         // },
         confirm_password: {
            required: function(element) {
               return $('#password').is(':filled');
            },
            minlength: 5,
            equalTo: '[name="password"]'
         }, 
      },
      messages: {
         name: "Please enter name",
         email: "Please enter email",
         // user_image: "Please choose image",
         // new_password: {
         //    required: "Please enter new password!",  
         //    minlength: "Length must be at least 5 characters!",  
         // },     
         confirm_password: {
            required: "Please enter confirm password!",  
            minlength: "Length must be at least 5 characters!",  
            equalTo: "Password and confirm password must be matched!",  
         },      
      },
      submitHandler: function(form) {
         var serializedData = new FormData(form);
         $("#err_mess").html('');
         $('#adminProfileFormBtn').attr('disabled', true);
         $('#adminProfileFormBtn').html('Processing <i class="fa fa-spinner fa-spin"></i>');
         $.ajax({
            headers: {
              'X-CSRF-Token': $('input[name="_token"]').val()
            },
            type: 'post',
            url: "{{ route('admin.updateProfile') }}",
            data: serializedData,
            dataType: 'json',
            processData: false,
            contentType: false,
            cache: false,
            success: function(data) {
               if (data.status == true) {
                  $('#adminProfileFormBtn').attr('disabled', false);         
                  $('#adminProfileFormBtn').html('Save Changes');
                  swal("", data.message, "success", {
                     button: "close",
                  });
                  window.location.href = "{{ URL::previous() }}";
               } else {
                  $('#adminProfileFormBtn').attr('disabled', false);         
                  $('#adminProfileFormBtn').html('Submit');
                  swal("", data.errors, "error", {
                     button: "close",
                  });
               }
            }
         });
      return false;
      }
   });
</script>
@endsection