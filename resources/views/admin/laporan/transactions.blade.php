@extends('admin.layouts.admin')

@section('title', 'Laporan Transaksi')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    
    <!-- Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h4 class="fw-bold py-3 mb-0">
                        <span class="text-muted fw-light">Laporan /</span> Transaksi
                    </h4>
                    <p class="text-muted mb-0">Daftar lengkap transaksi penyewaan alat dan pembelian gas.</p>
                </div>
                <div class="d-flex gap-2">
                    <button class="btn btn-outline-secondary">
                        <i class="bx bx-filter-alt me-1"></i> Filter
                    </button>
                    <button class="btn btn-primary" onclick="window.print()">
                        <i class="bx bx-printer me-1"></i> Cetak Laporan
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Summary Cards (Optional/Static for now) -->
    <div class="row g-4 mb-4">
        <div class="col-md-6">
            <div class="card h-100 border-0 shadow-sm hover-lift">
                <div class="card-body d-flex align-items-center">
                    <div class="avatar avatar-lg me-3">
                        <span class="avatar-initial rounded-circle bg-label-primary">
                            <i class='bx bx-receipt fs-3'></i>
                        </span>
                    </div>
                    <div>
                        <h5 class="mb-0 fw-bold">{{ $rentalRequests->count() + $gasOrders->count() }}</h5>
                        <small class="text-muted">Total Transaksi</small>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card h-100 border-0 shadow-sm hover-lift">
                <div class="card-body d-flex align-items-center">
                    <div class="avatar avatar-lg me-3">
                        <span class="avatar-initial rounded-circle bg-label-success">
                            <i class='bx bx-check-circle fs-3'></i>
                        </span>
                    </div>
                    <div>
                        <h5 class="mb-0 fw-bold">{{ $rentalRequests->where('status', 'completed')->count() + $gasOrders->where('status', 'completed')->count() }}</h5>
                        <small class="text-muted">Transaksi Selesai</small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- RENTAL REQUESTS -->
    <div class="card shadow-sm border-0 mb-4">
        <div class="card-header bg-white border-bottom d-flex justify-content-between align-items-center">
            <h5 class="mb-0 fw-bold">
                <i class="bx bx-wrench text-warning me-2"></i>Penyewaan Alat
            </h5>
            <span class="badge bg-label-primary rounded-pill">{{ $rentalRequests->count() }} Data</span>
        </div>
        <div class="card-body p-0">
            @if($rentalRequests->isEmpty())
                <div class="text-center py-5">
                    <img src="{{ asset('Admin/img/illustrations/empty.png') }}" alt="No Data" width="150" class="mb-3 opacity-50">
                    <p class="text-muted">Tidak ada transaksi penyewaan alat.</p>
                </div>
            @else
                <div class="table-responsive text-nowrap">
                    <table class="table table-hover table-striped">
                        <thead class="table-light">
                            <tr>
                                <th>No. Pesanan</th>
                                <th>Nama Pemesan</th>
                                <th>Item</th>
                                <th>Jumlah</th>
                                <th>Total</th>
                                <th>Status</th>
                                <th>Tanggal</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="table-border-bottom-0">
                            @foreach($rentalRequests as $req)
                                <tr>
                                    <td><span class="fw-semibold">#{{ $req->order_number }}</span></td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="avatar avatar-xs me-2">
                                                <span class="avatar-initial rounded-circle bg-label-secondary">{{ substr($req->full_name, 0, 1) }}</span>
                                            </div>
                                            {{ $req->full_name }}
                                        </div>
                                    </td>
                                    <td>{{ $req->item_name }}</td>
                                    <td>{{ $req->quantity }}</td>
                                    <td class="fw-bold text-primary">Rp {{ number_format($req->price, 0, ',', '.') }}</td>
                                    <td>
                                        @if($req->status == 'pending')
                                            <span class="badge bg-label-warning">Pending</span>
                                        @elseif($req->status == 'approved')
                                            <span class="badge bg-label-success">Disetujui</span>
                                        @elseif($req->status == 'rejected')
                                            <span class="badge bg-label-danger">Ditolak</span>
                                        @elseif($req->status == 'completed')
                                            <span class="badge bg-label-info">Selesai</span>
                                        @else
                                            <span class="badge bg-label-secondary">{{ ucfirst($req->status) }}</span>
                                        @endif
                                    </td>
                                    <td><small class="text-muted">{{ $req->created_at->format('d M Y H:i') }}</small></td>
                                    <td class="text-center">
                                        <div class="dropdown">
                                            <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                                <i class="bx bx-dots-vertical-rounded"></i>
                                            </button>
                                            <div class="dropdown-menu">
                                                <a class="dropdown-item" href="{{ route('admin.aktivitas.permintaan-pengajuan.show', ['id' => $req->id, 'type' => 'rental']) }}">
                                                    <i class="bx bx-show-alt me-1"></i> Detail
                                                </a>
                                                @if($req->status == 'pending')
                                                <a class="dropdown-item text-success" href="javascript:void(0);" onclick="confirmApprove({{ $req->id }}, 'rental')">
                                                    <i class="bx bx-check me-1"></i> Setujui
                                                </a>
                                                <a class="dropdown-item text-danger" href="javascript:void(0);" onclick="showRejectModal({{ json_encode($req->id) }}, 'rental')">
                                                    <i class="bx bx-x me-1"></i> Tolak
                                                </a>
                                                @endif
                                            </div>
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

    <!-- GAS ORDERS -->
    <div class="card shadow-sm border-0">
        <div class="card-header bg-white border-bottom d-flex justify-content-between align-items-center">
            <h5 class="mb-0 fw-bold">
                <i class="bx bx-cylinder text-info me-2"></i>Pembelian Gas
            </h5>
            <span class="badge bg-label-primary rounded-pill">{{ $gasOrders->count() }} Data</span>
        </div>
        <div class="card-body p-0">
            @if($gasOrders->isEmpty())
                <div class="text-center py-5">
                    <img src="{{ asset('Admin/img/illustrations/empty.png') }}" alt="No Data" width="150" class="mb-3 opacity-50">
                    <p class="text-muted">Tidak ada transaksi pembelian gas.</p>
                </div>
            @else
                <div class="table-responsive text-nowrap">
                    <table class="table table-hover table-striped">
                        <thead class="table-light">
                            <tr>
                                <th>No. Pesanan</th>
                                <th>Nama Pemesan</th>
                                <th>Item</th>
                                <th>Jumlah</th>
                                <th>Total</th>
                                <th>Status</th>
                                <th>Tanggal</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="table-border-bottom-0">
                            @foreach($gasOrders as $order)
                                <tr>
                                    <td><span class="fw-semibold">#{{ $order->order_number }}</span></td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="avatar avatar-xs me-2">
                                                <span class="avatar-initial rounded-circle bg-label-secondary">{{ substr($order->full_name, 0, 1) }}</span>
                                            </div>
                                            {{ $order->full_name }}
                                        </div>
                                    </td>
                                    <td>{{ $order->item_name }}</td>
                                    <td>{{ $order->quantity }}</td>
                                    <td class="fw-bold text-info">Rp {{ number_format($order->price, 0, ',', '.') }}</td>
                                    <td>
                                        @if($order->status == 'pending')
                                            <span class="badge bg-label-warning">Pending</span>
                                        @elseif($order->status == 'approved')
                                            <span class="badge bg-label-success">Disetujui</span>
                                        @elseif($order->status == 'rejected')
                                            <span class="badge bg-label-danger">Ditolak</span>
                                        @elseif($order->status == 'completed')
                                            <span class="badge bg-label-info">Selesai</span>
                                        @else
                                            <span class="badge bg-label-secondary">{{ ucfirst($order->status) }}</span>
                                        @endif
                                    </td>
                                    <td><small class="text-muted">{{ $order->created_at->format('d M Y H:i') }}</small></td>
                                    <td class="text-center">
                                        <div class="dropdown">
                                            <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                                <i class="bx bx-dots-vertical-rounded"></i>
                                            </button>
                                            <div class="dropdown-menu">
                                                <a class="dropdown-item" href="{{ route('admin.aktivitas.permintaan-pengajuan.show', ['id' => $order->id, 'type' => 'gas']) }}">
                                                    <i class="bx bx-show-alt me-1"></i> Detail
                                                </a>
                                                @if($order->status == 'pending')
                                                <a class="dropdown-item text-success" href="javascript:void(0);" onclick="confirmApprove({{ json_encode($order->id) }}, 'gas')">
                                                    <i class="bx bx-check me-1"></i> Setujui
                                                </a>
                                                <a class="dropdown-item text-danger" href="javascript:void(0);" onclick="showRejectModal({{ json_encode($order->id) }}, 'gas')">
                                                    <i class="bx bx-x me-1"></i> Tolak
                                                </a>
                                                @endif
                                            </div>
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
<div class="modal fade" id="rejectModal" tabindex="-1" aria-labelledby="rejectModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-bold" id="rejectModalLabel">Tolak Permintaan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="rejectForm" method="POST">
                @csrf
                <div class="modal-body">
                    <input type="hidden" name="id" id="rejectId">
                    <input type="hidden" name="type" id="rejectType">
                    <div class="mb-3">
                        <label for="reason" class="form-label fw-semibold">Alasan Penolakan</label>
                        <textarea name="reason" id="reason" class="form-control" rows="4" placeholder="Jelaskan alasan penolakan..." required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-danger">Tolak Permintaan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    .hover-lift {
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }
    .hover-lift:hover {
        transform: translateY(-5px);
        box-shadow: 0 .5rem 1rem rgba(0,0,0,.15)!important;
    }
</style>

@endsection

@section('scripts')
<script>
function confirmApprove(id, type) {
    Swal.fire({
        title: 'Konfirmasi Persetujuan',
        text: `Yakin ingin menyetujui permintaan ${type} ini?`,
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#71dd37',
        cancelButtonColor: '#8592a3',
        confirmButtonText: 'Ya, Setujui',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = `{{ route('admin.aktivitas.permintaan-pengajuan.approve', ['id' => ':id', 'type' => ':type']) }}`.replace(':id', id).replace(':type', type);
        }
    });
}

function showRejectModal(id, type) {
    document.getElementById('rejectId').value = id;
    document.getElementById('rejectType').value = type;
    const modal = new bootstrap.Modal(document.getElementById('rejectModal'));
    modal.show();
}

// Handle form submit
document.getElementById('rejectForm').addEventListener('submit', function(e) {
    e.preventDefault();
    const formData = new FormData(this);
    const url = `{{ route('admin.aktivitas.permintaan-pengajuan.reject', ['id' => ':id', 'type' => ':type']) }}`
        .replace(':id', formData.get('id'))
        .replace(':type', formData.get('type'));

    fetch(url, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({
            reason: formData.get('reason')
        })
    })
    .then(response => response.json())
    .then(data => {
        // Close modal
        const modalEl = document.getElementById('rejectModal');
        const modal = bootstrap.Modal.getInstance(modalEl);
        modal.hide();
        
        Swal.fire({
            icon: 'success',
            title: 'Berhasil',
            text: data.message || 'Permintaan berhasil ditolak.',
            timer: 1500,
            showConfirmButton: false
        }).then(() => {
            location.reload();
        });
    })
    .catch(error => {
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'Terjadi kesalahan saat memproses permintaan.'
        });
    });
});
</script>
@endsection