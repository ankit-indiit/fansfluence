@extends('admin.layout.master')
@section('content')
<div class="page-wrapper">
   <div class="content container-fluid">
      <div class="row">
         <div class="col-md-12">
            <div class="card card-table">
               <div class="card-header d-flex justify-content-between align-items-center">
                  <h4 class="card-title">Paypal</h4>
                  {{-- <a href="{{ URL::previous() }}" class="btn btn-default btnwhite">Back</a> --}}
               </div>
               <div class="card-body">
                  <div class="padBox">
                     <form action="{{ route('payment.store') }}" id="addPaymentMethodForm" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                           <div class="col-md-12">
                              <div class="form-group">
                                 <h1>Paypal Information</h1>
                              </div>
                           </div>
                           <div class="col-md-12">
                              <div class="form-group">
                                 <label>MODE</label>
                                 <select class="form-control" name="mode">
                                    <option value="">Select Mode</option>
                                    <option {{ @$payment->mode == 'sandbox' ? 'selected' : '' }} value="sandbox">Sandbox</option>
                                    <option {{ @$payment->mode == 'live' ? 'selected' : '' }} value="live">Live</option>
                                 </select>
                              </div>
                           </div>
                           <div class="col-md-12">
                              <div class="form-group">
                                 <label>CLIENT ID</label>
                                 <input class="form-control" name="client_id" type="text" value="{{ @$payment->client_id }}" placeholder="Enter client id">
                              </div>
                           </div>
                           <div class="col-md-12">
                              <div class="form-group">
                                 <label>CLIENT SECRET</label>
                                 <input class="form-control" name="client_secret" type="text" value="{{ @$payment->client_secret }}" placeholder="Enter client secret">
                              </div>
                           </div>                                      
                        </div>
                        <input type="hidden" name="type" value="paypal">
                        <input type="hidden" name="id" value="{{ @$payment->id }}">
                        <div class="mt-2">
                           <button class="btn btn-primary" id="addPaymentMethodFormBtn" type="submit">Submit</button>
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
   $("#addPaymentMethodForm").validate({
      rules: {
         mode: {
           required: true,
         },
         client_id: {
           required: true,
         },
         client_secret: {
           required: true,
         },          
      },
      messages: {
         mode: "Please choose mode!",
         client_id: "Please enter client id!",
         client_secret: "Please enter client secret!",
      },
      submitHandler: function(form) {
         var serializedData = new FormData(form);
         $("#err_mess").html('');
         $('#addPaymentMethodFormBtn').attr('disabled', true);
         $('#addPaymentMethodFormBtn').html('Processing <i class="fa fa-spinner fa-spin"></i>');
         $.ajax({
            headers: {
              'X-CSRF-Token': $('input[name="_token"]').val()
            },
            type: 'post',
            url: "{{ route('payment.store') }}",
            data: serializedData,
            dataType: 'json',
            processData: false,
            contentType: false,
            cache: false,
            success: function(data) {
               if (data.status == true) {
                  $('#addPaymentMethodFormBtn').attr('disabled', false);         
                  $('#addPaymentMethodFormBtn').html('Save Changes');
                  swal("", data.message, "success", {
                     button: "close",
                  });
                  window.location.reload();
               } else {
                  $('#addPaymentMethodFormBtn').attr('disabled', false);         
                  $('#addPaymentMethodFormBtn').html('Submit');
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