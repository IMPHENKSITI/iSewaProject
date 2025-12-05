@extends('admin.layouts.admin')

@section('title', 'Detail Pengajuan')

@section('content')
<div class="container-fluid py-4">
    <style>
        @keyframes pulse {
            0%, 100% { opacity: 1; }
            50% { opacity: .5; }
        }
        .animate-pulse {
            animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
        }
    </style>
    <div class="row justify-content-center">
        <div class="col-12 col-lg-10">
            <!-- HEADER -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h2 class="text-primary fw-bold mb-1">Detail Pengajuan</h2>
                    <p class="text-muted">Kelola status dan informasi pesanan</p>
                </div>
                <a href="{{ route('admin.aktivitas.permintaan-pengajuan.index') }}" class="btn btn-outline-secondary rounded-pill px-4">
                    <i class="bx bx-arrow-back me-2"></i> Kembali
                </a>
            </div>

            <!-- ALERT CANCELLATION -->
            @if($request->cancellation_status === 'pending')
            <div class="alert alert-warning border-0 shadow-sm rounded-4 mb-4 d-flex align-items-center" role="alert">
                <i class="bx bx-error-circle fs-1 me-3"></i>
                <div class="flex-grow-1">
                    <h5 class="alert-heading fw-bold mb-1">Permintaan Pembatalan Diajukan</h5>
                    <p class="mb-0">User mengajukan pembatalan dengan alasan: <strong>"{{ $request->cancellation_reason ?? $request->cancellation_reason_user }}"</strong></p>
                </div>
                <div class="d-flex gap-2">
                    <button class="btn btn-danger" onclick="handleCancellation({{ $request->id }}, '{{ $type }}', 'approve')">
                        Setujui Pembatalan
                    </button>
                    <button class="btn btn-secondary" onclick="showCancellationRejectModal({{ $request->id }}, '{{ $type }}')">
                        Tolak Pembatalan
                    </button>
                </div>
            </div>
            @endif

            <div class="row g-4">
                <!-- LEFT COLUMN -->
                <div class="col-lg-8">
                    <!-- MAIN CARD -->
                    <div class="card shadow-sm border-0 rounded-4 mb-4">
                        <div class="card-header bg-white border-bottom py-3">
                            <div class="d-flex justify-content-between align-items-center">
                                <h5 class="mb-0 fw-bold text-dark">
                                    <i class="bx bx-package me-2 text-primary"></i>Informasi Pesanan
                                </h5>
                                <span class="badge bg-light text-dark border rounded-pill px-3">
                                    {{ $request->order_number }}
                                </span>
                            </div>
                        </div>
                        <div class="card-body p-4">
    <div class="d-flex align-items-start gap-4 mb-4">
                                @php
                                    $imgSrc = asset('admin/img/no-image.png');
                                    if($type === 'rental' && $request->barang && $request->barang->foto) {
                                        $imgSrc = asset('storage/' . $request->barang->foto);
                                    } elseif($type === 'gas' && $request->gas && $request->gas->foto) {
                                        $imgSrc = asset('storage/' . $request->gas->foto);
                                    }
                                @endphp
                                <img src="{{ $imgSrc }}" alt="Product" class="rounded-3 object-fit-cover shadow-sm" style="width: 100px; height: 100px;">
                                <div>
                                    <h4 class="fw-bold mb-1">{{ $type === 'rental' ? ($request->barang->nama_barang ?? 'Alat') : ($request->item_name ?? 'Gas') }}</h4>
                                    <p class="text-muted mb-2">{{ $type === 'rental' ? 'Penyewaan Alat' : 'Pembelian Gas' }}</p>
                                    <h5 class="text-primary fw-bold">Rp {{ number_format($request->total_amount ?? $request->price, 0, ',', '.') }}</h5>
                                </div>
                            </div>

                            <div class="row g-4">
                                <div class="col-md-6">
                                    <p class="text-muted mb-1 text-uppercase small ls-1">Tanggal Pemesanan</p>
                                    <p class="fw-semibold">{{ $request->created_at->isoFormat('D MMMM Y, HH:mm') }} WIB</p>
                                </div>
                                <div class="col-md-6">
                                    <p class="text-muted mb-1 text-uppercase small ls-1">Jumlah</p>
                                    <p class="fw-semibold">{{ $request->quantity }} Unit</p>
                                </div>
                                <div class="col-md-6">
                                    <p class="text-muted mb-1 text-uppercase small ls-1">Metode Pembayaran</p>
                                    <p class="fw-semibold">
                                        @if($request->payment_method == 'tunai')
                                            <span class="badge bg-success-subtle text-success">Tunai</span>
                                        @else
                                            <span class="badge bg-info-subtle text-info">Transfer Bank</span>
                                        @endif
                                    </p>
                                </div>
                                <div class="col-md-6">
                                    <p class="text-muted mb-1 text-uppercase small ls-1">Metode Pengiriman</p>
                                    <p class="fw-semibold">
                                        @if($request->delivery_method == 'antar')
                                            <span class="badge bg-primary-subtle text-primary">Diantar</span>
                                        @else
                                            <span class="badge bg-warning-subtle text-warning">Jemput Sendiri</span>
                                        @endif
                                    </p>
                                </div>
                            </div>

                            <hr class="my-4 border-light">

                            @if($type === 'rental')
                            <h6 class="fw-bold mb-3">Jadwal Sewa</h6>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <div class="p-3 bg-light rounded-3 border">
                                        <small class="text-muted d-block mb-1">Mulai</small>
                                        <span class="fw-bold text-dark">{{ \Carbon\Carbon::parse($request->start_date)->isoFormat('D MMMM Y') }}</span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="p-3 bg-light rounded-3 border">
                                        <small class="text-muted d-block mb-1">Selesai</small>
                                        <span class="fw-bold text-dark">{{ \Carbon\Carbon::parse($request->end_date)->isoFormat('D MMMM Y') }}</span>
                                    </div>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>

                    <!-- PROOF OF PAYMENT -->
                    @if($request->proof_of_payment || $request->payment_proof)
                    <div class="card shadow-sm border-0 rounded-4">
                        <div class="card-header bg-white border-bottom py-3">
                            <h5 class="mb-0 fw-bold text-dark">
                                <i class="bx bx-receipt me-2 text-primary"></i>Bukti Pembayaran
                            </h5>
                        </div>
                        <div class="card-body p-4 text-center">
                            @php
                                $proof = $request->proof_of_payment ?? $request->payment_proof;
                            @endphp
                            <img src="{{ asset('storage/' . $proof) }}" alt="Bukti Pembayaran" class="img-fluid rounded mb-3 shadow-sm" style="max-height: 400px;">
                            <div>
                                <a href="{{ asset('storage/' . $proof) }}" download class="btn btn-outline-primary rounded-pill">
                                    <i class="bx bx-download me-2"></i>Unduh Bukti
                                </a>
                            </div>
                        </div>
                    </div>
                    @endif

                    <!-- DELIVERY STATUS WORKFLOW (RENTAL ONLY) -->
                    @if($type === 'rental' && in_array($request->status, ['confirmed', 'being_prepared', 'in_delivery', 'arrived', 'completed']))
                    <div class="card shadow-sm border-0 rounded-4 mb-4">
                        <div class="card-header bg-white border-bottom py-3">
                            <h5 class="mb-0 fw-bold text-dark"><i class="bx bx-map-alt me-2 text-primary"></i>Status Pengiriman</h5>
                        </div>
                        <div class="card-body p-4">
                            <div class="d-flex flex-column gap-0">
                                <!-- Step 1: Confirmed -->
                                <div class="d-flex gap-3">
                                    <div class="d-flex flex-column align-items-center">
                                        <div class="rounded-circle bg-success text-white d-flex align-items-center justify-content-center shadow-sm" style="width: 40px; height: 40px; z-index: 2;">
                                            <i class="bx bx-check fs-4"></i>
                                        </div>
                                        <div class="h-100 border-start border-2 border-primary-subtle" style="min-height: 40px; margin-top: -5px; margin-bottom: -5px;"></div>
                                    </div>
                                    <div class="flex-grow-1 pb-4">
                                        <div class="card border-0 bg-success-subtle bg-opacity-10 shadow-sm rounded-3">
                                            <div class="card-body p-3 d-flex justify-content-between align-items-center">
                                                <div>
                                                    <h6 class="fw-bold text-success mb-1">Pesanan Dikonfirmasi</h6>
                                                    <small class="text-muted">
                                                        <i class="bx bx-time me-1"></i>{{ $request->confirmed_at ? \Carbon\Carbon::parse($request->confirmed_at)->format('d M Y H:i') : '-' }}
                                                    </small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Step 2: Being Prepared -->
                                <div class="d-flex gap-3">
                                    <div class="d-flex flex-column align-items-center">
                                        <div class="rounded-circle {{ in_array($request->status, ['being_prepared', 'in_delivery', 'arrived', 'completed']) ? 'bg-success text-white' : ($request->status == 'confirmed' ? 'bg-primary text-white animate-pulse' : 'bg-white border text-secondary') }} d-flex align-items-center justify-content-center shadow-sm" style="width: 40px; height: 40px; z-index: 2;">
                                            <i class="bx bx-package fs-4"></i>
                                        </div>
                                        <div class="h-100 border-start border-2 border-primary-subtle" style="min-height: 40px; margin-top: -5px; margin-bottom: -5px;"></div>
                                    </div>
                                    <div class="flex-grow-1 pb-4">
                                        <div class="card border-0 {{ in_array($request->status, ['being_prepared', 'in_delivery', 'arrived', 'completed']) ? 'bg-success-subtle bg-opacity-10' : ($request->status == 'confirmed' ? 'bg-white border border-primary border-2 shadow-sm' : 'bg-light') }} rounded-3">
                                            <div class="card-body p-3 d-flex justify-content-between align-items-center flex-wrap gap-3">
                                                <div>
                                                    <h6 class="fw-bold {{ in_array($request->status, ['being_prepared', 'in_delivery', 'arrived', 'completed']) ? 'text-success' : 'text-dark' }} mb-1">Sedang Dipersiapkan</h6>
                                                    <small class="text-muted">Tim sedang menyiapkan barang pesanan</small>
                                                </div>
                                                @if($request->status == 'confirmed')
                                                    <button class="btn btn-primary rounded-pill px-4" onclick="updateStatus('being_prepared')">
                                                        <i class="bx bx-check me-2"></i>Update Status
                                                    </button>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Step 3: In Delivery -->
                                <div class="d-flex gap-3">
                                    <div class="d-flex flex-column align-items-center">
                                        <div class="rounded-circle {{ in_array($request->status, ['in_delivery', 'arrived', 'completed']) ? 'bg-success text-white' : ($request->status == 'being_prepared' ? 'bg-primary text-white animate-pulse' : 'bg-white border text-secondary') }} d-flex align-items-center justify-content-center shadow-sm" style="width: 40px; height: 40px; z-index: 2;">
                                            <i class="bx bx-car fs-4"></i>
                                        </div>
                                        <div class="h-100 border-start border-2 border-primary-subtle" style="min-height: 40px; margin-top: -5px; margin-bottom: -5px;"></div>
                                    </div>
                                    <div class="flex-grow-1 pb-4">
                                        <div class="card border-0 {{ in_array($request->status, ['in_delivery', 'arrived', 'completed']) ? 'bg-success-subtle bg-opacity-10' : ($request->status == 'being_prepared' ? 'bg-white border border-primary border-2 shadow-sm' : 'bg-light') }} rounded-3">
                                            <div class="card-body p-3 d-flex justify-content-between align-items-center flex-wrap gap-3">
                                                <div>
                                                    <h6 class="fw-bold {{ in_array($request->status, ['in_delivery', 'arrived', 'completed']) ? 'text-success' : 'text-dark' }} mb-1">Dalam Pengiriman</h6>
                                                    @if($request->delivery_time)
                                                        <small class="text-muted"><i class="bx bx-time me-1"></i>{{ \Carbon\Carbon::parse($request->delivery_time)->format('d M Y H:i') }}</small>
                                                    @endif
                                                </div>
                                                @if($request->status == 'being_prepared')
                                                    <button class="btn btn-primary rounded-pill px-4" onclick="updateStatus('in_delivery')">
                                                        <i class="bx bx-navigation me-2"></i>Mulai Pengiriman
                                                    </button>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Step 4: Arrived -->
                                <div class="d-flex gap-3">
                                    <div class="d-flex flex-column align-items-center">
                                        <div class="rounded-circle {{ in_array($request->status, ['arrived', 'completed']) ? 'bg-success text-white' : ($request->status == 'in_delivery' ? 'bg-primary text-white animate-pulse' : 'bg-white border text-secondary') }} d-flex align-items-center justify-content-center shadow-sm" style="width: 40px; height: 40px; z-index: 2;">
                                            <i class="bx bx-map-pin fs-4"></i>
                                        </div>
                                        <div class="h-100 border-start border-2 border-primary-subtle" style="min-height: 40px; margin-top: -5px; margin-bottom: -5px;"></div>
                                    </div>
                                    <div class="flex-grow-1 pb-4">
                                        <div class="card border-0 {{ in_array($request->status, ['arrived', 'completed']) ? 'bg-success-subtle bg-opacity-10' : ($request->status == 'in_delivery' ? 'bg-white border border-primary border-2 shadow-sm' : 'bg-light') }} rounded-3">
                                            <div class="card-body p-3 d-flex justify-content-between align-items-center flex-wrap gap-3">
                                                <div>
                                                    <h6 class="fw-bold {{ in_array($request->status, ['arrived', 'completed']) ? 'text-success' : 'text-dark' }} mb-1">Tiba di Lokasi</h6>
                                                    @if($request->arrival_time)
                                                        <small class="text-muted"><i class="bx bx-time me-1"></i>{{ \Carbon\Carbon::parse($request->arrival_time)->format('d M Y H:i') }}</small>
                                                    @endif
                                                    @if($request->delivery_proof_image)
                                                        <div class="mt-2">
                                                            <a href="{{ asset('storage/' . $request->delivery_proof_image) }}" target="_blank" class="badge bg-primary-subtle text-primary border border-primary-subtle p-2 text-decoration-none">
                                                                <i class="bx bx-image me-1"></i>Lihat Bukti
                                                            </a>
                                                        </div>
                                                    @endif
                                                </div>
                                                @if($request->status == 'in_delivery')
                                                    <button class="btn btn-primary rounded-pill px-4" data-bs-toggle="modal" data-bs-target="#uploadProofModal">
                                                        <i class="bx bx-camera me-2"></i>Pesanan Tiba
                                                    </button>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Step 5: Completed -->
                                <div class="d-flex gap-3">
                                    <div class="d-flex flex-column align-items-center">
                                        <div class="rounded-circle {{ $request->status == 'completed' ? 'bg-success text-white' : ($request->status == 'arrived' ? 'bg-primary text-white animate-pulse' : 'bg-white border text-secondary') }} d-flex align-items-center justify-content-center shadow-sm" style="width: 40px; height: 40px; z-index: 2;">
                                            <i class="bx bx-check-double fs-4"></i>
                                        </div>
                                    </div>
                                    <div class="flex-grow-1">
                                        <div class="card border-0 {{ $request->status == 'completed' ? 'bg-success-subtle bg-opacity-10' : ($request->status == 'arrived' ? 'bg-white border border-primary border-2 shadow-sm' : 'bg-light') }} rounded-3">
                                            <div class="card-body p-3 d-flex justify-content-between align-items-center flex-wrap gap-3">
                                                <div>
                                                    <h6 class="fw-bold {{ $request->status == 'completed' ? 'text-success' : 'text-dark' }} mb-1">Pesanan Selesai</h6>
                                                    @if($request->completion_time)
                                                        <small class="text-muted"><i class="bx bx-time me-1"></i>{{ \Carbon\Carbon::parse($request->completion_time)->format('d M Y H:i') }}</small>
                                                    @endif
                                                </div>
                                                @if($request->status == 'arrived')
                                                    <button class="btn btn-success rounded-pill px-4" onclick="updateStatus('completed')">
                                                        <i class="bx bx-trophy me-2"></i>Selesaikan
                                                    </button>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                    @endif
                </div>

                <!-- RIGHT COLUMN -->
                <div class="col-lg-4">
                    <!-- STATUS CARD -->
                    <div class="card shadow-sm border-0 rounded-4 mb-4">
                        <div class="card-header bg-white border-bottom py-3">
                            <h5 class="mb-0 fw-bold text-dark">Status Pesanan</h5>
                        </div>
                        <div class="card-body p-4">
                            @php
                                $statusLabels = [
                                    'pending' => ['Menunggu', 'bg-warning'],
                                    'approved' => ['Disetujui', 'bg-success'],
                                    'rejected' => ['Ditolak', 'bg-danger'],
                                    'cancelled' => ['Dibatalkan', 'bg-dark'],
                                    'confirmed' => ['Dikonfirmasi', 'bg-info'],
                                    'being_prepared' => ['Sedang Dipersiapkan', 'bg-info'],
                                    'in_delivery' => ['Dalam Pengiriman', 'bg-primary'],
                                    'arrived' => ['Tiba di Lokasi', 'bg-primary'],
                                    'completed' => ['Selesai', 'bg-success'],
                                ];
                                $currentStatus = $statusLabels[$request->status] ?? [$request->status, 'bg-secondary'];
                            @endphp
                            <div class="text-center mb-4">
                                <span class="badge {{ $currentStatus[1] }} fs-6 px-4 py-2 rounded-pill">
                                    {{ $currentStatus[0] }}
                                </span>
                            </div>

                            @if($request->status === 'pending')
                                <div class="d-grid gap-2">
                                    <button class="btn btn-success rounded-pill py-2" onclick="confirmApprove({{ $request->id }}, '{{ $type }}')">
                                        <i class="bx bx-check me-2"></i>Setujui Pengajuan
                                    </button>
                                    <button class="btn btn-outline-danger rounded-pill py-2" onclick="showRejectModal({{ $request->id }}, '{{ $type }}')">
                                        <i class="bx bx-x me-2"></i>Tolak Pengajuan
                                    </button>
                                </div>
                            @elseif($type === 'gas' && in_array($request->status, ['confirmed', 'approved', 'processed']))
                                <div class="d-grid gap-2">
                                    <button class="btn btn-success rounded-pill py-2" onclick="updateStatus('completed')">
                                        <i class="bx bx-check-double me-2"></i>Selesaikan Pesanan
                                    </button>
                                </div>
                            @elseif($request->status === 'rejected')
                                <div class="alert alert-danger mb-0">
                                    <small class="fw-bold d-block mb-1">Alasan Penolakan:</small>
                                    {{ $request->rejection_reason }}
                                </div>
                            @elseif($request->status === 'cancelled')
                                <div class="alert alert-secondary mb-0">
                                    <small class="fw-bold d-block mb-1">Dibatalkan karena:</small>
                                    {{ $request->cancellation_reason ?? $request->cancellation_reason_user }}
                                </div>
                            @endif
                        </div>
                    </div>



                    <!-- CUSTOMER INFO CARD -->
                    <div class="card shadow-sm border-0 rounded-4">
                        <div class="card-header bg-white border-bottom py-3">
                            <h5 class="mb-0 fw-bold text-dark">Data Pemesan</h5>
                        </div>
                        <div class="card-body p-4">
                            <div class="d-flex align-items-center mb-4">
                                <div class="bg-primary-subtle text-primary rounded-circle p-3 me-3">
                                    <i class="bx bx-user fs-4"></i>
                                </div>
                                <div>
                                    <h6 class="fw-bold mb-0">{{ $request->full_name ?? $request->user->name }}</h6>
                                    <small class="text-muted">Pelanggan</small>
                                </div>
                            </div>
                            
                            <div class="mb-3">
                                <small class="text-muted d-block uppercase ls-1 mb-1">Email</small>
                                <span class="fw-medium text-dark">{{ $request->email ?? $request->user->email }}</span>
                            </div>
                            
                            <div class="mb-3">
                                <small class="text-muted d-block uppercase ls-1 mb-1">Alamat</small>
                                <p class="fw-medium text-dark mb-0">{{ $request->address ?? $request->delivery_address }}</p>
                            </div>

                            @if($request->notes)
                            <div class="mt-4 p-3 bg-light rounded-3 border border-warning-subtle">
                                <small class="text-warning-emphasis fw-bold d-block mb-1">
                                    <i class="bx bx-note me-1"></i>Catatan
                                </small>
                                <p class="mb-0 text-dark small">{{ $request->notes }}</p>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Reject Modal -->
<div class="modal fade" id="rejectModal" tabindex="-1" aria-labelledby="rejectModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4 border-0">
            <div class="modal-header border-bottom-0 pb-0">
                <h5 class="modal-title fw-bold" id="rejectModalLabel">Tolak Permintaan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="rejectForm" method="POST">
                @csrf
                <div class="modal-body">
                    <input type="hidden" name="id" id="rejectId">
                    <input type="hidden" name="type" id="rejectType">
                    <div class="mb-3">
                        <label for="reason" class="form-label text-muted">Berikan alasan penolakan</label>
                        <textarea name="reason" id="reason" class="form-control bg-light border-0 py-3" rows="4" placeholder="Contoh: Stok barang habis atau pembayaran tidak valid..." required></textarea>
                    </div>
                </div>
                <div class="modal-footer border-top-0 pt-0">
                    <button type="button" class="btn btn-link text-secondary text-decoration-none" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-danger rounded-pill px-4">Tolak Permintaan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Cancellation Reject Modal -->
<div class="modal fade" id="cancellationRejectModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4 border-0">
            <div class="modal-header border-bottom-0 pb-0">
                <h5 class="modal-title fw-bold">Tolak Pembatalan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="cancelRejectId">
                <input type="hidden" id="cancelRejectType">
                <div class="mb-3">
                    <label class="form-label text-muted">Mengapa Anda menolak pembatalan ini?</label>
                    <textarea id="cancelRejectReason" class="form-control bg-light border-0 py-3" rows="4" placeholder="Berikan alasan kepada user..." required></textarea>
                </div>
            </div>
            <div class="modal-footer border-top-0 pt-0">
                <button type="button" class="btn btn-link text-secondary text-decoration-none" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-danger rounded-pill px-4" onclick="submitCancellationReject()">Kirim Penolakan</button>
            </div>
        </div>
    </div>
</div>

<!-- Upload Proof Modal -->
<div class="modal fade" id="uploadProofModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4 border-0">
            <div class="modal-header border-bottom-0 pb-0">
                <h5 class="modal-title fw-bold">Upload Bukti Pengiriman</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="uploadProofForm" enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label text-muted">Foto Bukti Penerimaan Barang</label>
                        <input type="file" name="delivery_proof" class="form-control" accept="image/*" required>
                        <div class="form-text">Upload foto saat barang diterima oleh pelanggan</div>
                    </div>
                </div>
                <div class="modal-footer border-top-0 pt-0">
                    <button type="button" class="btn btn-link text-secondary text-decoration-none" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary rounded-pill px-4">Upload & Update Status</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
function confirmApprove(id, type) {
    Swal.fire({
        title: 'Setujui Pesanan?',
        text: "Pesanan akan diproses ke tahap selanjutnya",
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#198754',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Ya, Setujui',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = `{{ route('admin.aktivitas.permintaan-pengajuan.approve', ['id' => ':id', 'type' => ':type']) }}`.replace(':id', id).replace(':type', type);
            const csrfToken = document.createElement('input');
            csrfToken.type = 'hidden';
            csrfToken.name = '_token';
            csrfToken.value = '{{ csrf_token() }}';
            form.appendChild(csrfToken);
            document.body.appendChild(form);
            form.submit();
        }
    });
}

function showRejectModal(id, type) {
    document.getElementById('rejectId').value = id;
    document.getElementById('rejectType').value = type;
    const modal = new bootstrap.Modal(document.getElementById('rejectModal'));
    modal.show();
}

document.getElementById('rejectForm').addEventListener('submit', function(e) {
    e.preventDefault();
    const formData = new FormData(this);
    const url = `{{ route('admin.aktivitas.permintaan-pengajuan.reject', ['id' => ':id', 'type' => ':type']) }}`
        .replace(':id', formData.get('id'))
        .replace(':type', formData.get('type'));

    fetch(url, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({
            reason: formData.get('reason')
        })
    })
    .then(response => response.json())
    .then(data => {
        location.reload();
    })
    .catch(error => {
        Swal.fire('Error', 'Terjadi kesalahan sistem', 'error');
    });
});

// Cancellation Logic
function handleCancellation(id, type, action) {
    const title = action === 'approve' ? 'Setujui Pembatalan?' : 'Tolak Pembatalan?';
    const text = action === 'approve' ? 'Pesanan akan dibatalkan permanen.' : 'Pesanan akan tetap dilanjutkan.';
    
    Swal.fire({
        title: title,
        text: text,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: action === 'approve' ? '#dc3545' : '#6c757d',
        confirmButtonText: 'Ya, Lanjutkan',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            submitCancellation(id, type, action);
        }
    });
}

function showCancellationRejectModal(id, type) {
    document.getElementById('cancelRejectId').value = id;
    document.getElementById('cancelRejectType').value = type;
    new bootstrap.Modal(document.getElementById('cancellationRejectModal')).show();
}

function submitCancellationReject() {
    const id = document.getElementById('cancelRejectId').value;
    const type = document.getElementById('cancelRejectType').value;
    const reason = document.getElementById('cancelRejectReason').value;

    if (!reason) {
        Swal.fire('Error', 'Mohon isi alasan penolakan', 'error');
        return;
    }

    submitCancellation(id, type, 'reject', reason);
}

function submitCancellation(id, type, action, reason = null) {
    const url = `{{ url('admin/aktivitas/permintaan-pengajuan') }}/${type}/${id}/cancellation/${action}`;

    fetch(url, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ admin_response: reason })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            Swal.fire({
                title: 'Berhasil',
                text: data.message,
                icon: 'success',
                timer: 1500,
                showConfirmButton: false
            }).then(() => location.reload());
        } else {
            Swal.fire('Gagal', data.message, 'error');
        }
    })
    .catch(err => Swal.fire('Error', 'Terjadi kesalahan sistem', 'error'));
}

function updateStatus(newStatus) {
    const url = `{{ route('admin.aktivitas.update-status', ['type' => $type, 'id' => $request->id]) }}`;
    
    Swal.fire({
        title: 'Update Status?',
        text: 'Anda yakin ingin mengubah status pesanan?',
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#0d6efd',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Ya, Update'
    }).then((result) => {
        if (result.isConfirmed) {
            fetch(url, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ status: newStatus })
            })
            .then(response => response.json())
            .then(data => {
                if(data.success) {
                    Swal.fire('Berhasil', 'Status berhasil diperbarui', 'success')
                    .then(() => location.reload());
                } else {
                    Swal.fire('Error', data.message || 'Gagal update status', 'error');
                }
            })
            .catch(err => {
                Swal.fire('Error', 'Terjadi kesalahan sistem', 'error');
            });
        }
    });
}

document.getElementById('uploadProofForm').addEventListener('submit', function(e) {
    e.preventDefault();
    const formData = new FormData(this);
    const url = `{{ route('admin.aktivitas.delivery-proof', ['type' => $type, 'id' => $request->id]) }}`;
    
    // Show loading
    Swal.fire({
        title: 'Mengupload...',
        didOpen: () => {
             Swal.showLoading();
        }
    });

    fetch(url, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if(data.success) {
            Swal.fire('Berhasil', data.message, 'success')
            .then(() => location.reload());
        } else {
            Swal.fire('Error', data.message || 'Gagal upload bukti', 'error');
        }
    })
    .catch(err => {
        Swal.fire('Error', 'Terjadi kesalahan sistem', 'error');
    });
});
</script>
@endsection
