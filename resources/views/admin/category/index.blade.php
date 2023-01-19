@extends('admin.layout.master')
@section('content')
<div class="page-wrapper">
   <div class="content container-fluid">
      <div class="row">
         <div class="col-md-12">
            <div class="card">
               <div class="card-header d-flex justify-content-between align-items-center">
                  <h4 class="card-title">All Category</h4>
                  <a href="{{ route('category.create') }}" class="btn btn-default btnwhite">Add</a>
               </div>
            </div>
             <table id="categoryDatatable" class="table table-border listing-data-table">
                <thead>
                    <th>Sr. no.</th>
                    <th>Name</th>
                    <th>Sub Category</th>
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
<link href="https://cdn.datatables.net/1.12.1/css/dataTables.bootstrap5.min.css">
<script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.12.1/js/dataTables.bootstrap5.min.js"></script>
<script type="text/javascript">
    $(function() {
        var table = $('#categoryDatatable').DataTable({
            processing: true,
            serverSide: true,
            order: [[0, 'desc']],
            ajax: "{{ route('category.index') }}",
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
                    data: 'sub_category',
                    name: 'sub_category[].name',
                    "className": "sub-category",
                    orderable: true,
                    searchable: true
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
   $(document).on('click', '#deleteCategory', function(){
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
            deleteCategory(id)
          } else {
              swal("", "Cancelled!", "error", {
                  button: "close",
            });
          }
      });
   });

   function deleteCategory(id) {      
      $.ajax({
        headers: {
            'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
        },
        type: 'delete',
        url: "{{ url('admin/category') }}/"+id,
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