@include('admin.layouts.head')

<body>
    <!-- container-scroller -->
    <div class="container-scroller">
        <!-- banner -->
        {{-- @include('admin.layouts.banner') --}}
        <!-- sidebar -->
        @include('admin.layouts.sidebar')
        <!-- wrapper -->
        <div class="container-fluid page-body-wrapper">
            <!-- navbar -->
            @include('admin.layouts.navbar')
            <!-- main panel -->
            <div class="main-panel">
                <!-- body -->
                <div class="content-wrapper">
                    @yield('content')
                </div>
                <!-- footer -->
                @include('admin.layouts.footer')
            </div>
        </div>
    </div>

    <!-- plugins:js -->
    @include('admin.layouts.plugins')
</body>

</html>
