@extends('layout.master')
@section('content')
<section class="pt-5 pb-5 order-details-section">
    <div class="container">
        <div class="d-flex mb-4">
            <h3 class="section-title">Link Bank Account</h3>
        </div>
        {{ Form::open([
            'url' => route('linkBankAcc'),
            'id' => 'linkBankAcc',
            'class' => 'row g-4 order-details-form'
        ]) }}
            <div class="col-md-6">
                <div class="form-group">
                    {{ Form::label('bank_acc_registerd_in', 'Bank Account Registerd in', ['class' => 'form-label']) }}
                   {{ Form::select('bank_acc_registerd_in', [
                        '' => 'Select one',
                        'Canada' => 'Canada',
                        'One' => 'One',
                        'Two' => 'Two',
                        'Three' => 'Three',
                    ], @$account->bank_acc_registerd_in, ['class' => 'form-select form-control']); }}
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    {{ Form::label('bic_swift_code', 'BIC/Swift Code', ['class' => 'form-label']) }}
                    {{ Form::text('bic_swift_code', @$account->bic_swift_code, ['class' => 'form-control', 'id' => '', 'placeholder' => 'Enter number']) }}
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    {{ Form::label('routing_number', 'Routing Number', ['class' => 'form-label']) }}
                    {{ Form::text('routing_number', @$account->routing_number, ['class' => 'form-control', 'id' => '', 'placeholder' => 'Enter number']) }}                    
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    {{ Form::label('account_number', 'Account Number', ['class' => 'form-label']) }}
                    {{ Form::text('account_number', @$account->account_number, ['class' => 'form-control', 'id' => '', 'placeholder' => 'Enter number']) }} 
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    {{ Form::label('account_name', 'Account Name', ['class' => 'form-label']) }}
                    {{ Form::text('account_name', @$account->account_name, ['class' => 'form-control', 'id' => '', 'placeholder' => 'Enter number']) }} 
                </div>
            </div>
            {{ Form::hidden('id', @$account->id) }} 
            <div class="col-12 text-end mt-sm-5 mt-4">
                {{ Form::button(@$account->id ? 'Update' : 'Add', [
                   'class' => 'btn custom-btn-main',
                   'id' => 'linkBankAccBtn',
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
    jQuery.validator.addMethod("lettersonly", function(value, element) {
        return this.optional(element) || /^[a-z\s]+$/i.test(value);
    });

    $("#linkBankAcc").validate({   
        rules: {
            bank_acc_registerd_in: {
                required: true,
            },
            bic_swift_code: {
                required: true,
                minlength: 8,
                maxlength: 10,
                // number: true
            },
            routing_number: {
                required: true,
                minlength: 9,
                number: true
            },
            account_number: {
                required: true,
                minlength: 12,
                number: true
            },
            account_name: {
                required: true,
                lettersonly: true
            },                   
        },
        messages: {
            bank_acc_registerd_in: "Please enter name!",
            bic_swift_code: {
                required: "Please enter code!",
                minlength: "Min Length must be 8 characters!",
                maxlength: "Max Length must be 10 characters!",
                // number: "Enter only numeric value!",
            },
            routing_number: {
                required: "Please enter number!",
                number: "Enter only numeric value!",
                minlength: "Min Length must be 9 characters!",
            },
            account_number: {
                required: "Please enter number!",
                minlength: "Min Length must be 12 characters!",
                number: "Enter only numeric value!",
            },
            account_name: {
                required: "Please enter name!",
                lettersonly: "Only alphabetical characters!",
            },
        },
        submitHandler: function(form) {
            var serializedData = $(form).serialize();
            $("#err_mess").html('');
            $('#linkBankAccBtn').attr('disabled');
            $('#linkBankAccBtn').html('Processing <i class="fa fa-spinner fa-spin"></i>');      
            $.ajax({
                headers: {
                'X-CSRF-Token': $('input[name="_token"]').val()
                },
                type: 'post',
                url: "{{ route('linkBankAcc') }}",
                data: serializedData,
                dataType: 'json',
                success: function(data) {
                    if (data.status == true) {
                        $('#linkBankAccBtn').html('Submitted');
                        $('.successMsg').html(data.message);
                        $("#successModel").modal("show");
                        // $('#linkBankAcc').trigger("reset");
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