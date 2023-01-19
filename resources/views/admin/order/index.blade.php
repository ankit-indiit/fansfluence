@extends('admin.layout.master')
@section('content')
<div class="page-wrapper">
   <div class="content container-fluid">
      <div class="row">
         <div class="col-md-12">
            <div class="card">
               <div class="card-header d-flex justify-content-between align-items-center">
                  <h4 class="card-title">All Orders</h4>
               </div>
            </div>
            {{-- {!! $dataTable->table() !!} --}}
             <table id="orderDatatable" class="table table-border listing-data-table">
                <thead>
                    <th>Sr. no.</th>
                    <th>Order Id</th>
                    <th>Product</th>
                    <th>Status</th>
                    <th>User</th>
                    <th>Date</th>
                    <th>Action</th>
                </thead>
                <tbody>
                </tbody>
            </table>
         </div>
      </div>
   </div>
</div>
@endsection
@section('customScript')
{{-- {!! $dataTable->scripts() !!} --}}
<link href="https://cdn.datatables.net/1.12.1/css/dataTables.bootstrap5.min.css">
<script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.12.1/js/dataTables.bootstrap5.min.js"></script>
<script type="text/javascript">
    $(function() {
        var table = $('#orderDatatable').DataTable({
            processing: true,
            serverSide: true,
            order: [[0, 'desc']],
            ajax: "{{ route('order.index') }}",
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'id',
                    orderable: true,
                },
                {
                    data: 'order_id',
                    name: 'order_id',
                    orderable: true,
                    searchable: true
                },
                {
                    data: 'product',
                    name: 'product',
                    orderable: true,
                },
                {
                    data: 'status',
                    name: 'status',
                    orderable: true,
                    searchable: false
                },
                {
                    data: 'user_id',
                    name: 'user_id',
                    orderable: true,
                    searchable: false
                },
                {
                    data: 'created_at',
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
   $(document).on('click', '#deletemOrders', function(){
      var blogId = $(this).data('id');
      swal({
          title: "Are you sure?",
           text: "You will not be able to recover this!",
           type: "warning",
           showCancelButton: true,
           confirmButtonColor: "#DD6B55",
           confirmButtonText: "Yes, delete it!",
      }).then((result) => {
          if (result == true) {
            deletemOrders(blogId)
          } else {
              swal("", "Cancelled!", "error", {
                  button: "close",
            });
          }
      });
   });

   function deletemMilestone(id) {      
      $.ajax({
        headers: {
            'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
        },
        type: 'post',
        url: "",
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