@extends('admin.layouts.admin')

@section('title', 'Profil Saya')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4 class="card-title mb-0">Profil Saya</h4>
                        <a href="#" class="btn btn-sm btn-outline-danger"
                            onclick="return confirm('Yakin ingin keluar?')">
                            <i class="bx bx-log-out"></i> Keluar
                        </a>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.profile.update') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div class="row">
                                <!-- Foto Profil -->
                                <div class="col-md-4">
                                    <div class="text-center mb-4">
                                        <img src="{{ $user && $user->avatar ? asset('storage/' . $user->avatar) : asset('Admin/img/avatars/hamizulf.jpg') }}"
                                            alt="Foto Profil" class="rounded-circle img-fluid"
                                            style="width: 150px; height: 150px; object-fit: cover;">
                                        <label for="avatar" class="form-label">Pilih File</label>
                                        <input type="file" class="form-control" id="avatar" name="avatar"
                                            accept="image/*">
                                        @if ($user && $user->avatar)
                                            <a href="{{ asset('storage/' . $user->avatar) }}" download
                                                class="mt-2 d-block">Unduh Foto</a>
                                        @endif
                                    </div>
                                </div>

                                <!-- Data Profil -->
                                <div class="col-md-8">
                                    <div class="mb-3">
                                        <label for="username" class="form-label">Username</label>
                                        <input type="text" class="form-control" id="username"
                                            value="{{ $user?->username ?? 'admin_user' }}" disabled>
                                    </div>
                                    <div class="mb-3">
                                        <label for="name" class="form-label">Nama Lengkap</label>
                                        <input type="text" class="form-control" id="name" name="name"
                                            value="{{ old('name', $user?->name ?? 'Admin Nama') }}" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="email" class="form-label">Email</label>
                                        <input type="email" class="form-control" id="email" name="email"
                                            value="{{ old('email', $user?->email ?? 'admin@example.com') }}" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="phone" class="form-label">No Telepon</label>
                                        <input type="text" class="form-control" id="phone" name="phone"
                                            value="{{ old('phone', $user?->phone ?? '081234567890') }}">
                                    </div>
                                    <div class="mb-3">
                                        <label for="gender" class="form-label">Jenis Kelamin</label>
                                        <select class="form-select" id="gender" name="gender">
                                            <option value="">Pilih Jenis Kelamin</option>
                                            <option value="laki-laki"
                                                {{ old('gender', $user?->gender ?? '') == 'laki-laki' ? 'selected' : '' }}>
                                                Laki-laki</option>
                                            <option value="perempuan"
                                                {{ old('gender', $user?->gender ?? '') == 'perempuan' ? 'selected' : '' }}>
                                                Perempuan</option>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="address" class="form-label">Alamat</label>
                                        <textarea class="form-control" id="address" name="address" rows="3">{{ old('address', $user?->address ?? 'Jl. Admin No. 1') }}</textarea>
                                    </div>
                                    <div class="mb-3">
                                        <label for="password" class="form-label">Kata Sandi</label>
                                        <input type="password" class="form-control" id="password" value="********"
                                            disabled>
                                        <a href="#" id="changePasswordBtn" class="mt-2 d-block">Ubah Sandi</a>
                                    </div>
                                </div>
                            </div>

                            <div class="mt-4">
                                <button type="submit" class="btn btn-primary">Simpan</button>
                                <a href="{{ route('admin.profile') }}" class="btn btn-secondary">Keluar</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Ubah Sandi -->
    <div class="modal fade" id="changePasswordModal" tabindex="-1" aria-labelledby="changePasswordModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="changePasswordModalLabel">Kata Sandi Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="changePasswordForm">
                        @csrf
                        <div class="mb-3">
                            <label for="current_password" class="form-label">Kata Sandi Lama</label>
                            <input type="password" class="form-control" id="current_password" name="current_password"
                                required>
                            <span class="toggle-password"
                                style="position: absolute; right: 10px; top: 35px; cursor: pointer;"><i
                                    class="bx bx-show"></i></span>
                        </div>
                        <div class="mb-3">
                            <label for="new_password" class="form-label">Kata Sandi Baru</label>
                            <input type="password" class="form-control" id="new_password" name="new_password" required>
                            <span class="toggle-password"
                                style="position: absolute; right: 10px; top: 35px; cursor: pointer;"><i
                                    class="bx bx-show"></i></span>
                        </div>
                        <div class="mb-3">
                            <label for="new_password_confirmation" class="form-label">Konfirmasi Kata Sandi Baru</label>
                            <input type="password" class="form-control" id="new_password_confirmation"
                                name="new_password_confirmation" required>
                            <span class="toggle-password"
                                style="position: absolute; right: 10px; top: 35px; cursor: pointer;"><i
                                    class="bx bx-show"></i></span>
                        </div>
                        <p class="text-muted text-center mt-3">Silahkan konfirmasi untuk melanjutkan</p>
                        <button type="button" id="confirmChangePasswordBtn"
                            class="btn btn-primary w-100">Konfirmasi</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Verifikasi Kode -->
    <div class="modal fade" id="otpVerificationModal" tabindex="-1" aria-labelledby="otpVerificationModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="otpVerificationModalLabel">Verifikasi Kode</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center">
                    <div class="mb-3">
                        <img src="{{ asset('admin/img/shield-lock.png') }}" alt="Lock"
                            style="width: 80px; height: 80px;">
                    </div>
                    <p>Masukkan Kode Untuk Melanjutkan</p>
                    <p class="text-muted">Silahkan masukkan kode konfirmasi yang anda terima</p>
                    <div class="d-flex justify-content-center gap-2 mb-3">
                        <input type="text" class="form-control form-control-lg text-center" maxlength="1"
                            style="width: 50px;" id="otp_1" oninput="moveToNext(this, 'otp_2')"
                            onkeydown="moveToPrev(this, 'otp_1')">
                        <input type="text" class="form-control form-control-lg text-center" maxlength="1"
                            style="width: 50px;" id="otp_2" oninput="moveToNext(this, 'otp_3')"
                            onkeydown="moveToPrev(this, 'otp_1')">
                        <input type="text" class="form-control form-control-lg text-center" maxlength="1"
                            style="width: 50px;" id="otp_3" oninput="moveToNext(this, 'otp_4')"
                            onkeydown="moveToPrev(this, 'otp_2')">
                        <input type="text" class="form-control form-control-lg text-center" maxlength="1"
                            style="width: 50px;" id="otp_4" oninput="moveToNext(this, 'otp_5')"
                            onkeydown="moveToPrev(this, 'otp_3')">
                        <input type="text" class="form-control form-control-lg text-center" maxlength="1"
                            style="width: 50px;" id="otp_5" oninput="moveToNext(this, 'otp_6')"
                            onkeydown="moveToPrev(this, 'otp_4')">
                        <input type="text" class="form-control form-control-lg text-center" maxlength="1"
                            style="width: 50px;" id="otp_6" oninput="moveToNext(this, 'otp_6')"
                            onkeydown="moveToPrev(this, 'otp_5')">
                    </div>
                    <button type="button" id="verifyOtpBtn" class="btn btn-primary w-100">Konfirmasi</button>
                    <p class="mt-3">
                        Belum Terima Kode? <a href="#" id="resendOtpBtn">Kirim Ulang Kode</a>
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Berhasil Diperbarui -->
    <div class="modal fade" id="successModal" tabindex="-1" aria-labelledby="successModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="successModalLabel">Berhasil Diperbarui</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center">
                    <img src="{{ asset('admin/img/logo-isewa.png') }}" alt="iSewa Logo"
                        style="width: 120px; height: auto; margin-bottom: 20px;">
                    <p><strong>Kata Sandi Telah Diperbarui</strong></p>
                    <p>Silahkan konfirmasi untuk melanjutkan</p>
                    <button type="button" id="closeSuccessModalBtn" class="btn btn-primary w-100">Konfirmasi</button>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const changePasswordBtn = document.getElementById('changePasswordBtn');
            const changePasswordModal = new bootstrap.Modal(document.getElementById('changePasswordModal'));
            const otpVerificationModal = new bootstrap.Modal(document.getElementById('otpVerificationModal'));
            const successModal = new bootstrap.Modal(document.getElementById('successModal'));

            // Toggle visibility of password fields
            document.querySelectorAll('.toggle-password').forEach(function(toggle) {
                toggle.addEventListener('click', function() {
                    const input = this.previousElementSibling;
                    if (input.type === 'password') {
                        input.type = 'text';
                        this.innerHTML = '<i class="bx bx-hide"></i>';
                    } else {
                        input.type = 'password';
                        this.innerHTML = '<i class="bx bx-show"></i>';
                    }
                });
            });

            // Move focus between OTP inputs
            function moveToNext(currentInput, nextId) {
                if (currentInput.value.length === 1) {
                    document.getElementById(nextId).focus();
                }
            }

            function moveToPrev(currentInput, prevId) {
                if (currentInput.value.length === 0 && currentInput.id !== 'otp_1') {
                    document.getElementById(prevId).focus();
                }
            }

            // Show change password modal
            changePasswordBtn.addEventListener('click', function(e) {
                e.preventDefault();
                changePasswordModal.show();
            });

            // Handle change password form submission
            document.getElementById('confirmChangePasswordBtn').addEventListener('click', function() {
                const formData = new FormData(document.getElementById('changePasswordForm'));
                fetch("{{ route('admin.profile.change-password') }}", {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                .getAttribute('content'),
                            'Accept': 'application/json'
                        },
                        body: formData
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            changePasswordModal.hide();
                            otpVerificationModal.show();
                        } else {
                            alert(data.message || 'Terjadi kesalahan.');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('Terjadi kesalahan jaringan.');
                    });
            });

            // Handle OTP verification
            document.getElementById('verifyOtpBtn').addEventListener('click', function() {
                const otp = [
                    document.getElementById('otp_1').value,
                    document.getElementById('otp_2').value,
                    document.getElementById('otp_3').value,
                    document.getElementById('otp_4').value,
                    document.getElementById('otp_5').value,
                    document.getElementById('otp_6').value
                ].join('');

                fetch("{{ route('admin.profile.verify-otp') }}", {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                .getAttribute('content'),
                            'Accept': 'application/json',
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify({
                            otp: otp
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            otpVerificationModal.hide();
                            successModal.show();
                        } else {
                            alert(data.message || 'Kode OTP tidak valid.');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('Terjadi kesalahan jaringan.');
                    });
            });

            // Handle resend OTP
            document.getElementById('resendOtpBtn').addEventListener('click', function(e) {
                e.preventDefault();
                fetch("{{ route('admin.profile.resend-otp') }}", {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                .getAttribute('content'),
                            'Accept': 'application/json'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        alert(data.message || 'Kode OTP telah dikirim ulang.');
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('Terjadi kesalahan jaringan.');
                    });
            });

            // Close success modal and redirect to login or refresh page
            document.getElementById('closeSuccessModalBtn').addEventListener('click', function() {
                successModal.hide();
                // alert('Password berhasil diubah!');
                window.location.reload(); // atau ganti dengan redirect ke halaman login nanti
            });
        });
    </script>
@endsection