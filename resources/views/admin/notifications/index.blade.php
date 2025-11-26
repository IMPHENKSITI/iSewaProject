@extends('admin.layouts.admin')

@section('title', 'Notifikasi')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="card-title mb-0">Daftar Notifikasi</h4>
                    <div>
                        <a href="{{ route('admin.notifications.create') }}" class="btn btn-sm btn-primary">
                            <i class="bx bx-plus"></i> Kirim Notifikasi
                        </a>
                        <a href="{{ route('admin.notifications.mark-all-read') }}" class="btn btn-sm btn-outline-secondary" onclick="return confirm('Yakin ingin menandai semua notifikasi sebagai dibaca?')">
                            <i class="bx bx-check-double"></i> Tandai Semua Dibaca
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    @if($notifications->isEmpty())
                        <p class="text-center text-muted">Tidak ada notifikasi.</p>
                    @else
                        <div class="list-group list-group-flush">
                            @foreach($notifications as $notification)
                            <div class="list-group-item d-flex justify-content-between align-items-start {{ !$notification->is_read ? 'list-group-item-primary' : '' }}">
                                <div class="ms-2 me-auto">
                                    <div class="fw-bold">{{ $notification->title }}</div>
                                    <p class="mb-1">{{ $notification->message }}</p>
                                    <small class="text-muted">
                                        Tipe: {{ ucfirst(str_replace('_', ' ', $notification->type)) }}
                                        @if($notification->user)
                                            | Untuk: {{ $notification->user->name }}
                                        @endif
                                        @if($notification->admin)
                                            | Dari: {{ $notification->admin->name }}
                                        @endif
                                    </small>
                                </div>
                                <div class="d-flex flex-column align-items-end">
                                    <small class="text-muted">{{ $notification->created_at->diffForHumans() }}</small>
                                    @if(!$notification->is_read)
                                        <form action="{{ route('admin.notifications.mark-as-read', $notification->id) }}" method="POST" style="display:inline;">
                                            @csrf
                                            @method('PUT')
                                            <button type="submit" class="btn btn-sm btn-outline-success mt-1">Tandai Dibaca</button>
                                        </form>
                                    @else
                                        <span class="badge bg-success mt-1">Dibaca</span>
                                    @endif
                                </div>
                            </div>
                            @endforeach
                        </div>

                        {{ $notifications->links() }} {{-- Pagination --}}
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection