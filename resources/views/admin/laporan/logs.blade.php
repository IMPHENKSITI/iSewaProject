@extends('admin.layouts.admin')

@section('title', 'Log Aktivitas')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    
    <!-- Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h4 class="fw-bold py-3 mb-0">
                        <span class="text-muted fw-light">Laporan /</span> Log Aktivitas
                    </h4>
                    <p class="text-muted mb-0">Rekam jejak aktivitas pengguna dan sistem.</p>
                </div>
                <div class="d-flex gap-2">
                    <button class="btn btn-outline-secondary">
                        <i class="bx bx-filter-alt me-1"></i> Filter
                    </button>
                    <button class="btn btn-outline-danger">
                        <i class="bx bx-trash me-1"></i> Bersihkan Log
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- LOG TABLE -->
    <div class="card shadow-sm border-0">
        <div class="card-header bg-white border-bottom d-flex justify-content-between align-items-center">
            <h5 class="mb-0 fw-bold">Aktivitas Terbaru</h5>
            <div class="input-group input-group-sm" style="width: 250px;">
                <span class="input-group-text bg-light border-end-0"><i class="bx bx-search"></i></span>
                <input type="text" class="form-control bg-light border-start-0" placeholder="Cari aktivitas...">
            </div>
        </div>
        <div class="card-body p-0">
            @if($logs->isEmpty())
                <div class="text-center py-5">
                    <img src="{{ asset('Admin/img/illustrations/empty.png') }}" alt="No Data" width="150" class="mb-3 opacity-50">
                    <p class="text-muted">Tidak ada log aktivitas yang tercatat.</p>
                </div>
            @else
                <div class="table-responsive text-nowrap">
                    <table class="table table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>Waktu</th>
                                <th>Pengguna</th>
                                <th>Aksi</th>
                                <th>Deskripsi</th>
                                <th>IP Address</th>
                            </tr>
                        </thead>
                        <tbody class="table-border-bottom-0">
                            @foreach($logs as $log)
                                <tr>
                                    <td>
                                        <div class="d-flex flex-column">
                                            <span class="fw-semibold text-dark">{{ $log->created_at->format('d M Y') }}</span>
                                            <small class="text-muted">{{ $log->created_at->format('H:i:s') }}</small>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="avatar avatar-xs me-2">
                                                <span class="avatar-initial rounded-circle bg-label-primary">
                                                    {{ $log->user ? substr($log->user->name, 0, 1) : 'S' }}
                                                </span>
                                            </div>
                                            <span class="fw-semibold">{{ $log->user ? $log->user->name : 'System' }}</span>
                                        </div>
                                    </td>
                                    <td>
                                        @php
                                            $badgeClass = 'bg-label-primary';
                                            if(stripos($log->action, 'create') !== false || stripos($log->action, 'tambah') !== false) $badgeClass = 'bg-label-success';
                                            elseif(stripos($log->action, 'update') !== false || stripos($log->action, 'ubah') !== false) $badgeClass = 'bg-label-warning';
                                            elseif(stripos($log->action, 'delete') !== false || stripos($log->action, 'hapus') !== false) $badgeClass = 'bg-label-danger';
                                            elseif(stripos($log->action, 'login') !== false) $badgeClass = 'bg-label-info';
                                        @endphp
                                        <span class="badge {{ $badgeClass }}">{{ $log->action }}</span>
                                    </td>
                                    <td>
                                        <span class="text-truncate d-inline-block" style="max-width: 300px;" title="{{ $log->description }}">
                                            {{ $log->description }}
                                        </span>
                                    </td>
                                    <td><small class="text-muted font-monospace">192.168.1.1</small></td> <!-- Placeholder IP -->
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <!-- Pagination (Static for now) -->
                <div class="card-footer bg-white border-top py-3">
                    <nav aria-label="Page navigation">
                        <ul class="pagination justify-content-end mb-0">
                            <li class="page-item disabled">
                                <a class="page-link" href="#" tabindex="-1"><i class="bx bx-chevron-left"></i></a>
                            </li>
                            <li class="page-item active"><a class="page-link" href="#">1</a></li>
                            <li class="page-item"><a class="page-link" href="#">2</a></li>
                            <li class="page-item"><a class="page-link" href="#">3</a></li>
                            <li class="page-item">
                                <a class="page-link" href="#"><i class="bx bx-chevron-right"></i></a>
                            </li>
                        </ul>
                    </nav>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection