@extends('admin.layout.master')
@section('content')
<div class="page-wrapper">
   <div class="content container-fluid">
      <div class="row">
         <!-- Users -->
         <div class="col-md-12">
            <div class="card card-table">
               <div class="card-header d-flex justify-content-between align-items-center">
                  <h4 class="card-title">All Gigs</h4>
                  {{-- <a href="{{ route('user.create') }}" class="btn btn-default btnwhite">Add</a> --}}
               </div>
               <div class="card-body">
                  <div class="table-responsive">
                     <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">
                        <div class="row">
                           <div class="col-sm-12">
                              <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">
                                 <div class="row">                                   
                                    <div class="col-sm-12 col-md-6"></div>
                                 </div>
                                 <div class="row">
                                    <div class="col-sm-12">
                                       <table class="table table-hover table-center mb-0 datatable dataTable no-footer" id="DataTables_Table_0" role="grid" aria-describedby="DataTables_Table_0_info">
                                          <thead>
                                             <tr role="row">
                                                <th class="sorting_asc" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="ID: activate to sort column descending" style="width: 77.3594px;" aria-sort="ascending">ID</th>
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Name: activate to sort column ascending" style="width: 139.594px;">Name</th>
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Clinic: activate to sort column ascending" style="width: 183.875px;">Email</th>
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Date: activate to sort column ascending" style="width: 205.141px;">Role</th>
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Date: activate to sort column ascending" style="width: 205.141px;">Image</th>
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Date: activate to sort column ascending" style="width: 205.141px;">Status</th>
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Action: activate to sort column ascending" style="width: 169.031px;">Action</th>
                                             </tr>
                                          </thead>
                                          <tbody>
                                             {{-- @if (count($users) > 0)
                                                @foreach ($users as $user)                          
                                                   <tr role="row" class="odd">
                                                      <td class="sorting_1">{{ $loop->iteration }}</td>
                                                      <td>{{ $user->name }}</td>
                                                      <td>{{ $user->email }}</td>
                                                      <td>
                                                         @foreach ($user->getRoleNames() as $role)
                                                            <span class="badge badge-primary">{{$role}}</span>
                                                         @endforeach
                                                      </td>
                                                      <td><img src="{{ $user->image }}" style="height: 80px; width: 80px; border-radius: 50px;"></td>
                                                      <td>
                                                         <label class="switch">
                                                            <input
                                                               type="checkbox"
                                                               name="profile_status"
                                                               class="profileStatus"
                                                               data-user={{$user->id}} 
                                                               {{ $user->status == 1 ? 'checked' : '' }}
                                                            >
                                                            <span class="slider round"></span>
                                                         </label>
                                                      </td>
                                                      <td>                                           
                                                         <a href="{{ route('user.edit', $user->id) }}" class="btn btn-sm bg-info-light">
                                                            <i class="far fa-edit mr-1"></i>
                                                         </a>
                                                         <a href="javascript: void(0)" id="deleteUser" data-id="{{ $user->id }}" class="btn btn-sm bg-danger-light delete_review_comment">
                                                            <i class="far fa-trash-alt"></i>
                                                         </a>
                                                      </td>
                                                   </tr>
                                                @endforeach
                                             @endif --}}
                                          </tbody>
                                       </table>
                                    </div>
                                 </div>
                                 
                              </div>
                           </div>
                        </div>
                        <div class="row">
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
         <!-- End Of Users -->
      </div>
   </div>
</div>
@endsection
@section('customScript')
<script type="text/javascript">
   $(document).on('change', '.profileStatus', function(){
      var userId = $(this).data('user');
      if($(this).is(':checked')) {
         var status = '1';
      } else {
         var status = '0';
      }
       $.ajax({
        headers: {
            'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
        },
        type: 'post',
        url: "{{ route('user.status') }}",
        data: { 
         userId: userId,
         status: status,
        },
        dataType: 'json',
        success: function (data) {
            if (data.status == true) {
               swal("", data.message, "success", {
                  button: "close",
            });
            $('.swal2-confirm').on('click', function(){
               location.reload();
            });
            } else {
               swal("", data.message, "error", {
                     button: "close",
               });
            }
        }
      });
   });

   $(document).on('click', '#deleteUser', function(){
      var id = $(this).data('id');
      swal({
          title: "Are you sure?",
           text: "You will not be able to recover this!",
           type: "warning",
           showCancelButton: true,
           confirmButtonColor: "#DD6B55",
           confirmButtonText: "Yes, delete it!",
      }).then((result) => {
          if (result == true) {
            deleteUser(id)
          } else {
              swal("", "Cancelled!", "error", {
                  button: "close",
            });
          }
      });
   });

   function deleteUser(id) {      
      $.ajax({
        headers: {
            'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
        },
        type: 'post',
        url: "{{ route('user.destroy') }}",
        data: { 
         id: id,
        },
        dataType: 'json',
        success: function (data) {
            if (data.status == true) {
               swal("", data.message, "success", {
                  button: "close",
            });
            $('.swal2-confirm').on('click', function(){
               location.reload();
            });
            } else {
               swal("", data.message, "error", {
                     button: "close",
               });
            }
        }
      });
   }
</script>
@endsection