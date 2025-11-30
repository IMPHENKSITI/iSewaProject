@extends('admin.layouts.admin')
@section('content')
    <div class="content-wrapper">
        <div class="container-xxl flex-grow-1 container-p-y">

            <!-- Welcome Card & Performance Chart -->
            <div class="row mb-2">
                <div class="col-lg-5">
                    <div class="card animate-fade-in">
                        <div class="d-flex align-items-end row">
                            <div class="col-sm-10">
                                <div class="card-body p-3">
                                    <h5 class="card-title text-primary fw-bold">Selamat Datang di iSewa 🏛️</h5>
                                    <p class="mb-2">Sistem Penyewaan Alat dan Promosi Usaha BUMDes berbasis Digital <span
                                            class="fw-bold">Desa Pematang Duku Timur</span></p>
                                    <a href="{{ route('admin.isewa.profile-bumdes') }}"
                                        class="btn btn-outline-primary">Profil BUMDes</a>
                                </div>
                            </div>
                            <div class="col-sm-45 text-center text-sm-left">
                                <div class="card-body pb-0 px-0 px-md-3">
                                    <img src="{{ asset('Admin/img/illustrations/bermasab.png') }}" height="255"
                                        alt="View Badge User" data-app-dark-img="illustrations/man-with-laptop-dark.png"
                                        data-app-light-img="illustrations/man-with-laptop-light.png" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-7">
                    <div class="card animate-fade-in">
                        <div class="card-body">
                            <div
                                class="d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center mb-4">
                                <div>
                                    <h5 class="card-title fw-bold mb-2">Kinerja BUMDES</h5>
                                    <span class="badge bg-label-warning rounded-pill">Tahun 2025</span>
                                </div>
                                <div class="d-flex flex-column flex-sm-row gap-2 mt-3 mt-sm-0">
                                    <select class="form-select form-select-sm" id="desaSelect" style="min-width: 200px;">
                                        <option selected>Desa Pematang Duku Timur</option>
                                        <option>Desa Pematang Duku Barat</option>
                                        <option>Sungai Pakning</option>
                                    </select>
                                    <select class="form-select form-select-sm" id="tahunSelect" style="min-width: 100px;">
                                        <option selected>2025</option>
                                        <option>2024</option>
                                        <option>2023</option>
                                    </select>
                                </div>
                            </div>
                            <div id="kinerjaChart" style="min-height: 300px;"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="mb-3"></div>

            <!-- Unit Cards - Full Width -->
            <div class="row mb-4">
                <div class="col-md-6 mb-3">
                    <div class="card unit-card warning hover-lift animate-on-scroll slide-in-left"
                        onclick="window.location='{{ route('admin.unit.penyewaan.index') }}'">
                        <div class="card-body p-4">
                            <div class="d-flex align-items-center">
                                <div class="avatar flex-shrink-0 me-3" style="width: 70px; height: 70px;">
                                    <img src="{{ asset('Admin/img/5.png') }}" alt="" class="rounded w-100" />
                                </div>
                                <div class="flex-grow-1">
                                    <span class="fw-semibold d-block mb-2 text-muted">Unit Penyewaan Alat</span>
                                    <h3 class="card-title mb-0">{{ $unitPenyewaan ?? 9 }} Item</h3>
                                </div>
                                <i class="bx bx-chevron-right bx-lg text-warning"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 mb-3">
                    <div class="card unit-card danger hover-lift animate-on-scroll slide-in-right"
                        onclick="window.location='{{ route('admin.unit.penjualan_gas.index') }}'">
                        <div class="card-body p-4">
                            <div class="d-flex align-items-center">
                                <div class="avatar flex-shrink-0 me-3" style="width: 70px; height: 70px;">
                                    <img src="{{ asset('Admin/img/icons/unicons/6.png') }}" alt=""
                                        class="rounded w-100" />
                                </div>
                                <div class="flex-grow-1">
                                    <span class="fw-semibold d-block mb-2 text-muted">Unit Penjualan Gas</span>
                                    <h3 class="card-title mb-0">{{ $unitGas ?? 2 }} Jenis Tabung</h3>
                                </div>
                                <i class="bx bx-chevron-right bx-lg text-danger"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Notifications Section -->
                <div class="row mb-4">
                    <div class="col-12">
                        <div class="card shadow-sm">
                            <div class="card-header bg-white py-3 border-bottom">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h5 class="mb-1 fw-semibold d-flex align-items-center">
                                            <span class="badge badge-center rounded-pill bg-label-primary me-2"
                                                style="width: 32px; height: 32px;">
                                                <i class="bx bx-bell fs-5"></i>
                                            </span>
                                            Notifikasi Permintaan
                                        </h5>
                                    </div>
                                    <span class="badge bg-primary rounded-pill px-3">3 Baru</span>
                                </div>
                            </div>
                            <div class="card-body p-0">
                                <div class="table-responsive">
                                    <table class="table table-hover mb-0">
                                        <tbody>

                                            <!-- Notification 1 -->
                                            <tr class="notification-item" id="notification1">
                                                <td class="ps-4" style="width: 60px;">
                                                    <div class="avatar">
                                                        <img src="{{ asset('Admin/img/avatars/1.png') }}" alt="User A"
                                                            class="rounded-circle"
                                                            style="width: 48px; height: 48px; object-fit: cover;">
                                                    </div>
                                                </td>
                                                <td class="py-3">
                                                    <div class="mb-1">
                                                        <span class="badge bg-label-warning me-2">
                                                            <i class=""></i>Penyewaan Alat
                                                        </span>
                                                        <small class="text-muted">2 jam lalu</small>
                                                    </div>
                                                    <h6 class="mb-1 fw-semibold">User A mengajukan penyewaan Tenda Komplit
                                                    </h6>
                                                    <p class="text-muted mb-0 small">Untuk acara pernikahan tanggal 15
                                                        November 2025</p>
                                                </td>
                                                <td class="text-end pe-4" style="width: 280px;">
                                                    <div class="d-flex gap-2 justify-content-end">
                                                        <button class="btn btn-sm btn-outline-info"
                                                            onclick="showDetails(1, 'Penyewaan Tenda Komplit', 'User A', 'Untuk acara pernikahan tanggal 15 November 2025', 'Penyewaan Alat')">
                                                            <i class="bx bx-show me-1"></i>Detail
                                                        </button>
                                                        <button class="btn btn-sm btn-success"
                                                            onclick="acceptRequest(1, 'User A', 'Tenda Komplit')">
                                                            <i class="bx bx-check me-1"></i>Terima
                                                        </button>
                                                        <button class="btn btn-sm btn-danger"
                                                            onclick="rejectRequest(1, 'User A', 'Tenda Komplit')">
                                                            <i class="bx bx-x me-1"></i>Tolak
                                                        </button>
                                                    </div>
                                                </td>
                                            </tr>

                                            <!-- Notification 2 -->
                                            <tr class="notification-item" id="notification2">
                                                <td class="ps-4" style="width: 60px;">
                                                    <div class="avatar">
                                                        <img src="{{ asset('Admin/img/avatars/2.png') }}"
                                                            alt="Budi Santoso" class="rounded-circle"
                                                            style="width: 48px; height: 48px; object-fit: cover;">
                                                    </div>
                                                </td>
                                                <td class="py-3">
                                                    <div class="mb-1">
                                                        <span class="badge bg-label-danger me-2">
                                                            <i class=></i>Penjualan Gas
                                                        </span>
                                                        <small class="text-muted">5 jam lalu</small>
                                                    </div>
                                                    <h6 class="mb-1 fw-semibold">Budi Santoso memesan Gas LPG 3 Kg</h6>
                                                    <p class="text-muted mb-0 small">Pemesanan 5 tabung untuk kebutuhan
                                                        usaha warung</p>
                                                </td>
                                                <td class="text-end pe-4" style="width: 280px;">
                                                    <div class="d-flex gap-2 justify-content-end">
                                                        <button class="btn btn-sm btn-outline-info"
                                                            onclick="showDetails(2, 'Penjualan Gas LPG 3 Kg', 'Budi Santoso', 'Pemesanan 5 tabung untuk kebutuhan usaha warung', 'Penjualan Gas')">
                                                            <i class="bx bx-show me-1"></i>Detail
                                                        </button>
                                                        <button class="btn btn-sm btn-success"
                                                            onclick="acceptRequest(2, 'Budi Santoso', 'Gas LPG 3 Kg')">
                                                            <i class="bx bx-check me-1"></i>Terima
                                                        </button>
                                                        <button class="btn btn-sm btn-danger"
                                                            onclick="rejectRequest(2, 'Budi Santoso', 'Gas LPG 3 Kg')">
                                                            <i class="bx bx-x me-1"></i>Tolak
                                                        </button>
                                                    </div>
                                                </td>
                                            </tr>

                                            <!-- Notification 3 -->
                                            <tr class="notification-item" id="notification3">
                                                <td class="ps-4" style="width: 60px;">
                                                    <div class="avatar">
                                                        <img src="{{ asset('Admin/img/avatars/3.png') }}"
                                                            alt="Siti Aminah" class="rounded-circle"
                                                            style="width: 48px; height: 48px; object-fit: cover;">
                                                    </div>
                                                </td>
                                                <td class="py-3">
                                                    <div class="mb-1">
                                                        <span class="badge bg-label-warning me-2">
                                                            <i class=></i>Penyewaan Alat
                                                        </span>
                                                        <small class="text-muted">1 hari lalu</small>
                                                    </div>
                                                    <h6 class="mb-1 fw-semibold">Siti Aminah mengajukan penyewaan Sound
                                                        System</h6>
                                                    <p class="text-muted mb-0 small">Untuk acara pengajian 17 Agustusan di
                                                        RT 05</p>
                                                </td>
                                                <td class="text-end pe-4" style="width: 280px;">
                                                    <div class="d-flex gap-2 justify-content-end">
                                                        <button class="btn btn-sm btn-outline-info"
                                                            onclick="showDetails(3, 'Penyewaan Sound System', 'Siti Aminah', 'Untuk acara pengajian 17 Agustusan di RT 05', 'Penyewaan Alat')">
                                                            <i class="bx bx-show me-1"></i>Detail
                                                        </button>
                                                        <button class="btn btn-sm btn-success"
                                                            onclick="acceptRequest(3, 'Siti Aminah', 'Sound System')">
                                                            <i class="bx bx-check me-1"></i>Terima
                                                        </button>
                                                        <button class="btn btn-sm btn-danger"
                                                            onclick="rejectRequest(3, 'Siti Aminah', 'Sound System')">
                                                            <i class="bx bx-x me-1"></i>Tolak
                                                        </button>
                                                    </div>
                                                </td>
                                            </tr>

                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <!-- Footer -->
                            <div class="card-footer bg-white text-center py-3 border-top">
                                <a href="#" class="text-primary fw-medium text-decoration-none">
                                    Lihat Semua Notifikasi
                                    <i class="bx bx-chevron-right"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>



                <!-- Custom CSS untuk Notifications -->
                <style>
                    .table-hover tbody tr:hover {
                        background-color: #f8f9fa;
                        transition: background-color 0.2s ease;
                    }

                    .notification-item {
                        border-left: 3px solid transparent;
                        transition: all 0.2s ease;
                    }

                    .notification-item:hover {
                        border-left-color: #696cff;
                    }

                    /* Force pill-shaped buttons with high specificity */
                    .notification-item .btn-sm,
                    .notification-item button.btn-sm,
                    .d-flex.gap-2 .btn-sm {
                        padding: 0.35rem 1rem !important;
                        font-size: 0.8rem !important;
                        font-weight: 600 !important;
                        border-radius: 50px !important;
                        line-height: 1.5 !important;
                        display: inline-flex !important;
                        align-items: center !important;
                        justify-content: center !important;
                        border-width: 1.5px !important;
                        transition: all 0.2s ease !important;
                        min-width: 80px !important;
                    }

                    .notification-item .btn-outline-info,
                    .notification-item button.btn-outline-info {
                        color: #00cfe8 !important;
                        border-color: #00cfe8 !important;
                        background: transparent !important;
                    }

                    .notification-item .btn-outline-info:hover,
                    .notification-item button.btn-outline-info:hover {
                        color: #fff !important;
                        background-color: #00cfe8 !important;
                        border-color: #00cfe8 !important;
                        transform: translateY(-1px);
                        box-shadow: 0 2px 8px rgba(0, 207, 232, 0.3);
                    }
                    
                    .notification-item .btn-success,
                    .notification-item button.btn-success {
                        background-color: #28c76f !important;
                        border-color: #28c76f !important;
                        color: #fff !important;
                    }

                    .notification-item .btn-success:hover,
                    .notification-item button.btn-success:hover {
                        background-color: #24b263 !important;
                        border-color: #24b263 !important;
                        transform: translateY(-1px);
                        box-shadow: 0 2px 8px rgba(40, 199, 111, 0.3);
                    }
                    
                    .notification-item .btn-danger,
                    .notification-item button.btn-danger {
                        background-color: #ea5455 !important;
                        border-color: #ea5455 !important;
                        color: #fff !important;
                    }

                    .notification-item .btn-danger:hover,
                    .notification-item button.btn-danger:hover {
                        background-color: #e63f40 !important;
                        border-color: #e63f40 !important;
                        transform: translateY(-1px);
                        box-shadow: 0 2px 8px rgba(234, 84, 85, 0.3);
                    }

                    .badge-center {
                        display: flex;
                        align-items: center;
                        justify-content: center;
                    }

                    .avatar img {
                        border: 2px solid #f0f0f0;
                    }

                    .card {
                        border: 1px solid #e5e5e5;
                    }

                    .table td {
                        vertical-align: middle;
                        border-bottom: 1px solid #f0f0f0;
                    }

                    .table tbody tr:last-child td {
                        border-bottom: none;
                    }
                </style>

                <script>
                    // Debug: Check if SweetAlert2 is loaded
                    console.log('SweetAlert2 loaded:', typeof Swal !== 'undefined');

                    // Toast Configuration
                    const Toast = Swal.mixin({
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 3000,
                        timerProgressBar: true,
                        didOpen: (toast) => {
                            toast.addEventListener('mouseenter', Swal.stopTimer)
                            toast.addEventListener('mouseleave', Swal.resumeTimer)
                        }
                    });

                    // Fungsi untuk menampilkan detail permintaan
                    function showDetails(id, item, user, description, type) {
                        console.log('showDetails called:', {id, item, user, description, type});
                        
                        if (typeof Swal === 'undefined') {
                            alert('SweetAlert2 belum dimuat. Silakan refresh halaman.');
                            return;
                        }

                        Swal.fire({
                            title: '<strong>Detail Permintaan</strong>',
                            html: `
                                <div class="text-start p-3">
                                    <div class="mb-4 text-center">
                                        <span class="badge bg-primary fs-6 px-4 py-2 rounded-pill">${type}</span>
                                    </div>
                                    <div class="mb-3 pb-3 border-bottom">
                                        <small class="text-muted d-block text-uppercase fw-bold mb-2" style="letter-spacing: 0.5px;">👤 Pengguna</small>
                                        <h5 class="mb-0 text-dark">${user}</h5>
                                    </div>
                                    <div class="mb-3 pb-3 border-bottom">
                                        <small class="text-muted d-block text-uppercase fw-bold mb-2" style="letter-spacing: 0.5px;">📦 Item</small>
                                        <h5 class="mb-0 text-dark">${item}</h5>
                                    </div>
                                    <div class="mb-0">
                                        <small class="text-muted d-block text-uppercase fw-bold mb-2" style="letter-spacing: 0.5px;">📝 Keterangan</small>
                                        <p class="mb-0 text-secondary" style="line-height: 1.6;">${description}</p>
                                    </div>
                                </div>
                            `,
                            icon: 'info',
                            iconColor: '#696cff',
                            showCloseButton: true,
                            showConfirmButton: false,
                            width: '600px',
                            padding: '2rem',
                            customClass: {
                                popup: 'rounded-4 shadow-lg',
                                title: 'text-primary mb-3',
                                htmlContainer: 'text-start'
                            },
                            showClass: {
                                popup: 'animate__animated animate__fadeInDown animate__faster'
                            },
                            hideClass: {
                                popup: 'animate__animated animate__fadeOutUp animate__faster'
                            }
                        });
                    }

                    // Fungsi untuk menerima permintaan
                    function acceptRequest(id, userName, itemName) {
                        console.log('acceptRequest called:', {id, userName, itemName});
                        
                        if (typeof Swal === 'undefined') {
                            alert('SweetAlert2 belum dimuat. Silakan refresh halaman.');
                            return;
                        }

                        Swal.fire({
                            title: '<strong>Terima Permintaan?</strong>',
                            html: `
                                <div class="p-3">
                                    <p class="mb-0 fs-5" style="line-height: 1.6;">
                                        Anda akan menerima permintaan dari<br>
                                        <strong class="text-success fs-4">${userName}</strong>
                                    </p>
                                </div>
                            `,
                            icon: 'question',
                            iconColor: '#28c76f',
                            showCancelButton: true,
                            confirmButtonText: '<i class="bx bx-check-circle me-2"></i> Ya, Terima',
                            cancelButtonText: '<i class="bx bx-x me-2"></i> Batal',
                            customClass: {
                                popup: 'rounded-4 shadow-lg',
                                title: 'text-success mb-3',
                                htmlContainer: 'mb-4',
                                confirmButton: 'btn btn-success btn-lg px-5 py-3 rounded-pill shadow-sm',
                                cancelButton: 'btn btn-secondary btn-lg px-5 py-3 rounded-pill shadow-sm'
                            },
                            buttonsStyling: false,
                            reverseButtons: true,
                            width: '550px',
                            padding: '2.5rem',
                            showClass: {
                                popup: 'animate__animated animate__zoomIn animate__faster'
                            },
                            hideClass: {
                                popup: 'animate__animated animate__zoomOut animate__faster'
                            }
                        }).then((result) => {
                            console.log('Accept modal result:', result);
                            
                            if (result.isConfirmed) {
                                // Proses penerimaan
                                const notificationElement = document.getElementById(`notification${id}`);
                                
                                if (!notificationElement) {
                                    console.error('Notification element not found:', `notification${id}`);
                                    return;
                                }
                                
                                const buttons = notificationElement.querySelectorAll('button');

                                // Disable semua tombol dan tampilkan loading
                                buttons.forEach(btn => {
                                    btn.disabled = true;
                                    btn.innerHTML = '<span class="spinner-border spinner-border-sm"></span>';
                                });

                                // Simulasi proses (ganti dengan AJAX ke server)
                                setTimeout(() => {
                                    // Tampilkan toast sukses
                                    Toast.fire({
                                        icon: 'success',
                                        title: 'Berhasil!',
                                        text: `Permintaan dari ${userName} telah diterima.`
                                    });

                                    // Animasi hapus notifikasi
                                    notificationElement.style.transition = 'all 0.3s ease';
                                    notificationElement.style.opacity = '0';
                                    notificationElement.style.transform = 'translateX(100%)';

                                    setTimeout(() => {
                                        notificationElement.remove();
                                        updateNotificationCount();
                                    }, 300);
                                }, 1000);
                            }
                        });
                    }

                    // Fungsi untuk menolak permintaan
                    function rejectRequest(id, userName, itemName) {
                        console.log('rejectRequest called:', {id, userName, itemName});
                        
                        if (typeof Swal === 'undefined') {
                            alert('SweetAlert2 belum dimuat. Silakan refresh halaman.');
                            return;
                        }

                        Swal.fire({
                            title: '<strong>Tolak Permintaan?</strong>',
                            html: `
                                <div class="p-3">
                                    <p class="mb-4 fs-5" style="line-height: 1.6;">
                                        Anda akan menolak permintaan dari<br>
                                        <strong class="text-danger fs-4">${userName}</strong>
                                    </p>
                                    <div class="text-start">
                                        <label class="form-label fw-bold mb-2">Alasan Penolakan (Opsional)</label>
                                        <textarea 
                                            class="form-control form-control-lg" 
                                            id="rejectReason" 
                                            rows="4" 
                                            placeholder="Masukkan alasan penolakan..."
                                            style="resize: none; border-radius: 12px; border: 2px solid #e0e0e0;"
                                        ></textarea>
                                    </div>
                                </div>
                            `,
                            icon: 'warning',
                            iconColor: '#ea5455',
                            showCancelButton: true,
                            confirmButtonText: '<i class="bx bx-x-circle me-2"></i> Ya, Tolak',
                            cancelButtonText: '<i class="bx bx-undo me-2"></i> Batal',
                            customClass: {
                                popup: 'rounded-4 shadow-lg',
                                title: 'text-danger mb-3',
                                htmlContainer: 'mb-4',
                                confirmButton: 'btn btn-danger btn-lg px-5 py-3 rounded-pill shadow-sm',
                                cancelButton: 'btn btn-secondary btn-lg px-5 py-3 rounded-pill shadow-sm'
                            },
                            buttonsStyling: false,
                            reverseButtons: true,
                            width: '600px',
                            padding: '2.5rem',
                            showClass: {
                                popup: 'animate__animated animate__shakeX animate__faster'
                            },
                            hideClass: {
                                popup: 'animate__animated animate__fadeOut animate__faster'
                            },
                            preConfirm: () => {
                                return document.getElementById('rejectReason').value;
                            }
                        }).then((result) => {
                            console.log('Reject modal result:', result);
                            
                            if (result.isConfirmed) {
                                const reason = result.value;
                                
                                // Proses penolakan
                                const notificationElement = document.getElementById(`notification${id}`);
                                
                                if (!notificationElement) {
                                    console.error('Notification element not found:', `notification${id}`);
                                    return;
                                }
                                
                                const buttons = notificationElement.querySelectorAll('button');

                                // Disable semua tombol dan tampilkan loading
                                buttons.forEach(btn => {
                                    btn.disabled = true;
                                    btn.innerHTML = '<span class="spinner-border spinner-border-sm"></span>';
                                });

                                // Simulasi proses (ganti dengan AJAX ke server)
                                setTimeout(() => {
                                    // Tampilkan toast sukses
                                    Toast.fire({
                                        icon: 'success',
                                        title: 'Berhasil!',
                                        text: `Permintaan dari ${userName} telah ditolak.`
                                    });

                                    // Animasi hapus notifikasi
                                    notificationElement.style.transition = 'all 0.3s ease';
                                    notificationElement.style.opacity = '0';
                                    notificationElement.style.transform = 'translateX(-100%)';

                                    setTimeout(() => {
                                        notificationElement.remove();
                                        updateNotificationCount();
                                    }, 300);
                                }, 1000);
                            }
                        });
                    }

                    // Fungsi untuk update notification count
                    function updateNotificationCount() {
                        const remainingNotifications = document.querySelectorAll('.notification-item').length;
                        const badge = document.querySelector('.badge.bg-primary.rounded-pill');

                        console.log('Updating notification count:', remainingNotifications);

                        if (badge) {
                            if (remainingNotifications > 0) {
                                badge.textContent = `${remainingNotifications} Baru`;
                            } else {
                                badge.textContent = '0 Baru';
                                badge.classList.remove('bg-primary');
                                badge.classList.add('bg-secondary');
                            }
                        }
                    }

                    // Debug: Log when script is loaded
                    console.log('Notification functions loaded successfully');
                </script>

                <!-- Add Animate.css for smooth animations -->
                <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>

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
                                    <div class="body">
                                        <div class="chart-wrapper">
                                            <div id="totalRevenueChart" class="px-2"></div>
                                        </div>
                                        <div class="text-center mt-3">
                                            <div class="dropdown">
                                                <button class="btn btn-sm btn-outline-primary dropdown-toggle"
                                                    type="button" id="growthReportId" data-bs-toggle="dropdown"
                                                    aria-haspopup="true" aria-expanded="false">
                                                    2025
                                                </button>
                                                <div class="dropdown-menu dropdown-menu-end"
                                                    aria-labelledby="growthReportId">
                                                    <a class="dropdown-item" href="javascript:void(0);">2024</a>
                                                    <a class="dropdown-item" href="javascript:void(0);">2023</a>
                                                    <a class="dropdown-item" href="javascript:void(0);">2022</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Middle Column: Grafik Transaksi -->
                            <div class="dashboard-stats-col">
                                <div class="card animate-fade-in">
                                    <div class="card-header">
                                        <h5 class="card-title mb-0">Perbandingan Transaksi</h5>
                                    </div>
                                    <div class="card-body d-flex flex-column justify-content-center align-items-center"
                                        style="min-height: 400px; padding: 2rem;">
                                        <h2 class="mb-2">500</h2>
                                        <span class="text-muted mb-4">Total Transaksi</span>
                                        <!-- Large donut chart will be rendered here by inline script -->
                                        <div id="transactionDonutChart" style="width: 100%; max-width: 300px;"></div>
                                    </div>
                                </div>
                            </div>

                            <!-- Right Column: Anggota Mitra Aktif & Total Transaksi -->
                            <div class="dashboard-stats-col">
                                <div class="card animate-fade-in">
                                    <div class="card-header">
                                        <h5 class="card-title mb-0">Transaksi dan Pendapatan</h5>
                                        <div class="card-body">
                                            <div class="tab-content p-0">
                                                <div class="tab-pane fade show active" id="navs-tabs-line-card-income"
                                                    role="tabpanel"></div>
                                                <div>
                                                    <small class="text-muted d-block">Pendapatan</small>
                                                    <div class="d-flex align-items-center">
                                                        <h6 class="mb-0 me-1">$459.10</h6>
                                                        <small class="text-success fw-semibold">
                                                            <i class="bx bx-chevron-up"></i>
                                                            42.9%
                                                        </small>
                                                    </div>
                                                </div>
                                            </div>
                                            <div id="incomeChart"></div>
                                            <div class="d-flex justify-content-center pt-4 gap-2">
                                                <div class="flex-shrink-0">
                                                    <div id="expensesOfWeek"></div>
                                                </div>
                                                <div>
                                                    <p class="mb-n1 mt-1">Minggu ini</p>
                                                    <small class="text-muted">Transaksi dan Pendapatan</small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="chart-wrapper">
                                        <div id="transactionChart" class="px-2"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                <!-- Popular Products -->
                <div class="row mb-4">
                    <div class="col-12">
                        <div class="card shadow-sm">
                            <div class="card-header bg-white py-3 border-bottom">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h5 class="mb-1 fw-semibold d-flex align-items-center">
                                            <span class="badge badge-center rounded-pill bg-label-warning me-2"
                                                style="width: 32px; height: 32px;">
                                                <i class="bx bx-star fs-5"></i>
                                            </span>
                                            Populer
                                        </h5>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body p-4">
                                <div class="row g-4">

                                    <!-- Product 1 - Gas LPG -->
                                    <div class="col-lg-3 col-md-6">
                                        <div class="card product-card h-100 border shadow-sm">
                                            <div class="card-body p-0">
                                                <!-- Product Image -->
                                                <div class="product-img-wrapper position-relative overflow-hidden"
                                                    style="height: 200px; background-color: #f5f5f5;">
                                                    <img src="{{ asset('Admin/img/icons/unicons/gas.png') }}"
                                                        alt="Gas LPG 3 Kg" class="product-image"
                                                        style="width: 100%; height: 100%; object-fit: contain; padding: 20px;">
                                                    <span class="badge bg-danger position-absolute top-0 end-0 m-3">
                                                        <i class="bx bx-trending-up me-1"></i>Hot
                                                    </span>
                                                </div>
                                                <!-- Product Info -->
                                                <div class="p-3">
                                                    <div class="mb-2">
                                                        <span class="badge bg-label-danger text-uppercase"
                                                            style="font-size: 0.7rem; font-weight: 600;">
                                                            Unit Penjualan Gas
                                                        </span>
                                                    </div>
                                                    <h6 class="mb-2 fw-semibold">Gas LPG 3 Kg</h6>
                                                    <div class="d-flex justify-content-between align-items-center">
                                                        <div>
                                                            <span class="text-primary fw-bold fs-6">Rp 20.000</span>
                                                            <small class="text-muted d-block">Per tabung</small>
                                                        </div>
                                                    </div>
                                                    <div class="mt-3 pt-3 border-top">
                                                        <div class="d-flex justify-content-between text-muted small">
                                                            <span><i class="bx bx-package me-1"></i>Stok: 50</span>
                                                            <span><i class="bx bx-shopping-bag me-1"></i>125 Terjual</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Product 2 - Sound System -->
                                    <div class="col-lg-3 col-md-6">
                                        <div class="card product-card h-100 border shadow-sm">
                                            <div class="card-body p-0">
                                                <!-- Product Image -->
                                                <div class="product-img-wrapper position-relative overflow-hidden"
                                                    style="height: 200px;">
                                                    <img src="{{ asset('Admin/img/icons/unicons/sound system.png') }}"
                                                        alt="Sound System" class="product-image"
                                                        style="width: 100%; height: 100%; object-fit: cover;">
                                                    <span class="badge bg-danger position-absolute top-0 end-0 m-3">
                                                        <i class="bx bx-trending-up me-1"></i>Hot
                                                    </span>
                                                </div>
                                                <!-- Product Info -->
                                                <div class="p-3">
                                                    <div class="mb-2">
                                                        <span class="badge bg-label-warning text-uppercase"
                                                            style="font-size: 0.7rem; font-weight: 600;">
                                                            Unit Penyewaan Alat
                                                        </span>
                                                    </div>
                                                    <h6 class="mb-2 fw-semibold">Sound System</h6>
                                                    <div class="d-flex justify-content-between align-items-center">
                                                        <div>
                                                            <span class="text-primary fw-bold fs-6">Rp 500.000</span>
                                                            <small class="text-muted d-block">Per hari</small>
                                                        </div>
                                                    </div>
                                                    <div class="mt-3 pt-3 border-top">
                                                        <div class="d-flex justify-content-between text-muted small">
                                                            <span><i class="bx bx-check-circle me-1"></i>Tersedia</span>
                                                            <span><i class="bx bx-time me-1"></i>98 Booking</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Product 3 - Tenda Komplit -->
                                    <div class="col-lg-3 col-md-6">
                                        <div class="card product-card h-100 border shadow-sm">
                                            <div class="card-body p-0">
                                                <!-- Product Image -->
                                                <div class="product-img-wrapper position-relative overflow-hidden"
                                                    style="height: 200px;">
                                                    <img src="{{ asset('Admin/img/icons/unicons/tendakom.jpg') }}"
                                                        alt="Tenda Komplit" class="product-image"
                                                        style="width: 100%; height: 100%; object-fit: cover;">
                                                    <span class="badge bg-danger position-absolute top-0 end-0 m-3">
                                                        <i class="bx bx-trending-up me-1"></i>Hot
                                                    </span>
                                                </div>
                                                <!-- Product Info -->
                                                <div class="p-3">
                                                    <div class="mb-2">
                                                        <span class="badge bg-label-warning text-uppercase"
                                                            style="font-size: 0.7rem; font-weight: 600;">
                                                            Unit Penyewaan Alat
                                                        </span>
                                                    </div>
                                                    <h6 class="mb-2 fw-semibold">Tenda Komplit</h6>
                                                    <div class="d-flex justify-content-between align-items-center">
                                                        <div>
                                                            <span class="text-primary fw-bold fs-6">Rp 2.500.000</span>
                                                            <small class="text-muted d-block">Per set</small>
                                                        </div>
                                                    </div>
                                                    <div class="mt-3 pt-3 border-top">
                                                        <div class="d-flex justify-content-between text-muted small">
                                                            <span><i class="bx bx-check-circle me-1"></i>Tersedia</span>
                                                            <span><i class="bx bx-time me-1"></i>87 Booking</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Product 4 - Meja dan Kursi -->
                                    <div class="col-lg-3 col-md-6">
                                        <div class="card product-card h-100 border shadow-sm">
                                            <div class="card-body p-0">
                                                <!-- Product Image -->
                                                <div class="product-img-wrapper position-relative overflow-hidden"
                                                    style="height: 200px;">
                                                    <img src="{{ asset('Admin/img/icons/unicons/tendakursi.jpg') }}"
                                                        alt="Meja dan Kursi" class="product-image"
                                                        style="width: 100%; height: 100%; object-fit: cover;">
                                                    <span class="badge bg-danger position-absolute top-0 end-0 m-3">
                                                        <i class="bx bx-trending-up me-1"></i>Hot
                                                    </span>
                                                </div>
                                                <!-- Product Info -->
                                                <div class="p-3">
                                                    <div class="mb-2">
                                                        <span class="badge bg-label-warning text-uppercase"
                                                            style="font-size: 0.7rem; font-weight: 600;">
                                                            Unit Penyewaan Alat
                                                        </span>
                                                    </div>
                                                    <h6 class="mb-2 fw-semibold">Meja dan Kursi</h6>
                                                    <div class="d-flex justify-content-between align-items-center">
                                                        <div>
                                                            <span class="text-primary fw-bold fs-6">Rp 10.000</span>
                                                            <small class="text-muted d-block">Per set</small>
                                                        </div>
                                                    </div>
                                                    <div class="mt-3 pt-3 border-top">
                                                        <div class="d-flex justify-content-between text-muted small">
                                                            <span><i class="bx bx-check-circle me-1"></i>Tersedia</span>
                                                            <span><i class="bx bx-time me-1"></i>156 Booking</span>
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
                </div>

                <!-- Custom CSS untuk Product Cards -->
                <style>
                    .product-card {
                        transition: all 0.3s ease;
                        border-radius: 0.5rem;
                        overflow: hidden;
                    }

                    .product-card:hover {
                        transform: translateY(-8px);
                        box-shadow: 0 0.5rem 1.5rem rgba(0, 0, 0, 0.15) !important;
                    }

                    .product-img-wrapper {
                        transition: all 0.3s ease;
                        border-radius: 0.5rem 0.5rem 0 0;
                    }

                    .product-card:hover .product-img-wrapper {
                        transform: scale(1.05);
                    }

                    .product-image {
                        transition: all 0.3s ease;
                    }

                    .badge-center {
                        display: flex;
                        align-items: center;
                        justify-content: center;
                    }

                    .badge.bg-danger {
                        background-color: #dc3545 !important;
                    }

                    /* Responsive adjustments */
                    @media (max-width: 991px) {
                        .product-img-wrapper {
                            height: 180px !important;
                        }
                    }

                    @media (max-width: 767px) {
                        .product-img-wrapper {
                            height: 220px !important;
                        }
                    }
                </style>

            <!-- Footer -->
            <footer class="content-footer footer bg-footer-theme">
                <div class="container-xxl d-flex flex-wrap justify-content-between py-2 flex-md-row flex-column">
                    <div class="mb-2 mb-md-0">
                        ©
                        <script>
                            document.write(new Date().getFullYear());
                        </script>
                        , made with by
                        <a href="https://themeselection.com" target="_blank" class="footer-link fw-bolder">iSewa Project
                            Team 😎</a>
                    </div>
                </div>
            </footer>
            <div class="content-backdrop fade"></div>

        <!-- SCRIPT LANGSUNG DI SINI -->
        <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
        <script>
            // Tunggu sampai halaman selesai load
            window.addEventListener('load', function() {
                console.log('Page loaded, initializing charts...');

                // Cek apakah element ada
                const chartElement = document.querySelector("#kinerjaChart");
                console.log('Chart element:', chartElement);

                if (!chartElement) {
                    console.error('Chart element not found!');
                    return;
                }

                // ========================================
                // GRAFIK KINERJA BUMDES (AREA CHART)
                // ========================================
                const kinerjaOptions = {
                    series: [{
                        name: 'Kinerja',
                        data: [25, 20.8, 17.6, 20.2, 19.8, 22.5]
                    }],
                    chart: {
                        type: 'area',
                        height: 300,
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
                        categories: ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni'],
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
                        min: 15,
                        max: 26,
                        tickAmount: 5,
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
                            right: 5,
                            bottom: 0,
                            left: 5
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

                try {
                    const kinerjaChart = new ApexCharts(chartElement, kinerjaOptions);
                    kinerjaChart.render();
                    console.log('Kinerja chart rendered successfully!');
                } catch (error) {
                    console.error('Error rendering kinerja chart:', error);
                }

                // Donut Chart untuk Transaksi (Large centered chart)
                const orderChartElement = document.querySelector("#transactionDonutChart");
                if (orderChartElement) {
                    var optionsOrder = {
                        series: [58, 82],
                        chart: {
                            type: "donut",
                            width: 300,
                            height: 300,
                        },
                        labels: ["Weekly", "Others"],
                        colors: ["#28C76F", "#00CFE8"],
                        legend: {
                            show: false
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
                                            show: true,
                                            fontSize: "16px",
                                            color: "#6e6b7b",
                                            offsetY: 20,
                                        },
                                        value: {
                                            show: true,
                                            fontSize: "30px",
                                            fontWeight: 600,
                                            color: "#5e5873",
                                            offsetY: -10,
                                            formatter: function() {
                                                return "38%";
                                            },
                                        },
                                        total: {
                                            show: true,
                                            label: "2025",
                                            fontSize: "16px",
                                            color: "#6e6b7b",
                                        },
                                    },
                                },
                            },
                        },
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
        </script>
    @endsection
