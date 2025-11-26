@extends('admin.layouts.admin')

@section('title', 'Detail Pengajuan')

@section('content')
<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-12 col-lg-8">
            <!-- HEADER -->
            <h2 class="text-primary fw-bold mb-4">Detail Pengajuan</h2>

            <!-- DETAIL CARD -->
            <div class="card shadow-sm border-0 rounded-4">
                <div class="card-header bg-white border-bottom">
                    <h5 class="mb-0">{{ $request->item_name }} — {{ $request->order_number }}</h5>
                </div>
                <div class="card-body p-4">
                    <div class="row g-4">
                        <div class="col-md-6">
                            <h6 class="fw-bold">Informasi Pemesan</h6>
                            <p><strong>Nama:</strong> {{ $request->full_name }}</p>
                            <p><strong>Email:</strong> {{ $request->email }}</p>
                            <p><strong>Alamat:</strong> {{ $request->address }}</p>
                            <p><strong>Metode Antar/Jemput:</strong> {{ ucfirst($request->delivery_method) }}</p>
                            <p><strong>Metode Pembayaran:</strong> {{ ucfirst($request->payment_method) }}</p>
                        </div>
                        <div class="col-md-6">
                            <h6 class="fw-bold">Waktu & Status</h6>
                            <p><strong>Tanggal Pemesanan:</strong> {{ $request->created_at->format('d F Y H:i') }}</p>
                            <p><strong>Status:</strong> 
                                <span class="badge 
                                    @if($request->status == 'pending') bg-warning
                                    @elseif($request->status == 'approved') bg-success
                                    @elseif($request->status == 'rejected') bg-danger
                                    @elseif($request->status == 'completed') bg-info
                                    @endif">
                                    {{ ucfirst($request->status) }}
                                </span>
                            </p>
                            @if($request->rejection_reason)
                                <p><strong>Alasan Penolakan:</strong> {{ $request->rejection_reason }}</p>
                            @endif
                        </div>
                    </div>

                    @if($type === 'rental')
                        <div class="mt-4">
                            <h6 class="fw-bold">Detail Penyewaan</h6>
                            <p><strong>Waktu Pengiriman:</strong> {{ $request->pickup_time ?? '-' }}</p>
                            <p><strong>Waktu Penyewaan:</strong> {{ $request->start_date }} - {{ $request->end_date }}</p>
                            <p><strong>Waktu Pengembalian:</strong> {{ $request->return_time ?? '-' }}</p>
                            <p><strong>Jumlah:</strong> {{ $request->quantity }} unit</p>
                            <p><strong>Total:</strong> Rp {{ number_format($request->price, 0, ',', '.') }}</p>
                        </div>
                    @else
                        <div class="mt-4">
                            <h6 class="fw-bold">Detail Pembelian Gas</h6>
                            <p><strong>Tanggal Pemesanan:</strong> {{ $request->order_date }}</p>
                            <p><strong>Jumlah:</strong> {{ $request->quantity }} unit</p>
                            <p><strong>Total:</strong> Rp {{ number_format($request->price, 0, ',', '.') }}</p>
                        </div>
                    @endif

                    @if($request->proof_of_payment)
                        <div class="mt-4">
                            <h6 class="fw-bold">Bukti Pembayaran</h6>
                            <img src="{{ asset('storage/' . $request->proof_of_payment) }}" alt="Bukti Pembayaran" class="img-fluid rounded" style="max-height: 300px; object-fit: contain;">
                            <div class="mt-2">
                                <a href="{{ route('admin.aktivitas.bukti-transaksi.download', ['id' => $request->id, 'type' => $type]) }}" class="btn btn-sm btn-outline-info">
                                    <i class="bx bx-download"></i> Download Bukti
                                </a>
                            </div>
                        </div>
                    @endif

                    <div class="mt-4 d-flex gap-2">
                        <a href="{{ route('admin.aktivitas.permintaan-pengajuan.index') }}" class="btn btn-outline-secondary">
                            <i class="bx bx-arrow-back"></i> Kembali
                        </a>
                        @if($request->status === 'pending')
                            <button class="btn btn-success" onclick="confirmApprove({{ $request->id }}, '{{ $type }}')">
                                <i class="bx bx-check"></i> Setujui
                            </button>
                            <button class="btn btn-danger" onclick="showRejectModal({{ $request->id }}, '{{ $type }}')">
                                <i class="bx bx-x"></i> Tolak
                            </button>
                        @endif
                    </div>
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