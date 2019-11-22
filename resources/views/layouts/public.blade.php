@include('partials.header')
        <!-- Content Wrapper -->
            <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

            @include('partials.admin-topbar')

            <!-- Begin Page Content -->
            <div>

                @yield('content')

            </div>
            <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <footer class="sticky-footer bg-white mt-4">
            <div class="container my-auto">
                <div class="copyright text-center my-auto">
                <span>Copyright &copy; Your Website {{date('Y')}}</span>
                </div>
            </div>
            </footer>
            <!-- End of Footer -->

            </div>
            <!-- End of Content Wrapper -->
@include('partials.footer')