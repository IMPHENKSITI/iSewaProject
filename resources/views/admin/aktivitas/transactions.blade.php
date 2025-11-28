@extends('admin.layouts.admin')

@section('title', 'Bukti Transaksi')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    
    <!-- Header -->
    <div class="row mb-4">
        <div class="col-12">
            <h4 class="fw-bold py-3 mb-0">
                <span class="text-muted fw-light">Aktivitas /</span> Bukti Transaksi
            </h4>
            <p class="text-muted mb-0">Verifikasi bukti pembayaran dari pengguna</p>
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
                                <i class="bx bx-receipt fs-4"></i>
                            </span>
                        </div>
                        <div>
                            <p class="mb-0 text-muted small">Total Bukti</p>
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
                            <span class="avatar-initial rounded-circle bg-label-info">
                                <i class="bx bx-wrench fs-4"></i>
                            </span>
                        </div>
                        <div>
                            <p class="mb-0 text-muted small">Penyewaan</p>
                            <h4 class="mb-0 fw-bold">{{ $stats['rental_total'] }}</h4>
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
                                <i class="bx bxs-gas-pump fs-4"></i>
                            </span>
                        </div>
                        <div>
                            <p class="mb-0 text-muted small">Gas</p>
                            <h4 class="mb-0 fw-bold">{{ $stats['gas_total'] }}</h4>
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
                                <i class="bx bx-credit-card fs-4"></i>
                            </span>
                        </div>
                        <div>
                            <p class="mb-0 text-muted small">Transfer / Tunai</p>
                            <h4 class="mb-0 fw-bold">{{ $stats['transfer_total'] }} / {{ $stats['cash_total'] }}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters -->
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('admin.aktivitas.bukti-transaksi.index') }}" id="filterForm">
                <div class="row g-3 align-items-end">
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Kategori Transaksi</label>
                        <select name="category" class="form-select" onchange="document.getElementById('filterForm').submit()">
                            <option value="all" {{ $category == 'all' ? 'selected' : '' }}>Semua Kategori</option>
                            <option value="rental" {{ $category == 'rental' ? 'selected' : '' }}>Penyewaan Alat ({{ $stats['rental_total'] }})</option>
                            <option value="gas" {{ $category == 'gas' ? 'selected' : '' }}>Pembelian Gas ({{ $stats['gas_total'] }})</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Metode Pembayaran</label>
                        <select name="payment_method" class="form-select" onchange="document.getElementById('filterForm').submit()">
                            <option value="all" {{ $paymentMethod == 'all' ? 'selected' : '' }}>Semua Metode</option>
                            <option value="transfer" {{ $paymentMethod == 'transfer' ? 'selected' : '' }}>Transfer Bank ({{ $stats['transfer_total'] }})</option>
                            <option value="tunai" {{ $paymentMethod == 'tunai' ? 'selected' : '' }}>Tunai ({{ $stats['cash_total'] }})</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        @if($category != 'all' || $paymentMethod != 'all')
                            <a href="{{ route('admin.aktivitas.bukti-transaksi.index') }}" class="btn btn-outline-secondary w-100">
                                <i class="bx bx-reset me-1"></i> Reset Filter
                            </a>
                        @endif
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Transactions List -->
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white border-bottom d-flex justify-content-between align-items-center py-3">
            <h5 class="mb-0 fw-bold">
                <i class="bx bx-receipt me-2"></i>
                Daftar Bukti Pembayaran
                @if($category != 'all')
                    <span class="badge bg-label-primary ms-2">
                        {{ $category == 'rental' ? 'Penyewaan' : 'Gas' }}
                    </span>
                @endif
                @if($paymentMethod != 'all')
                    <span class="badge bg-label-info ms-2">
                        {{ ucfirst($paymentMethod) }}
                    </span>
                @endif
            </h5>
            <div class="text-muted small">
                Total: <strong>{{ $rentalPayments->count() + $gasPayments->count() }}</strong> bukti
            </div>
        </div>
        <div class="card-body p-0">
            @if($rentalPayments->isEmpty() && $gasPayments->isEmpty())
                <div class="text-center py-5">
                    <i class="bx bx-inbox fs-1 text-muted mb-3 d-block"></i>
                    <p class="text-muted">Tidak ada bukti pembayaran yang sesuai dengan filter</p>
                </div>
            @else
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th class="ps-4">Pengguna</th>
                                <th>Kategori</th>
                                <th>Detail Transaksi</th>
                                <th>Metode Bayar</th>
                                <th>Tanggal Upload</th>
                                <th>Status</th>
                                <th class="text-center pe-4">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($rentalPayments as $payment)
                                <tr>
                                    <td class="ps-4">
                                        <div class="d-flex align-items-center">
                                            <div class="avatar avatar-sm me-3">
                                                @if($payment->user && $payment->user->avatar)
                                                    <img src="{{ asset('storage/' . $payment->user->avatar) }}" alt="Avatar" class="rounded-circle">
                                                @else
                                                    <span class="avatar-initial rounded-circle bg-label-primary">
                                                        {{ strtoupper(substr($payment->user->name ?? 'U', 0, 1)) }}
                                                    </span>
                                                @endif
                                            </div>
                                            <div>
                                                <div class="fw-semibold">{{ $payment->user->name ?? 'Unknown' }}</div>
                                                <small class="text-muted">{{ $payment->user->email ?? '-' }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge bg-label-primary rounded-pill">
                                            <i class="bx bx-wrench me-1"></i> Penyewaan
                                        </span>
                                    </td>
                                    <td>
                                        <div class="fw-semibold">{{ $payment->equipment_name ?? 'Alat Penyewaan' }}</div>
                                        <small class="text-muted">
                                            ID: #{{ $payment->id }} | Rp {{ number_format($payment->total_price ?? 0, 0, ',', '.') }}
                                        </small>
                                    </td>
                                    <td>
                                        @if($payment->payment_method == 'transfer')
                                            <span class="badge bg-info">
                                                <i class="bx bx-credit-card me-1"></i> Transfer
                                            </span>
                                        @else
                                            <span class="badge bg-success">
                                                <i class="bx bx-money me-1"></i> Tunai
                                            </span>
                                        @endif
                                    </td>
                                    <td>
                                        <div>{{ $payment->updated_at->format('d M Y') }}</div>
                                        <small class="text-muted">{{ $payment->updated_at->format('H:i') }}</small>
                                    </td>
                                    <td>
                                        @if($payment->status == 'completed')
                                            <span class="badge bg-success">
                                                <i class="bx bx-check-circle me-1"></i> Terverifikasi
                                            </span>
                                        @elseif($payment->status == 'rejected')
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
                                        <a href="{{ route('admin.aktivitas.bukti-transaksi.download', [$payment->id, 'rental']) }}" 
                                           class="btn btn-sm btn-icon btn-outline-primary rounded-circle" 
                                           title="Lihat Bukti" target="_blank">
                                            <i class="bx bx-image"></i>
                                        </a>
                                        @if($payment->status != 'completed')
                                            <button type="button" class="btn btn-sm btn-icon btn-outline-success rounded-circle ms-1" 
                                                    onclick="verifyPayment({{ $payment->id }}, 'rental')" title="Verifikasi">
                                                <i class="bx bx-check"></i>
                                            </button>
                                            <button type="button" class="btn btn-sm btn-icon btn-outline-danger rounded-circle ms-1" 
                                                    onclick="rejectPayment({{ $payment->id }}, 'rental')" title="Tolak">
                                                <i class="bx bx-x"></i>
                                            </button>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach

                            @foreach($gasPayments as $payment)
                                <tr>
                                    <td class="ps-4">
                                        <div class="d-flex align-items-center">
                                            <div class="avatar avatar-sm me-3">
                                                @if($payment->user && $payment->user->avatar)
                                                    <img src="{{ asset('storage/' . $payment->user->avatar) }}" alt="Avatar" class="rounded-circle">
                                                @else
                                                    <span class="avatar-initial rounded-circle bg-label-info">
                                                        {{ strtoupper(substr($payment->user->name ?? 'U', 0, 1)) }}
                                                    </span>
                                                @endif
                                            </div>
                                            <div>
                                                <div class="fw-semibold">{{ $payment->user->name ?? 'Unknown' }}</div>
                                                <small class="text-muted">{{ $payment->user->email ?? '-' }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge bg-label-info rounded-pill">
                                            <i class="bx bxs-gas-pump me-1"></i> Gas
                                        </span>
                                    </td>
                                    <td>
                                        <div class="fw-semibold">Gas LPG {{ $payment->gas_size ?? '3' }} Kg</div>
                                        <small class="text-muted">
                                            ID: #{{ $payment->id }} | {{ $payment->quantity ?? 1 }} tabung | Rp {{ number_format($payment->total_price ?? 0, 0, ',', '.') }}
                                        </small>
                                    </td>
                                    <td>
                                        @if($payment->payment_method == 'transfer')
                                            <span class="badge bg-info">
                                                <i class="bx bx-credit-card me-1"></i> Transfer
                                            </span>
                                        @else
                                            <span class="badge bg-success">
                                                <i class="bx bx-money me-1"></i> Tunai
                                            </span>
                                        @endif
                                    </td>
                                    <td>
                                        <div>{{ $payment->updated_at->format('d M Y') }}</div>
                                        <small class="text-muted">{{ $payment->updated_at->format('H:i') }}</small>
                                    </td>
                                    <td>
                                        @if($payment->status == 'completed')
                                            <span class="badge bg-success">
                                                <i class="bx bx-check-circle me-1"></i> Terverifikasi
                                            </span>
                                        @elseif($payment->status == 'rejected')
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
                                        <a href="{{ route('admin.aktivitas.bukti-transaksi.download', [$payment->id, 'gas']) }}" 
                                           class="btn btn-sm btn-icon btn-outline-primary rounded-circle" 
                                           title="Lihat Bukti" target="_blank">
                                            <i class="bx bx-image"></i>
                                        </a>
                                        @if($payment->status != 'completed')
                                            <button type="button" class="btn btn-sm btn-icon btn-outline-success rounded-circle ms-1" 
                                                    onclick="verifyPayment({{ $payment->id }}, 'gas')" title="Verifikasi">
                                                <i class="bx bx-check"></i>
                                            </button>
                                            <button type="button" class="btn btn-sm btn-icon btn-outline-danger rounded-circle ms-1" 
                                                    onclick="rejectPayment({{ $payment->id }}, 'gas')" title="Tolak">
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
                <h5 class="modal-title">Tolak Bukti Pembayaran</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="rejectForm" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Alasan Penolakan <span class="text-danger">*</span></label>
                        <textarea name="reason" class="form-control" rows="4" placeholder="Jelaskan alasan penolakan bukti pembayaran..." required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-danger">
                        <i class="bx bx-x me-1"></i> Tolak Bukti
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function verifyPayment(id, type) {
    Swal.fire({
        title: 'Verifikasi Pembayaran?',
        text: 'Bukti pembayaran akan diverifikasi dan transaksi diselesaikan',
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: 'Ya, Verifikasi',
        cancelButtonText: 'Batal',
        confirmButtonColor: '#28a745',
        cancelButtonColor: '#6c757d'
    }).then((result) => {
        if (result.isConfirmed) {
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = `{{ url('admin/aktivitas/bukti-transaksi') }}/${id}/${type}/verify`;
            
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

function rejectPayment(id, type) {
    const modal = new bootstrap.Modal(document.getElementById('rejectModal'));
    const form = document.getElementById('rejectForm');
    form.action = `{{ url('admin/aktivitas/bukti-transaksi') }}/${id}/${type}/reject`;
    modal.show();
}
</script>
@endsection