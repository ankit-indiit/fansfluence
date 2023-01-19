@extends('admin.layout.master')
@section('content')
<div class="page-wrapper">
   <div class="content container-fluid">
      <div class="row">
         <div class="col-md-12">
            <div class="card">
               <div class="card-header d-flex justify-content-between align-items-center">
                  <h4 class="card-title">Pages</h4>
                  <a href="{{ route('page.create') }}" class="btn btn-default btnwhite">Add Page</a>
               </div>
            </div>
            {!! $dataTable->table() !!}
         </div>
      </div>
   </div>
</div>
@endsection
@section('customScript')
{!! $dataTable->scripts() !!}
<script type="text/javascript">
   $(document).on('click', '.deletePage', function(){
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
            deletePage(id)
          } else {
              swal("", "Cancelled!", "error", {
                  button: "close",
            });
          }
      });
   });

   function deletePage(id) {      
      $.ajax({
        headers: {
            'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
        },
        type: 'post',
        url: "{{ route('page.destroy') }}",
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