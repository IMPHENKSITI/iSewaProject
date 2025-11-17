<!-- Sidebar -->
<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    <div class="app-brand demo">
        <a href="{{ route('admin.dashboard') }}" class="app-brand-link">
            <span class="app-brand-logo demo">
                <img src="{{ asset('admin/img/favicon/isewalogo.png') }}" alt="Logo" style="width: 40px; height: 40px;">
            </span>
            <span class="app-brand-text demo menu-text fw-bold ms-2">iSewa Admin</span>
        </a>

        <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
            <i class="bx bx-chevron-left bx-sm align-middle"></i>
        </a>
    </div>

    <div class="menu-inner-shadow"></div>

    <ul class="menu-inner py-1">
        <!-- Dashboard -->
        <li class="menu-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
            <a href="{{ route('admin.dashboard') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-home-circle"></i>
                <div data-i18n="Dashboard">Dashboard</div>
            </a>
        </li>

        <!-- Unit Layanan -->
        <li class="menu-item {{ request()->routeIs('admin.unit.*') ? 'active open' : '' }}">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-box"></i>
                <div data-i18n="Unit Layanan">Unit Layanan</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item {{ request()->routeIs('admin.unit.penyewaan.*') ? 'active' : '' }}">
                    <a href="{{ route('admin.unit.penyewaan.index') }}" class="menu-link">
                        <div data-i18n="Penyewaan Alat">Penyewaan Alat</div>
                    </a>
                </li>
                <li class="menu-item {{ request()->routeIs('admin.unit.penjualan-gas.*') ? 'active' : '' }}">
                    <a href="#" class="menu-link">
                        <div data-i18n="Penjualan Gas">Penjualan Gas</div>
                    </a>
                </li>
                <li class="menu-item {{ request()->routeIs('admin.unit.pertanian.*') ? 'active' : '' }}">
                    <a href="#" class="menu-link">
                        <div data-i18n="Pertanian & Perkebunan">Pertanian & Perkebunan</div>
                    </a>
                </li>
            </ul>
        </li>

        <!-- Aktivitas -->
        <li class="menu-item {{ request()->routeIs('admin.aktivitas.*') ? 'active open' : '' }}">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-time"></i>
                <div data-i18n="Aktivitas">Aktivitas</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item {{ request()->routeIs('admin.aktivitas.riwayat-sewa.*') ? 'active' : '' }}">
                    <a href="#" class="menu-link">
                        <div data-i18n="Riwayat Sewa">Riwayat Sewa</div>
                    </a>
                </li>
            </ul>
        </li>

        <!-- Data & Laporan -->
        <li class="menu-item {{ request()->routeIs('admin.laporan.*') ? 'active open' : '' }}">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-chart"></i>
                <div data-i18n="Data & Laporan">Data & Laporan</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item {{ request()->routeIs('admin.laporan.keuangan.*') ? 'active' : '' }}">
                    <a href="#" class="menu-link">
                        <div data-i18n="Laporan Keuangan">Laporan Keuangan</div>
                    </a>
                </li>
            </ul>
        </li>

        <!-- Manajemen Pengguna -->
        <li class="menu-item {{ request()->routeIs('admin.user.*') ? 'active open' : '' }}">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-user"></i>
                <div data-i18n="Manajemen Pengguna">Manajemen Pengguna</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item {{ request()->routeIs('admin.user.list.*') ? 'active' : '' }}">
                    <a href="#" class="menu-link">
                        <div data-i18n="Daftar Pengguna">Daftar Pengguna</div>
                    </a>
                </li>
            </ul>
        </li>

        <!-- Notifikasi -->
        <li class="menu-item {{ request()->routeIs('admin.notifikasi.*') ? 'active' : '' }}">
            <a href="javascript:void(0);" class="menu-link">
                <i class="menu-icon tf-icons bx bx-bell"></i>
                <div data-i18n="Notifikasi">Notifikasi</div>
            </a>
        </li>

        <!-- Profil iSewa -->
        <li class="menu-item {{ request()->routeIs('admin.profil-isewa.*') ? 'active' : '' }}">
            <a href="javascript:void(0);" class="menu-link">
                <i class="menu-icon tf-icons bx bx-info-circle"></i>
                <div data-i18n="Profil iSewa">Profil iSewa</div>
            </a>
        </li>

        <!-- Profil BUMDes -->
        <li class="menu-item {{ request()->routeIs('admin.profil-bumdes.*') ? 'active' : '' }}">
            <a href="javascript:void(0);" class="menu-link">
                <i class="menu-icon tf-icons bx bx-building"></i>
                <div data-i18n="Profil BUMDes">Profil BUMDes</div>
            </a>
        </li>

        <!-- Pengaturan -->
        <li class="menu-item {{ request()->routeIs('admin.pengaturan.*') ? 'active' : '' }}">
            <a href="javascript:void(0);" class="menu-link">
                <i class="menu-icon tf-icons bx bx-cog"></i>
                <div data-i18n="Pengaturan">Pengaturan</div>
            </a>
        </li>
    </ul>
</aside>
<!-- /Sidebar -->