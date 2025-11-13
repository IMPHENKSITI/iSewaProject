<!DOCTYPE html>
<html lang="en" class="light-style layout-menu-fixed" dir="ltr" data-theme="theme-default" data-assets-path="{{ asset('Admin/') }}" data-template="vertical-menu-template-free">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
    <title>Dashboard - iSewa Admin</title>
    <meta name="description" content="" />
    <link rel="icon" type="image/x-icon" href="{{ asset('Admin/img/favicon/isewalogo.png') }}" />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('Admin/vendor/fonts/boxicons.css') }}" />
    <link rel="stylesheet" href="{{ asset('Admin/vendor/css/core.css') }}" class="template-customizer-core-css" />
    <link rel="stylesheet" href="{{ asset('Admin/vendor/css/theme-default.css') }}" class="template-customizer-theme-css" />
    <link rel="stylesheet" href="{{ asset('Admin/css/demo.css') }}" />
    <link rel="stylesheet" href="{{ asset('Admin/vendor/libs/perfect-scrollbar/perfect-scrollbar.css') }}" />
    <link rel="stylesheet" href="{{ asset('Admin/vendor/libs/apex-charts/apex-charts.css') }}" />
    <!-- Custom CSS for Styling -->
    <style>
        .card {
            transition: box-shadow 0.3s ease;
        }
        .card:hover {
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
        }
        .unit-card {
            border-left: 4px solid #696cff;
            transition: all 0.3s ease;
        }
        .unit-card:hover {
            border-left-width: 6px;
            background-color: #f8f9fa;
        }
        .unit-card.warning {
            border-left-color: #ffc107;
        }
        .unit-card.danger {
            border-left-color: #dc3545;
        }
        .unit-card.success {
            border-left-color: #28a745;
        }
        .unit-card.info {
            border-left-color: #17a2b8;
        }
        .notification-item {
            transition: background-color 0.3s ease;
        }
        .notification-item:hover {
            background-color: #f8f9fa;
            border-radius: 8px;
            padding: 8px;
        }
        .product-item {
            transition: transform 0.3s ease;
        }
        .product-item:hover {
            transform: scale(1.02);
            z-index: 1;
        }
        .partnership-card {
            transition: all 0.3s ease;
        }
        .partnership-card:hover {
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
            transform: translateY(-3px);
        }
        .nav-link {
            transition: all 0.3s ease;
        }
        .nav-link:hover {
            color: #696cff !important;
            background-color: rgba(105, 105, 255, 0.1) !important;
        }
        .menu-item.active .menu-link {
            background-color: rgba(105, 105, 255, 0.1) !important;
            color: #696cff !important;
        }
        .avatar {
            transition: transform 0.3s ease;
        }
        .avatar:hover {
            transform: scale(1.1);
        }
        /* Smooth scroll animation */
        .animate-fade-in {
            opacity: 0;
            transform: translateY(20px);
            transition: opacity 0.6s ease, transform 0.6s ease;
        }
        .animate-fade-in.visible {
            opacity: 1;
            transform: translateY(0);
        }
        /* Product ranking badge */
        .product-rank {
            position: absolute;
            top: 10px;
            left: 10px;
            background-color: #696cff;
            color: white;
            border-radius: 50%;
            width: 30px;
            height: 30px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            font-size: 14px;
            z-index: 1;
        }
        /* Chart container styling */
        .chart-container {
            height: 300px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .chart-wrapper {
            width: 100%;
            max-width: 600px;
            margin: 0 auto;
        }
        /* Notification badges */
        .notification-badge {
            position: relative;
        }
        .notification-count {
            position: absolute;
            top: -8px;
            right: -8px;
            background-color: #dc3545;
            color: white;
            border-radius: 50%;
            width: 24px;
            height: 24px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 12px;
            font-weight: bold;
        }
        /* Sidebar styling */
        .layout-menu {
            transition: all 0.3s ease;
        }
        .layout-menu-toggle {
            transition: all 0.3s ease;
        }
        .layout-menu-toggle:hover {
            transform: rotate(180deg);
        }
        /* Financial stats cards */
        .financial-stat-card {
            transition: all 0.3s ease;
        }
        .financial-stat-card:hover {
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
        }
        /* Product card styling */
        .product-card {
            transition: all 0.3s ease;
            border: 1px solid #e9ecef;
        }
        .product-card:hover {
            border-color: #696cff;
            box-shadow: 0 4px 12px rgba(105, 105, 255, 0.15);
        }
        /* Partnership card styling */
        .partnership-card {
            transition: all 0.3s ease;
            border: 1px solid #e9ecef;
        }
        .partnership-card:hover {
            border-color: #696cff;
            box-shadow: 0 4px 12px rgba(105, 105, 255, 0.15);
        }
        /* Card header styling */
        .card-header {
            border-bottom: 1px solid #e9ecef;
        }
        /* Button styling */
        .btn {
            transition: all 0.3s ease;
        }
        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }
        /* New styling for the three-column layout */
        .dashboard-stats-row {
            display: flex;
            gap: 20px;
            margin-bottom: 20px;
        }
        .dashboard-stats-col {
            flex: 1;
            min-width: 0;
        }
        .dashboard-stats-col .card {
            height: 100%;
        }
        .dashboard-stats-col .card-body {
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }
        .dashboard-stats-col .card-title {
            margin-bottom: 1rem;
        }
        .dashboard-stats-col .stat-value {
            font-size: 1.5rem;
            font-weight: bold;
            margin-bottom: 0.5rem;
        }
        .dashboard-stats-col .stat-change {
            font-size: 0.875rem;
            color: #28a745;
        }
        .dashboard-stats-col .stat-change.negative {
            color: #dc3545;
        }
        .dashboard-stats-col .stat-label {
            font-size: 0.75rem;
            color: #6c757d;
        }
        .dashboard-stats-col .chart-placeholder {
            height: 150px;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: #f8f9fa;
            border-radius: 8px;
            margin-top: 1rem;
        }
        .dashboard-stats-col .chart-placeholder p {
            margin: 0;
            text-align: center;
            color: #6c757d;
        }
    </style>
    <script src="{{ asset('Admin/vendor/js/helpers.js') }}"></script>
    <script src="{{ asset('Admin/js/config.js') }}"></script>
</head>
<body>
    <div class="layout-wrapper layout-content-navbar">
        <div class="layout-container">
            <!-- Sidebar -->
            <aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
                <div class="app-brand demo">
                    <a href="{{ route('admin.dashboard') }}" class="app-brand-link">
                        <span class="app-brand-logo demo">
                            <img src="{{ asset('Admin/img/illustrations/isewalogo.png') }}" alt="Logo" width="130" height="130">
                        </span>
                    </a>
                    <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
                        <i class="bx bx-chevron-left bx-sm align-middle"></i>
                    </a>
                </div>
                <div class="menu-inner-shadow"></div>
                <ul class="menu-inner py-1">
                    <!-- Dashboard -->
                    <li class="menu-item active">
                        <a href="{{ route('admin.dashboard') }}" class="menu-link">
                            <i class="menu-icon tf-icons bx bx-home-circle"></i>
                            <div data-i18n="Dashboard">Dashboard</div>
                        </a>
                    </li>
                    <!-- Unit Layanan -->
                    <li class="menu-item">
                        <a href="javascript:void(0);" class="menu-link menu-toggle">
                            <i class="menu-icon tf-icons bx bx-building"></i>
                            <div data-i18n="Unit Layanan">Unit Layanan</div>
                        </a>
                        <ul class="menu-sub">
                            <li class="menu-item">
                                <a href="{{ route('admin.unit.penyewaan.index') }}" class="menu-link">
                                    <i class="menu-icon tf-icons bx bx-wrench"></i>
                                    <div data-i18n="Unit Penyewaan Alat">Penyewaan Alat</div>
                                </a>
                            </li>
                            <li class="menu-item">
                                <a href="{{ route('admin.unit.gas.index') }}" class="menu-link">
                                    <i class="menu-icon tf-icons bx bx-fire"></i>
                                    <div data-i18n="Unit Penjualan Gas">Penjualan Gas</div>
                                </a>
                            </li>
                            <li class="menu-item">
                                <a href="{{ route('admin.unit.pertanian.index') }}" class="menu-link">
                                    <i class="menu-icon tf-icons bx bx-sprout"></i>
                                    <div data-i18n="Unit Pertanian & Perkebunan">Pertanian & Perkebunan</div>
                                </a>
                            </li>
                            <li class="menu-item">
                                <a href="{{ route('admin.unit.simpanpinjam.index') }}" class="menu-link">
                                    <i class="menu-icon tf-icons bx bx-money"></i>
                                    <div data-i18n="Unit Simpan Pinjam">Simpan Pinjam</div>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <!-- Aktivitas -->
                    <li class="menu-item">
                        <a href="javascript:void(0);" class="menu-link menu-toggle">
                            <i class="menu-icon tf-icons bx bx-activity"></i>
                            <div data-i18n="Aktivitas">Aktivitas</div>
                        </a>
                        <ul class="menu-sub">
                            <li class="menu-item">
                                <a href="{{ route('admin.aktivitas.permintaan.index') }}" class="menu-link">
                                    <i class="menu-icon tf-icons bx bx-envelope"></i>
                                    <div data-i18n="Permintaan & Pengajuan">Permintaan & Pengajuan</div>
                                </a>
                            </li>
                            <li class="menu-item">
                                <a href="{{ route('admin.aktivitas.transaksi.index') }}" class="menu-link">
                                    <i class="menu-icon tf-icons bx bx-receipt"></i>
                                    <div data-i18n="Bukti Transaksi">Bukti Transaksi</div>
                                </a>
                            </li>
                            <li class="menu-item">
                                <a href="{{ route('admin.aktivitas.kemitraan.index') }}" class="menu-link">
                                    <i class="menu-icon tf-icons bx bx-handshake"></i>
                                    <div data-i18n="Kemitraan">Kemitraan</div>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <!-- Data & Laporan -->
                    <li class="menu-item">
                        <a href="javascript:void(0);" class="menu-link menu-toggle">
                            <i class="menu-icon tf-icons bx bx-bar-chart"></i>
                            <div data-i18n="Data & Laporan">Data & Laporan</div>
                        </a>
                        <ul class="menu-sub">
                            <li class="menu-item">
                                <a href="{{ route('admin.laporan.transaksi') }}" class="menu-link">
                                    <i class="menu-icon tf-icons bx bx-file"></i>
                                    <div data-i18n="Laporan Transaksi">Laporan Transaksi</div>
                                </a>
                            </li>
                            <li class="menu-item">
                                <a href="{{ route('admin.laporan.panen') }}" class="menu-link">
                                    <i class="menu-icon tf-icons bx bx-leaf"></i>
                                    <div data-i18n="Laporan Hasil Panen">Laporan Hasil Panen</div>
                                </a>
                            </li>
                            <li class="menu-item">
                                <a href="{{ route('admin.laporan.pendapatan') }}" class="menu-link">
                                    <i class="menu-icon tf-icons bx bx-pie-chart-alt"></i>
                                    <div data-i18n="Laporan Pendapatan Total">Laporan Pendapatan</div>
                                </a>
                            </li>
                            <li class="menu-item">
                                <a href="{{ route('admin.laporan.log') }}" class="menu-link">
                                    <i class="menu-icon tf-icons bx bx-log-in"></i>
                                    <div data-i18n="Log Aktivitas">Log Aktivitas</div>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <!-- Manajemen Pengguna -->
                    <li class="menu-item">
                        <a href="{{ route('admin.users.index') }}" class="menu-link">
                            <i class="menu-icon tf-icons bx bx-user"></i>
                            <div data-i18n="Manajemen Pengguna">Manajemen Pengguna</div>
                        </a>
                    </li>
                    <!-- Notifikasi -->
                    <li class="menu-item">
                        <a href="{{ route('admin.notifications.index') }}" class="menu-link">
                            <i class="menu-icon tf-icons bx bx-bell"></i>
                            <div data-i18n="Notifikasi">Notifikasi</div>
                        </a>
                    </li>
                    <!-- Profil iSewa -->
                    <li class="menu-item">
                        <a href="{{ route('admin.isewa.profile') }}" class="menu-link">
                            <i class="menu-icon tf-icons bx bx-info-circle"></i>
                            <div data-i18n="Profil iSewa">Profil iSewa</div>
                        </a>
                    </li>
                    <!-- Profil BUMDes -->
                    <li class="menu-item">
                        <a href="{{ route('admin.bumdes.profile') }}" class="menu-link">
                            <i class="menu-icon tf-icons bx bx-home-alt"></i>
                            <div data-i18n="Profil BUMDes">Profil BUMDes</div>
                        </a>
                    </li>
                    <!-- Pengaturan -->
                    <li class="menu-item">
                        <a href="{{ route('admin.settings') }}" class="menu-link">
                            <i class="menu-icon tf-icons bx bx-cog"></i>
                            <div data-i18n="Pengaturan">Pengaturan</div>
                        </a>
                    </li>
                </ul>
            </aside>
            <!-- Layout page -->
            <div class="layout-page">
                <!-- Navbar -->
                <nav class="layout-navbar container-xxl navbar navbar-expand-xl navbar-detached align-items-center bg-navbar-theme" id="layout-navbar">
                    <div class="layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0 d-xl-none">
                        <a class="nav-item nav-link px-0 me-xl-4" href="javascript:void(0)">
                            <i class="bx bx-menu bx-sm"></i>
                        </a>
                    </div>
                    <div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">
                        <div class="navbar-nav align-items-center">
                            <div class="nav-item d-flex align-items-center">
                                <i class="bx bx-search fs-4 lh-0"></i>
                                <input type="text" class="form-control border-0 shadow-none" placeholder="Cari..." aria-label="Search..." />
                            </div>
                        </div>
                        <ul class="navbar-nav flex-row align-items-center ms-auto">
                            <!-- Nama Admin -->
                            <li class="nav-item lh-1 me-3">
                                <span class="fw-semibold">Hamizul Fuad</span>
                            </li>
                            <!-- Profil Admin -->
                            <li class="nav-item navbar-dropdown dropdown-user dropdown">
                                <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);" data-bs-toggle="dropdown">
                                        <img src="{{ asset('Admin/img/avatars/hamizulf.jpg') }}" alt class="w-px-40 h-auto rounded-circle" />
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end">
                                    <li>
                                        <a class="dropdown-item" href="{{ route('admin.profile') }}">
                                            <div class="d-flex">
                                                <div class="flex-shrink-0 me-3">
                                                <div class="flex-grow-1">
                                                    <span class="fw-semibold d-block">Hamizul Fuad</span>
                                                    <small class="text-muted">Admin</small>
                                                </div>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <div class="dropdown-divider"></div>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="{{ route('admin.profile') }}">
                                            <i class="bx bx-user me-2"></i>
                                            <span class="align-middle">My Profile</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="{{ route('admin.settings') }}">
                                            <i class="bx bx-cog me-2"></i>
                                            <span class="align-middle">Settings</span>
                                        </a>
                                    </li>
                                    <li>
                                        <div class="dropdown-divider"></div>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="{{ route('admin.logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                            <i class="bx bx-power-off me-2"></i>
                                            <span class="align-middle">Log Out</span>
                                        </a>
                                        <form id="logout-form" action="{{ route('admin.logout') }}" method="POST" class="d-none">
                                            @csrf
                                        </form>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </nav>
                <!-- Content wrapper -->
                <div class="content-wrapper">
                    <div class="container-xxl flex-grow-1 container-p-y">
                        <!-- Welcome Card & Unit Cards -->
                        <div class="row mb-2">
                            <div class="col-lg-8">
                                <div class="card animate-fade-in">
                                    <div class="d-flex align-items-end row">
                                        <div class="col-sm-7">
                                            <div class="card-body p-3">
                                                <h5 class="card-title text-primary fw-bold">Selamat Datang di iSewa 🏛️</h5>
                                                <p class="mb-2">Sistem Penyewaan Alat dan Promosi Usaha BUMDes berbasis Digital <span class="fw-bold">Desa Pematang Duku Timur</span></p>
                                                <a href="{{ route('admin.bumdes.profile') }}" class="btn btn-sm btn-outline-primary">Profil BUMDes</a>
                                            </div>
                                        </div>
                                        <div class="col-sm-5 text-center text-sm-left">
                                            <div class="card-body pb-0 px-0 px-md-3">
                                                <img src="{{ asset('Admin/img/illustrations/bermasab.png') }}" height="150" alt="View Badge User" data-app-dark-img="illustrations/man-with-laptop-dark.png" data-app-light-img="illustrations/man-with-laptop-light.png" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="row g-2">
                                    <div class="col-12">
                                        <div class="card animate-fade-in">
                                            <div class="card-body">
                                                <div class="d-flex justify-content-between flex-sm-row flex-column gap-3">
                                                    <div class="d-flex flex-sm-column flex-row align-items-start justify-content-between">
                                                        <div class="card-title">
                                                            <h5 class="text-nowrap mb-2">Total Pendapatan</h5>
                                                            <span class="badge bg-label-warning rounded-pill">Tahun 2025</span>
                                                        </div>
                                                        <div class="mt-sm-auto">
                                                            <small class="text-success text-nowrap fw-semibold"><i class="bx bx-chevron-up"></i> 68.2%</small>
                                                            <h3 class="mb-0">Rp.50.000.000</h3>
                                                        </div>
                                                    </div>
                                                    <div id="profileReportChart"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Unit Cards - SATU PER BARIS -->
                        <div class="row mb-4">
                            <div class="col-12 mb-3">
                                <div class="card unit-card warning animate-fade-in" onclick="window.location='{{ route('admin.unit.penyewaan.index') }}'">
                                    <div class="card-body">
                                        <div class="d-flex align-items-center">
                                            <div class="avatar flex-shrink-0 me-3" style="width: 60px; height: 60px;">
                                                <img src="{{ asset('Admin/img/5.png') }}" alt="" class="rounded w-100" />
                                            </div>
                                            <div class="flex-grow-1">
                                                <span class="fw-semibold d-block mb-1 text-muted">Unit Penyewaan Alat</span>
                                                <h4 class="card-title mb-0">{{ $unitPenyewaan ?? 45 }} Item</h4>
                                            </div>
                                            <div class="text-end">
                                                <h5 class="text-success mb-0"><i class="bx bx-up-arrow-alt"></i> +72.80%</h5>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 mb-3">
                                <div class="card unit-card danger animate-fade-in" onclick="window.location='{{ route('admin.unit.gas.index') }}'">
                                    <div class="card-body">
                                        <div class="d-flex align-items-center">
                                            <div class="avatar flex-shrink-0 me-3" style="width: 60px; height: 60px;">
                                                <img src="{{ asset('Admin/img/icons/unicons/6.png') }}" alt="" class="rounded w-100" />
                                            </div>
                                            <div class="flex-grow-1">
                                                <span class="fw-semibold d-block mb-1 text-muted">Unit Penjualan Gas</span>
                                                <h4 class="card-title mb-0">{{ $unitGas ?? 320 }} Tabung</h4>
                                            </div>
                                            <div class="text-end">
                                                <h5 class="text-success mb-0"><i class="bx bx-up-arrow-alt"></i> +28.42%</h5>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 mb-3">
                                <div class="card unit-card success animate-fade-in" onclick="window.location='{{ route('admin.unit.pertanian.index') }}'">
                                    <div class="card-body">
                                        <div class="d-flex align-items-center">
                                            <div class="avatar flex-shrink-0 me-3" style="width: 60px; height: 60px;">
                                                <img src="{{ asset('Admin/img/icons/unicons/4.png') }}" alt="" class="rounded w-100" />
                                            </div>
                                            <div class="flex-grow-1">
                                                <span class="fw-semibold d-block mb-1 text-muted">Unit Pertanian dan Perkebunan</span>
                                                <h4 class="card-title mb-0">{{ $unitPertanian ?? 28 }} Produk</h4>
                                            </div>
                                            <div class="text-end">
                                                <h5 class="text-danger mb-0"><i class="bx bx-down-arrow-alt"></i> -14.82%</h5>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 mb-3">
                                <div class="card unit-card info animate-fade-in" onclick="window.location='{{ route('admin.unit.simpanpinjam.index') }}'">
                                    <div class="card-body">
                                        <div class="d-flex align-items-center">
                                            <div class="avatar flex-shrink-0 me-3" style="width: 60px; height: 60px;">
                                                <img src="{{ asset('Admin/img/icons/unicons/isewa.png') }}" alt="" class="rounded w-100" />
                                            </div>
                                            <div class="flex-grow-1">
                                                <span class="fw-semibold d-block mb-1 text-muted">Unit Simpan Pinjam</span>
                                                <h4 class="card-title mb-0">{{ $unitSimpanPinjam ?? 156 }} Anggota</h4>
                                            </div>
                                            <div class="text-end">
                                                <h5 class="text-success mb-0"><i class="bx bx-up-arrow-alt"></i> +26.14%</h5>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Notifications Section -->
                        <div class="row mb-2">
                            <div class="col-12">
                                <div class="card animate-fade-in">
                                    <div class="card-header p-3">
                                        <div class="card-title mb-0">
                                            <h5 class="m-0 me-2"><i class="bx bx-bell text-primary"></i> Notifikasi Permintaan</h5>
                                            <small class="text-muted">Permintaan aktivitas dari pengguna</small>
                                        </div>
                                    </div>
                                    <div class="card-body p-3">
                                        <div class="list-group list-group-flush">
                                            <div class="list-group-item d-flex align-items-center p-2 notification-item" id="notification1">
                                                <div class="avatar flex-shrink-0 me-2">
                                                    <span class="avatar-initial rounded bg-label-secondary">P</span>
                                                </div>
                                                <div class="flex-grow-1">
                                                    <div class="mb-2">
                                                        <span class="badge bg-warning me-2">Penyewaan Alat</span>
                                                        <small class="text-muted">2 jam yang lalu</small>
                                                    </div>
                                                    <h6 class="mb-1">User A mengajukan penyewaan Tenda Komplit</h6>
                                                    <p class="text-muted mb-0 small">Untuk acara pernikahan tanggal 15 November 2025</p>
                                                </div>
                                                <div class="d-flex gap-2 ms-3">
                                                    <button class="btn btn-sm btn-outline-primary" onclick="showDetails('Penyewaan Tenda Komplit', 'User A', 'Untuk acara pernikahan tanggal 15 November 2025')">
                                                        <i class="bx bx-show"></i> Detail
                                                    </button>
                                                    <button class="btn btn-sm btn-success" onclick="acceptRequest(1)">
                                                        <i class="bx bx-check"></i> Terima
                                                    </button>
                                                    <button class="btn btn-sm btn-danger" onclick="rejectRequest(1)">
                                                        <i class="bx bx-x"></i> Tolak
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="list-group-item d-flex align-items-center p-2 notification-item" id="notification2">
                                                <div class="avatar flex-shrink-0 me-2">
                                                    <span class="avatar-initial rounded bg-label-success">S</span>
                                                </div>
                                                <div class="flex-grow-1">
                                                    <div class="mb-2">
                                                        <span class="badge bg-info me-2">Simpan Pinjam</span>
                                                        <small class="text-muted">5 jam yang lalu</small>
                                                    </div>
                                                    <h6 class="mb-1">User B mengajukan pinjaman sebesar Rp 5.000.000</h6>
                                                    <p class="text-muted mb-0 small">Untuk modal usaha toko kelontong</p>
                                                </div>
                                                <div class="d-flex gap-2 ms-3">
                                                    <button class="btn btn-sm btn-outline-primary" onclick="showDetails('Pinjaman Modal Usaha', 'User B', 'Untuk modal usaha toko kelontong')">
                                                        <i class="bx bx-show"></i> Detail
                                                    </button>
                                                    <button class="btn btn-sm btn-success" onclick="acceptRequest(2)">
                                                        <i class="bx bx-check"></i> Terima
                                                    </button>
                                                    <button class="btn btn-sm btn-danger" onclick="rejectRequest(2)">
                                                        <i class="bx bx-x"></i> Tolak
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="list-group-item d-flex align-items-center p-2 notification-item" id="notification3">
                                                <div class="avatar flex-shrink-0 me-2">
                                                    <span class="avatar-initial rounded bg-label-warning">K</span>
                                                </div>
                                                <div class="flex-grow-1">
                                                    <div class="mb-2">
                                                        <span class="badge bg-success me-2">Kemitraan</span>
                                                        <small class="text-muted">1 hari yang lalu</small>
                                                    </div>
                                                    <h6 class="mb-1">User C mengajukan pendaftaran gabung kemitraan</h6>
                                                    <p class="text-muted mb-0 small">Bidang pertanian dan perkebunan sawit</p>
                                                </div>
                                                <div class="d-flex gap-2 ms-3">
                                                    <button class="btn btn-sm btn-outline-primary" onclick="showDetails('Pendaftaran Kemitraan', 'User C', 'Bidang pertanian dan perkebunan sawit')">
                                                        <i class="bx bx-show"></i> Detail
                                                    </button>
                                                    <button class="btn btn-sm btn-success" onclick="acceptRequest(3)">
                                                        <i class="bx bx-check"></i> Terima
                                                    </button>
                                                    <button class="btn btn-sm btn-danger" onclick="rejectRequest(3)">
                                                        <i class="bx bx-x"></i> Tolak
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Three Column Layout for Financial Stats -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <div class="dashboard-stats-row">
                                    <!-- Left Column: Pendapatan dan Pengeluaran -->
                                    <div class="dashboard-stats-col">
                                        <div class="card animate-fade-in">
                                            <div class="card-header">
                                                <h5 class="card-title mb-0">Pendapatan dan Pengeluaran</h5>
                                            </div>
                                            <div class="card-body">
                                                <div class="chart-wrapper">
                                                    <div id="totalRevenueChart" class="px-2"></div>
                                                </div>
                                                <div class="text-center mt-3">
                                                    <div class="dropdown">
                                                        <button class="btn btn-sm btn-outline-primary dropdown-toggle" type="button" id="growthReportId" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                            2025
                                                        </button>
                                                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="growthReportId">
                                                            <a class="dropdown-item" href="javascript:void(0);">2024</a>
                                                            <a class="dropdown-item" href="javascript:void(0);">2023</a>
                                                            <a class="dropdown-item" href="javascript:void(0);">2022</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Middle Column: Grafik Transaksi (Persentase) -->
                                    <div class="dashboard-stats-col">
                                        <div class="card animate-fade-in">
                                            <div class="card-header">
                                                <h5 class="card-title mb-0">Grafik Transaksi</h5>
                                            </div>
                                            <div class="card-body">
                                                <div class="chart-wrapper">
                                                    <div id="transactionChart" class="px-2"></div>
                                                </div>
                                                <div class="text-center mt-3">
                                                    <p class="mb-0">Perbandingan transaksi antar unit</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Right Column: Anggota Mitra Aktif & Total Transaksi -->
                                    <div class="dashboard-stats-col">
                                        <div class="card animate-fade-in">
                                            <div class="card-header">
                                                <h5 class="card-title mb-0">Anggota Mitra Aktif & Total Transaksi</h5>
                                            </div>
                                            <div class="card-body">
                                                <div class="d-flex justify-content-between mb-3">
                                                    <div>
                                                        <h6 class="mb-0">Anggota Mitra Aktif</h6>
                                                        <div class="stat-value">156</div>
                                                        <div class="stat-change positive">+42.9%</div>
                                                    </div>
                                                    <div>
                                                        <h6 class="mb-0">Total Transaksi</h6>
                                                        <div class="stat-value">1,245</div>
                                                        <div class="stat-change positive">+26.14%</div>
                                                    </div>
                                                </div>
                                                <div class="chart-placeholder">
                                                    <p>Klik untuk melihat detail transaksi per unit</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Popular Products -->
                        <div class="row mb-2">
                            <div class="col-12">
                                <div class="card animate-fade-in">
                                    <div class="card-header p-3">
                                        <h5 class="card-title mb-0">Produk Populer</h5>
                                    </div>
                                    <div class="card-body p-3">
                                        <div class="row g-3">
                                            <div class="col-md-4 product-item">
                                                <div class="card h-100 product-card">
                                                    <div class="card-body p-2 position-relative">
                                                        <div class="product-rank">1</div>
                                                        <div class="d-flex align-items-center mb-2">
                                                            <div class="avatar flex-shrink-0 me-3">
                                                                <img src="{{ asset('Admin/img/icons/unicons/gas.png') }}" alt="" class="rounded w-70" />
                                                            </div>
                                                            <div class="flex-grow-1">
                                                                <h6 class="mb-0">Gas LPG 3 Kg</h6>
                                                                <small class="text-muted">Unit Penjualan Gas</small>
                                                            </div>
                                                        </div>
                                                        <div class="d-flex justify-content-between">
                                                            <div></div>
                                                            <div class="user-progress">
                                                                <h6 class="mb-0">+15.000.000</h6>
                                                                <span class="text-muted">IDR</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4 product-item">
                                                <div class="card h-100 product-card">
                                                    <div class="card-body p-2 position-relative">
                                                        <div class="product-rank">2</div>
                                                        <div class="d-flex align-items-center mb-2">
                                                            <div class="avatar flex-shrink-0 me-3">
                                                                <img src="{{ asset('Admin/img/icons/unicons/sound system.png') }}" alt="" class="rounded w-70" />
                                                            </div>
                                                            <div class="flex-grow-1">
                                                                <h6 class="mb-0">Sound System</h6>
                                                                <small class="text-muted">Unit Penyewaan Alat</small>
                                                            </div>
                                                        </div>
                                                        <div class="d-flex justify-content-between">
                                                            <div></div>
                                                            <div class="user-progress">
                                                                <h6 class="mb-0">+8.500.000</h6>
                                                                <span class="text-muted">IDR</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4 product-item">
                                                <div class="card h-100 product-card">
                                                    <div class="card-body p-2 position-relative">
                                                        <div class="product-rank">3</div>
                                                        <div class="d-flex align-items-center mb-2">
                                                            <div class="avatar flex-shrink-0 me-3">
                                                                <img src="{{ asset('Admin/img/icons/unicons/tendakom.jpg') }}" alt="" class="rounded w-70" />
                                                            </div>
                                                            <div class="flex-grow-1">
                                                                <h6 class="mb-0">Tenda Komplit</h6>
                                                                <small class="text-muted">Unit Penyewaan Alat</small>
                                                            </div>
                                                        </div>
                                                        <div class="d-flex justify-content-between">
                                                            <div></div>
                                                            <div class="user-progress">
                                                                <h6 class="mb-0">+7.000.000</h6>
                                                                <span class="text-muted">IDR</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4 product-item">
                                                <div class="card h-100 product-card">
                                                    <div class="card-body p-2 position-relative">
                                                        <div class="product-rank">4</div>
                                                        <div class="d-flex align-items-center mb-2">
                                                            <div class="avatar flex-shrink-0 me-3">
                                                                <img src="{{ asset('Admin/img/icons/unicons/tendakursi.jpg') }}" alt="" class="rounded w-70" />
                                                            </div>
                                                            <div class="flex-grow-1">
                                                                <h6 class="mb-0">Meja dan Kursi</h6>
                                                                <small class="text-muted">Unit Penyewaan Alat</small>
                                                            </div>
                                                        </div>
                                                        <div class="d-flex justify-content-between">
                                                            <div></div>
                                                            <div class="user-progress">
                                                                <h6 class="mb-0">-500.000</h6>
                                                                <span class="text-muted">IDR</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4 product-item">
                                                <div class="card h-100 product-card">
                                                    <div class="card-body p-2 position-relative">
                                                        <div class="product-rank">5</div>
                                                        <div class="d-flex align-items-center mb-2">
                                                            <div class="avatar flex-shrink-0 me-3">
                                                                <img src="{{ asset('Admin/img/icons/unicons/mitra.png') }}" alt="" class="rounded w-70" />
                                                            </div>
                                                            <div class="flex-grow-1">
                                                                <h6 class="mb-0">Bermitra</h6>
                                                                <small class="text-muted">Unit Pertanian</small>
                                                            </div>
                                                        </div>
                                                        <div class="d-flex justify-content-between">
                                                            <div></div>
                                                            <div class="user-progress">
                                                                <h6 class="mb-0">+2.500.000</h6>
                                                                <span class="text-muted">IDR</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4 product-item">
                                                <div class="card h-100 product-card">
                                                    <div class="card-body p-2 position-relative">
                                                        <div class="product-rank">6</div>
                                                        <div class="d-flex align-items-center mb-2">
                                                            <div class="avatar flex-shrink-0 me-3">
                                                                <img src="{{ asset('Admin/img/icons/unicons/sp.png') }}" alt="" class="rounded w-70" />
                                                            </div>
                                                            <div class="flex-grow-1">
                                                                <h6 class="mb-0">Pengajuan Pinjaman</h6>
                                                                <small class="text-muted">Unit Simpan Pinjam</small>
                                                            </div>
                                                        </div>
                                                        <div class="d-flex justify-content-between">
                                                            <div></div>
                                                            <div class="user-progress">
                                                                <h6 class="mb-0">-200.000</h6>
                                                                <span class="text-muted">IDR</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Partnership Section -->
                        <div class="row mb-2">
                            <div class="col-12">
                                <div class="card animate-fade-in">
                                    <div class="card-header p-3">
                                        <h5 class="card-title mb-0">Kemitraan</h5>
                                    </div>
                                    <div class="card-body p-3">
                                        <div class="row g-3">
                                            <div class="col-md-4">
                                                <div class="card h-100 partnership-card">
                                                    <div class="card-body p-3">
                                                        <div class="d-flex align-items-center mb-3">
                                                            <div class="avatar flex-shrink-0 me-3">
                                                                <span class="avatar-initial rounded bg-label-success">H</span>
                                                            </div>
                                                            <div class="flex-grow-1">
                                                                <h6 class="card-title mb-0">Heri</h6>
                                                                <small class="text-muted">Petani</small>
                                                            </div>
                                                        </div>
                                                        <div class="mt-2">
                                                            <p class="mb-1"><strong>Jenis Hasil Panen:</strong> Ubi</p>
                                                            <p class="mb-1"><strong>Jumlah:</strong> 5 Ton</p>
                                                            <p class="mb-1"><strong>Harga Jual:</strong> Rp 5.000.000</p>
                                                            <p class="mb-0"><strong>Lokasi Lahan:</strong> RW 03 Desa Pematang Duku Timur</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="card h-100 partnership-card">
                                                    <div class="card-body p-3">
                                                        <div class="d-flex align-items-center mb-3">
                                                            <div class="avatar flex-shrink-0 me-3">
                                                                <span class="avatar-initial rounded bg-label-info">S</span>
                                                            </div>
                                                            <div class="flex-grow-1">
                                                                <h6 class="card-title mb-0">Siti</h6>
                                                                <small class="text-muted">Petani</small>
                                                            </div>
                                                        </div>
                                                        <div class="mt-2">
                                                            <p class="mb-1"><strong>Jenis Hasil Panen:</strong> Sayur-sayuran</p>
                                                            <p class="mb-1"><strong>Jumlah:</strong> 10 Ton</p>
                                                            <p class="mb-1"><strong>Harga Jual:</strong> Rp 15.000.000</p>
                                                            <p class="mb-0"><strong>Lokasi Lahan:</strong> RW 05 Desa Pematang Duku Timur</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="card h-100 partnership-card">
                                                    <div class="card-body p-3">
                                                        <div class="d-flex align-items-center mb-3">
                                                            <div class="avatar flex-shrink-0 me-3">
                                                                <span class="avatar-initial rounded bg-label-warning">B</span>
                                                            </div>
                                                            <div class="flex-grow-1">
                                                                <h6 class="card-title mb-0">Budi</h6>
                                                                <small class="text-muted">Petani</small>
                                                            </div>
                                                        </div>
                                                        <div class="mt-2">
                                                            <p class="mb-1"><strong>Jenis Hasil Panen:</strong> Padi</p>
                                                            <p class="mb-1"><strong>Jumlah:</strong> 2 Ton</p>
                                                            <p class="mb-1"><strong>Harga Jual:</strong> Rp 3.000.000</p>
                                                            <p class="mb-0"><strong>Lokasi Lahan:</strong> RW 02 Desa Pematang Duku Timur</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Generate Report Button -->
                        <div class="row mb-2">
                            <div class="col-12">
                                <div class="card animate-fade-in">
                                    <div class="card-body p-3 text-center">
                                        <h5 class="card-title mb-0">Laporan BUMDes</h5>
                                        <p class="mb-2">Generate laporan lengkap untuk diserahkan ke pemerintah desa.</p>
                                        <button class="btn btn-primary btn-sm" onclick="generateReport()">
                                            <i class="bx bx-file"></i> Generate Laporan PDF
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Footer -->
                    <footer class="content-footer footer bg-footer-theme">
                        <div class="container-xxl d-flex flex-wrap justify-content-between py-2 flex-md-row flex-column">
                            <div class="mb-2 mb-md-0">
                                ©
                                <script>
                                    document.write(new Date().getFullYear());
                                </script>
                                , made with 😎 by
                                <a href="https://themeselection.com" target="_blank" class="footer-link fw-bolder">BUMDes Desa Pematang Duku Timur</a>
                            </div>
                            <div>
                            </div>
                        </div>
                    </footer>
                    <div class="content-backdrop fade"></div>
                </div>
            </div>
        </div>
        <div class="layout-overlay layout-menu-toggle"></div>
    </div>
    <script src="{{ asset('Admin/vendor/libs/jquery/jquery.js') }}"></script>
    <script src="{{ asset('Admin/vendor/libs/popper/popper.js') }}"></script>
    <script src="{{ asset('Admin/vendor/js/bootstrap.js') }}"></script>
    <script src="{{ asset('Admin/vendor/libs/perfect-scrollbar/perfect-scrollbar.js') }}"></script>
    <script src="{{ asset('Admin/vendor/js/menu.js') }}"></script>
    <script src="{{ asset('Admin/vendor/libs/apex-charts/apexcharts.js') }}"></script>
    <script src="{{ asset('Admin/js/main.js') }}"></script>
    <script src="{{ asset('Admin/js/dashboards-analytics.js') }}"></script>
    <script async defer src="https://buttons.github.io/buttons.js"></script>
    <!-- Script for animations and functionality -->
    <script>
        // Function to show details of a request
        function showDetails(title, user, description) {
            alert(`Detail Permintaan:\nJudul: ${title}\nUser: ${user}\nDeskripsi: ${description}`);
        }

        // Function to accept a request
        function acceptRequest(id) {
            const notificationItem = document.getElementById(`notification${id}`);
            if (notificationItem) {
                notificationItem.classList.add('bg-success', 'text-white');
                notificationItem.querySelectorAll('button').forEach(btn => btn.disabled = true);
                // Show success notification
                showToast('success', 'Permintaan telah diterima!');
            }
        }

        // Function to reject a request
        function rejectRequest(id) {
            const notificationItem = document.getElementById(`notification${id}`);
            if (notificationItem) {
                notificationItem.classList.add('bg-danger', 'text-white');
                notificationItem.querySelectorAll('button').forEach(btn => btn.disabled = true);
                // Show error notification
                showToast('error', 'Permintaan telah ditolak!');
            }
        }

        // Function to generate report
        function generateReport() {
            showToast('info', 'Laporan PDF sedang diproses. Fitur ini akan terhubung ke backend Laravel untuk menghasilkan file.');
            // In a real application, this would trigger a server-side PDF generation
            setTimeout(() => {
                showToast('success', 'Laporan berhasil dibuat dan siap diunduh!');
            }, 2000);
        }

        // Function to show toast notifications
        function showToast(type, message) {
            // Create toast element
            const toast = document.createElement('div');
            toast.className = `toast align-items-center text-white bg-${type} border-0`;
            toast.style.position = 'fixed';
            toast.style.top = '20px';
            toast.style.right = '20px';
            toast.style.zIndex = '10000';
            toast.innerHTML = `
                <div class="d-flex">
                    <div class="toast-body">${message}</div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
            `;
            
            // Add to body
            document.body.appendChild(toast);
            
            // Initialize bootstrap toast
            const bsToast = new bootstrap.Toast(toast, {
                delay: 3000,
                autohide: true
            });
            
            // Show toast
            bsToast.show();
            
            // Remove toast after it's hidden
            toast.addEventListener('hidden.bs.toast', () => {
                toast.remove();
            });
        }

        // Animation on scroll
        document.addEventListener('DOMContentLoaded', function() {
            const animateElements = document.querySelectorAll('.animate-fade-in');
            
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('visible');
                    }
                });
            }, {
                threshold: 0.1
            });
            
            animateElements.forEach(el => {
                observer.observe(el);
            });
        });

        // Add smooth scrolling to anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                e.preventDefault();
                
                document.querySelector(this.getAttribute('href')).scrollIntoView({
                    behavior: 'smooth'
                });
            });
        });
    </script>
</body>
</html>