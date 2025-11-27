<!-- backend/v_layout/sidebar.blade.php -->
<aside class="left-sidebar" data-sidebarbg="skin5" style="background:#1f1f1f;">
    <div class="scroll-sidebar">
        <nav class="sidebar-nav">
            <ul id="sidebarnav" class="p-t-30">

                <li class="sidebar-item">
                    <a href="{{ route('backend.beranda') }}"
                       class="sidebar-link waves-effect waves-dark {{ request()->routeIs('backend.beranda') ? 'active' : '' }}">
                        <i class="mdi mdi-view-dashboard"></i>
                        <span class="hide-menu">Beranda</span>
                    </a>
                </li>

                <li class="sidebar-item">
                    <a href="{{ route('backend.pos') }}"
                       class="sidebar-link waves-effect waves-dark {{ request()->is('backend/pos*') ? 'active' : '' }}">
                        <i class="mdi mdi-cart"></i>
                        <span class="hide-menu">POS</span>
                    </a>
                </li>

                <li class="sidebar-item">
                    <a href="{{ route('backend.transaksi.index') }}"
                       class="sidebar-link {{ request()->is('backend/transaksi*') ? 'active' : '' }}">
                        <i class="mdi mdi-receipt"></i>
                        <span class="hide-menu">Transaksi</span>
                    </a>
                </li>

                <li class="sidebar-item">
                    <a href="{{ route('backend.laporan.index') }}"
                       class="sidebar-link {{ request()->is('backend/laporan*') ? 'active' : '' }}">
                        <i class="mdi mdi-chart-line"></i>
                        <span class="hide-menu">Laporan</span>
                    </a>
                </li>

                <li class="sidebar-item">
                    <a href="{{ route('backend.produk.index') }}"
                       class="sidebar-link {{ request()->is('backend/produk*') ? 'active' : '' }}">
                        <i class="mdi mdi-store"></i>
                        <span class="hide-menu">Produk</span>
                    </a>
                </li>

                <li class="sidebar-item">
                    <a href="{{ route('backend.kategori.index') }}"
                       class="sidebar-link {{ request()->is('backend/kategori*') ? 'active' : '' }}">
                        <i class="mdi mdi-tag"></i>
                        <span class="hide-menu">Kategori</span>
                    </a>
                </li>

                <li class="sidebar-item">
                    <a href="{{ route('backend.user.index') }}"
                       class="sidebar-link {{ request()->is('backend/user*') ? 'active' : '' }}">
                        <i class="mdi mdi-account-multiple"></i>
                        <span class="hide-menu">User</span>
                    </a>
                </li>

                <li class="sidebar-item mt-4">
                    <form action="{{ route('backend.logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-outline-danger w-100">Logout</button>
                    </form>
                </li>

            </ul>
        </nav>
    </div>
</aside>
