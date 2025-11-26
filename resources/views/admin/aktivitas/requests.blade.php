@extends('admin.layouts.admin')

@section('title', 'Permintaan & Pengajuan')

@section('content')
<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-12 col-lg-10">
            <!-- HEADER -->
            <h2 class="text-primary fw-bold mb-4">Notifikasi Permintaan</h2>
            <p class="text-muted mb-4">Permintaan aktivitas dari pengguna</p>

            <!-- RENTAL REQUESTS -->
            <div class="card shadow-sm border-0 rounded-4 mb-4">
                <div class="card-header bg-white border-bottom">
                    <h5 class="mb-0">Penyewaan Alat</h5>
                </div>
                <div class="card-body p-3">
                    @if($rentalRequests->isEmpty())
                        <p class="text-center text-muted">Tidak ada permintaan penyewaan alat.</p>
                    @else
                        <div class="list-group list-group-flush">
                            @foreach($rentalRequests as $req)
                                <div class="list-group-item d-flex align-items-center p-2 notification-item" id="notification{{ $req->id }}">
                                    <div class="avatar flex-shrink-0 me-2">
                                        <span class="avatar-initial rounded bg-label-secondary">P</span>
                                    </div>
                                    <div class="flex-grow-1">
                                        <div class="mb-2">
                                            <span class="badge bg-warning me-2">Penyewaan Alat</span>
                                            <small class="text-muted">{{ $req->created_at->diffForHumans() }}</small>
                                        </div>
                                        <h6 class="mb-1">{{ $req->full_name }} mengajukan penyewaan {{ $req->item_name }}</h6>
                                        <p class="text-muted mb-0 small">Untuk acara tanggal {{ $req->start_date }} - {{ $req->end_date }}</p>
                                    </div>
                                    <div class="d-flex gap-2 ms-3">
                                        <a href="{{ route('admin.aktivitas.permintaan-pengajuan.show', ['id' => $req->id, 'type' => 'rental']) }}" class="btn btn-sm btn-outline-primary">
                                            <i class="bx bx-show"></i> Detail
                                        </a>
                                        <button class="btn btn-sm btn-success" onclick="confirmApprove({{ $req->id }}, 'rental')">
                                            <i class="bx bx-check"></i> Terima
                                        </button>
                                        <button class="btn btn-sm btn-danger" onclick="showRejectModal({{ $req->id }}, 'rental')">
                                            <i class="bx bx-x"></i> Tolak
                                        </button>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>

            <!-- GAS ORDERS -->
            <div class="card shadow-sm border-0 rounded-4">
                <div class="card-header bg-white border-bottom">
                    <h5 class="mb-0">Pembelian Gas</h5>
                </div>
                <div class="card-body p-3">
                    @if($gasOrders->isEmpty())
                        <p class="text-center text-muted">Tidak ada permintaan pembelian gas.</p>
                    @else
                        <div class="list-group list-group-flush">
                            @foreach($gasOrders as $order)
                                <div class="list-group-item d-flex align-items-center p-2 notification-item" id="notification{{ $order->id }}">
                                    <div class="avatar flex-shrink-0 me-2">
                                        <span class="avatar-initial rounded bg-label-secondary">G</span>
                                    </div>
                                    <div class="flex-grow-1">
                                        <div class="mb-2">
                                            <span class="badge bg-info me-2">Pembelian Gas</span>
                                            <small class="text-muted">{{ $order->created_at->diffForHumans() }}</small>
                                        </div>
                                        <h6 class="mb-1">{{ $order->full_name }} mengajukan pembelian {{ $order->item_name }}</h6>
                                        <p class="text-muted mb-0 small">Jumlah: {{ $order->quantity }} unit</p>
                                    </div>
                                    <div class="d-flex gap-2 ms-3">
                                        <a href="{{ route('admin.aktivitas.permintaan-pengajuan.show', ['id' => $order->id, 'type' => 'gas']) }}" class="btn btn-sm btn-outline-primary">
                                            <i class="bx bx-show"></i> Detail
                                        </a>
                                        <button class="btn btn-sm btn-success" onclick="confirmApprove({{ $order->id }}, 'gas')">
                                            <i class="bx bx-check"></i> Terima
                                        </button>
                                        <button class="btn btn-sm btn-danger" onclick="showRejectModal({{ $order->id }}, 'gas')">
                                            <i class="bx bx-x"></i> Tolak
                                        </button>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Reject Modal -->
<div class="modal fade" id="rejectModal" tabindex="-1" aria-labelledby="rejectModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="rejectModalLabel">Tolak Permintaan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="rejectForm" method="POST">
                @csrf
                <div class="modal-body">
                    <input type="hidden" name="id" id="rejectId">
                    <input type="hidden" name="type" id="rejectType">
                    <div class="mb-3">
                        <label for="reason" class="form-label">Alasan Penolakan</label>
                        <textarea name="reason" id="reason" class="form-control" rows="4" required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-danger">Tolak</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
function confirmApprove(id, type) {
    if (confirm(`Yakin ingin menyetujui permintaan ${type} ini?`)) {
        window.location.href = `{{ route('admin.aktivitas.permintaan-pengajuan.approve', ['id' => ':id', 'type' => ':type']) }}`.replace(':id', id).replace(':type', type);
    }
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
        alert(data.message || 'Permintaan ditolak.');
        location.reload();
    })
    .catch(error => {
        alert('Terjadi kesalahan.');
    });
});
</script>
@endsection