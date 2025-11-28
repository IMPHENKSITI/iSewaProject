@extends('admin.layouts.admin')

@section('title', 'Notifikasi')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="row justify-content-center">
        <div class="col-md-10 col-lg-8">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white border-bottom d-flex justify-content-between align-items-center py-3">
                    <div>
                        <h5 class="mb-0 fw-bold">Notifikasi</h5>
                        <small class="text-muted">Pantau aktivitas terbaru sistem</small>
                    </div>
                    <div class="d-flex gap-2">
                        <a href="{{ route('admin.notifications.create') }}" class="btn btn-sm btn-primary">
                            <i class="bx bx-plus me-1"></i> Buat Baru
                        </a>
                        <form action="{{ route('admin.notifications.mark-all-read') }}" method="POST" onsubmit="return confirm('Tandai semua sebagai dibaca?')">
                            @csrf
                            @method('PUT')
                            <button type="submit" class="btn btn-sm btn-outline-secondary">
                                <i class="bx bx-check-double me-1"></i> Baca Semua
                            </button>
                        </form>
                    </div>
                </div>
                <div class="card-body p-0">
                    @if($notifications->isEmpty())
                        <div class="text-center py-5">
                            <div class="mb-3">
                                <span class="avatar avatar-xl rounded-circle bg-label-secondary">
                                    <i class="bx bx-bell-off fs-1"></i>
                                </span>
                            </div>
                            <h6 class="text-muted">Tidak ada notifikasi saat ini.</h6>
                        </div>
                    @else
                        <div class="list-group list-group-flush">
                            @foreach($notifications as $notification)
                            <div class="list-group-item list-group-item-action d-flex gap-3 py-3 {{ !$notification->is_read ? 'bg-label-primary bg-opacity-10' : '' }}">
                                <div class="avatar">
                                    <span class="avatar-initial rounded-circle {{ !$notification->is_read ? 'bg-primary' : 'bg-label-secondary' }}">
                                        <i class="bx {{ $notification->type == 'info' ? 'bx-info-circle' : ($notification->type == 'warning' ? 'bx-error' : 'bx-bell') }}"></i>
                                    </span>
                                </div>
                                <div class="d-flex w-100 justify-content-between">
                                    <div>
                                        <h6 class="mb-1 fw-bold {{ !$notification->is_read ? 'text-primary' : 'text-dark' }}">
                                            {{ $notification->title }}
                                            @if(!$notification->is_read)
                                                <span class="badge bg-danger rounded-pill ms-2" style="font-size: 0.6rem;">BARU</span>
                                            @endif
                                        </h6>
                                        <p class="mb-1 text-secondary" style="font-size: 0.9rem;">{{ $notification->message }}</p>
                                        <div class="d-flex align-items-center mt-2">
                                            <small class="text-muted me-3">
                                                <i class="bx bx-time-five me-1"></i> {{ $notification->created_at->diffForHumans() }}
                                            </small>
                                            @if($notification->user)
                                                <small class="text-muted">
                                                    <i class="bx bx-user me-1"></i> {{ $notification->user->name }}
                                                </small>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="d-flex flex-column align-items-end justify-content-center">
                                        @if(!$notification->is_read)
                                            <form action="{{ route('admin.notifications.mark-as-read', $notification->id) }}" method="POST">
                                                @csrf
                                                @method('PUT')
                                                <button type="submit" class="btn btn-sm btn-icon btn-outline-success rounded-circle" data-bs-toggle="tooltip" title="Tandai Dibaca">
                                                    <i class="bx bx-check"></i>
                                                </button>
                                            </form>
                                        @else
                                            <i class="bx bx-check-double text-success fs-4" data-bs-toggle="tooltip" title="Sudah Dibaca"></i>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        <div class="p-3 border-top">
                            {{ $notifications->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection