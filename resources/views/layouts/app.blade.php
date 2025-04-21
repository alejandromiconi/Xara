@include('partials.header')

<body class="layout-fixed sidebar-expand-lg bg-body-tertiary">

    <div id="loading" style="font-size:largest;">
        <!-- you can set whatever style you want on this -->
        Loading, please wait...
    </div>

    <!--begin::App Wrapper-->
    <div class="app-wrapper">

        <!-- Page Heading -->
        <x-admin-lte.navigator />

        <!-- Main Sidebar Container -->
        <x-admin-lte.sidebar />

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper p-2">
            {{ $slot }}
        </div>
        {{--
        @include('partials.footer') --}}

    </div>
    <!-- ./wrapper -->


    @include('partials.footer')

    <script type="text/javascript">
        $(document).ready(function() {
            $('.wrapper').show();
            $('#loading').hide();
        });
    </script>

    <div class="modal fade" id="modal-messages" aria-hidden="true" style="display: none;">
        <div class="modal-dialog modal-lg">
            <div class="modal-content bg-light">
                <div class="modal-header">
                    <h4 class="modal-title" data="{{ __('Messages') }}"></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">x</span>
                    </button>
                </div>
                <div class="modal-body">
                </div>
                <div class="modal-footer justify-content-right"> {{-- justify-content-between --}}
                    <button type="button" class="btn btn-outline-dark" data-dismiss="modal">
                        {{ __('Close') }}</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>

    <a class="btn-scroll btn-info scroll-up" role="button">
        <i class="fas fa-chevron-up"></i>
    </a>

    <a class="btn-scroll btn-info scroll-down" role="button">
        <i class="fas fa-chevron-down"></i>
    </a>

    {{--
    <a id="back-to-top" href="#" class="btn btn-info back-to-top opacity-25" 
        role="button" aria-label="Scroll to top">
        <i class="fas fa-chevron-up"></i>
    </a>
 --}}

</body>

</html>
<!-- 
<script>
    $(function() {
        notifications();
        setInterval(notifications, REFRESH_CHAT_SECONDS * 1000); // Actualiza cada segundo..
    });
</script>
 -->