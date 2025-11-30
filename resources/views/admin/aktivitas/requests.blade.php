@extends('admin.layouts.admin')

@section('title', 'Permintaan Pengajuan')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    
    <!-- Header -->
    <div class="row mb-4">
        <div class="col-12">
            <h4 class="fw-bold py-3 mb-0">
                <span class="text-muted fw-light">Aktivitas /</span> Permintaan Pengajuan
            </h4>
            <p class="text-muted mb-0">Kelola permintaan penyewaan dan pembelian gas</p>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="row g-3 mb-4">
        <div class="col-md-3 col-sm-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="avatar avatar-md me-3">
                            <span class="avatar-initial rounded-circle bg-label-primary">
                                <i class="bx bx-list-ul fs-4"></i>
                            </span>
                        </div>
                        <div>
                            <p class="mb-0 text-muted small">Total Permintaan</p>
                            <h4 class="mb-0 fw-bold">{{ $stats['total'] }}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="avatar avatar-md me-3">
                            <span class="avatar-initial rounded-circle bg-label-warning">
                                <i class="bx bx-time fs-4"></i>
                            </span>
                        </div>
                        <div>
                            <p class="mb-0 text-muted small">Menunggu</p>
                            <h4 class="mb-0 fw-bold">{{ $stats['pending'] }}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="avatar avatar-md me-3">
                            <span class="avatar-initial rounded-circle bg-label-success">
                                <i class="bx bx-check-circle fs-4"></i>
                            </span>
                        </div>
                        <div>
                            <p class="mb-0 text-muted small">Disetujui</p>
                            <h4 class="mb-0 fw-bold">{{ $stats['approved'] }}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="avatar avatar-md me-3">
                            <span class="avatar-initial rounded-circle bg-label-danger">
                                <i class="bx bx-x-circle fs-4"></i>
                            </span>
                        </div>
                        <div>
                            <p class="mb-0 text-muted small">Ditolak</p>
                            <h4 class="mb-0 fw-bold">{{ $stats['rejected'] }}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters -->
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('admin.aktivitas.permintaan-pengajuan.index') }}" id="filterForm">
                <div class="row g-3 align-items-end">
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Kategori</label>
                        <select name="category" class="form-select" onchange="document.getElementById('filterForm').submit()">
                            <option value="all" {{ $category == 'all' ? 'selected' : '' }}>Semua Kategori</option>
                            <option value="rental" {{ $category == 'rental' ? 'selected' : '' }}>Penyewaan Alat ({{ $stats['rental_total'] }})</option>
                            <option value="gas" {{ $category == 'gas' ? 'selected' : '' }}>Pembelian Gas ({{ $stats['gas_total'] }})</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Status</label>
                        <select name="status" class="form-select" onchange="document.getElementById('filterForm').submit()">
                            <option value="all" {{ $status == 'all' ? 'selected' : '' }}>Semua Status</option>
                            <option value="pending" {{ $status == 'pending' ? 'selected' : '' }}>Menunggu</option>
                            <option value="approved" {{ $status == 'approved' ? 'selected' : '' }}>Disetujui</option>
                            <option value="rejected" {{ $status == 'rejected' ? 'selected' : '' }}>Ditolak</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        @if($category != 'all' || $status != 'all')
                            <a href="{{ route('admin.aktivitas.permintaan-pengajuan.index') }}" class="btn btn-outline-secondary w-100">
                                <i class="bx bx-reset me-1"></i> Reset Filter
                            </a>
                        @endif
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Requests List -->
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white border-bottom d-flex justify-content-between align-items-center py-3">
            <h5 class="mb-0 fw-bold">
                <i class="bx bx-list-check me-2"></i>
                Daftar Permintaan
                @if($category != 'all')
                    <span class="badge bg-label-primary ms-2">
                        {{ $category == 'rental' ? 'Penyewaan' : 'Gas' }}
                    </span>
                @endif
                @if($status != 'all')
                    <span class="badge bg-label-info ms-2">
                        {{ ucfirst($status) }}
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
                    <i class="bx bx-inbox fs-1 text-muted mb-3 d-block"></i>
                    <p class="text-muted">Tidak ada permintaan yang sesuai dengan filter</p>
                </div>
            @else
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th class="ps-4">Pengguna</th>
                                <th>Kategori</th>
                                <th>Detail Permintaan</th>
                                <th>Tanggal</th>
                                <th>Status</th>
                                <th class="text-center pe-4">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($rentalRequests as $request)
                                <tr>
                                    <td class="ps-4">
                                        <div class="d-flex align-items-center">
                                            <div class="avatar avatar-sm me-3">
                                                @if($request->user && $request->user->avatar)
                                                    <img src="{{ asset('storage/' . $request->user->avatar) }}" alt="Avatar" class="rounded-circle">
                                                @else
                                                    <span class="avatar-initial rounded-circle bg-label-primary">
                                                        {{ strtoupper(substr($request->user->name ?? 'U', 0, 1)) }}
                                                    </span>
                                                @endif
                                            </div>
                                            <div>
                                                <div class="fw-semibold">{{ $request->user->name ?? 'Unknown' }}</div>
                                                <small class="text-muted">{{ $request->user->email ?? '-' }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge bg-label-primary rounded-pill">
                                            <i class="bx bx-wrench me-1"></i> Penyewaan
                                        </span>
                                    </td>
                                    <td>
                                        <div class="fw-semibold">{{ $request->equipment_name ?? 'Alat' }}</div>
                                        <small class="text-muted">
                                            ID: #{{ $request->id }} | Durasi: {{ $request->duration ?? 1 }} Hari
                                        </small>
                                    </td>
                                    <td>
                                        <div>{{ $request->created_at->format('d M Y') }}</div>
                                        <small class="text-muted">{{ $request->created_at->format('H:i') }}</small>
                                    </td>
                                    <td>
                                        @if($request->status == 'approved')
                                            <span class="badge bg-success">
                                                <i class="bx bx-check-circle me-1"></i> Disetujui
                                            </span>
                                        @elseif($request->status == 'rejected')
                                            <span class="badge bg-danger">
                                                <i class="bx bx-x-circle me-1"></i> Ditolak
                                            </span>
                                        @else
                                            <span class="badge bg-warning">
                                                <i class="bx bx-time me-1"></i> Menunggu
                                            </span>
                                        @endif
                                    </td>
                                    <td class="text-center pe-4">
                                        <a href="{{ route('admin.aktivitas.permintaan-pengajuan.show', [$request->id, 'rental']) }}" 
                                           class="btn btn-sm btn-icon btn-outline-primary rounded-circle" 
                                           title="Detail">
                                            <i class="bx bx-show"></i>
                                        </a>
                                        @if($request->status == 'pending')
                                            <button type="button" class="btn btn-sm btn-icon btn-outline-success rounded-circle ms-1" 
                                                    onclick="approveRequest({{ $request->id }}, 'rental')" title="Setujui">
                                                <i class="bx bx-check"></i>
                                            </button>
                                            <button type="button" class="btn btn-sm btn-icon btn-outline-danger rounded-circle ms-1" 
                                                    onclick="rejectRequest({{ $request->id }}, 'rental')" title="Tolak">
                                                <i class="bx bx-x"></i>
                                            </button>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach

                            @foreach($gasOrders as $order)
                                <tr>
                                    <td class="ps-4">
                                        <div class="d-flex align-items-center">
                                            <div class="avatar avatar-sm me-3">
                                                @if($order->user && $order->user->avatar)
                                                    <img src="{{ asset('storage/' . $order->user->avatar) }}" alt="Avatar" class="rounded-circle">
                                                @else
                                                    <span class="avatar-initial rounded-circle bg-label-info">
                                                        {{ strtoupper(substr($order->user->name ?? 'U', 0, 1)) }}
                                                    </span>
                                                @endif
                                            </div>
                                            <div>
                                                <div class="fw-semibold">{{ $order->user->name ?? 'Unknown' }}</div>
                                                <small class="text-muted">{{ $order->user->email ?? '-' }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge bg-label-info rounded-pill">
                                            <i class="bx bxs-gas-pump me-1"></i> Gas
                                        </span>
                                    </td>
                                    <td>
                                        <div class="fw-semibold">Gas LPG {{ $order->gas_size ?? '3' }} Kg</div>
                                        <small class="text-muted">
                                            ID: #{{ $order->id }} | Jumlah: {{ $order->quantity ?? 1 }} Tabung
                                        </small>
                                    </td>
                                    <td>
                                        <div>{{ $order->created_at->format('d M Y') }}</div>
                                        <small class="text-muted">{{ $order->created_at->format('H:i') }}</small>
                                    </td>
                                    <td>
                                        @if($order->status == 'approved')
                                            <span class="badge bg-success">
                                                <i class="bx bx-check-circle me-1"></i> Disetujui
                                            </span>
                                        @elseif($order->status == 'rejected')
                                            <span class="badge bg-danger">
                                                <i class="bx bx-x-circle me-1"></i> Ditolak
                                            </span>
                                        @else
                                            <span class="badge bg-warning">
                                                <i class="bx bx-time me-1"></i> Menunggu
                                            </span>
                                        @endif
                                    </td>
                                    <td class="text-center pe-4">
                                        <a href="{{ route('admin.aktivitas.permintaan-pengajuan.show', [$order->id, 'gas']) }}" 
                                           class="btn btn-sm btn-icon btn-outline-primary rounded-circle" 
                                           title="Detail">
                                            <i class="bx bx-show"></i>
                                        </a>
                                        @if($order->status == 'pending')
                                            <button type="button" class="btn btn-sm btn-icon btn-outline-success rounded-circle ms-1" 
                                                    onclick="approveRequest({{ $order->id }}, 'gas')" title="Setujui">
                                                <i class="bx bx-check"></i>
                                            </button>
                                            <button type="button" class="btn btn-sm btn-icon btn-outline-danger rounded-circle ms-1" 
                                                    onclick="rejectRequest({{ $order->id }}, 'gas')" title="Tolak">
                                                <i class="bx bx-x"></i>
                                            </button>
                                        @endif
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
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tolak Permintaan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="rejectForm" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Alasan Penolakan <span class="text-danger">*</span></label>
                        <textarea name="reason" class="form-control" rows="4" placeholder="Jelaskan alasan penolakan permintaan..." required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-danger">
                        <i class="bx bx-x me-1"></i> Tolak Permintaan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function approveRequest(id, type) {
    Swal.fire({
        title: 'Setujui Permintaan?',
        text: 'Permintaan akan disetujui dan pengguna akan diberitahu',
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: 'Ya, Setujui',
        cancelButtonText: 'Batal',
        confirmButtonColor: '#28a745',
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
