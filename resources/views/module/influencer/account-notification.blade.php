@extends('layout.master')
@section('content')
<section class="pt-5 pb-5 seller-notifications-section section-full-height">
    <div class="container">
        <div class="d-flex mb-4">
            <h3 class="section-title">Account Notifications</h3>
        </div>
        {{ Form::open(['url' => route('manageNotification'), 'id' => 'manageNotification']) }}
        <div class="account-notifications">
            <div class="table-responsive">
                <table class="table table-borderless">
                    <thead>
                        <tr>
                            <th scope="col" width="60%">Notifications</th>
                            <th scope="col" width=""><i class="fa fa-bell"></i></th>
                            <th scope="col" width="">Email</th>
                            <th scope="col" width="">Mobile</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Order Updates</td>
                            {{ Form::hidden('orderUpdateId', @$data['orderUpdate']->id) }}
                            <td>
                                {{ Form::checkbox('orderUpdate[notification]', 1, @$data['orderUpdate']->notification == 1 ? true : false, [
                                    'class' => 'form-check-input'
                                ]) }}                                
                            </td>
                            <td>
                                {{ Form::checkbox('orderUpdate[email]', 1, @$data['orderUpdate']->email == 1 ? true : false, [
                                    'class' => 'form-check-input'
                                ]) }}                                
                            </td>
                            <td>
                                {{ Form::checkbox('orderUpdate[mobile]', 1, @$data['orderUpdate']->mobile == 1 ? true : false, [
                                    'class' => 'form-check-input'
                                ]) }}                                
                            </td>
                        </tr>
                        <tr>
                            <td>Order Finished</td>
                            {{ Form::hidden('orderFinishedId', @$data['orderFinished']->id) }}
                            <td>
                                {{ Form::checkbox('orderFinished[notification]', 1, @$data['orderFinished']->notification == 1 ? true : false, [
                                    'class' => 'form-check-input'
                                ]) }}                                
                            </td>
                            <td>
                                {{ Form::checkbox('orderFinished[email]', 1, @$data['orderFinished']->email == 1 ? true : false, [
                                    'class' => 'form-check-input'
                                ]) }}                                
                            </td>
                            <td>
                                {{ Form::checkbox('orderFinished[mobile]', 1, @$data['orderFinished']->mobile == 1 ? true : false, [
                                    'class' => 'form-check-input'
                                ]) }}                                
                            </td>
                        </tr>
                        <tr>
                            <td>Events &amp; Discounts</td>
                            {{ Form::hidden('eventDiscountId', @$data['eventDiscount']->id) }}
                            <td>
                                {{ Form::checkbox('eventDiscount[notification]', 1, @$data['eventDiscount']->notification == 1 ? true : false, [
                                    'class' => 'form-check-input'
                                ]) }}                                
                            </td>
                            <td>
                                {{ Form::checkbox('eventDiscount[email]', 1, @$data['eventDiscount']->email == 1 ? true : false, [
                                    'class' => 'form-check-input'
                                ]) }}                                
                            </td>
                            <td>
                                {{ Form::checkbox('eventDiscount[mobile]', 1, @$data['eventDiscount']->mobile == 1 ? true : false, [
                                    'class' => 'form-check-input'
                                ]) }}                                
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="text-end mt-sm-5 mt-4">
            {{ Form::button('Save', [
               'class' => 'btn custom-btn-main',
               'id' => 'manageNotificationBtn',
               'type' => 'submit'
            ]) }}
        </div>
        {{ Form::close() }}
    </div>
</section>
@endsection
@section('customScript')
<script src="{{ asset('assets/js/jquery.validate.min.js') }}"></script>
<script type="text/javascript">
   $("#manageNotification").validate({    
      rules: {
         name: {
            required: true,
         },         
      },
      messages: {
         name: "Please enter name!",               
      },
      submitHandler: function(form) {
         var serializedData = $(form).serialize();
         $("#err_mess").html('');
         $('#manageNotificationBtn').attr('disabled');
         $('#manageNotificationBtn').html('Processing <i class="fa fa-spinner fa-spin"></i>');      
         $.ajax({
            headers: {
              'X-CSRF-Token': $('input[name="_token"]').val()
            },
            type: 'post',
            url: "{{ route('manageNotification') }}",
            data: serializedData,
            dataType: 'json',
            success: function(data) {
                if (data.status == true) {
                    $('#manageNotificationBtn').html('Saved');
                    $('.successMsg').html(data.message);
                    $("#successModel").modal("show");
                    $('.okMsgBtn').on('click', function(){
                        window.location.reload();
                    });
                } else {
                    $('.errorMsg').html(data.message);
                    $("#errorModel").modal("show");
                }
            }
         });
      return false;
      }
   });
</script>
@endsection