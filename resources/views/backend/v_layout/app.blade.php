<!DOCTYPE html>
<html dir="ltr" lang="en">
<head>
    @include('backend.v_layout.header')
</head>
<body>
    {{-- PRELOADER (opsional) --}}
    <div class="preloader">
        <div class="lds-ripple"><div class="lds-pos"></div><div class="lds-pos"></div></div>
    </div>

    <div id="main-wrapper">

        {{-- SIDEBAR (template lama) --}}
        @include('backend.v_layout.sidebar')

        {{-- PAGE WRAPPER --}}
        <div class="page-wrapper">

            {{-- TOPBAR --}}
            @include('backend.v_layout.topbar')

            {{-- MAIN CONTENT: pastikan container-fluid (typo fixed) --}}
            <div class="container-fluid">
                @yield('content')
            </div>

            {{-- FOOTER --}}
            @include('backend.v_layout.footer')
        </div>
    </div>

    <!-- =========================
         SCRIPTS (only once, tidy)
         ========================= -->
    <script src="{{ asset('backend/libs/jquery/dist/jquery.min.js') }}"></script>
    <script src="{{ asset('backend/libs/popper.js/dist/umd/popper.min.js') }}"></script>
    <script src="{{ asset('backend/libs/bootstrap/dist/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('backend/libs/perfect-scrollbar/dist/perfect-scrollbar.jquery.min.js') }}"></script>

    <!-- template behavior -->
    <script src="{{ asset('backend/dist/js/sidebarmenu.js') }}"></script>
    <script src="{{ asset('backend/dist/js/custom.min.js') }}"></script>

    <!-- DataTables -->
    <script src="{{ asset('backend/extra-libs/DataTables/datatables.min.js') }}"></script>

    <!-- SweetAlert2 only (modern) -->
    <script src="{{ asset('sweetalert/sweetalert2.all.min.js') }}"></script>

    <script>
    (function(){
        // Init DataTable if exists
        $(document).ready(function(){
            if ($('#zero_config').length) {
                $('#zero_config').DataTable();
            }
        });

        // Mobile toggler: toggle body class to show/hide sidebar on small screens
        function toggleSidebar() {
            document.body.classList.toggle('sidebar-open');
        }

        // wire up toggles
        document.addEventListener('click', function(e){
            if (e.target.closest('.nav-toggler') || e.target.closest('.sidebartoggler')) {
                toggleSidebar();
            }
        });

        // Close sidebar on click outside (mobile)
        document.addEventListener('click', function(e){
            if (document.body.classList.contains('sidebar-open')) {
                var sidebar = document.querySelector('.left-sidebar');
                if (sidebar && !e.target.closest('.left-sidebar') && !e.target.closest('.nav-toggler') && !e.target.closest('.sidebartoggler')) {
                    document.body.classList.remove('sidebar-open');
                }
            }
        });

        // SweetAlert2 helper for delete confirmation (use class .show_confirm on button)
        document.addEventListener('click', function(e){
            var el = e.target.closest('.show_confirm');
            if (!el) return;
            e.preventDefault();
            var form = el.closest('form');
            var konfdelete = el.dataset.konfDelete || el.getAttribute('data-konf-delete') || 'item ini';
            Swal.fire({
                title: 'Konfirmasi Hapus Data?',
                html: "Data yang dihapus <strong>" + konfdelete + "</strong> tidak dapat dikembalikan!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, hapus',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });

    })();
    </script>
</body>
</html>
