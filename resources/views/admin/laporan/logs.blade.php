@extends('admin.layouts.admin')

@section('title', 'Log Aktivitas')

@section('content')
<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-12 col-lg-10">
            <!-- HEADER -->
            <h2 class="text-primary fw-bold mb-4">Log Aktivitas</h2>
            <p class="text-muted mb-4">Catatan semua aktivitas sistem oleh admin dan user.</p>

            <!-- LOG TABLE -->
            <div class="card shadow-sm border-0 rounded-4">
                <div class="card-header bg-white border-bottom">
                    <h5 class="mb-0">Aktivitas Terbaru</h5>
                </div>
                <div class="card-body p-3">
                    @if($logs->isEmpty())
                        <p class="text-center text-muted">Tidak ada log aktivitas.</p>
                    @else
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>Waktu</th>
                                        <th>User</th>
                                        <th>Aksi</th>
                                        <th>Deskripsi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($logs as $log)
                                        <tr>
                                            <td>{{ $log->created_at->format('d M Y H:i') }}</td>
                                            <td>{{ $log->user ? $log->user->name : 'System' }}</td>
                                            <td><span class="badge bg-primary">{{ $log->action }}</span></td>
                                            <td>{{ $log->description }}</td>
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
@endsection