@extends('admin.layout.master')
@section('content')
<div class="page-wrapper">
   <div class="content container-fluid">
      <div class="row">
         <div class="col-md-12">
            <div class="card card-table">
               <div class="card-header d-flex justify-content-between align-items-center">
                  <h4 class="card-title">Update Milestone</h4>
                  <a href="{{ route('milestone.index') }}" class="btn btn-default btnwhite">Back</a>
               </div>
               <div class="card-body">
                  <div class="padBox">
                     <form action="{{ route('milestone.update') }}" id="updateMilestoneForm" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                           <div class="col-md-12">
                              <div class="form-group">
                                 <h1>Milestone Information</h1>
                              </div>
                           </div>
                           <div class="col-md-4">
                              <div class="form-group">
                                 <label>Title</label>
                                 <input class="form-control" name="title" type="text" value="{{ $milestone->title }}" placeholder="Enter Title">
                              </div>
                           </div>
                           <div class="col-md-4">
                              <div class="form-group">
                                 <label>Distance</label>
                                 <input class="form-control" name="distance" type="text" value="{{ $milestone->distance }}" placeholder="Enter Distance">
                              </div>
                           </div>
                           <div class="col-md-4">
                              <div class="form-group">
                                 <label>Time</label>
                                 <select class="form-control" name="time">
                                    <option value="">Select time</option>
                                    <option {{ $milestone->time == 'day' ? 'selected' : '' }} value="day">Day</option>
                                    <option {{ $milestone->time == 'week' ? 'selected' : '' }} value="week">Week</option>
                                    <option {{ $milestone->time == 'month' ? 'selected' : '' }} value="month">Month</option>
                                 </select>                                 
                              </div>
                           </div>
                           <div class="col-md-6">
                              <div class="form-group">
                                 <label>Assign User</label>
                                 <div class="row">
                                    <div class="col-md-6">
                                       <input
                                          type="radio"
                                          name="assigned_user"
                                          value="all"
                                          class="assignUser"
                                          id="assignAll"
                                          {{ $milestone->assigned_user == 'all' ? 'checked' : '' }}
                                       >
                                       <label for="assignAll">All user</label>   
                                    </div>
                                    <div class="col-md-6">
                                       <input
                                          type="radio"
                                          name="assigned_user"
                                          value="selected"
                                          class="assignUser"
                                          id="assignSelected"
                                          {{ $milestone->assigned_user == 'selected' ? 'checked' : '' }}
                                       >
                                       <label for="assignSelected">Selected user</label>   
                                    </div>
                                 </div>                                 
                              </div>
                           </div>
                           <div class="col-md-12 assignUserSec" style="display:{{ $milestone->assigned_user == 'selected' ? 'block' : 'none' }};">
                              <div class="form-group">
                                 <label>User</label>
                                 <select class="multiple" name="user[]" multiple>
                                    <option value="">Select User</option>
                                    @foreach ($users as $user)
                                       <option {{ in_array($user->id, $assignedUser) ? 'selected' : '' }} value="{{ $user->id }}">{{ $user->first_name }}</option>
                                    @endforeach
                                 </select>                                 
                              </div>
                           </div>                  
                        </div>
                        <input type="hidden" name="id" value="{{ $milestone->id }}">
                        <div class="mt-2">
                           <button class="btn btn-primary" id="updateMilestoneFormBtn" type="submit">Submit</button>
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
   $(document).on('change', '.assignUser', function(){
      if ($(this).val() == 'selected') {
         $('.assignUserSec').show();
      } else {
         $('.assignUserSec').hide();
      }
   });

   $("#updateMilestoneForm").validate({
      rules: {
         title: {
           required: true,
         },
         distance: {
           required: true,
         },
         time: {
           required: true,
         },
         "user[]": {
           required: true,
         },           
      },
      messages: {
         title: "Please enter title",
         distance: "Please enter distance",
         time: "Please choose time",
         "user[]": "Please select user",                         
      },      
      submitHandler: function(form) {
         var serializedData = new FormData(form);
         $("#err_mess").html('');
         $('#updateMilestoneFormBtn').attr('disabled', true);
         $('#updateMilestoneFormBtn').html('Processing <i class="fa fa-spinner fa-spin"></i>');
         $.ajax({
            headers: {
              'X-CSRF-Token': $('input[name="_token"]').val()
            },
            type: 'post',
            url: "{{ route('milestone.update') }}",
            data: serializedData,
            dataType: 'json',
            processData: false,
            contentType: false,
            cache: false,
            success: function(data) {
               if (data.status == true) {
                  $('#updateMilestoneFormBtn').attr('disabled', false);         
                  $('#updateMilestoneFormBtn').html('Save Changes');
                  swal("", data.message, "success", {
                     button: "close",
                  });
                  $('.swal2-confirm').on('click', function(){
                     window.location.href = "{{ route('milestone.index') }}";
                  });
               } else {
                  $('#updateMilestoneFormBtn').attr('disabled', false);         
                  $('#updateMilestoneFormBtn').html('Submit');
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