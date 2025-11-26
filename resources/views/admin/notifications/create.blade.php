@extends('admin.layouts.admin')

@section('title', 'Kirim Notifikasi')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title mb-0">Kirim Notifikasi Baru</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.notifications.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="title" class="form-label">Judul</label>
                            <input type="text" class="form-control" id="title" name="title" value="{{ old('title') }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="message" class="form-label">Pesan</label>
                            <textarea class="form-control" id="message" name="message" rows="4" required>{{ old('message') }}</textarea>
                        </div>
                        <div class="mb-3">
                            <label for="user_id" class="form-label">Kirim Kepada (Opsional - kosongkan untuk broadcast)</label>
                            <select class="form-select" id="user_id" name="user_id">
                                <option value="">Semua User</option>
                                @foreach($users as $user)
                                    <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>
                                        {{ $user->name }} ({{ $user->username }})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary">Kirim Notifikasi</button>
                        <a href="{{ route('admin.notifications.index') }}" class="btn btn-secondary">Batal</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection