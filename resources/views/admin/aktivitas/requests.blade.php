@extends('admin.layouts.admin')

@section('title', 'Permintaan Pengajuan')

@section('content')
<div class="container-fluid py-4">
    
    <!-- Header -->
    <div class="row mb-4">
        <div class="col-12">
            <h4 class="fw-bold fs-3 mb-1 text-primary">
                Permintaan Pengajuan
            </h4>
            <p class="text-muted mb-0">Kelola permintaan penyewaan dan pembelian gas</p>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="row g-3 mb-4">
        <div class="col-md-3 col-sm-6">
            <div class="card border-0 shadow-sm h-100 rounded-4">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="avatar avatar-md me-3 bg-primary-subtle text-primary rounded-3 p-2">
                            <i class="bx bx-list-ul fs-3"></i>
                        </div>
                        <div>
                            <p class="mb-0 text-muted small text-uppercase fw-semibold">Total</p>
                            <h4 class="mb-0 fw-bold text-dark">{{ $stats['total'] }}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6">
            <div class="card border-0 shadow-sm h-100 rounded-4">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="avatar avatar-md me-3 bg-warning-subtle text-warning rounded-3 p-2">
                            <i class="bx bx-time fs-3"></i>
                        </div>
                        <div>
                            <p class="mb-0 text-muted small text-uppercase fw-semibold">Menunggu</p>
                            <h4 class="mb-0 fw-bold text-dark">{{ $stats['pending'] }}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6">
            <div class="card border-0 shadow-sm h-100 rounded-4">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="avatar avatar-md me-3 bg-success-subtle text-success rounded-3 p-2">
                            <i class="bx bx-check-circle fs-3"></i>
                        </div>
                        <div>
                            <p class="mb-0 text-muted small text-uppercase fw-semibold">Disetujui</p>
                            <h4 class="mb-0 fw-bold text-dark">{{ $stats['approved'] }}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6">
            <div class="card border-0 shadow-sm h-100 rounded-4">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="avatar avatar-md me-3 bg-danger-subtle text-danger rounded-3 p-2">
                            <i class="bx bx-x-circle fs-3"></i>
                        </div>
                        <div>
                            <p class="mb-0 text-muted small text-uppercase fw-semibold">Ditolak</p>
                            <h4 class="mb-0 fw-bold text-dark">{{ $stats['rejected'] }}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6">
            <div class="card border-0 shadow-sm h-100 rounded-4">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="avatar avatar-md me-3 bg-warning-subtle text-warning rounded-3 p-2">
                            <i class="bx bx-error fs-3"></i>
                        </div>
                        <div>
                            <p class="mb-0 text-muted small text-uppercase fw-semibold">Minta Batal</p>
                            <h4 class="mb-0 fw-bold text-dark">{{ $stats['cancellation_pending'] }}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters -->
    <div class="card border-0 shadow-sm mb-4 rounded-4">
        <div class="card-body p-4">
            <form method="GET" action="{{ route('admin.aktivitas.permintaan-pengajuan.index') }}" id="filterForm">
                <div class="row g-3 align-items-end">
                    <div class="col-md-4">
                        <label class="form-label fw-semibold text-muted small text-uppercase">Kategori</label>
                        <select name="category" class="form-select border-0 bg-light py-2" onchange="document.getElementById('filterForm').submit()">
                            <option value="all" {{ $category == 'all' ? 'selected' : '' }}>Semua Kategori</option>
                            <option value="latest" {{ $category == 'latest' ? 'selected' : '' }}>Terbaru (7 Hari)</option>
                            <option value="rental" {{ $category == 'rental' ? 'selected' : '' }}>Penyewaan Alat ({{ $stats['rental_total'] }})</option>
                            <option value="gas" {{ $category == 'gas' ? 'selected' : '' }}>Pembelian Gas ({{ $stats['gas_total'] }})</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-semibold text-muted small text-uppercase">Status</label>
                        <select name="status" class="form-select border-0 bg-light py-2" onchange="document.getElementById('filterForm').submit()">
                            <option value="all" {{ $status == 'all' ? 'selected' : '' }}>Semua Status</option>
                            <option value="pending" {{ $status == 'pending' ? 'selected' : '' }}>Menunggu</option>
                            <option value="in_process" {{ $status == 'in_process' ? 'selected' : '' }}>Dalam Proses</option>
                            <option value="completed" {{ $status == 'completed' ? 'selected' : '' }}>Selesai</option>
                            <option value="cancellation_pending" {{ $status == 'cancellation_pending' ? 'selected' : '' }}>Permintaan Pembatalan</option>
                            <option value="approved" {{ $status == 'approved' ? 'selected' : '' }}>Disetujui</option>
                            <option value="rejected" {{ $status == 'rejected' ? 'selected' : '' }}>Ditolak</option>
                            <option value="cancelled" {{ $status == 'cancelled' ? 'selected' : '' }}>Dibatalkan</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        @if($category != 'all' || $status != 'all')
                            <a href="{{ route('admin.aktivitas.permintaan-pengajuan.index') }}" class="btn btn-outline-secondary w-100 py-2 border-dashed">
                                <i class="bx bx-reset me-1"></i> Reset Filter
                            </a>
                        @endif
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Requests List -->
    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        <div class="card-header bg-white border-bottom py-3 px-4 d-flex justify-content-between align-items-center">
            <h5 class="mb-0 fw-bold">
                Daftar Permintaan
                @if($category != 'all')
                    <span class="badge bg-primary-subtle text-primary ms-2 fs-6 fw-normal">
                        @if($category == 'rental') Penyewaan
                        @elseif($category == 'gas') Gas
                        @elseif($category == 'latest') Terbaru
                        @endif
                    </span>
                @endif
                @if($status != 'all')
                    <span class="badge bg-info-subtle text-info ms-2 fs-6 fw-normal">
                        @if($status == 'pending') Menunggu
                        @elseif($status == 'approved') Disetujui
                        @elseif($status == 'rejected') Ditolak
                        @elseif($status == 'cancelled') Dibatalkan
                        @else {{ ucfirst($status) }}
                        @endif
                    </span>
                @endif
            </h5>
            <div class="text-muted small">
                Total: <strong>{{ $rentalRequests->count() + $gasOrders->count() }}</strong> permintaan
            </div>
        </div>
        <div class="card-body p-0">
            @if($rentalRequests->isEmpty() && $gasOrders->isEmpty())
                <div class="text-center py-5">
                    <div class="mb-3">
                        <i class="bx bx-inbox fs-1 text-muted opacity-50"></i>
                    </div>
                    <p class="text-muted mb-0">Tidak ada permintaan yang ditemukan</p>
                </div>
            @else
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th class="ps-4 py-3 text-secondary text-uppercase small fw-bold">Pengguna</th>
                                <th class="py-3 text-secondary text-uppercase small fw-bold">Kategori</th>
                                <th class="py-3 text-secondary text-uppercase small fw-bold">Detail</th>
                                <th class="py-3 text-secondary text-uppercase small fw-bold">Tanggal</th>
                                <th class="py-3 text-secondary text-uppercase small fw-bold">Status</th>
                                <th class="pe-4 py-3 text-center text-secondary text-uppercase small fw-bold">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="border-top-0">
                            @foreach($rentalRequests as $request)
                                <tr>
                                    <td class="ps-4 py-3">
                                        <div class="d-flex align-items-center">
                                            <div class="avatar avatar-sm me-3 border rounded-circle p-1">
                                                @if($request->user && $request->user->avatar)
                                                    <img src="{{ asset('storage/' . $request->user->avatar) }}" alt="Avatar" class="rounded-circle object-fit-cover w-100 h-100">
                                                @else
                                                    <span class="avatar-initial rounded-circle bg-primary-subtle text-primary fw-bold">
                                                        {{ strtoupper(substr($request->user->name ?? 'U', 0, 1)) }}
                                                    </span>
                                                @endif
                                            </div>
                                            <div>
                                                <div class="fw-semibold text-dark">{{ $request->user->name ?? 'Unknown' }}</div>
                                                <small class="text-muted" style="font-size: 0.75rem;">{{ $request->user->email ?? '-' }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge bg-primary-subtle text-primary rounded-pill px-3">
                                            <i class="bx bx-wrench me-1"></i> Penyewaan
                                        </span>
                                    </td>
                                    <td>
                                        <div class="fw-semibold text-dark">{{ $request->barang->nama_barang ?? 'Alat' }}</div>
                                        <small class="text-muted">
                                            <span class="me-2">ID: #{{ $request->order_number ?? $request->id }}</span>
                                            <span>• {{ $request->days_count ?? 1 }} Hari</span>
                                        </small>
                                    </td>
                                    <td>
                                        <div class="fw-medium text-dark">{{ $request->created_at->isoFormat('D MMM Y') }}</div>
                                        <small class="text-muted">{{ $request->created_at->format('H:i') }} WIB</small>
                                    </td>
                                    <td>
                                        @if($request->status == 'approved' || $request->status == 'confirmed')
                                            <span class="badge bg-success-subtle text-success border border-success-subtle px-3 py-2 rounded-pill">
                                                <i class="bx bx-check-circle me-1"></i> Disetujui
                                            </span>
                                        @elseif($request->status == 'being_prepared')
                                            <span class="badge bg-info-subtle text-info border border-info-subtle px-3 py-2 rounded-pill">
                                                <i class="bx bx-package me-1"></i> Dipersiapkan
                                            </span>
                                        @elseif($request->status == 'in_delivery')
                                            <span class="badge bg-info-subtle text-info border border-info-subtle px-3 py-2 rounded-pill">
                                                <i class="bx bx-car me-1"></i> Diantar
                                            </span>
                                        @elseif($request->status == 'arrived')
                                            <span class="badge bg-primary-subtle text-primary border border-primary-subtle px-3 py-2 rounded-pill">
                                                <i class="bx bx-map-pin me-1"></i> Tiba
                                            </span>
                                        @elseif($request->status == 'completed' || $request->status == 'resolved' || $request->status == 'returned')
                                            <span class="badge bg-success-subtle text-success border border-success-subtle px-3 py-2 rounded-pill">
                                                <i class="bx bx-check-double me-1"></i> Selesai
                                            </span>
                                        @elseif($request->status == 'rejected')
                                            <span class="badge bg-danger-subtle text-danger border border-danger-subtle px-3 py-2 rounded-pill">
                                                <i class="bx bx-x-circle me-1"></i> Ditolak
                                            </span>
                                        @elseif($request->status == 'cancelled')
                                            <span class="badge bg-dark-subtle text-dark border border-dark-subtle px-3 py-2 rounded-pill">
                                                <i class="bx bx-x me-1"></i> Dibatalkan
                                            </span>
                                        @elseif($request->cancellation_status == 'pending')
                                            <span class="badge bg-warning-subtle text-warning border border-warning-subtle px-3 py-2 rounded-pill animate-pulse">
                                                <i class="bx bx-error me-1"></i> Minta Batal
                                            </span>
                                        @else
                                            <span class="badge bg-warning-subtle text-warning border border-warning-subtle px-3 py-2 rounded-pill">
                                                <i class="bx bx-time me-1"></i> Menunggu
                                            </span>
                                        @endif
                                    </td>
                                    <td class="text-center pe-4">
                                        <div class="d-flex justify-content-center gap-1">
                                            <a href="{{ route('admin.aktivitas.permintaan-pengajuan.show', [$request->id, 'rental']) }}" 
                                               class="btn btn-sm btn-icon btn-light text-primary rounded-circle border shadow-sm hover-primary" 
                                               title="Lihat Detail">
                                                <i class="bx bx-show fs-5"></i>
                                            </a>
                                            @if($request->status == 'pending')
                                                <button type="button" class="btn btn-sm btn-icon btn-light text-success rounded-circle border shadow-sm hover-success" 
                                                        onclick="approveRequest({{ $request->id }}, 'rental')" title="Setujui">
                                                    <i class="bx bx-check fs-5"></i>
                                                </button>
                                                <button type="button" class="btn btn-sm btn-icon btn-light text-danger rounded-circle border shadow-sm hover-danger" 
                                                        onclick="rejectRequest({{ $request->id }}, 'rental')" title="Tolak">
                                                    <i class="bx bx-x fs-5"></i>
                                                </button>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @endforeach

                            @foreach($gasOrders as $order)
                                <tr>
                                    <td class="ps-4 py-3">
                                        <div class="d-flex align-items-center">
                                            <div class="avatar avatar-sm me-3 border rounded-circle p-1">
                                                @if($order->user && $order->user->avatar)
                                                    <img src="{{ asset('storage/' . $order->user->avatar) }}" alt="Avatar" class="rounded-circle object-fit-cover w-100 h-100">
                                                @else
                                                    <span class="avatar-initial rounded-circle bg-info-subtle text-info fw-bold">
                                                        {{ strtoupper(substr($order->user->name ?? 'U', 0, 1)) }}
                                                    </span>
                                                @endif
                                            </div>
                                            <div>
                                                <div class="fw-semibold text-dark">{{ $order->user->name ?? 'Unknown' }}</div>
                                                <small class="text-muted" style="font-size: 0.75rem;">{{ $order->user->email ?? '-' }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge bg-info-subtle text-info rounded-pill px-3">
                                            <i class="bx bxs-gas-pump me-1"></i> Gas
                                        </span>
                                    </td>
                                    <td>
                                        <div class="fw-semibold text-dark">{{ $order->item_name ?? 'Gas LPG' }}</div>
                                        <small class="text-muted">
                                            <span class="me-2">ID: #{{ $order->order_number ?? $order->id }}</span>
                                            <span>• {{ $order->quantity ?? 1 }} Tabung</span>
                                        </small>
                                    </td>
                                    <td>
                                        <div class="fw-medium text-dark">{{ $order->created_at->isoFormat('D MMM Y') }}</div>
                                        <small class="text-muted">{{ $order->created_at->format('H:i') }} WIB</small>
                                    </td>
                                    <td>
                                        @if($order->status == 'approved')
                                            <span class="badge bg-success-subtle text-success border border-success-subtle px-3 py-2 rounded-pill">
                                                <i class="bx bx-check-circle me-1"></i> Disetujui
                                            </span>
                                        @elseif($order->status == 'rejected')
                                            <span class="badge bg-danger-subtle text-danger border border-danger-subtle px-3 py-2 rounded-pill">
                                                <i class="bx bx-x-circle me-1"></i> Ditolak
                                            </span>
                                        @elseif($order->status == 'cancelled')
                                            <span class="badge bg-dark-subtle text-dark border border-dark-subtle px-3 py-2 rounded-pill">
                                                <i class="bx bx-x me-1"></i> Dibatalkan
                                            </span>
                                        @elseif($order->cancellation_status == 'pending')
                                            <span class="badge bg-warning-subtle text-warning border border-warning-subtle px-3 py-2 rounded-pill animate-pulse">
                                                <i class="bx bx-error me-1"></i> Minta Batal
                                            </span>
                                        @else
                                            <span class="badge bg-warning-subtle text-warning border border-warning-subtle px-3 py-2 rounded-pill">
                                                <i class="bx bx-time me-1"></i> Menunggu
                                            </span>
                                        @endif
                                    </td>
                                    <td class="text-center pe-4">
                                        <div class="d-flex justify-content-center gap-1">
                                            <a href="{{ route('admin.aktivitas.permintaan-pengajuan.show', [$order->id, 'gas']) }}" 
                                               class="btn btn-sm btn-icon btn-light text-primary rounded-circle border shadow-sm hover-primary" 
                                               title="Lihat Detail">
                                                <i class="bx bx-show fs-5"></i>
                                            </a>
                                            @if($order->status == 'pending')
                                                <button type="button" class="btn btn-sm btn-icon btn-light text-success rounded-circle border shadow-sm hover-success" 
                                                        onclick="approveRequest({{ $order->id }}, 'gas')" title="Setujui">
                                                    <i class="bx bx-check fs-5"></i>
                                                </button>
                                                <button type="button" class="btn btn-sm btn-icon btn-light text-danger rounded-circle border shadow-sm hover-danger" 
                                                        onclick="rejectRequest({{ $order->id }}, 'gas')" title="Tolak">
                                                    <i class="bx bx-x fs-5"></i>
                                                </button>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Reject Modal -->
<div class="modal fade" id="rejectModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4 border-0">
            <div class="modal-header border-bottom-0 pb-0">
                <h5 class="modal-title fw-bold">Tolak Permintaan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="rejectForm" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label text-muted">Alasan Penolakan <span class="text-danger">*</span></label>
                        <textarea name="reason" class="form-control bg-light border-0 py-3" rows="4" placeholder="Jelaskan alasan penolakan permintaan..." required></textarea>
                    </div>
                </div>
                <div class="modal-footer border-top-0 pt-0">
                    <button type="button" class="btn btn-link text-secondary text-decoration-none" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-danger rounded-pill px-4">
                        Tolak Permintaan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    .hover-primary:hover { background-color: #0d6efd !important; color: white !important; border-color: #0d6efd !important; }
    .hover-success:hover { background-color: #198754 !important; color: white !important; border-color: #198754 !important; }
    .hover-danger:hover { background-color: #dc3545 !important; color: white !important; border-color: #dc3545 !important; }
    
    @keyframes pulse-warning {
        0% { box-shadow: 0 0 0 0 rgba(255, 193, 7, 0.4); }
        70% { box-shadow: 0 0 0 6px rgba(255, 193, 7, 0); }
        100% { box-shadow: 0 0 0 0 rgba(255, 193, 7, 0); }
    }
    .animate-pulse {
        animation: pulse-warning 2s infinite;
    }
</style>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
function approveRequest(id, type) {
    Swal.fire({
        title: 'Setujui Permintaan?',
        text: 'Permintaan akan disetujui dan pengguna akan diberitahu',
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: 'Ya, Setujui',
        cancelButtonText: 'Batal',
        confirmButtonColor: '#198754',
        cancelButtonColor: '#6c757d'
    }).then((result) => {
        if (result.isConfirmed) {
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = `{{ url('admin/aktivitas/permintaan-pengajuan') }}/${id}/${type}/approve`;
            
            const csrf = document.createElement('input');
            csrf.type = 'hidden';
            csrf.name = '_token';
            csrf.value = '{{ csrf_token() }}';
            form.appendChild(csrf);
            
            document.body.appendChild(form);
            form.submit();
        }
    });
}

function rejectRequest(id, type) {
    const modal = new bootstrap.Modal(document.getElementById('rejectModal'));
    const form = document.getElementById('rejectForm');
    form.action = `{{ url('admin/aktivitas/permintaan-pengajuan') }}/${id}/${type}/reject`;
    modal.show();
}
</script>
@endsection
