@extends('admin.layouts.admin')

@section('title', 'Manajemen Pengguna')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="card-title mb-0">Daftar Pengguna</h4>
                    <span class="text-muted small">Total: {{ $users->total() }}</span>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Username</th>
                                    <th>Nama Lengkap</th>
                                    <th>Email</th>
                                    <th>No Telepon</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($users as $user)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td><strong>{{ $user->username }}</strong></td>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ $user->phone ?? '-' }}</td>
                                    <td>
                                        <span class="badge {{ $user->status === 'aktif' ? 'badge-success' : 'badge-danger' }}">
                                            {{ ucfirst($user->status) }}
                                        </span>
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.manajemen-pengguna.show', $user->id) }}" class="btn btn-sm btn-outline-primary">
                                            <i class="bx bx-detail"></i> Detail
                                        </a>
                                        <form action="{{ route('admin.manajemen-pengguna.toggle-status', $user->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Yakin ingin mengubah status akun ini?')">
                                            @csrf
                                            @method('PUT')
                                            <button type="submit" class="btn btn-sm btn-outline-{{ $user->status === 'aktif' ? 'warning' : 'info' }}">
                                                <i class="bx bx-block"></i> {{ $user->status === 'aktif' ? 'Nonaktifkan' : 'Aktifkan' }}
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    {{ $users->links() }} {{-- Pagination --}}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection