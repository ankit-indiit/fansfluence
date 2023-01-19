@extends('admin.layout.master')
@section('content')
<div class="page-wrapper">
   <div class="content container-fluid">
      <div class="row">
         <div class="col-md-12">
            <div class="card card-table">
               <div class="card-header d-flex justify-content-between align-items-center">
                  <h4 class="card-title">Add Milestone</h4>
                  <a href="{{ route('milestone.index') }}" class="btn btn-default btnwhite">Back</a>
               </div>
               <div class="card-body">
                  <div class="padBox">
                     <form action="{{ route('milestone.store') }}" id="addMilestoneForm" method="post" enctype="multipart/form-data">
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
                                 <input class="form-control" name="title" type="text" placeholder="Enter Title">
                              </div>
                           </div>
                           <div class="col-md-4">
                              <div class="form-group">
                                 <label>Distance</label>
                                 <input class="form-control" name="distance" type="text" placeholder="Enter Distance">
                              </div>
                           </div>
                           <div class="col-md-4">
                              <div class="form-group">
                                 <label>Time</label>
                                 <select class="form-control" name="time">
                                    <option value="">Select time</option>
                                    <option value="day">Day</option>
                                    <option value="week">Week</option>
                                    <option value="month">Month</option>
                                 </select>                                 
                              </div>
                           </div>
                           <div class="col-md-6">
                              <div class="form-group">
                                 <label>Status</label>
                                 <select class="form-control" name="status">
                                    <option value="">Select status</option>
                                    <option value="active">Active</option>
                                    <option value="expired">Expired</option>
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
                                          {{ $request->assigned_user == 'all' ? 'selected' : '' }}
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
                                          {{ $request->assigned_user == 'selected' ? 'selected' : '' }}
                                       >
                                       <label for="assignSelected">Selected user</label>   
                                    </div>
                                 </div>                                 
                              </div>
                           </div>
                           <div class="col-md-12 assignUserSec" style="display:{{ $request->assigned_user == 'selected' ? 'block' : 'none' }};">
                              <div class="form-group">
                                 <label>Select User</label>
                                 <select class="multiple" name="user[]" multiple>
                                    <option value="">Select User</option>
                                    @foreach ($users as $user)
                                       <option value="{{ $user->id }}">{{ $user->first_name }}</option>
                                    @endforeach
                                 </select>                                 
                              </div>
                           </div>                  
                        </div>
                        <div class="mt-2">
                           <button class="btn btn-primary" id="addMilestoneFormBtn" type="submit">Submit</button>
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

   $("#addMilestoneForm").validate({
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
         $('#addMilestoneFormBtn').attr('disabled', true);
         $('#addMilestoneFormBtn').html('Processing <i class="fa fa-spinner fa-spin"></i>');
         $.ajax({
            headers: {
              'X-CSRF-Token': $('input[name="_token"]').val()
            },
            type: 'post',
            url: "{{ route('milestone.store') }}",
            data: serializedData,
            dataType: 'json',
            processData: false,
            contentType: false,
            cache: false,
            success: function(data) {
               if (data.status == true) {
                  $('#addMilestoneFormBtn').attr('disabled', false);         
                  $('#addMilestoneFormBtn').html('Save Changes');
                  swal("", data.message, "success", {
                     button: "close",
                  });
                  $('.swal2-confirm').on('click', function(){
                     window.location.href = "{{ route('milestone.index') }}";
                  });
               } else {
                  $('#addMilestoneFormBtn').attr('disabled', false);         
                  $('#addMilestoneFormBtn').html('Submit');
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