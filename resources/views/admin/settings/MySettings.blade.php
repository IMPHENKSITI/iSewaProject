@extends('admin.dashboard.index')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4">
        <span class="text-muted fw-light">Account Settings /</span> Security
    </h4>

    <div class="row">
        <div class="col-md-12">
            <ul class="nav nav-pills flex-column flex-md-row mb-3">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('admin.profile') }}">
                        <i class="bx bx-user me-1"></i> Account
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('admin.settings.notifications') }}">
                        <i class="bx bx-bell me-1"></i> Notifications
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('admin.settings.connections') }}">
                        <i class="bx bx-link-alt me-1"></i> Connections
                    </a>
                </li>
            </ul>

            <div class="card mb-4">
                <h5 class="card-header">Change Password</h5>
                
                <!-- Success Message -->
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible m-3" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <div class="card-body">
                    <form action="{{ route('admin.settings.update') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="mb-3 col-md-6">
                                <label for="current_password" class="form-label">Current Password</label>
                                <input class="form-control @error('current_password') is-invalid @enderror" 
                                       type="password" 
                                       id="current_password" 
                                       name="current_password" 
                                       placeholder="Enter current password" />
                                @error('current_password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="mb-3 col-md-6">
                                <label for="password" class="form-label">New Password</label>
                                <input class="form-control @error('password') is-invalid @enderror" 
                                       type="password" 
                                       id="password" 
                                       name="password" 
                                       placeholder="Enter new password" />
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="mb-3 col-md-6">
                                <label for="password_confirmation" class="form-label">Confirm New Password</label>
                                <input class="form-control" 
                                       type="password" 
                                       id="password_confirmation" 
                                       name="password_confirmation" 
                                       placeholder="Confirm new password" />
                            </div>
                        </div>
                        
                        <div class="mt-2">
                            <button type="submit" class="btn btn-primary me-2">Change Password</button>
                            <button type="reset" class="btn btn-outline-secondary">Cancel</button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Recent Activity -->
            <div class="card">
                <h5 class="card-header">Recent Activity</h5>
                <div class="card-body">
                    <ul class="list-unstyled mb-0">
                        <li class="d-flex mb-3">
                            <div class="flex-shrink-0">
                                <i class="bx bx-log-in text-primary"></i>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h6 class="mb-0">Login</h6>
                                <small class="text-muted">Last login: {{ now()->diffForHumans() }}</small>
                            </div>
                        </li>
                        <li class="d-flex mb-3">
                            <div class="flex-shrink-0">
                                <i class="bx bx-user text-success"></i>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h6 class="mb-0">Profile Updated</h6>
                                <small class="text-muted">Account created: {{ $user->created_at->format('M d, Y') }}</small>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection