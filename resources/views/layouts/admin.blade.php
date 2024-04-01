<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>
        @if (@$general_setting->site_name)
            {{ @$general_setting->site_name }}
        @else
            Admin
            Dashboard
        @endif
    </title>
    <link rel="shortcut icon" type="image/png" href="{{ asset('storage/frontend/assets/dist/images/main-logo.png') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('storage/admin/assets/plugins/fontawesome-free/css/all.min.css') }}">
    <!-- Select2 -->
    <link rel="stylesheet" href="{{ asset('storage/admin/assets/plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet"
        href="{{ asset('storage/admin/assets/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Tempusdominus Bootstrap 4 -->
    <link rel="stylesheet"
        href="{{ asset('storage/admin/assets/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}">
    <!-- iCheck -->
    <link rel="stylesheet"
        href="{{ asset('storage/admin/assets/plugins/icheck-bootstrap/icheck-bootstrap.min.css ') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('storage/admin/assets/dist/css/adminlte.min.css') }}">
    <!-- overlayScrollbars -->
    <link rel="stylesheet"
        href="{{ asset('storage/admin/assets/plugins/overlayScrollbars/css/OverlayScrollbars.min.css') }}">
    <!-- Daterange picker -->
    <link rel="stylesheet" href="{{ asset('storage/admin/assets/plugins/daterangepicker/daterangepicker.css') }}">
    <!-- summernote -->
    <link rel="stylesheet" href="{{ asset('storage/admin/assets/plugins/summernote/summernote-bs4.min.css') }}">
    <link rel="stylesheet"
        href="{{ asset('storage/admin/assets/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
    <link rel="stylesheet"
        href="{{ asset('storage/admin/assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet"
        href="{{ asset('storage/admin/assets/plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
    <link rel="stylesheet"
        href="{{ asset('storage/admin/assets/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css') }}">

    <link rel="stylesheet" href="{{ asset('storage/admin/assets/plugins/toastr/toastr.min.css') }}">
    <link rel="stylesheet" href="{{ asset('storage/admin/assets/dist/css/tags-input.min.css') }}">
    <link rel="stylesheet" href="{{ asset('storage/admin/assets/dist/css/style.css') }}">
    <link rel="stylesheet"
        href="{{ asset('storage/admin/assets/plugins/bootstrap-iconpicker/css/bootstrap-iconpicker.min.css') }}">
    <!-- jQuery -->
    <script src="{{ asset('storage/admin/assets/plugins/jquery/jquery.min.js') }}"></script>
    <script>
        var BASE_URL = "{{ url('/') }}";
    </script>

</head>
@yield('style')

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
        <div id="app">
            @include('admin.partials.header')
            @include('admin.partials.sidebar')
            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper">
                <!-- /.content-header -->
                <section class="content">
                    @yield('content')
                </section>
            </div>
            @include('admin.partials.footer')
        </div>
        <!-- /.navbar -->
    </div>
    <!-- ./wrapper -->

    <!-- jQuery UI 1.11.4 -->
    <script src="{{ asset('storage/admin/assets/plugins/jquery-ui/jquery-ui.min.js') }}"></script>
    <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
    <script>
        $.widget.bridge('uibutton', $.ui.button)
    </script>
    <script src="{{ asset('storage/admin/assets/dist/js/spartan-multi-image-picker-min.js') }}"></script>
    <!-- Bootstrap 4 -->
    <script src="{{ asset('storage/admin/assets/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <!-- ChartJS -->
    <script src="{{ asset('storage/admin/assets/plugins/chart.js/Chart.min.js') }}"></script>
    <!-- Sparkline -->
    <script src="{{ asset('storage/admin/assets/plugins/sparklines/sparkline.js') }}"></script>
    <!-- jQuery Knob Chart -->
    <script src="{{ asset('storage/admin/assets/plugins/jquery-knob/jquery.knob.min.js') }}"></script>
    <!-- daterangepicker -->
    <script src="{{ asset('storage/admin/assets/plugins/moment/moment.min.js') }}"></script>
    <script src="{{ asset('storage/admin/assets/plugins/daterangepicker/daterangepicker.js') }}"></script>
    <!-- Tempusdominus Bootstrap 4 -->
    <script
        src="{{ asset('storage/admin/assets/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}">
    </script>
    <!-- Summernote -->
    <script src="{{ asset('storage/admin/assets/plugins/summernote/summernote-bs4.min.js') }}"></script>
    <!-- overlayScrollbars -->
    <script src="{{ asset('storage/admin/assets/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.min.js"></script>
    <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/additional-methods.js"></script>

    <!-- DataTables  & Plugins -->
    <script src="{{ asset('storage/admin/assets/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('storage/admin/assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('storage/admin/assets/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}">
    </script>
    <script src="{{ asset('storage/admin/assets/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}">
    </script>
    <script src="{{ asset('storage/admin/assets/plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('storage/admin/assets/plugins/datatables-buttons/js/buttons.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('storage/admin/assets/plugins/datatables-buttons/js/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('storage/admin/assets/plugins/datatables-buttons/js/buttons.print.min.js') }}"></script>
    <script src="{{ asset('storage/admin/assets/plugins/datatables-buttons/js/buttons.colVis.min.js') }}"></script>

    <script src="{{ asset('storage/admin/assets/plugins/toastr/toastr.min.js') }}"></script>
    <script src="{{ asset('storage/admin/assets/plugins/sweetalert2/sweetalert2.min.js') }}"></script>
    <script src="{{ asset('storage/admin/assets/plugins/select2/js/select2.full.min.js') }}"></script>
    <script src="{{ asset('storage/admin/assets/plugins/bootstrap-switch/js/bootstrap-switch.min.js') }}"></script>
    <script type="text/javascript"
        src="{{ asset('storage/admin/assets/plugins/bootstrap-iconpicker/js/bootstrap-iconpicker.bundle.min.js') }}">
    </script>
    <!-- AdminLTE App -->
    <script src="{{ asset('storage/admin/assets/dist/js/adminlte.js') }}"></script>
    <!-- tags-input  -->
    <script src="{{ asset('storage/admin/assets/dist/js/tags-input.min.js') }}"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="{{ asset('storage/admin/assets/dist/js/demo.js') }}"></script>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.6.0/dist/leaflet.css"
        integrity="sha512-xwE/Az9zrjBIphAcBb3F6JVqxf46+CDLwfLMHloNu6KEQCAWi6HcDUbeOfBIptF7tcCzusKFjFw2yuvEpDL9wQ=="
        crossorigin="" />
    <script>
        $('.select2').select2();

        @if (Session::has('message'))
            toastr.options = {
                "closeButton": true,
                "progressBar": true
            }
            toastr.success("{{ session('message') }}");
        @endif

        @if (Session::has('error'))
            toastr.options = {
                "closeButton": true,
                "progressBar": true
            }
            toastr.error("{{ session('error') }}");
        @endif

        @if (Session::has('info'))
            toastr.options = {
                "closeButton": true,
                "progressBar": true
            }
            toastr.info("{{ session('info') }}");
        @endif

        @if (Session::has('warning'))
            toastr.options = {
                "closeButton": true,
                "progressBar": true
            }
            toastr.warning("{{ session('warning') }}");
        @endif

        //sidebar serach :start
        $('#searchInput').on('keyup', function() {
            var searchText = $(this).val().toLowerCase();
            $('.nav-item').each(function() {
                var menuItemText = $(this).text().toLowerCase();
                if (menuItemText.includes(searchText)) {
                    $(this).show();
                    $(this).parents('.nav-item').addClass('menu-open');
                } else {
                    $(this).hide();
                }
            });

            if (searchText === '') {
                $('.nav-item').removeClass('menu-open');
            }
        });
        //side bar serach :end
    </script>
    @yield('scripts')
</body>

</html>
