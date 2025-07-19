            <!-- Scripts -->
            @vite(['resources/css/app.css', 'resources/js/app.js'])

            <!-- Google Font: Source Sans Pro -->
            <link rel="stylesheet"
                href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">

            <!-- Select 2 plugin -->
            <link rel="stylesheet" href="{{ asset('admin/plugins/select2/css/select2.min.css') }}">
            <!-- Tempusdominus Bootstrap 4 -->
            <link rel="stylesheet"
                href="{{ asset('admin/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}">
            <link rel="stylesheet" href="{{ asset('admin/plugins/bs-custom-file-input/bs-custom-file-input.min.js') }}">
            <!-- iCheck -->

            <!-- Dualist box  -->
            <link rel="stylesheet"
                href="{{ asset('admin/plugins/bootstrap4-duallistbox/bootstrap-duallistbox.min.css') }}">
            <!-- toastr -->
            <link rel="stylesheet" href="{{ asset('admin/plugins/toastr/toastr.min.css') }}">

            <!-- Custom style -->
            <link rel="stylesheet" href="{{ asset('admin/dist/css/custom.css') }}">
            <!-- Datatables plugins -->
            <link rel="stylesheet" href="{{ asset('admin/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
            <link rel="stylesheet"
                href="{{ asset('admin/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">

            <!-- Font Awesome -->
            <link rel="stylesheet" href="{{ asset('admin/plugins/fontawesome-free/css/all.min.css') }}">
            <!-- Ionicons -->
            <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
            <!-- Tempusdominus Bootstrap 4 -->
            <link rel="stylesheet"
                href="{{ asset('admin/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}">
            <!-- iCheck -->
            <link rel="stylesheet" href="{{ asset('admin/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
            <!-- JQVMap -->
            <link rel="stylesheet" href="{{ asset('admin/plugins/jqvmap/jqvmap.min.css') }}">
            <!-- Theme style -->
            <link rel="stylesheet" href="{{ asset('admin/dist/css/adminlte.min.css') }}">
            <!-- overlayScrollbars -->
            <link rel="stylesheet" href="{{ asset('admin/plugins/overlayScrollbars/css/OverlayScrollbars.min.css') }}">
            <!-- Daterange picker -->
            <link rel="stylesheet" href="{{ asset('admin/plugins/daterangepicker/daterangepicker.css') }}">
            <!-- summernote -->
            <link rel="stylesheet" href="{{ asset('admin/plugins/summernote/summernote-bs4.min.css') }}">

            @yield('css')
