@extends('admin.layout.master')
@section('content')
<div class="page-wrapper">
   <div class="content container-fluid">
      <div class="row">
         <div class="col-md-12">
            <div class="card card-table">
               <div class="card-header d-flex justify-content-between align-items-center">
                  <h4 class="card-title">Update User</h4>
                  <a href="{{ URL::previous() }}" class="btn btn-default btnwhite">Back</a>
               </div>
               <div class="card-body">
                  <div class="padBox">
                     <form action="{{ route('user.store') }}" id="updateUserForm" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                           <div class="col-md-12">
                              <div class="form-group">
                                 <h1>User Information</h1>
                              </div>
                           </div>
                           <div class="col-md-6">
                              <div class="form-group">
                                 <label>Name</label>
                                 <input class="form-control" name="name" type="text" value="{{ $user->name }}" placeholder="Enter Name">
                              </div>
                           </div>
                           <div class="col-md-6">
                              <div class="form-group">
                                 <label>Email</label>
                                 <input class="form-control" name="email" type="text" value="{{ $user->email }}" placeholder="Enter Email" readonly>
                              </div>
                           </div>
                           <div class="col-md-6">
                              <div class="form-group">
                                 <label>Image</label>
                                 <input type="file" class="form-control userImage" name="user_image">
                              </div>
                              <div class="">
                                 <img src="{{ $user->image }}" class="preUserImage" width="100" height="100">
                              </div>
                           </div>
                           <div class="col-md-6">
                              <div class="form-group">
                                 <label>Role</label>
                                 <select class="form-control" name="role">
                                    {{-- <option value="">Select Role</option> --}}
                                    <option {{ $user->hasRole('buyer') ? 'selected' : '' }} value="1">Buyer</option>
                                    <option {{ $user->hasRole('influencer') ? 'selected' : '' }} value="2">Influencer</option>
                                 </select>
                              </div>
                           </div>
                           {{-- <div class="col-md-6">
                              <div class="form-group">
                                 <label>Role</label>
                                 <select class="form-control multiple" name="role[]" multiple>
                                    <option value="">Select Role</option>
                                    <option {{ $user->hasRole('buyer') ? 'selected' : '' }} value="1">Buyer</option>
                                    <option {{ $user->hasRole('influencer') ? 'selected' : '' }} value="2">Influencer</option>
                                 </select>
                              </div>
                           </div> --}}
                           <div class="col-md-6">
                              <div class="form-group">
                                 <label>Password</label>
                                 <input class="form-control" name="password" type="password" placeholder="Enter Password" id="password">
                              </div>
                           </div>
                           <div class="col-md-6">
                              <div class="form-group">
                                 <label>Confirm Password</label>
                                 <input class="form-control" name="confirm_password" type="password" placeholder="Enter Confirm Password" id="confirm_password">
                              </div>
                           </div>             
                        </div>
                        <div class="mt-2">
                           <button class="btn btn-primary" id="updateUserFormBtn" type="submit">Submit</button>
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
               $('.preUserImage').attr('src', e.target.result);
           }
           reader.readAsDataURL(input.files[0]);
       }
   }
   $(".userImage").change(function(){
       readURL(this);
   });

   $("#updateUserForm").validate({
      rules: {
         name: {
           required: true,
         },
         email: {
           required: true,
         },         
         role: {
           required: true,
         },
         password: {
            required: function(element) {
               return $('#current_password').is(':filled');
            },
            minlength: 5,
         },
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
         role: "Please choose date of birth",      
         password: {
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
         var serializedData = new FormData(form);
         $("#err_mess").html('');
         $('#updateUserFormBtn').attr('disabled', true);
         $('#updateUserFormBtn').html('Processing <i class="fa fa-spinner fa-spin"></i>');
         $.ajax({
            headers: {
              'X-CSRF-Token': $('input[name="_token"]').val()
            },
            type: 'post',
            url: "{{ route('user.update', $user->id) }}",
            data: serializedData,
            dataType: 'json',
            processData: false,
            contentType: false,
            cache: false,
            success: function(data) {
               if (data.status == true) {
                  $('#updateUserFormBtn').attr('disabled', false);         
                  $('#updateUserFormBtn').html('Save Changes');
                  swal("", data.message, "success", {
                     button: "close",
                  });
                  window.location.href = "{{ URL::previous() }}";
               } else {
                  $('#updateUserFormBtn').attr('disabled', false);         
                  $('#updateUserFormBtn').html('Submit');
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