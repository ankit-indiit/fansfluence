@extends('admin.layout.master')
@section('content')
<div class="page-wrapper">
   <div class="content container-fluid">
      <div class="row">
         <div class="col-md-12">
            <div class="card">
               <div class="card-header d-flex justify-content-between align-items-center">
                  <h4 class="card-title">All Contact List</h4>
               </div>
            </div>
            {{-- {!! $dataTable->table() !!} --}}
            <table id="contactUsDatatable" class="table table-border listing-data-table">
                <thead>
                    <th>Sr. no.</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Reason</th>
                    <th>Date</th>
                    <th>Action</th>
                </thead>
                <tbody>
                </tbody>
            </table>
         </div>
      </div>
   </div>
   <div class="modal fade" id="contactUsMessage" tabindex="-1" role="dialog" aria-labelledby="contactUsMessageTitle" aria-hidden="true">
     <div class="modal-dialog" role="document">
       <div class="modal-content">
         <div class="modal-header">
           <h5 class="modal-title" id="contactUsMessageTitle">Contact Detail</h5>
           <button type="button" class="close" data-dismiss="modal" aria-label="Close">
             <span aria-hidden="true">&times;</span>
           </button>
         </div>
         <div class="modal-body">
           <label>Message</label>
           <p class="contactMsg border p-2"></p>
         </div>
         <div class="modal-footer">
           <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
         </div>
       </div>
     </div>
   </div>
</div>
@endsection
@section('customScript')
<link href="https://cdn.datatables.net/1.12.1/css/dataTables.bootstrap5.min.css">
<script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.12.1/js/dataTables.bootstrap5.min.js"></script>
{{-- {!! $dataTable->scripts() !!} --}}
<script type="text/javascript">
    $(function() {
        var table = $('#contactUsDatatable').DataTable({
            processing: true,
            serverSide: true,
            order: [[4, 'desc']],
            ajax: "{{ route('contactUs.index') }}",
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'id',
                    orderable: true,
                },
                {
                    data: 'name',
                    name: 'name',
                    orderable: true,
                    searchable: true
                },
                {
                    data: 'email',
                    name: 'email',
                    orderable: true,
                },
                {
                    data: 'reason',
                    name: 'reason',
                    orderable: true,
                    searchable: false
                },
                {
                    data: 'date',
                    name: 'created_at',
                    orderable: true,
                    searchable: false
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                },
            ]
        });

    });

   $(document).on('click', '.contactDesc', function(){
      $('.contactMsg').html('Processing <i class="fa fa-spinner fa-spin"></i>');
      var id = $(this).data('id');
      $.ajax({
        headers: {
            'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
        },
        type: 'get',
        url: "{{ route('contactUs.desc') }}",
        data: { 
         id: id,
        },
        dataType: 'json',
        success: function (data) {
            if (data.status == true) {
               $('.contactMsg').html(data.data);
               $('#contactUsMessage').modal('show');
            } else {
               swal("", data.message, "error", {
                     button: "close",
               });
            }
        }
      });
   });

   $(document).on('click', '#deleteContact', function(){
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
            deleteContact(id)
          } else {
              swal("", "Cancelled!", "error", {
                  button: "close",
            });
          }
      });
   });

   function deleteContact(id) {      
      $.ajax({
        headers: {
            'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
        },
        type: 'post',
        url: "{{ route('contactUs.destroy') }}",
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