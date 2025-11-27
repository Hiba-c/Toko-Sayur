<!-- backend/v_layout/topbar.blade.php -->
<!-- Topbar header -->
<header class="topbar" data-navbarbg="skin5">
    <nav class="navbar top-navbar navbar-expand-md navbar-dark">
        <div class="navbar-header" data-logobg="skin5" style="background-color: #1f1f1f;">
            <style>
                /* local override untuk memastikan warna navbar konsisten */
                [data-logobg="skin5"] { background-color: #1f1f1f !important; }
                [data-navbarbg="skin5"] { background-color: #1f1f1f !important; }
                .navbar-header .navbar-brand img { max-height: 40px; }
            </style>

            <!-- sidebar toggle (mobile) -->
            <a class="nav-toggler waves-effect waves-light d-block d-md-none" href="javascript:void(0)">
                <i class="ti-menu ti-close"></i>
            </a>

            <!-- Logo -->
            <a class="navbar-brand" href="{{ url('/') }}">
                <b class="logo-icon p-l-10">
                    <img src="{{ asset('image/ikon_SayurKu.jpeg') }}" alt="homepage" class="light-logo" />
                </b>
                <span class="logo-text">
                    <img src="{{ asset('image/logo_text.png') }}" alt="homepage" class="light-logo" />
                </span>
            </a>

            <!-- topbar toggler (mobile) -->
            <a class="topbartoggler d-block d-md-none waves-effect waves-light"
               href="javascript:void(0)"
               data-toggle="collapse"
               data-target="#navbarSupportedContent"
               aria-controls="navbarSupportedContent"
               aria-expanded="false"
               aria-label="Toggle navigation">
                <i class="ti-more"></i>
            </a>
        </div>

        <div class="navbar-collapse collapse" id="navbarSupportedContent" data-navbarbg="skin5">
            <ul class="navbar-nav float-left mr-auto">
                <li class="nav-item d-none d-md-block">
                    <!-- desktop sidebar toggler -->
                    <a class="nav-link sidebartoggler waves-effect waves-light" href="javascript:void(0)">
                        <i class="mdi mdi-menu font-24"></i>
                    </a>
                </li>
            </ul>

            <ul class="navbar-nav float-right">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle text-muted waves-effect waves-dark pro-pic"
                       href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        @if (Auth::user() && Auth::user()->foto)
                            <img src="{{ asset('storage/img-user/' . Auth::user()->foto) }}"
                                 alt="user" class="rounded-circle" width="31">
                        @else
                            <img src="{{ asset('storage/img-user/img-default.jpg') }}"
                                 alt="user" class="rounded-circle" width="31">
                        @endif
                    </a>
                    <div class="dropdown-menu dropdown-menu-right user-dd animated">
                        <a class="dropdown-item" href="{{ route('backend.user.edit', Auth::id() ?? 0) }}">
                            <i class="ti-user m-r-5 m-l-5"></i> Profil Saya
                        </a>
                        <a class="dropdown-item" href=""
                           onclick="event.preventDefault(); document.getElementById('keluar-app').submit();">
                            <i class="fa fa-power-off m-r-5 m-l-5"></i> Keluar
                        </a>
                        <div class="dropdown-divider"></div>
                    </div>
                </li>
            </ul>
        </div>
    </nav>
</header>
