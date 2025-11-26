@extends('admin.layouts.admin')

@section('title', 'Bukti Transaksi')

@section('content')
<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-12 col-lg-10">
            <!-- HEADER -->
            <h2 class="text-primary fw-bold mb-4">Bukti Transaksi</h2>
            <p class="text-muted mb-4">Bukti pembayaran dari pengguna yang perlu diverifikasi</p>

            <!-- RENTAL PAYMENTS -->
            <div class="card shadow-sm border-0 rounded-4 mb-4">
                <div class="card-header bg-white border-bottom">
                    <h5 class="mb-0">Penyewaan Alat</h5>
                </div>
                <div class="card-body p-3">
                    @if($rentalPayments->isEmpty())
                        <p class="text-center text-muted">Tidak ada bukti pembayaran penyewaan alat.</p>
                    @else
                        <div class="list-group list-group-flush">
                            @foreach($rentalPayments as $req)
                                <div class="list-group-item d-flex align-items-center p-2 notification-item" id="transaction{{ $req->id }}">
                                    <div class="avatar flex-shrink-0 me-2">
                                        <span class="avatar-initial rounded bg-label-secondary">P</span>
                                    </div>
                                    <div class="flex-grow-1">
                                        <div class="mb-2">
                                            <span class="badge bg-success me-2">Bukti Pembayaran</span>
                                            <small class="text-muted">{{ $req->updated_at->diffForHumans() }}</small>
                                        </div>
                                        <h6 class="mb-1">{{ $req->full_name }} - {{ $req->item_name }} ({{ $req->order_number }})</h6>
                                        <p class="text-muted mb-0 small">Total: Rp {{ number_format($req->price, 0, ',', '.') }}</p>
                                    </div>
                                    <div class="d-flex gap-2 ms-3">
                                        <a href="{{ route('admin.aktivitas.bukti-transaksi.show', ['id' => $req->id, 'type' => 'rental']) }}" class="btn btn-sm btn-outline-primary">
                                            <i class="bx bx-show"></i> Detail
                                        </a>
                                        <button class="btn btn-sm btn-success" onclick="verifyPayment({{ $req->id }}, 'rental')">
                                            <i class="bx bx-check"></i> Verifikasi
                                        </button>
                                        <button class="btn btn-sm btn-danger" onclick="showRejectPaymentModal({{ $req->id }}, 'rental')">
                                            <i class="bx bx-x"></i> Tolak
                                        </button>
                                        <a href="{{ route('admin.aktivitas.bukti-transaksi.download', ['id' => $req->id, 'type' => 'rental']) }}" class="btn btn-sm btn-outline-info">
                                            <i class="bx bx-download"></i> Download
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>

            <!-- GAS PAYMENTS -->
            <div class="card shadow-sm border-0 rounded-4">
                <div class="card-header bg-white border-bottom">
                    <h5 class="mb-0">Pembelian Gas</h5>
                </div>
                <div class="card-body p-3">
                    @if($gasPayments->isEmpty())
                        <p class="text-center text-muted">Tidak ada bukti pembayaran pembelian gas.</p>
                    @else
                        <div class="list-group list-group-flush">
                            @foreach($gasPayments as $order)
                                <div class="list-group-item d-flex align-items-center p-2 notification-item" id="transaction{{ $order->id }}">
                                    <div class="avatar flex-shrink-0 me-2">
                                        <span class="avatar-initial rounded bg-label-secondary">G</span>
                                    </div>
                                    <div class="flex-grow-1">
                                        <div class="mb-2">
                                            <span class="badge bg-success me-2">Bukti Pembayaran</span>
                                            <small class="text-muted">{{ $order->updated_at->diffForHumans() }}</small>
                                        </div>
                                        <h6 class="mb-1">{{ $order->full_name }} - {{ $order->item_name }} ({{ $order->order_number }})</h6>
                                        <p class="text-muted mb-0 small">Total: Rp {{ number_format($order->price, 0, ',', '.') }}</p>
                                    </div>
                                    <div class="d-flex gap-2 ms-3">
                                        <a href="{{ route('admin.aktivitas.bukti-transaksi.show', ['id' => $order->id, 'type' => 'gas']) }}" class="btn btn-sm btn-outline-primary">
                                            <i class="bx bx-show"></i> Detail
                                        </a>
                                        <button class="btn btn-sm btn-success" onclick="verifyPayment({{ $order->id }}, 'gas')">
                                            <i class="bx bx-check"></i> Verifikasi
                                        </button>
                                        <button class="btn btn-sm btn-danger" onclick="showRejectPaymentModal({{ $order->id }}, 'gas')">
                                            <i class="bx bx-x"></i> Tolak
                                        </button>
                                        <a href="{{ route('admin.aktivitas.bukti-transaksi.download', ['id' => $order->id, 'type' => 'gas']) }}" class="btn btn-sm btn-outline-info">
                                            <i class="bx bx-download"></i> Download
                                        </a>
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

<!-- Reject Payment Modal -->
<div class="modal fade" id="rejectPaymentModal" tabindex="-1" aria-labelledby="rejectPaymentModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="rejectPaymentModalLabel">Tolak Bukti Pembayaran</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="rejectPaymentForm" method="POST">
                @csrf
                <div class="modal-body">
                    <input type="hidden" name="id" id="rejectPaymentId">
                    <input type="hidden" name="type" id="rejectPaymentType">
                    <div class="mb-3">
                        <label for="paymentReason" class="form-label">Alasan Penolakan</label>
                        <textarea name="reason" id="paymentReason" class="form-control" rows="4" required></textarea>
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
function verifyPayment(id, type) {
    if (confirm(`Yakin ingin memverifikasi bukti pembayaran ${type} ini?`)) {
        window.location.href = `{{ route('admin.aktivitas.bukti-transaksi.verify', ['id' => ':id', 'type' => ':type']) }}`.replace(':id', id).replace(':type', type);
    }
}

function showRejectPaymentModal(id, type) {
    document.getElementById('rejectPaymentId').value = id;
    document.getElementById('rejectPaymentType').value = type;
    const modal = new bootstrap.Modal(document.getElementById('rejectPaymentModal'));
    modal.show();
}

// Handle payment rejection form
document.getElementById('rejectPaymentForm').addEventListener('submit', function(e) {
    e.preventDefault();
    const formData = new FormData(this);
    const url = `{{ route('admin.aktivitas.bukti-transaksi.reject', ['id' => ':id', 'type' => ':type']) }}`
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
        alert(data.message || 'Bukti pembayaran ditolak.');
        location.reload();
    })
    .catch(error => {
        alert('Terjadi kesalahan.');
    });
});
</script>
@endsection