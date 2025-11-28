@extends('admin.layouts.admin')

@section('title', 'Profil Saya')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Pengaturan Akun /</span> Profil Saya</h4>

        <div class="row">
            <div class="col-md-12">
                <form id="formAccountSettings" method="POST" action="{{ route('admin.profile.update') }}"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="card mb-4">
                        <h5 class="card-header">Detail Profil</h5>
                        <!-- Account -->
                        <div class="card-body">
                            <div class="d-flex align-items-start align-items-sm-center gap-4">
                                <img src="{{ $user && $user->avatar ? asset('storage/' . $user->avatar) : asset('Admin/img/avatars/hamizulf.jpg') }}"
                                    alt="user-avatar" class="d-block rounded" height="100" width="100"
                                    id="uploadedAvatar" style="object-fit: cover;" />
                                <div class="button-wrapper">
                                    <label for="upload" class="btn btn-primary me-2 mb-4" tabindex="0">
                                        <span class="d-none d-sm-block">Upload foto baru</span>
                                        <i class="bx bx-upload d-block d-sm-none"></i>
                                        <input type="file" id="upload" class="account-file-input" hidden
                                            name="avatar" accept="image/png, image/jpeg" />
                                    </label>
                                    <button type="button" class="btn btn-outline-secondary account-image-reset mb-4">
                                        <i class="bx bx-reset d-block d-sm-none"></i>
                                        <span class="d-none d-sm-block">Reset</span>
                                    </button>

                                    <p class="text-muted mb-0">Diizinkan JPG, GIF atau PNG. Ukuran maksimal 800K</p>
                                </div>
                            </div>
                        </div>
                        <hr class="my-0" />
                        <div class="card-body">
                            <div class="row">
                                <div class="mb-3 col-md-6">
                                    <label for="username" class="form-label">Username</label>
                                    <input class="form-control" type="text" id="username" name="username"
                                        value="{{ $user?->username ?? 'admin_user' }}" disabled />
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label for="email" class="form-label">E-mail</label>
                                    <input class="form-control" type="text" id="email" name="email"
                                        value="{{ old('email', $user?->email ?? 'admin@example.com') }}"
                                        placeholder="john.doe@example.com" />
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label for="firstName" class="form-label">Nama Lengkap</label>
                                    <input class="form-control" type="text" id="firstName" name="name"
                                        value="{{ old('name', $user?->name ?? 'Admin Nama') }}" autofocus />
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label for="organization" class="form-label">Perusahaan / Organisasi</label>
                                    <input type="text" class="form-control" id="organization" name="organization"
                                        value="BUMDes Pematang Duku Timur" disabled />
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label class="form-label" for="phoneNumber">Nomor Telepon</label>
                                    <div class="input-group input-group-merge">
                                        <span class="input-group-text">ID (+62)</span>
                                        <input type="text" id="phoneNumber" name="phone" class="form-control"
                                            value="{{ old('phone', $user?->phone ?? '081234567890') }}"
                                            placeholder="812 3456 7890" />
                                    </div>
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label for="address" class="form-label">Alamat</label>
                                    <input type="text" class="form-control" id="address" name="address"
                                        value="{{ old('address', $user?->address ?? 'Jl. Admin No. 1') }}"
                                        placeholder="Alamat Lengkap" />
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label for="state" class="form-label">Jenis Kelamin</label>
                                    <select id="state" class="select2 form-select" name="gender">
                                        <option value="">Pilih Jenis Kelamin</option>
                                        <option value="laki-laki"
                                            {{ old('gender', $user?->gender ?? '') == 'laki-laki' ? 'selected' : '' }}>
                                            Laki-laki</option>
                                        <option value="perempuan"
                                            {{ old('gender', $user?->gender ?? '') == 'perempuan' ? 'selected' : '' }}>
                                            Perempuan</option>
                                    </select>
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label for="zipCode" class="form-label">Jabatan</label>
                                    <input type="text" class="form-control" id="zipCode" name="zipCode"
                                        value="Direktur BUMDES" disabled />
                                </div>
                            </div>
                            <div class="mt-2">
                                <button type="submit" class="btn btn-primary me-2">Simpan Perubahan</button>
                                <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-secondary">Batal</a>
                            </div>
                        </div>
                        <!-- /Account -->
                    </div>
                    <div class="card">
                        <h5 class="card-header">Keamanan Akun</h5>
                        <div class="card-body">
                            <div class="mb-3 col-12 mb-0">
                                <div class="alert alert-warning">
                                    <h6 class="alert-heading fw-bold mb-1">Apakah Anda ingin mengubah kata sandi?</h6>
                                    <p class="mb-0">Disarankan untuk mengganti kata sandi secara berkala demi keamanan akun
                                        Anda.</p>
                                </div>
                            </div>
                            <button type="button" class="btn btn-danger deactivate-account" id="changePasswordBtn">Ubah
                                Kata Sandi</button>
                        </div>
                    </div>
                </form>
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
                        <div class="mb-3 position-relative">
                            <label for="current_password" class="form-label">Kata Sandi Lama</label>
                            <input type="password" class="form-control" id="current_password" name="current_password"
                                required>
                            <span class="toggle-password"
                                style="position: absolute; right: 10px; top: 35px; cursor: pointer;"><i
                                    class="bx bx-show"></i></span>
                        </div>
                        <div class="mb-3 position-relative">
                            <label for="new_password" class="form-label">Kata Sandi Baru</label>
                            <input type="password" class="form-control" id="new_password" name="new_password" required>
                            <span class="toggle-password"
                                style="position: absolute; right: 10px; top: 35px; cursor: pointer;"><i
                                    class="bx bx-show"></i></span>
                        </div>
                        <div class="mb-3 position-relative">
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
            // Update/Reset User Image
            let accountUserImage = document.getElementById('uploadedAvatar');
            const fileInput = document.querySelector('.account-file-input'),
                resetFileInput = document.querySelector('.account-image-reset');

            if (accountUserImage) {
                const resetImage = accountUserImage.src;

                fileInput.onchange = () => {
                    if (fileInput.files[0]) {
                        accountUserImage.src = window.URL.createObjectURL(fileInput.files[0]);
                    }
                };

                resetFileInput.onclick = () => {
                    fileInput.value = '';
                    accountUserImage.src = resetImage;
                };
            }

            // Modal & Password Logic
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
            window.moveToNext = function(currentInput, nextId) {
                if (currentInput.value.length === 1) {
                    document.getElementById(nextId).focus();
                }
            }

            window.moveToPrev = function(currentInput, prevId) {
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
                window.location.reload();
            });
        });
    </script>
@endsection