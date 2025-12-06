@extends('admin.layouts.admin')

@section('title', 'Profil Saya')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Pengaturan Akun /</span> Profil Saya</h4>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>Berhasil!</strong> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="row">
            <div class="col-md-12">
                <form id="formAccountSettings" method="POST" action="{{ route('admin.profile.update') }}"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="card mb-4 profile-card">
                        <h5 class="card-header bg-gradient-primary text-white">
                            <i class="bx bx-user-circle me-2"></i>Detail Profil
                        </h5>
                        <!-- Account -->
                        <div class="card-body">
                            <div class="d-flex align-items-start align-items-sm-center gap-4 mb-4">
                                <div class="avatar-wrapper position-relative">
                                    @if($user && $user->avatar)
                                        <img src="{{ asset('storage/' . $user->avatar) }}"
                                            alt="user-avatar" class="avatar-preview rounded-circle" 
                                            id="uploadedAvatar" />
                                    @else
                                        <div class="avatar-preview avatar-default rounded-circle" id="uploadedAvatar">
                                            <span class="avatar-initials">{{ strtoupper(substr($user->name ?? 'A', 0, 1)) }}</span>
                                        </div>
                                    @endif
                                    <div class="avatar-overlay rounded-circle">
                                        <i class="bx bx-camera"></i>
                                    </div>
                                </div>
                                <div class="button-wrapper flex-grow-1">
                                    <label for="upload" class="btn btn-primary me-2 mb-2" tabindex="0">
                                        <i class="bx bx-upload me-1"></i>
                                        <span>Upload Foto Baru</span>
                                        <input type="file" id="upload" class="account-file-input" hidden
                                            name="avatar" accept="image/png, image/jpeg, image/jpg, image/gif" />
                                    </label>
                                    <button type="button" class="btn btn-outline-secondary account-image-reset mb-2">
                                        <i class="bx bx-reset me-1"></i>
                                        <span>Reset</span>
                                    </button>

                                    <p class="text-muted mb-0 mt-2">
                                        <small><i class="bx bx-info-circle me-1"></i>Diizinkan JPG, PNG, atau GIF. Ukuran maksimal 2MB</small>
                                    </p>
                                </div>
                            </div>
                            
                            <hr class="my-4" />
                            
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label for="username" class="form-label fw-semibold">
                                        <i class="bx bx-user me-1"></i>Username
                                    </label>
                                    <input class="form-control form-control-lg" type="text" id="username" name="username"
                                        value="{{ $user->username ?? 'admin_user' }}" disabled />
                                    <small class="text-muted">Username tidak dapat diubah</small>
                                </div>
                                <div class="col-md-6">
                                    <label for="email" class="form-label fw-semibold">
                                        <i class="bx bx-envelope me-1"></i>E-mail
                                    </label>
                                    <input class="form-control form-control-lg" type="email" id="email" name="email"
                                        value="{{ old('email', $user->email ?? 'admin@example.com') }}"
                                        placeholder="admin@example.com" />
                                </div>
                                <div class="col-md-6">
                                    <label for="firstName" class="form-label fw-semibold">
                                        <i class="bx bx-id-card me-1"></i>Nama Lengkap
                                    </label>
                                    <input class="form-control form-control-lg" type="text" id="firstName" name="name"
                                        value="{{ old('name', $user->name ?? 'Admin Nama') }}" autofocus />
                                </div>
                                <div class="col-md-6">
                                    <label for="organization" class="form-label fw-semibold">
                                        <i class="bx bx-buildings me-1"></i>Perusahaan / Organisasi
                                    </label>
                                    <input type="text" class="form-control form-control-lg" id="organization" name="organization"
                                        value="BUMDes Pematang Duku Timur" disabled />
                                    <small class="text-muted">Organisasi tidak dapat diubah</small>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold" for="phoneNumber">
                                        <i class="bx bx-phone me-1"></i>Nomor Telepon
                                    </label>
                                    <div class="input-group input-group-lg">
                                        <span class="input-group-text">ID (+62)</span>
                                        <input type="text" id="phoneNumber" name="phone" class="form-control"
                                            value="{{ old('phone', $user->phone ?? '') }}"
                                            placeholder="812 3456 7890" />
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label for="address" class="form-label fw-semibold">
                                        <i class="bx bx-map me-1"></i>Alamat
                                    </label>
                                    <input type="text" class="form-control form-control-lg" id="address" name="address"
                                        value="{{ old('address', $user->address ?? '') }}"
                                        placeholder="Alamat Lengkap" />
                                </div>
                                <div class="col-md-6">
                                    <label for="state" class="form-label fw-semibold">
                                        <i class="bx bx-male-female me-1"></i>Jenis Kelamin
                                    </label>
                                    <select id="state" class="form-select form-select-lg" name="gender">
                                        <option value="">Pilih Jenis Kelamin</option>
                                        <option value="laki-laki"
                                            {{ old('gender', $user->gender ?? '') == 'laki-laki' ? 'selected' : '' }}>
                                            Laki-laki</option>
                                        <option value="perempuan"
                                            {{ old('gender', $user->gender ?? '') == 'perempuan' ? 'selected' : '' }}>
                                            Perempuan</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label for="position" class="form-label fw-semibold">
                                        <i class="bx bx-briefcase me-1"></i>Jabatan
                                    </label>
                                    <input type="text" class="form-control form-control-lg" id="position" name="position"
                                        value="{{ old('position', $user->position ?? '') }}" 
                                        placeholder="Contoh: Direktur BUMDES" />
                                    <small class="text-muted">Anda dapat mengubah jabatan sesuai posisi Anda</small>
                                </div>
                            </div>
                            <div class="mt-4 d-flex gap-2">
                                <button type="submit" class="btn btn-primary btn-lg">
                                    <i class="bx bx-save me-1"></i>Simpan Perubahan
                                </button>
                                <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-secondary btn-lg">
                                    <i class="bx bx-x me-1"></i>Batal
                                </a>
                            </div>
                        </div>
                        <!-- /Account -->
                    </div>
                    
                    <div class="card security-card">
                        <h5 class="card-header bg-gradient-warning text-white">
                            <i class="bx bx-shield me-2"></i>Keamanan Akun
                        </h5>
                        <div class="card-body">
                            <div class="alert alert-warning border-warning mb-3">
                                <h6 class="alert-heading fw-bold mb-2">
                                    <i class="bx bx-info-circle me-1"></i>Apakah Anda ingin mengubah kata sandi?
                                </h6>
                                <p class="mb-0">Disarankan untuk mengganti kata sandi secara berkala demi keamanan akun Anda.</p>
                            </div>
                            <button type="button" class="btn btn-danger btn-lg" id="changePasswordBtn">
                                <i class="bx bx-key me-1"></i>Ubah Kata Sandi
                            </button>
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
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="changePasswordModalLabel">
                        <i class="bx bx-key me-2"></i>Kata Sandi Baru
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="changePasswordForm">
                        @csrf
                        <div class="mb-3 position-relative">
                            <label for="current_password" class="form-label fw-semibold">Kata Sandi Lama</label>
                            <input type="password" class="form-control form-control-lg" id="current_password" name="current_password"
                                required>
                            <span class="toggle-password"
                                style="position: absolute; right: 10px; top: 42px; cursor: pointer;"><i
                                    class="bx bx-show"></i></span>
                        </div>
                        <div class="mb-3 position-relative">
                            <label for="new_password" class="form-label fw-semibold">Kata Sandi Baru</label>
                            <input type="password" class="form-control form-control-lg" id="new_password" name="new_password" required>
                            <span class="toggle-password"
                                style="position: absolute; right: 10px; top: 42px; cursor: pointer;"><i
                                    class="bx bx-show"></i></span>
                        </div>
                        <div class="mb-3 position-relative">
                            <label for="new_password_confirmation" class="form-label fw-semibold">Konfirmasi Kata Sandi Baru</label>
                            <input type="password" class="form-control form-control-lg" id="new_password_confirmation"
                                name="new_password_confirmation" required>
                            <span class="toggle-password"
                                style="position: absolute; right: 10px; top: 42px; cursor: pointer;"><i
                                    class="bx bx-show"></i></span>
                        </div>
                        <p class="text-muted text-center mt-3">Silahkan konfirmasi untuk melanjutkan</p>
                        <button type="button" id="confirmChangePasswordBtn"
                            class="btn btn-primary btn-lg w-100">Konfirmasi</button>
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
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="otpVerificationModalLabel">
                        <i class="bx bx-lock-alt me-2"></i>Verifikasi Kode
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center">
                    <div class="mb-3">
                        <img src="{{ asset('admin/img/shield-lock.png') }}" alt="Lock"
                            style="width: 80px; height: 80px;">
                    </div>
                    <p class="fw-bold">Masukkan Kode Untuk Melanjutkan</p>
                    <p class="text-muted">Silahkan masukkan kode konfirmasi yang anda terima</p>
                    <div class="d-flex justify-content-center gap-2 mb-3">
                        <input type="text" class="form-control form-control-lg text-center otp-input" maxlength="1"
                            style="width: 50px;" id="otp_1" oninput="moveToNext(this, 'otp_2')"
                            onkeydown="moveToPrev(this, 'otp_1')">
                        <input type="text" class="form-control form-control-lg text-center otp-input" maxlength="1"
                            style="width: 50px;" id="otp_2" oninput="moveToNext(this, 'otp_3')"
                            onkeydown="moveToPrev(this, 'otp_1')">
                        <input type="text" class="form-control form-control-lg text-center otp-input" maxlength="1"
                            style="width: 50px;" id="otp_3" oninput="moveToNext(this, 'otp_4')"
                            onkeydown="moveToPrev(this, 'otp_2')">
                        <input type="text" class="form-control form-control-lg text-center otp-input" maxlength="1"
                            style="width: 50px;" id="otp_4" oninput="moveToNext(this, 'otp_5')"
                            onkeydown="moveToPrev(this, 'otp_3')">
                        <input type="text" class="form-control form-control-lg text-center otp-input" maxlength="1"
                            style="width: 50px;" id="otp_5" oninput="moveToNext(this, 'otp_6')"
                            onkeydown="moveToPrev(this, 'otp_4')">
                        <input type="text" class="form-control form-control-lg text-center otp-input" maxlength="1"
                            style="width: 50px;" id="otp_6" oninput="moveToNext(this, 'otp_6')"
                            onkeydown="moveToPrev(this, 'otp_5')">
                    </div>
                    <button type="button" id="verifyOtpBtn" class="btn btn-primary btn-lg w-100">Konfirmasi</button>
                    <p class="mt-3">
                        Belum Terima Kode? <a href="#" id="resendOtpBtn" class="fw-bold">Kirim Ulang Kode</a>
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Berhasil Diperbarui -->
    <div class="modal fade" id="successModal" tabindex="-1" aria-labelledby="successModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-success text-white">
                    <h5 class="modal-title" id="successModalLabel">
                        <i class="bx bx-check-circle me-2"></i>Berhasil Diperbarui
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center">
                    <img src="{{ asset('admin/img/logo-isewa.png') }}" alt="iSewa Logo"
                        style="width: 120px; height: auto; margin-bottom: 20px;">
                    <p><strong>Kata Sandi Telah Diperbarui</strong></p>
                    <p>Silahkan konfirmasi untuk melanjutkan</p>
                    <button type="button" id="closeSuccessModalBtn" class="btn btn-success btn-lg w-100">Konfirmasi</button>
                </div>
            </div>
        </div>
    </div>

    <style>
        .profile-card, .security-card {
            border: none;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
            border-radius: 12px;
            overflow: hidden;
            transition: all 0.3s ease;
        }

        .profile-card:hover, .security-card:hover {
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.12);
            transform: translateY(-2px);
        }

        .bg-gradient-primary {
            background: #4a4a4a;
        }

        .bg-gradient-warning {
            background: linear-gradient(135deg, #4a4a4a 0%, #2c2c2c 100%);
        }

        .avatar-wrapper {
            position: relative;
            width: 120px;
            height: 120px;
        }

        .avatar-preview {
            width: 120px;
            height: 120px;
            object-fit: cover;
            border: 4px solid #fff;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
            transition: all 0.3s ease;
        }

        .avatar-default {
            width: 120px;
            height: 120px;
            background: linear-gradient(135deg, #0099ff 0%, #ffb300 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            border: 4px solid #fff;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }

        .avatar-initials {
            font-size: 48px;
            font-weight: bold;
            color: white;
        }

        .avatar-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 120px;
            height: 120px;
            background: rgba(0, 0, 0, 0.5);
            display: flex;
            align-items: center;
            justify-content: center;
            opacity: 0;
            transition: opacity 0.3s ease;
            cursor: pointer;
        }

        .avatar-overlay i {
            font-size: 32px;
            color: white;
        }

        .avatar-wrapper:hover .avatar-overlay {
            opacity: 1;
        }

        .avatar-wrapper:hover .avatar-preview {
            transform: scale(1.05);
        }

        .form-control-lg, .form-select-lg {
            border-radius: 8px;
            border: 2px solid #e9ecef;
            transition: all 0.3s ease;
        }

        .form-control-lg:focus, .form-select-lg:focus {
            border-color: #0099ff;
            box-shadow: 0 0 0 0.2rem rgba(0, 153, 255, 0.25);
        }

        .btn-lg {
            border-radius: 8px;
            padding: 12px 24px;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-primary {
            background: #0099ff;
            border: none;
        }

        .btn-primary:hover {
            background: #0088ee;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 153, 255, 0.4);
        }

        .btn-outline-secondary:hover {
            transform: translateY(-2px);
        }

        .otp-input {
            border: 2px solid #e9ecef;
            border-radius: 8px;
            font-size: 24px;
            font-weight: bold;
        }

        .otp-input:focus {
            border-color: #0099ff;
            box-shadow: 0 0 0 0.2rem rgba(0, 153, 255, 0.25);
        }

        .modal-content {
            border-radius: 12px;
            border: none;
            overflow: hidden;
        }

        .modal-header {
            border-bottom: none;
        }

        .toggle-password {
            z-index: 10;
        }

        .toggle-password:hover {
            color: #0099ff;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .profile-card, .security-card {
            animation: fadeInUp 0.5s ease;
        }

        .security-card {
            animation-delay: 0.1s;
        }
    </style>

@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Update/Reset User Image
            let accountUserImage = document.getElementById('uploadedAvatar');
            const fileInput = document.querySelector('.account-file-input'),
                resetFileInput = document.querySelector('.account-image-reset');

            if (accountUserImage) {
                const resetImage = accountUserImage.src || accountUserImage.innerHTML;
                const isDefaultAvatar = accountUserImage.classList.contains('avatar-default');

                fileInput.onchange = () => {
                    if (fileInput.files[0]) {
                        // Create image preview
                        const reader = new FileReader();
                        reader.onload = function(e) {
                            if (isDefaultAvatar) {
                                // Replace default avatar with image
                                accountUserImage.outerHTML = '<img src="' + e.target.result + '" alt="user-avatar" class="avatar-preview rounded-circle" id="uploadedAvatar" />';
                                accountUserImage = document.getElementById('uploadedAvatar');
                            } else {
                                accountUserImage.src = e.target.result;
                            }
                        };
                        reader.readAsDataURL(fileInput.files[0]);
                    }
                };

                resetFileInput.onclick = () => {
                    fileInput.value = '';
                    if (isDefaultAvatar) {
                        accountUserImage.innerHTML = resetImage;
                    } else {
                        accountUserImage.src = resetImage;
                    }
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