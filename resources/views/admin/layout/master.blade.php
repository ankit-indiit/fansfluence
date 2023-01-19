
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
        <title>Fansfluence || Admin Dashboard</title>
        <meta name="csrf-token" content="{{ csrf_token() }}" />
        <link rel="icon" href="{{ asset('assets/img/logo-icon2.png') }}" sizes="16x16" type="image/png">
        <link rel="stylesheet" href="{{ asset('admin/assets/plugins/bootstrap/css/bootstrap.min.css') }}">
        <link rel="stylesheet" href="{{ asset('admin/assets/plugins/fontawesome/css/fontawesome.min.css') }}">
        <link rel="stylesheet" href="{{ asset('admin/assets/plugins/fontawesome/css/all.min.css') }}">
        <link rel="stylesheet" href="{{ asset('admin/assets/css/bootstrap-datetimepicker.min.css') }}">
        <link rel="stylesheet" href="{{ asset('admin/assets/plugins/datatables/datatables.min.css') }}">
        <link rel="stylesheet" href="{{ asset('admin/assets/css/animate.min.css') }}">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Spartan:wght@300;400;500;600;700&display=swap">
        <link rel="stylesheet" href="{{ asset('admin/assets/css/admin.css') }}">
        <link rel="stylesheet" href="{{ asset('admin/assets/css/responsive.css') }}">
        <link rel="stylesheet" href="{{ asset('admin/assets/css/sweetalert2.min.css') }}">
        {{-- <link rel="stylesheet" href="{{ asset('assets/editor.css') }}"> --}}
        <script src="{{ asset('admin/assets/js/sweetalert2.min.js') }}"></script>
        <link href="{{ asset('admin/assets/css/toastr.css') }}" rel="stylesheet" />
        <link href="{{ asset('admin/assets/css/select2.min.css') }}" rel="stylesheet" />
        <link rel="stylesheet" type="text/css" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
        <link href="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/css/bootstrap4-toggle.min.css" rel="stylesheet">
        <script>
           var _baseURL = '{{ url('/') }}';
        </script>
    </head>
    <body>
        <div class="main-wrapper">
            @include('admin.layout.header')
            @include('admin.layout.sidebar')
            @yield('content')
        </div>

        <!-- Delete Modal -->
        <div class="modal fade modalCss" tabindex="-1" id="deletemodal">
          <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
              <div class="modal-body">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>

                <i class="far fa-times-circle"></i>
                <p>Are you sure you want to delete this records? This process cannot be undone</p>
                <div>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-danger">Delete</button>
                </div>
              </div>
            </div>
          </div>
        </div>

        <script src="{{ asset('admin/assets/js/jquery-3.5.0.min.js') }}"></script>
        <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
        <script src="{{ asset('admin/assets/js/popper.min.js') }}"></script>
        <script src="{{ asset('admin/assets/plugins/bootstrap/js/bootstrap.min.js') }}"></script>
        <script src="{{ asset('admin/assets/plugins/slimscroll/jquery.slimscroll.min.js') }}"></script>
        <script src="{{ asset('admin/assets/js/moment.min.js') }}"></script>
        <script src="{{ asset('admin/assets/js/bootstrap-datetimepicker.min.js') }}"></script>
        <script src="{{ asset('admin/assets/plugins/datatables/datatables.min.js') }}"></script>        
        <script src="{{ asset('admin/assets/js/admin.js') }}"></script>
        <script src="{{ asset('admin/assets/js/jquery.validate.min.js') }}"></script>
        <script src="{{ asset('admin/assets/js/custom-script.js') }}"></script>
        <script src="{{ asset('admin/editor.js') }}"></script>
        <script src="{{ asset('admin/assets/js/toastr.js') }}"></script>
        <script src="{{ asset('admin/assets/js/select2.min.js') }}"></script>
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
        <script src="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/js/bootstrap4-toggle.min.js"></script>
        @yield('customScript')        
        <script>
            $(document).ready(function() {
                $('.multiple').select2();
                // $('.multiple').select2({disabled:'readonly'});
            });

            $(document).ready(function() {
                toastr.options.timeOut = 10000;
                @if (Session::has('error'))
                    toastr.error('{{ Session::get('error') }}');
                @endif
                @if(Session::has('success'))
                    toastr.success('{{ Session::get('success') }}');
                @endif

                @if(Session::has('status'))
                    toastr.success('{{ Session::get('status') }}');
                @endif
          });        
        </script>
    </body>
</html>