@extends('admin.layout.master')
@section('content')
<style type="text/css">
   .switch {
     position: relative;
     display: inline-block;
     width: 60px;
     height: 34px;
   }

   .switch input { 
     opacity: 0;
     width: 0;
     height: 0;
   }
   .slider {
     position: absolute;
     cursor: pointer;
     top: 0;
     left: 0;
     right: 0;
     bottom: 0;
     background-color: #ccc;
     -webkit-transition: .4s;
     transition: .4s;
   }

   .slider:before {
     position: absolute;
     content: "";
     height: 26px;
     width: 26px;
     left: 4px;
     bottom: 4px;
     background-color: white;
     -webkit-transition: .4s;
     transition: .4s;
   }

   input:checked + .slider {
     background-color: #DE0017;
   }

   input:focus + .slider {
     box-shadow: 0 0 1px #DE0017;
   }

   input:checked + .slider:before {
     -webkit-transform: translateX(26px);
     -ms-transform: translateX(26px);
     transform: translateX(26px);
   }

   /* Rounded sliders */
   .slider.round {
     border-radius: 34px;
   }

   .slider.round:before {
     border-radius: 50%;
   }
</style>
<div class="page-wrapper">
   <div class="content container-fluid">
      <div class="row">
         <div class="col-md-12">
            <div class="card">
               <div class="card-header d-flex justify-content-between align-items-center">
                  <h4 class="card-title">All Users</h4>
                  <a href="{{ route('user.create') }}" class="btn btn-default btnwhite">Add User</a>
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