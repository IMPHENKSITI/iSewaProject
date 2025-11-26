@extends('admin.layouts.admin')

@section('title', 'Laporan Transaksi')

@section('content')
<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-12 col-lg-10">
            <!-- HEADER -->
            <h2 class="text-primary fw-bold mb-4">Laporan Transaksi</h2>
            <p class="text-muted mb-4">Daftar semua transaksi penyewaan alat dan pembelian gas.</p>

            <!-- RENTAL REQUESTS -->
            <div class="card shadow-sm border-0 rounded-4 mb-4">
                <div class="card-header bg-white border-bottom">
                    <h5 class="mb-0">Penyewaan Alat</h5>
                </div>
                <div class="card-body p-3">
                    @if($rentalRequests->isEmpty())
                        <p class="text-center text-muted">Tidak ada transaksi penyewaan alat.</p>
                    @else
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>No. Pesanan</th>
                                        <th>Nama Pemesan</th>
                                        <th>Item</th>
                                        <th>Jumlah</th>
                                        <th>Total</th>
                                        <th>Status</th>
                                        <th>Tanggal</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($rentalRequests as $req)
                                        <tr>
                                            <td>{{ $req->order_number }}</td>
                                            <td>{{ $req->full_name }}</td>
                                            <td>{{ $req->item_name }}</td>
                                            <td>{{ $req->quantity }}</td>
                                            <td>Rp {{ number_format($req->price, 0, ',', '.') }}</td>
                                            <td><span class="badge 
                                                @if($req->status == 'pending') bg-warning
                                                @elseif($req->status == 'approved') bg-success
                                                @elseif($req->status == 'rejected') bg-danger
                                                @elseif($req->status == 'completed') bg-info
                                                @endif">
                                                {{ ucfirst($req->status) }}
                                            </span></td>
                                            <td>{{ $req->created_at->format('d M Y H:i') }}</td>
                                            <td>
                                                <a href="{{ route('admin.aktivitas.permintaan-pengajuan.show', ['id' => $req->id, 'type' => 'rental']) }}" class="btn btn-sm btn-outline-primary">
                                                    <i class="bx bx-show"></i>
                                                </a>
                                                <button class="btn btn-sm btn-success" onclick="confirmApprove({{ $req->id }}, 'rental')">
                                                    <i class="bx bx-check"></i>
                                                </button>
                                                <button class="btn btn-sm btn-danger" onclick="showRejectModal({{ json_encode($req->id) }}, 'rental')">
                                                    <i class="bx bx-x"></i>
                                                </button>
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
            <div class="card shadow-sm border-0 rounded-4">
                <div class="card-header bg-white border-bottom">
                    <h5 class="mb-0">Pembelian Gas</h5>
                </div>
                <div class="card-body p-3">
                    @if($gasOrders->isEmpty())
                        <p class="text-center text-muted">Tidak ada transaksi pembelian gas.</p>
                    @else
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>No. Pesanan</th>
                                        <th>Nama Pemesan</th>
                                        <th>Item</th>
                                        <th>Jumlah</th>
                                        <th>Total</th>
                                        <th>Status</th>
                                        <th>Tanggal</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($gasOrders as $order)
                                        <tr>
                                            <td>{{ $order->order_number }}</td>
                                            <td>{{ $order->full_name }}</td>
                                            <td>{{ $order->item_name }}</td>
                                            <td>{{ $order->quantity }}</td>
                                            <td>Rp {{ number_format($order->price, 0, ',', '.') }}</td>
                                            <td><span class="badge 
                                                @if($order->status == 'pending') bg-warning
                                                @elseif($order->status == 'approved') bg-success
                                                @elseif($order->status == 'rejected') bg-danger
                                                @elseif($order->status == 'completed') bg-info
                                                @endif">
                                                {{ ucfirst($order->status) }}
                                            </span></td>
                                            <td>{{ $order->created_at->format('d M Y H:i') }}</td>
                                            <td>
                                                <a href="{{ route('admin.aktivitas.permintaan-pengajuan.show', ['id' => $order->id, 'type' => 'gas']) }}" class="btn btn-sm btn-outline-primary">
                                                    <i class="bx bx-show"></i>
                                                </a>
                                                <button class="btn btn-sm btn-success" onclick="confirmApprove({{ json_encode($order->id) }}, 'gas')">
                                                    <i class="bx bx-check"></i>
                                                </button>
                                                <button class="btn btn-sm btn-danger" onclick="showRejectModal({{ json_encode($order->id) }}, 'gas')">
                                                    <i class="bx bx-x"></i>
                                                </button>
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