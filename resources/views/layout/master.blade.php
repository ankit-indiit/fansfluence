<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Fansfluence</title>
        <meta name="csrf-token" content="{{ csrf_token() }}" />
        <link rel="icon" href="{{ asset('assets/img/logo-icon2.png') }}" sizes="16x16" type="image/png">
        <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet">
        <link href="{{ asset('assets/css/owl.carousel.min.css') }}" rel="stylesheet">
        <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet">
        <link href="{{ asset('assets/css/responsive.css') }}" rel="stylesheet">
        <link href="{{ asset('assets/css/toastr.css') }}" rel="stylesheet">
        <link href="{{ asset('assets/css/dropzone.min.css') }}" rel="stylesheet">
        <script type="text/javascript">
            _baseURL = '{{url('/')}}';
        </script>
    </head>
    <body>
        
        @include('layout.header')         
        
        @yield('content')
        
        @include('layout.footer')
        
        @yield('customModal')        
        
        @include('module.component.custom-model')

        @include('module.component.success', ['session' => Session::has('success')])
        @include('module.component.error', ['session' => Session::has('error')])
        <script src="{{ asset('assets/js/jquery.min.js') }}"></script>
        <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
        <script src="{{ asset('assets/js/feather.min.js') }}"></script>
        <script src="{{ asset('assets/js/owl.carousel.min.js') }}"></script>
        <script src="{{ asset('assets/js/main.js') }}"></script>
        <script src="{{ asset('assets/js/jquery.validate.min.js') }}"></script>
        <script src="{{ asset('assets/js/custom-script.js') }}"></script>
        <script src="{{ asset('assets/js/toastr.js') }}"></script>
        <script src="{{ asset('assets/js/dropzone.min.js') }}"></script>          
        <script>
            $(document).on('keyup', '#searchBox', function(){
                var search = $(this).val();
                $.ajax({                    
                    type: 'get',
                    url: "{{ route('searchBox') }}",
                    data: {
                        search: search
                    },                    
                    success: function(data) {
                        if (data.status == true) {
                            $('.searchdrop').toggle();                        
                            $('.searchdrop').html(data.data);                        
                        } else {
                            $('.searchdrop').toggle();
                        }
                    }
                });
            });

            $(document).on('click', '.name-list', function(){
                var name = $(this).data('name');
                $('#searchBox').val(name);
                $('#search').submit();
            })

            $(document).on('click', '.okMsgBtn', function(){
                $('.custom-model-design').removeClass('show');
                $('.custom-model-design').css('display', 'none');            
            })
                    
        </script>        
        @yield('customScript')
    </body>
</html>