@extends('admin.layouts.admin')

@section('title', 'Laporan Pendapatan')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">

        <!-- Header -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h4 class="fw-bold py-3 mb-0">
                            <span class="text-muted fw-light">Laporan /</span> Pendapatan
                        </h4>
                        <p class="text-muted mb-0">Ringkasan pendapatan dan analisis keuangan BUMDes.</p>
                    </div>
                    <div class="d-flex gap-2">
                        <button class="btn btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                            <i class="bx bx-calendar me-1"></i> 2025
                        </button>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="javascript:void(0);">2025</a></li>
                            <li><a class="dropdown-item" href="javascript:void(0);">2024</a></li>
                            <li><a class="dropdown-item" href="javascript:void(0);">2023</a></li>
                        </ul>
                        <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#manualTransactionModal">
                            <i class="bx bx-plus me-1"></i> Tambah Laporan Manual
                        </button>
                        <button class="btn btn-primary" onclick="window.print()">
                            <i class="bx bx-printer me-1"></i> Cetak Laporan
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Summary Cards -->
        <div class="row g-4 mb-4">
            <!-- Total Pendapatan -->
            <div class="col-md-4">
                <div class="card h-100 border-0 shadow-sm hover-lift">
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-3">
                            <div class="avatar avatar-md me-3">
                                <span class="avatar-initial rounded-circle bg-label-primary">
                                    <i class='bx bx-wallet fs-4'></i>
                                </span>
                            </div>
                            <div>
                                <span class="d-block text-muted text-uppercase fs-7 fw-bold">Total Pendapatan</span>
                                <h4 class="mb-0 fw-bold text-primary">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}
                                </h4>
                            </div>
                        </div>
                        <div class="d-flex align-items-center small">
                            <span class="badge bg-label-success me-2"><i class="bx bx-up-arrow-alt"></i> +12.5%</span>
                            <span class="text-muted">dari bulan lalu</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Pendapatan Penyewaan -->
            <div class="col-md-4">
                <div class="card h-100 border-0 shadow-sm hover-lift">
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-3">
                            <div class="avatar avatar-md me-3">
                                <span class="avatar-initial rounded-circle bg-label-warning">
                                    <i class='bx bx-wrench fs-4'></i>
                                </span>
                            </div>
                            <div>
                                <span class="d-block text-muted text-uppercase fs-7 fw-bold">Unit Penyewaan</span>
                                <h4 class="mb-0 fw-bold text-warning">Rp {{ number_format($totalPenyewaan, 0, ',', '.') }}
                                </h4>
                            </div>
                        </div>
                        <div class="d-flex align-items-center small">
                            <span class="badge bg-label-success me-2"><i class="bx bx-up-arrow-alt"></i> +8.2%</span>
                            <span class="text-muted">dari bulan lalu</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Pendapatan Gas -->
            <div class="col-md-4">
                <div class="card h-100 border-0 shadow-sm hover-lift">
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-3">
                            <div class="avatar avatar-md me-3">
                                <span class="avatar-initial rounded-circle bg-label-info">
                                    <i class='bx bx-cylinder fs-4'></i>
                                </span>
                            </div>
                            <div>
                                <span class="d-block text-muted text-uppercase fs-7 fw-bold">Unit Gas</span>
                                <h4 class="mb-0 fw-bold text-info">Rp {{ number_format($totalGas, 0, ',', '.') }}</h4>
                            </div>
                        </div>
                        <div class="d-flex align-items-center small">
                            <span class="badge bg-label-danger me-2"><i class="bx bx-down-arrow-alt"></i> -2.4%</span>
                            <span class="text-muted">dari bulan lalu</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filters & Kinerja Chart -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-white border-bottom d-flex justify-content-between align-items-center">
                        <h5 class="mb-0 fw-bold">Kinerja Keuangan BUMDes</h5>
                        <div class="d-flex gap-2">
                            <select class="form-select form-select-sm" style="width: 150px;">
                                <option value="all">Semua Metode</option>
                                <option value="tunai">Tunai</option>
                                <option value="transfer">Transfer</option>
                            </select>
                            <select class="form-select form-select-sm" style="width: 120px;">
                                <option>Bulanan</option>
                                <option>Mingguan</option>
                                <option>Harian</option>
                            </select>
                        </div>
                    </div>
                    <div class="card-body">
                        <div id="kinerjaChart" style="min-height: 350px;"></div>
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
                                <div class="card">
                                    <div class="card-header">
                                        <h5 class="card-title mb-0">Pendapatan dan Pengeluaran</h5>
                                    </div>
                                    <div class="body">
                                        <div class="chart-wrapper">
                                            <div id="totalRevenueChart" class="px-2"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Middle Column: Grafik Transaksi -->
                            <div class="dashboard-stats-col">
                                <div class="card">
                                    <div class="card-header">
                                        <h5 class="card-title mb-0">Perbandingan Transaksi</h5>
                                    </div>
                                    <div class="card-body d-flex flex-column justify-content-center align-items-center"
                                        style="min-height: 400px; padding: 2rem;">
                                        <h2 class="mb-2">{{ $rentalCount + $gasCount }}</h2>
                                        <span class="text-muted mb-4">Total Transaksi</span>
                                        <!-- Large donut chart will be rendered here by inline script -->
                                        <div id="transactionDonutChart" style="width: 100%; max-width: 300px;"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

        <!-- Unit Populer Chart -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-white border-bottom">
                        <h5 class="mb-0 fw-bold">Statistik Unit Populer</h5>
                    </div>
                    <div class="card-body">
                        <div id="unitChart" style="min-height: 350px;"></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Detail Table -->
        <div class="row">
            <div class="col-12">
                <div class="card shadow-sm border-0 overflow-hidden">
                    <div class="card-header bg-white border-bottom d-flex justify-content-between align-items-center py-3">
                        <h5 class="mb-0 fw-bold">Detail Pendapatan Per Unit</h5>
                        <button class="btn btn-sm btn-outline-primary">
                            <i class="bx bx-download me-1"></i> Unduh Data
                        </button>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th class="py-3 ps-4 text-uppercase fs-7 fw-bold text-muted">Unit Layanan</th>
                                    <th class="py-3 text-uppercase fs-7 fw-bold text-muted">Total Pendapatan</th>
                                    <th class="py-3 text-uppercase fs-7 fw-bold text-muted">Jumlah Transaksi</th>
                                    <th class="py-3 text-uppercase fs-7 fw-bold text-muted">Rata-rata / Transaksi</th>
                                    <th class="py-3 text-uppercase fs-7 fw-bold text-muted">Status Target</th>
                                </tr>
                            </thead>
                            <tbody class="border-top-0">
                                <tr>
                                    <td class="ps-4 py-3">
                                        <div class="d-flex align-items-center">
                                            <div class="avatar avatar-md me-3">
                                                <span
                                                    class="avatar-initial rounded-circle bg-label-warning bg-opacity-10 text-warning">
                                                    <i class='bx bx-wrench fs-4'></i>
                                                </span>
                                            </div>
                                            <div>
                                                <span class="fw-bold text-dark d-block">Penyewaan Alat</span>
                                                <small class="text-muted">Layanan penyewaan peralatan</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="py-3">
                                        <span class="fw-bold text-primary">Rp
                                            {{ number_format($totalPenyewaan, 0, ',', '.') }}</span>
                                    </td>
                                    <td class="py-3">
                                        <span
                                            class="badge bg-label-secondary rounded-pill px-3">{{ $rentalRequests->count() }}
                                            Transaksi</span>
                                    </td>
                                    <td class="py-3">
                                        <span class="text-dark">Rp
                                            {{ number_format($totalPenyewaan / max(1, $rentalRequests->count()), 0, ',', '.') }}</span>
                                    </td>
                                    <td class="py-3">
                                        <span class="badge bg-success bg-opacity-75 px-3 py-2 rounded-pill">Tercapai</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="ps-4 py-3">
                                        <div class="d-flex align-items-center">
                                            <div class="avatar avatar-md me-3">
                                                <span
                                                    class="avatar-initial rounded-circle bg-label-info bg-opacity-10 text-info">
                                                    <i class='bx bx-cylinder fs-4'></i>
                                                </span>
                                            </div>
                                            <div>
                                                <span class="fw-bold text-dark d-block">Penjualan Gas</span>
                                                <small class="text-muted">Layanan distribusi gas LPG</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="py-3">
                                        <span class="fw-bold text-info">Rp
                                            {{ number_format($totalGas, 0, ',', '.') }}</span>
                                    </td>
                                    <td class="py-3">
                                        <span class="badge bg-label-secondary rounded-pill px-3">{{ $gasOrders->count() }}
                                            Transaksi</span>
                                    </td>
                                    <td class="py-3">
                                        <span class="text-dark">Rp
                                            {{ number_format($totalGas / max(1, $gasOrders->count()), 0, ',', '.') }}</span>
                                    </td>
                                    <td class="py-3">
                                        <span class="badge bg-warning bg-opacity-75 px-3 py-2 rounded-pill">Perlu
                                            Peningkatan</span>
                                    </td>
                                </tr>
                            </tbody>
                            <tfoot class="bg-light border-top">
                                <tr>
                                    <td class="ps-4 py-3">
                                        <span class="fw-bold text-uppercase text-dark">Total Keseluruhan</span>
                                    </td>
                                    <td class="py-3">
                                        <span class="fw-bolder text-dark fs-6">Rp
                                            {{ number_format($totalPendapatan, 0, ',', '.') }}</span>
                                    </td>
                                    <td class="py-3">
                                        <span
                                            class="fw-bold text-dark">{{ $rentalRequests->count() + $gasOrders->count() }}
                                            Transaksi</span>
                                    </td>
                                    <td class="py-3">
                                        <span class="fw-bold text-dark">Rp
                                            {{ number_format($totalPendapatan / max(1, $rentalRequests->count() + $gasOrders->count()), 0, ',', '.') }}</span>
                                    </td>
                                    <td></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Manual Transactions Table -->
        <div class="row mt-4">
            <div class="col-12">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-white border-bottom d-flex justify-content-between align-items-center py-3">
                        <h5 class="mb-0 fw-bold">Laporan Transaksi Manual</h5>
                        <span class="badge bg-label-primary">{{ $manualReports->count() }} Laporan</span>
                    </div>
                    <div class="table-responsive">
                        @if($manualReports->count() > 0)
                        <table class="table table-hover align-middle mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th class="py-3 ps-4 text-uppercase fs-7 fw-bold text-muted">Tanggal</th>
                                    <th class="py-3 text-uppercase fs-7 fw-bold text-muted">Kategori</th>
                                    <th class="py-3 text-uppercase fs-7 fw-bold text-muted">Nama Item</th>
                                    <th class="py-3 text-uppercase fs-7 fw-bold text-muted">Jumlah</th>
                                    <th class="py-3 text-uppercase fs-7 fw-bold text-muted">Harga</th>
                                    <th class="py-3 text-uppercase fs-7 fw-bold text-muted">Total</th>
                                    <th class="py-3 text-uppercase fs-7 fw-bold text-muted">Pembayaran</th>
                                    <th class="py-3 pe-4 text-uppercase fs-7 fw-bold text-muted text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($manualReports as $report)
                                <tr>
                                    <td class="ps-4 py-3">
                                        <span class="text-dark">{{ $report->transaction_date->format('d M Y') }}</span>
                                    </td>
                                    <td class="py-3">
                                        <span class="badge bg-{{ $report->category_badge }}">{{ $report->category_label }}</span>
                                    </td>
                                    <td class="py-3">
                                        <div>
                                            <span class="fw-bold text-dark d-block">{{ $report->name }}</span>
                                            @if($report->description)
                                            <small class="text-muted">{{ Str::limit($report->description, 50) }}</small>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="py-3">
                                        <span class="badge bg-label-secondary">{{ $report->quantity }} item</span>
                                    </td>
                                    <td class="py-3">
                                        <span class="text-dark">{{ $report->formatted_amount }}</span>
                                    </td>
                                    <td class="py-3">
                                        <span class="fw-bold text-primary">{{ $report->formatted_total }}</span>
                                    </td>
                                    <td class="py-3">
                                        <span class="badge bg-label-{{ $report->payment_method == 'tunai' ? 'success' : 'info' }}">
                                            {{ ucfirst($report->payment_method) }}
                                        </span>
                                    </td>
                                    <td class="py-3 pe-4 text-center">
                                        <button class="btn btn-sm btn-icon btn-outline-primary me-1" 
                                                onclick="editManualTransaction({{ $report->id }})"
                                                title="Edit">
                                            <i class="bx bx-edit"></i>
                                        </button>
                                        <button class="btn btn-sm btn-icon btn-outline-danger" 
                                                onclick="deleteManualTransaction({{ $report->id }})"
                                                title="Hapus">
                                            <i class="bx bx-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        @else
                        <div class="text-center py-5">
                            <i class="bx bx-file-blank fs-1 text-muted mb-3"></i>
                            <p class="text-muted">Belum ada laporan transaksi manual</p>
                            <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#manualTransactionModal">
                                <i class="bx bx-plus me-1"></i> Tambah Laporan Pertama
                            </button>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- Manual Transaction Modal -->
    <div class="modal fade" id="manualTransactionModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTitle">Tambah Laporan Transaksi Manual</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="manualTransactionForm">
                    <input type="hidden" id="transactionId" name="id">
                    <div class="modal-body">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Kategori <span class="text-danger">*</span></label>
                                <select class="form-select" id="category" name="category" required>
                                    <option value="">Pilih Kategori</option>
                                    <option value="penyewaan">Penyewaan Alat</option>
                                    <option value="gas">Penjualan Gas</option>
                                    <option value="lainnya">Lainnya</option>
                                </select>
                                <div class="invalid-feedback"></div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Tanggal Transaksi <span class="text-danger">*</span></label>
                                <input type="date" class="form-control" id="transaction_date" name="transaction_date" required>
                                <div class="invalid-feedback"></div>
                            </div>
                            <div class="col-12">
                                <label class="form-label fw-bold">Nama Item <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="name" name="name" placeholder="Contoh: Tenda 3x3 meter" required>
                                <div class="invalid-feedback"></div>
                            </div>
                            <div class="col-12">
                                <label class="form-label fw-bold">Deskripsi</label>
                                <textarea class="form-control" id="description" name="description" rows="2" placeholder="Deskripsi tambahan (opsional)"></textarea>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-bold">Jumlah Item <span class="text-danger">*</span></label>
                                <input type="number" class="form-control" id="quantity" name="quantity" min="1" value="1" required>
                                <div class="invalid-feedback"></div>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-bold">Harga per Item <span class="text-danger">*</span></label>
                                <input type="number" class="form-control" id="amount" name="amount" min="0" step="0.01" placeholder="0" required>
                                <div class="invalid-feedback"></div>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-bold">Total</label>
                                <input type="text" class="form-control bg-light" id="total" readonly>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Metode Pembayaran <span class="text-danger">*</span></label>
                                <select class="form-select" id="payment_method" name="payment_method" required>
                                    <option value="">Pilih Metode</option>
                                    <option value="tunai">Tunai</option>
                                    <option value="transfer">Transfer</option>
                                </select>
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary" id="submitBtn">
                            <i class="bx bx-save me-1"></i> Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Styles for Hover Effects -->
    <style>
        .hover-lift {
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .hover-lift:hover {
            transform: translateY(-5px);
            box-shadow: 0 .5rem 1rem rgba(0, 0, 0, .15) !important;
        }

        .avatar-initial {
            display: flex;
            align-items: center;
            justify-content: center;
        }
    </style>

    <!-- Scripts for Charts -->
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {

            // ========================================
            // GRAFIK KINERJA BUMDES (AREA CHART)
            // ========================================
            const kinerjaElement = document.querySelector("#kinerjaChart");
            if (kinerjaElement) {
                const kinerjaOptions = {
                    series: [{
                        name: 'Pendapatan',
                        data: {!! json_encode(array_values($monthlyIncome)) !!}
                    }],
                    chart: {
                        type: 'area',
                        height: 350,
                        toolbar: {
                            show: false
                        },
                        zoom: {
                            enabled: false
                        }
                    },
                    colors: ['#f59e0b'],
                    stroke: {
                        curve: 'smooth',
                        width: 3
                    },
                    fill: {
                        type: 'gradient',
                        gradient: {
                            shadeIntensity: 1,
                            opacityFrom: 0.45,
                            opacityTo: 0.05,
                            stops: [0, 90, 100]
                        }
                    },
                    dataLabels: {
                        enabled: false
                    },
                    markers: {
                        size: 0,
                        hover: {
                            size: 5
                        }
                    },
                    xaxis: {
                        categories: {!! json_encode(array_keys($monthlyIncome)) !!},
                        labels: {
                            style: {
                                colors: '#374151',
                                fontSize: '12px'
                            }
                        },
                        axisBorder: {
                            show: false
                        },
                        axisTicks: {
                            show: false
                        }
                    },
                    yaxis: {
                        labels: {
                            formatter: function(val) {
                                return val.toFixed(1);
                            },
                            style: {
                                colors: '#6b7280',
                                fontSize: '11px'
                            }
                        }
                    },
                    grid: {
                        borderColor: '#e5e7eb',
                        strokeDashArray: 3,
                        xaxis: {
                            lines: {
                                show: true
                            }
                        },
                        yaxis: {
                            lines: {
                                show: true
                            }
                        },
                        padding: {
                            top: 0,
                            right: 0,
                            bottom: 0,
                            left: 10
                        }
                    },
                    tooltip: {
                        y: {
                            formatter: function(val) {
                                return val.toFixed(1);
                            }
                        }
                    }
                };
                const kinerjaChart = new ApexCharts(kinerjaElement, kinerjaOptions);
                kinerjaChart.render();
            }

            // ========================================
            // GRAFIK UNIT POPULER (BAR CHART)
            // ========================================
            const unitElement = document.querySelector("#unitChart");
            if (unitElement) {
                const unitOptions = {
                    series: [{
                            name: 'Unit Penyewaan Alat',
                            data: {!! json_encode(array_slice(array_values($monthlyIncome), 0, 5)) !!}
                        },
                        {
                            name: 'Unit Penjualan Gas',
                            data: {!! json_encode(array_slice(array_values($monthlyIncome), 0, 5)) !!}
                        }
                    ],
                    chart: {
                        type: 'bar',
                        height: 350,
                        toolbar: {
                            show: false
                        },
                        stacked: false,
                        background: 'transparent'
                    },
                    colors: ['#f59e0b', '#3b82f6'],
                    plotOptions: {
                        bar: {
                            horizontal: false,
                            columnWidth: '50%',
                            borderRadius: 4,
                            dataLabels: {
                                position: 'top'
                            }
                        }
                    },
                    dataLabels: {
                        enabled: false
                    },
                    xaxis: {
                        categories: {!! json_encode(array_slice(array_keys($monthlyIncome), 0, 5)) !!},
                        labels: {
                            style: {
                                colors: '#374151',
                                fontSize: '12px',
                                fontWeight: 500
                            }
                        },
                        axisBorder: {
                            show: false
                        },
                        axisTicks: {
                            show: false
                        }
                    },
                    yaxis: {
                        min: 0,
                        max: 35,
                        tickAmount: 7,
                        labels: {
                            style: {
                                colors: '#6b7280',
                                fontSize: '11px'
                            }
                        }
                    },
                    grid: {
                        borderColor: '#e5e7eb',
                        strokeDashArray: 3,
                        padding: {
                            top: 0,
                            right: 10,
                            bottom: 0,
                            left: 5
                        }
                    },
                    legend: {
                        position: 'bottom',
                        horizontalAlign: 'center',
                        offsetY: 5
                    },
                    tooltip: {
                        shared: true,
                        intersect: false
                    }
                };
                const unitChart = new ApexCharts(unitElement, unitOptions);
                unitChart.render();
            }

            // ========================================
            // GRAFIK PENDAPATAN DAN PENGELUARAN (BAR CHART)
            // ========================================
            const totalRevenueElement = document.querySelector("#totalRevenueChart");
            if (totalRevenueElement) {
                const totalRevenueOptions = {
                    series: [{
                            name: 'Pendapatan 2025',
                            data: {!! json_encode(array_slice(array_values($monthlyIncome), 0, 7)) !!}
                        },
                        {
                            name: 'Pengeluaran 2025',
                            data: [0, 0, 0, 0, 0, 0, 0]
                        }
                    ],
                    chart: {
                        type: 'bar',
                        height: 300,
                        stacked: true,
                        toolbar: {
                            show: false
                        }
                    },
                    colors: ['#696cff', '#03c3ec'],
                    plotOptions: {
                        bar: {
                            horizontal: false,
                            columnWidth: '33%',
                            borderRadius: 8,
                            startingShape: 'rounded',
                            endingShape: 'rounded'
                        }
                    },
                    dataLabels: {
                        enabled: false
                    },
                    stroke: {
                        curve: 'smooth',
                        width: 6,
                        lineCap: 'round',
                        colors: ['transparent']
                    },
                    legend: {
                        show: true,
                        horizontalAlign: 'left',
                        position: 'top',
                        markers: {
                            height: 8,
                            width: 8,
                            radius: 12,
                            offsetX: -3
                        },
                        labels: {
                            colors: '#6e6b7b'
                        },
                        itemMargin: {
                            horizontal: 10
                        }
                    },
                    grid: {
                        borderColor: '#e7e7e7',
                        padding: {
                            top: 0,
                            bottom: -8,
                            left: 20,
                            right: 20
                        }
                    },
                    xaxis: {
                        categories: {!! json_encode(array_slice(array_keys($monthlyIncome), 0, 7)) !!},
                        labels: {
                            style: {
                                fontSize: '13px',
                                colors: '#6e6b7b'
                            }
                        },
                        axisTicks: {
                            show: false
                        },
                        axisBorder: {
                            show: false
                        }
                    },
                    yaxis: {
                        labels: {
                            style: {
                                fontSize: '13px',
                                colors: '#6e6b7b'
                            }
                        }
                    },
                    responsive: [{
                        breakpoint: 1700,
                        options: {
                            plotOptions: {
                                bar: {
                                    borderRadius: 10,
                                    columnWidth: '32%'
                                }
                            }
                        }
                    }, {
                        breakpoint: 1580,
                        options: {
                            plotOptions: {
                                bar: {
                                    borderRadius: 10,
                                    columnWidth: '35%'
                                }
                            }
                        }
                    }, {
                        breakpoint: 1440,
                        options: {
                            plotOptions: {
                                bar: {
                                    borderRadius: 10,
                                    columnWidth: '42%'
                                }
                            }
                        }
                    }, {
                        breakpoint: 1300,
                        options: {
                            plotOptions: {
                                bar: {
                                    borderRadius: 10,
                                    columnWidth: '48%'
                                }
                            }
                        }
                    }, {
                        breakpoint: 1200,
                        options: {
                            plotOptions: {
                                bar: {
                                    borderRadius: 10,
                                    columnWidth: '40%'
                                }
                            }
                        }
                    }, {
                        breakpoint: 1040,
                        options: {
                            plotOptions: {
                                bar: {
                                    borderRadius: 11,
                                    columnWidth: '48%'
                                }
                            }
                        }
                    }, {
                        breakpoint: 991,
                        options: {
                            plotOptions: {
                                bar: {
                                    borderRadius: 10,
                                    columnWidth: '30%'
                                }
                            }
                        }
                    }, {
                        breakpoint: 840,
                        options: {
                            plotOptions: {
                                bar: {
                                    borderRadius: 10,
                                    columnWidth: '35%'
                                }
                            }
                        }
                    }, {
                        breakpoint: 768,
                        options: {
                            plotOptions: {
                                bar: {
                                    borderRadius: 10,
                                    columnWidth: '28%'
                                }
                            }
                        }
                    }, {
                        breakpoint: 640,
                        options: {
                            plotOptions: {
                                bar: {
                                    borderRadius: 10,
                                    columnWidth: '32%'
                                }
                            }
                        }
                    }, {
                        breakpoint: 576,
                        options: {
                            plotOptions: {
                                bar: {
                                    borderRadius: 10,
                                    columnWidth: '37%'
                                }
                            }
                        }
                    }, {
                        breakpoint: 480,
                        options: {
                            plotOptions: {
                                bar: {
                                    borderRadius: 10,
                                    columnWidth: '45%'
                                }
                            }
                        }
                    }, {
                        breakpoint: 420,
                        options: {
                            plotOptions: {
                                bar: {
                                    borderRadius: 10,
                                    columnWidth: '52%'
                                }
                            }
                        }
                    }, {
                        breakpoint: 380,
                        options: {
                            plotOptions: {
                                bar: {
                                    borderRadius: 10,
                                    columnWidth: '60%'
                                }
                            }
                        }
                    }],
                    states: {
                        hover: {
                            filter: {
                                type: 'lighten',
                                value: 0.04
                            }
                        },
                        active: {
                            filter: {
                                type: 'darken',
                                value: 0.88
                            }
                        }
                    }
                };
                const totalRevenueChart = new ApexCharts(totalRevenueElement, totalRevenueOptions);
                totalRevenueChart.render();
            }

            // ========================================
            // DONUT CHART UNTUK TRANSAKSI
            // ========================================
            const orderChartElement = document.querySelector("#transactionDonutChart");
            if (orderChartElement) {
                var optionsOrder = {
                    series: [{{ $rentalCount ?? 0 }}, {{ $gasCount ?? 0 }}],
                    chart: {
                        type: "donut",
                        width: 300,
                        height: 300,
                        events: {
                            dataPointSelection: function(event, chartContext, config) {
                                // Prevent default behavior on click
                                event.preventDefault();
                            }
                        }
                    },
                    labels: ["Unit Penyewaan Alat {{ $rentalCount ?? 0 }} Transaksi", "Gas {{ $gasCount ?? 0 }} Transaksi"],
                    colors: ["#FFC107", "#EA5455"],
                    legend: {
                        show: true,
                        position: 'bottom',
                        horizontalAlign: 'center',
                        fontSize: '13px',
                        fontWeight: 500,
                        markers: {
                            width: 10,
                            height: 10,
                            radius: 12
                        },
                        itemMargin: {
                            horizontal: 10,
                            vertical: 5
                        }
                    },
                    dataLabels: {
                        enabled: false
                    },
                    plotOptions: {
                        pie: {
                            donut: {
                                size: "70%",
                                labels: {
                                    show: true,
                                    name: {
                                        show: false
                                    },
                                    value: {
                                        show: true,
                                        fontSize: "30px",
                                        fontWeight: 600,
                                        color: "#5e5873",
                                        offsetY: 5,
                                        formatter: function() {
                                            return "{{ ($rentalCount ?? 0) + ($gasCount ?? 0) }}";
                                        },
                                    },
                                    total: {
                                        show: true,
                                        label: "2025",
                                        fontSize: "16px",
                                        color: "#6e6b7b",
                                        offsetY: 25,
                                    },
                                },
                            },
                        },
                    },
                    tooltip: {
                        enabled: true,
                        y: {
                            formatter: function(value, { seriesIndex, dataPointIndex, w }) {
                                // Return empty string to hide the value, only show label
                                return '';
                            },
                            title: {
                                formatter: function(seriesName) {
                                    // Return only the label name without any value
                                    return seriesName;
                                }
                            }
                        },
                        custom: function({ series, seriesIndex, dataPointIndex, w }) {
                            // Custom tooltip to show only the label name
                            return '<div class="apexcharts-tooltip-custom" style="padding: 8px 12px; background: #fff; border: 1px solid #e3e3e3; border-radius: 4px;">' +
                                '<span style="font-weight: 500; color: #333;">' + w.config.labels[seriesIndex] + '</span>' +
                                '</div>';
                        }
                    },
                    states: {
                        active: {
                            filter: {
                                type: 'none'
                            }
                        }
                    }
                };

                try {
                    var chartOrder = new ApexCharts(orderChartElement, optionsOrder);
                    chartOrder.render();
                    console.log('Order chart rendered successfully!');
                } catch (error) {
                    console.error('Error rendering order chart:', error);
                }
            }
        });

        // ========================================
        // MANUAL TRANSACTION CRUD OPERATIONS
        // ========================================
        
        // Calculate total automatically
        document.getElementById('quantity').addEventListener('input', calculateTotal);
        document.getElementById('amount').addEventListener('input', calculateTotal);
        
        function calculateTotal() {
            const quantity = parseFloat(document.getElementById('quantity').value) || 0;
            const amount = parseFloat(document.getElementById('amount').value) || 0;
            const total = quantity * amount;
            document.getElementById('total').value = 'Rp ' + total.toLocaleString('id-ID');
        }
        
        // Reset form when modal is closed
        document.getElementById('manualTransactionModal').addEventListener('hidden.bs.modal', function () {
            document.getElementById('manualTransactionForm').reset();
            document.getElementById('transactionId').value = '';
            document.getElementById('modalTitle').textContent = 'Tambah Laporan Transaksi Manual';
            document.querySelectorAll('.is-invalid').forEach(el => el.classList.remove('is-invalid'));
            document.querySelectorAll('.invalid-feedback').forEach(el => el.textContent = '');
        });
        
        // Handle form submission
        document.getElementById('manualTransactionForm').addEventListener('submit', async function(e) {
            e.preventDefault();
            
            const transactionId = document.getElementById('transactionId').value;
            const isEdit = transactionId !== '';
            const url = isEdit 
                ? `/admin/laporan/manual-transaction/${transactionId}`
                : '/admin/laporan/manual-transaction';
            const method = isEdit ? 'PUT' : 'POST';
            
            const formData = {
                category: document.getElementById('category').value,
                name: document.getElementById('name').value,
                description: document.getElementById('description').value,
                amount: document.getElementById('amount').value,
                quantity: document.getElementById('quantity').value,
                payment_method: document.getElementById('payment_method').value,
                transaction_date: document.getElementById('transaction_date').value,
            };
            
            try {
                const response = await fetch(url, {
                    method: method,
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify(formData)
                });
                
                const data = await response.json();
                
                if (data.success) {
                    // Close modal
                    bootstrap.Modal.getInstance(document.getElementById('manualTransactionModal')).hide();
                    
                    // Show success message
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: data.message,
                        timer: 2000,
                        showConfirmButton: false
                    }).then(() => {
                        // Reload page to show updated data
                        window.location.reload();
                    });
                } else {
                    // Show validation errors
                    if (data.errors) {
                        Object.keys(data.errors).forEach(key => {
                            const input = document.getElementById(key);
                            if (input) {
                                input.classList.add('is-invalid');
                                const feedback = input.nextElementSibling;
                                if (feedback && feedback.classList.contains('invalid-feedback')) {
                                    feedback.textContent = data.errors[key][0];
                                }
                            }
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal!',
                            text: data.message || 'Terjadi kesalahan'
                        });
                    }
                }
            } catch (error) {
                console.error('Error:', error);
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: 'Terjadi kesalahan saat menyimpan data'
                });
            }
        });
        
        // Edit manual transaction
        window.editManualTransaction = async function(id) {
            try {
                // Fetch transaction data
                const reports = @json($manualReports);
                const report = reports.find(r => r.id === id);
                
                if (report) {
                    document.getElementById('transactionId').value = report.id;
                    document.getElementById('category').value = report.category;
                    document.getElementById('name').value = report.name;
                    document.getElementById('description').value = report.description || '';
                    document.getElementById('amount').value = report.amount;
                    document.getElementById('quantity').value = report.quantity;
                    document.getElementById('payment_method').value = report.payment_method;
                    document.getElementById('transaction_date').value = report.transaction_date.split('T')[0];
                    document.getElementById('modalTitle').textContent = 'Edit Laporan Transaksi Manual';
                    
                    calculateTotal();
                    
                    // Show modal
                    new bootstrap.Modal(document.getElementById('manualTransactionModal')).show();
                }
            } catch (error) {
                console.error('Error:', error);
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: 'Terjadi kesalahan saat mengambil data'
                });
            }
        };
        
        // Delete manual transaction
        window.deleteManualTransaction = async function(id) {
            const result = await Swal.fire({
                title: 'Hapus Laporan?',
                text: 'Data yang dihapus tidak dapat dikembalikan!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal'
            });
            
            if (result.isConfirmed) {
                try {
                    const response = await fetch(`/admin/laporan/manual-transaction/${id}`, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                        }
                    });
                    
                    const data = await response.json();
                    
                    if (data.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Terhapus!',
                            text: data.message,
                            timer: 2000,
                            showConfirmButton: false
                        }).then(() => {
                            window.location.reload();
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal!',
                            text: data.message || 'Terjadi kesalahan'
                        });
                    }
                } catch (error) {
                    console.error('Error:', error);
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: 'Terjadi kesalahan saat menghapus data'
                    });
                }
            }
        };
    </script>
@endsection
