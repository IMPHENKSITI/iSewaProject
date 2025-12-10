@extends('admin.layouts.admin')

@section('title', 'Bukti Transaksi')

@section('content')
<div class="container-fluid py-4">
    
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold fs-3 mb-1 text-primary">Bukti Transaksi</h4>
        </div>
        <div class="d-flex gap-2">
            <button class="btn btn-white border shadow-sm rounded-pill px-4" onclick="location.reload()">
                <i class="bx bx-refresh me-2"></i>Refresh
            </button>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="row g-3 mb-4">
        <div class="col-md-3 col-6">
            <div class="card border-0 shadow-sm h-100 rounded-4 position-relative overflow-hidden">
                <div class="card-body p-3">
                    <div class="d-flex align-items-center mb-2">
                        <div class="avatar avatar-md bg-primary-subtle text-primary rounded-3 p-2 me-3">
                            <i class="bx bx-receipt fs-3"></i>
                        </div>
                        <div>
                            <small class="text-muted text-uppercase fw-bold ls-1" style="font-size: 0.7rem;">Total Bukti</small>
                            <h4 class="fw-bold mb-0 text-dark">{{ $stats['total'] }}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-6">
            <div class="card border-0 shadow-sm h-100 rounded-4 position-relative overflow-hidden">
                <div class="card-body p-3">
                    <div class="d-flex align-items-center mb-2">
                        <div class="avatar avatar-md bg-info-subtle text-info rounded-3 p-2 me-3">
                            <i class="bx bx-wrench fs-3"></i>
                        </div>
                        <div>
                            <small class="text-muted text-uppercase fw-bold ls-1" style="font-size: 0.7rem;">Penyewaan</small>
                            <h4 class="fw-bold mb-0 text-dark">{{ $stats['rental_total'] }}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-6">
            <div class="card border-0 shadow-sm h-100 rounded-4 position-relative overflow-hidden">
                <div class="card-body p-3">
                    <div class="d-flex align-items-center mb-2">
                        <div class="avatar avatar-md bg-success-subtle text-success rounded-3 p-2 me-3">
                            <i class="bx bxs-gas-pump fs-3"></i>
                        </div>
                        <div>
                            <small class="text-muted text-uppercase fw-bold ls-1" style="font-size: 0.7rem;">Gas</small>
                            <h4 class="fw-bold mb-0 text-dark">{{ $stats['gas_total'] }}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-6">
            <div class="card border-0 shadow-sm h-100 rounded-4 position-relative overflow-hidden">
                <div class="card-body p-3">
                    <div class="d-flex align-items-center mb-2">
                        <div class="avatar avatar-md bg-warning-subtle text-warning rounded-3 p-2 me-3">
                            <i class="bx bx-money fs-3"></i>
                        </div>
                        <div>
                            <small class="text-muted text-uppercase fw-bold ls-1" style="font-size: 0.7rem;">Tunai</small>
                            <h4 class="fw-bold mb-0 text-dark">{{ $stats['cash_total'] }}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content Tabs -->
    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        <div class="card-header bg-white border-bottom py-3 px-4">
             <ul class="nav nav-pills card-header-pills gap-2" id="proofTabs" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active rounded-pill px-4 fw-semibold" id="rental-tab" data-bs-toggle="tab" data-bs-target="#rental-pane" type="button" role="tab">
                        <i class="bx bx-wrench me-2"></i>Penyewaan Alat
                        <span class="badge bg-white text-primary ms-2 shadow-sm">{{ $rentalPayments->count() }}</span>
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link rounded-pill px-4 fw-semibold" id="gas-tab" data-bs-toggle="tab" data-bs-target="#gas-pane" type="button" role="tab">
                        <i class="bx bxs-gas-pump me-2"></i>Pembelian Gas
                        <span class="badge bg-white text-primary ms-2 shadow-sm">{{ $gasPayments->count() }}</span>
                    </button>
                </li>
            </ul>
        </div>
        
        <div class="card-body p-0">
             <div class="tab-content" id="proofTabsContent">
                
                <!-- RENTAL TAB -->
                <div class="tab-pane fade show active" id="rental-pane" role="tabpanel">
                    @if($rentalPayments->isEmpty())
                        <div class="text-center py-5">
                            <div class="mb-3"><i class="bx bx-receipt fs-1 text-muted opacity-25"></i></div>
                            <h6 class="text-muted fw-bold">Belum ada bukti pembayaran penyewaan</h6>
                        </div>
                    @else
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="bg-light">
                                    <tr>
                                        <th class="ps-4 py-3 text-secondary text-uppercase small fw-bold">Pengguna</th>
                                        <th class="py-3 text-secondary text-uppercase small fw-bold">Item Sewa</th>
                                        <th class="py-3 text-secondary text-uppercase small fw-bold">Total Bayar</th>
                                        <th class="py-3 text-secondary text-uppercase small fw-bold">Metode</th>
                                        <th class="py-3 text-secondary text-uppercase small fw-bold">Status</th>
                                        <th class="text-end pe-4 py-3 text-secondary text-uppercase small fw-bold">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($rentalPayments as $payment)
                                    <tr>
                                        <td class="ps-4">
                                            <div class="d-flex align-items-center">
                                                <div class="avatar avatar-sm border rounded-circle p-1 me-3">
                                                    @if($payment->user && $payment->user->avatar)
                                                        <img src="{{ asset('storage/' . $payment->user->avatar) }}" alt="Av" class="rounded-circle w-100 h-100 object-fit-cover">
                                                    @else
                                                        <span class="avatar-initial rounded-circle bg-primary-subtle text-primary fw-bold">
                                                            {{ strtoupper(substr($payment->user->name ?? 'U', 0, 1)) }}
                                                        </span>
                                                    @endif
                                                </div>
                                                <div>
                                                    <h6 class="mb-0 fw-semibold text-dark">{{ $payment->full_name ?? $payment->recipient_name ?? $payment->user->name }}</h6>
                                                    <small class="text-muted">{{ $payment->user->email ?? '-' }}</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="fw-medium text-dark">{{ $payment->equipment_name ?? 'Alat' }}</div>
                                            <small class="text-muted">ID: #{{ $payment->order_number ?? $payment->id }}</small>
                                        </td>
                                        <td>
                                            <span class="fw-bold text-dark">Rp {{ number_format($payment->total_price ?? 0, 0, ',', '.') }}</span>
                                        </td>
                                        <td>
                                            @if($payment->payment_method == 'tunai')
                                                <span class="badge bg-success-subtle text-success border border-success-subtle rounded-pill px-3">Tunai</span>
                                            @elseif($payment->payment_method == 'transfer')
                                                <span class="badge bg-primary-subtle text-primary border border-primary-subtle rounded-pill px-3">Transfer</span>
                                            @else
                                                <span class="badge bg-secondary-subtle text-secondary border border-secondary-subtle rounded-pill px-3">{{ ucfirst($payment->payment_method) }}</span>
                                            @endif
                                        </td>
                                        <td>
                                            @include('admin.partials.status-badge', ['status' => $payment->status])
                                        </td>
                                        <td class="text-end pe-4">
                                            <div class="d-flex justify-content-end gap-2">
                                                @if($payment->payment_proof)
                                                    <a href="{{ route('admin.aktivitas.bukti-transaksi.download', [$payment->id, 'rental']) }}" 
                                                       class="btn btn-sm btn-light border shadow-sm rounded-circle p-2 text-primary hover-primary" 
                                                       title="Lihat Bukti" target="_blank">
                                                        <i class="bx bx-image fs-5"></i>
                                                    </a>
                                                @else
                                                    <a href="{{ route('receipt.rental.view', $payment->id) }}" 
                                                       class="btn btn-sm btn-light border shadow-sm rounded-circle p-2 text-info hover-primary" 
                                                       title="Lihat Struk System" target="_blank">
                                                        <i class="bx bx-receipt fs-5"></i>
                                                    </a>
                                                @endif
                                                @if($payment->status != 'completed')
                                                    <button class="btn btn-sm btn-light border shadow-sm rounded-circle p-2 text-success hover-success" 
                                                            onclick="verifyPayment({{ $payment->id }}, 'rental')" title="Verifikasi">
                                                        <i class="bx bx-check fs-5"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-light border shadow-sm rounded-circle p-2 text-danger hover-danger" 
                                                            onclick="rejectPayment({{ $payment->id }}, 'rental')" title="Tolak">
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

                <!-- GAS TAB -->
                <div class="tab-pane fade" id="gas-pane" role="tabpanel">
                      @if($gasPayments->isEmpty())
                        <div class="text-center py-5">
                            <div class="mb-3"><i class="bx bx-receipt fs-1 text-muted opacity-25"></i></div>
                            <h6 class="text-muted fw-bold">Belum ada bukti pembayaran gas</h6>
                        </div>
                    @else
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="bg-light">
                                    <tr>
                                        <th class="ps-4 py-3 text-secondary text-uppercase small fw-bold">Pembeli</th>
                                        <th class="py-3 text-secondary text-uppercase small fw-bold">Produk Gas</th>
                                        <th class="py-3 text-secondary text-uppercase small fw-bold">Total Bayar</th>
                                        <th class="py-3 text-secondary text-uppercase small fw-bold">Metode</th>
                                        <th class="py-3 text-secondary text-uppercase small fw-bold">Status</th>
                                        <th class="text-end pe-4 py-3 text-secondary text-uppercase small fw-bold">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($gasPayments as $payment)
                                    <tr>
                                        <td class="ps-4">
                                            <div class="d-flex align-items-center">
                                                <div class="avatar avatar-sm border rounded-circle p-1 me-3">
                                                    @if($payment->user && $payment->user->avatar)
                                                        <img src="{{ asset('storage/' . $payment->user->avatar) }}" alt="Av" class="rounded-circle w-100 h-100 object-fit-cover">
                                                    @else
                                                        <span class="avatar-initial rounded-circle bg-info-subtle text-info fw-bold">
                                                            {{ strtoupper(substr($payment->full_name ?? $payment->user->name ?? 'U', 0, 1)) }}
                                                        </span>
                                                    @endif
                                                </div>
                                                <div>
                                                    <h6 class="mb-0 fw-semibold text-dark">{{ $payment->full_name ?? $payment->user->name }}</h6>
                                                    <small class="text-muted">{{ $payment->address ?? $payment->user->address ?? '-' }}</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="fw-medium text-dark">{{ $payment->item_name ?? 'Gas LPG' }}</div>
                                            <small class="text-muted">{{ $payment->quantity }} Tabung</small>
                                        </td>
                                        <td>
                                             <span class="fw-bold text-dark">Rp {{ number_format($payment->total_price ?? 0, 0, ',', '.') }}</span>
                                        </td>
                                        <td>
                                            @if($payment->payment_method == 'tunai')
                                                <span class="badge bg-success-subtle text-success border border-success-subtle rounded-pill px-3">Tunai</span>
                                            @elseif($payment->payment_method == 'transfer')
                                                <span class="badge bg-primary-subtle text-primary border border-primary-subtle rounded-pill px-3">Transfer</span>
                                            @else
                                                <span class="badge bg-secondary-subtle text-secondary border border-secondary-subtle rounded-pill px-3">{{ ucfirst($payment->payment_method) }}</span>
                                            @endif
                                        </td>
                                        <td>
                                            @include('admin.partials.status-badge', ['status' => $payment->status])
                                        </td>
                                        <td class="text-end pe-4">
                                            <div class="d-flex justify-content-end gap-2">
                                                 @if($payment->proof_of_payment)
                                                    <a href="{{ route('admin.aktivitas.bukti-transaksi.download', [$payment->id, 'gas']) }}" 
                                                       class="btn btn-sm btn-light border shadow-sm rounded-circle p-2 text-primary hover-primary" 
                                                       title="Lihat Bukti" target="_blank">
                                                        <i class="bx bx-image fs-5"></i>
                                                    </a>
                                                @else
                                                    <a href="{{ route('receipt.gas.view', $payment->id) }}" 
                                                       class="btn btn-sm btn-light border shadow-sm rounded-circle p-2 text-info hover-primary" 
                                                       title="Lihat Struk System" target="_blank">
                                                        <i class="bx bx-receipt fs-5"></i>
                                                    </a>
                                                @endif
                                                @if($payment->status != 'completed')
                                                    <button class="btn btn-sm btn-light border shadow-sm rounded-circle p-2 text-success hover-success" 
                                                            onclick="verifyPayment({{ $payment->id }}, 'gas')" title="Verifikasi">
                                                        <i class="bx bx-check fs-5"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-light border shadow-sm rounded-circle p-2 text-danger hover-danger" 
                                                            onclick="rejectPayment({{ $payment->id }}, 'gas')" title="Tolak">
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
    </div>
</div>

<!-- Reject Modal -->
<div class="modal fade" id="rejectModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4 border-0">
            <div class="modal-header border-bottom-0 pb-0">
                <h5 class="modal-title fw-bold">Tolak Bukti Pembayaran</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="rejectForm" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label text-muted">Alasan Penolakan <span class="text-danger">*</span></label>
                        <textarea name="reason" class="form-control bg-light border-0 py-3" rows="4" placeholder="Jelaskan alasan penolakan bukti pembayaran..." required></textarea>
                    </div>
                </div>
                <div class="modal-footer border-top-0 pt-0">
                    <button type="button" class="btn btn-link text-secondary text-decoration-none" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-danger rounded-pill px-4">
                        Tolak Bukti
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    /* Custom Tab Styling */
    .nav-pills .nav-link {
        color: #6c757d;
        background-color: transparent;
        transition: all 0.3s ease;
    }
    .nav-pills .nav-link:hover {
        background-color: #f8f9fa;
        color: #0d6efd;
    }
    .nav-pills .nav-link.active {
        background-color: #0d6efd;
        color: #fff;
        box-shadow: 0 4px 6px rgba(13, 110, 253, 0.2);
    }
    .hover-primary:hover { background-color: #0d6efd !important; color: white !important; border-color: #0d6efd !important; }
    .hover-success:hover { background-color: #198754 !important; color: white !important; border-color: #198754 !important; }
    .hover-danger:hover { background-color: #dc3545 !important; color: white !important; border-color: #dc3545 !important; }
</style>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
function verifyPayment(id, type) {
    Swal.fire({
        title: 'Verifikasi Pembayaran?',
        text: 'Bukti pembayaran akan diverifikasi.',
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: 'Ya, Verifikasi',
        cancelButtonText: 'Batal',
        confirmButtonColor: '#198754',
        cancelButtonColor: '#6c757d'
    }).then((result) => {
        if (result.isConfirmed) {
            Swal.fire({ title: 'Memproses...', didOpen: () => Swal.showLoading() });
            
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