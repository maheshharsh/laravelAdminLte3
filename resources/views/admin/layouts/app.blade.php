<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('page_title', config('app.name'))</title>
    @include('admin.layouts.htmlheader')
</head>

<body class="hold-transition sidebar-mini layout-fixed">

    <div class="wrapper">
        <!-- Header -->
        @include('admin.layouts.top-nav')
        <!-- Sidebr -->
        @include('admin.layouts.side-nav')
        <!-- Content -->
        <div class="content-wrapper px-3">
            <!-- Page Content Here -->
            <section class="content">

                <div class="row">
                    <div class="col-md-12">


                        <!--===================================
                                Card Content Here
                            =====================================-->
                        <div class="card mt-4 elevation-2">

                            <!-- Card Header Here -->
                            <div class="card-header">
                                <div class="card-title">
                                    <h3 class="m-0">
                                        <!-- Card Header Title -->
                                        @yield('contentheader_title')
                                    </h3>
                                </div>
                                <div class="card-tools">
                                    <!-- Card Header Button -->
                                    @yield('contentheader_btn')
                                </div>
                            </div>

                            <!--=======================================
                                    Card Body Here
                                =========================================-->
                            @yield('content')

                        </div>

                    </div>
                </div>
            </section>
        </div>

        @include('admin.layouts.footer')
    </div>
    <script>
        /*** add active class and stay opened when selected ***/
        var url = window.location;

        // for sidebar menu entirely but not cover treeview
        $('ul.nav-sidebar a').filter(function() {
            if (this.href) {
                return this.href == url || url.href.indexOf(this.href) == 0;
            }
        }).addClass('active');

        // for the treeview
        $('ul.nav-treeview a').filter(function() {
            if (this.href) {
                return this.href == url || url.href.indexOf(this.href) == 0;
            }
        }).parentsUntil(".nav-sidebar > .nav-treeview").addClass('menu-open').prev('a').addClass('active');

        @if (session()->has('info'))
            toastr.info("{{ __(session('info')) }}");
        @endif
        @if (session()->has('warning'))
            toastr.info("{{ __(session('warning')) }}");
        @endif
        @if (session()->has('success'))
            toastr.success("{{ __(session('success')) }}");
        @endif
        @if (session()->has('error'))
            toastr.error("{{ __(session('error')) }}");
        @endif
        @if ($errors->any())
            @foreach ($errors->all() as $error)
                toastr.error("{{ $error }}");
            @endforeach
        @endif
    </script>
    @yield('javascript')
</body>

</html>
