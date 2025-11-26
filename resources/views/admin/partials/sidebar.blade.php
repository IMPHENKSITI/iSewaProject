<!-- Sidebar -->
<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    <div class="app-brand demo">
        <a href="{{ route('admin.dashboard') }}" class="app-brand-link">
            <span class="app-brand-logo demo">
                <img src="{{ asset('Admin/img/illustrations/isewalogo.png') }}" alt="Logo" width="130"
                    height="130">
            </span>
        </a>
        <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
            <i class="bx bx-chevron-left bx-sm align-middle"></i>
        </a>
    </div>
    <div class="menu-inner-shadow"></div>
    <ul class="menu-inner py-1">
        <!-- Dashboard -->
        <li class="menu-item {{ request()->routeis('admin.dashboard.*') ? 'active' : '' }}">
            <a href="{{ route('admin.dashboard') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-home-circle"></i>
                <div data-i18n="Dashboard">Dashboard</div>
            </a>
        </li>

        <!-- Unit Layanan -->
        <li
            class="menu-item {{ request()->is('admin/unit/penyewaan*') || request()->is('admin/unit/gas*') ? 'open active show' : '' }}">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-collection"></i>
                <div data-i18n="Unit Layanan">Unit Layanan</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item {{ request()->is('admin/unit/penyewaan*') ? 'active' : '' }}">
                    <a href="{{ route('admin.unit.penyewaan.index') }}" class="menu-link">
                        <div data-i18n="Penyewaan Alat">Penyewaan Alat</div>
                    </a>
                </li>
                <li class="menu-item {{ request()->is('admin/unit/gas*') ? 'active' : '' }}">
                    <a href="{{ route('admin.unit.penjualan_gas.index') }}" class="menu-link">
                        <div data-i18n="Penjualan Gas">Penjualan Gas</div>
                    </a>
                </li>
        </li>
    </ul>
    </li>
    <!-- Aktivitas -->
    <li
        class="menu-item {{ request()->is('admin/aktivitas/permintaan-pengajuan*') || request()->is('admin/aktivitas/bukti-transaksi*') ? 'open active show' : '' }}">
        <a href="javascript:void(0);" class="menu-link menu-toggle">
            <i class="menu-icon tf-icons bx bx-time"></i>
            <div data-i18n="Aktivitas">Aktivitas</div>
        </a>
        <ul class="menu-sub">
            <li class="menu-item {{ request()->is('admin/aktivitas/permintaan-pengajuan*') ? 'active' : '' }}">
                <a href="{{ route('admin.aktivitas.permintaan-pengajuan.index') }}" class="menu-link">
                    <div data-i18n="Permintaan & Pengajuan">Permintaan & Pengajuan</div>
                </a>
            </li>
            <li class="menu-item {{ request()->is('admin/aktivitas/bukti-transaksi*') ? 'active' : '' }}">
                <a href="{{ route('admin.aktivitas.bukti-transaksi.index') }}" class="menu-link">
                    <div data-i18n="Bukti Transaksi">Bukti Transaksi</div>
                </a>
            </li>
        </ul>
    </li>
    <!-- Data & Laporan -->
    <li
        class="menu-item {{ request()->is('admin/laporan/transaksi*') || request()->is('admin/laporan/pendapatan*') || request()->is('admin/laporan/log*') ? 'open active show' : '' }}">
        <a href="javascript:void(0);" class="menu-link menu-toggle">
            <i class="menu-icon tf-icons bx bx-bar-chart"></i>
            <div data-i18n="Data & Laporan">Data & Laporan</div>
        </a>
        <ul class="menu-sub">
            <li class="menu-item {{ request()->routeIs('admin.laporan.transaksi') ? 'active' : '' }}">
                <a href="{{ route('admin.laporan.transaksi') }}" class="menu-link">
                    <div data-i18n="Laporan Transaksi">Laporan Transaksi</div>
                </a>
            </li>
            <li class="menu-item {{ request()->routeIs('admin.laporan.pendapatan') ? 'active' : '' }}">
                <a href="{{ route('admin.laporan.pendapatan') }}" class="menu-link">
                    <div data-i18n="Laporan Pendapatan">Laporan Pendapatan</div>
                </a>
            </li>
            <li class="menu-item {{ request()->routeIs('admin.laporan.log') ? 'active' : '' }}">
                <a href="{{ route('admin.laporan.log') }}" class="menu-link">
                    <div data-i18n="Log Aktivitas">Log Aktivitas</div>
                </a>
            </li>
        </ul>
    </li>
    <!-- Pengaturan Sistem -->
    <li class="menu-item {{ request()->routeIs('admin.system-settings.*') ? 'active' : '' }}">
        <a href="{{ route('admin.system-settings.index') }}" class="menu-link">
            <i class="menu-icon tf-icons bx bx-payment"></i>
            <div>Pengaturan Sistem</div>
        </a>
    </li>
    <!-- Manajemen Pengguna -->
    <li class="menu-item {{ request()->routeIs('admin.manajemen-pengguna.*') ? 'active' : '' }}">
        <a href="{{ route('admin.manajemen-pengguna.index') }}" class="menu-link">
            <i class="menu-icon tf-icons bx bx-user"></i>
            <div data-i18n="Manajemen Pengguna">Manajemen Pengguna</div>
        </a>
    </li>
    <!-- Notifikasi -->
    <li class="menu-item {{ request()->routeIs('admin.notifications.*') ? 'active' : '' }}">
        <a href="{{ route('admin.notifications.index') }}" class="menu-link">
            <i class="menu-icon tf-icons bx bx-bell"></i>
            <div data-i18n="Notifikasi">Notifikasi</div>
        </a>
    </li>
    <!-- Profil iSewa -->
    <li class="menu-item {{ request()->routeIs('admin/isewa/profile*') ? 'active' : '' }}">
        <a href="{{ route('admin.isewa.profile') }}" class="menu-link">
            <i class="menu-icon tf-icons bx bx-info-circle"></i>
            <div data-i18n="Profil iSewa">Profil iSewa</div>
        </a>
    </li>
    <!-- Profil BUMDes -->
    <li class="menu-item {{ request()->routeIs('admin.isewa.profil.bumdes.*') ? 'active' : '' }}">
        <a href="{{ route('admin.isewa.profil.bumdes') }}" class="menu-link">
            <i class="menu-icon tf-icons bx bx-buildings"></i>
            <div data-i18n="Profil BUMDes">Profil BUMDes</div>
        </a>
    </li>
    </ul>
</aside>
<!-- /Sidebar -->
