{{-- Modal Auth Container --}}
<div id="auth-modal-overlay"
    class="fixed inset-0 bg-black/40 backdrop-blur-sm z-50 hidden opacity-0 transition-opacity duration-300">
    <div class="flex items-center justify-center min-h-screen p-4">

        {{-- MODAL LOGIN --}}
        <div id="modal-login"
            class="modal-content bg-white rounded-3xl shadow-2xl max-w-md w-full p-8 transform scale-95 opacity-0 transition-all duration-300 hidden">
            <button type="button"
                class="modal-close absolute top-4 right-4 text-gray-400 hover:text-gray-600 transition">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>

            <div class="text-center mb-6">
                <h2 class="text-3xl font-bold text-gray-900 mb-2">Masuk</h2>
                <p class="text-gray-600">Silahkan masuk atau daftar menggunakan akun anda</p>
            </div>

            {{-- Tab Buttons --}}
            <div class="flex gap-2 mb-6">
                <button type="button" id="tab-login"
                    class="flex-1 py-2.5 rounded-full text-sm font-semibold bg-blue-500 text-white transition">
                    Masuk
                </button>
                <button type="button" id="tab-register"
                    class="flex-1 py-2.5 rounded-full text-sm font-semibold bg-gray-100 text-gray-600 hover:bg-gray-200 transition">
                    Daftar
                </button>
            </div>

            {{-- Form Login --}}
            <form id="form-login" class="space-y-4">
                <div>
                    <input type="text" name="email_or_phone" placeholder="Email / No Telepon" required
                        class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 outline-none transition">
                    <span class="text-red-500 text-sm hidden" data-error="email_or_phone"></span>
                </div>

                <div class="relative">
                    <input type="password" name="password" id="login-password" placeholder="Kata Sandi" required
                        class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 outline-none transition pr-12">
                    <button type="button"
                        class="toggle-password absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600"
                        data-target="login-password">
                        <svg class="w-5 h-5 eye-open" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                        <svg class="w-5 h-5 eye-closed hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                        </svg>
                    </button>
                    <span class="text-red-500 text-sm hidden" data-error="password"></span>
                </div>

                <div class="flex items-center justify-between text-sm">
                    <label class="flex items-center cursor-pointer">
                        <input type="checkbox" name="remember" class="mr-2 rounded">
                        <span class="text-gray-600">Ingat Saya</span>
                    </label>
                    <button type="button" id="btn-open-forgot-password" class="text-blue-500 hover:underline">Lupa Kata Sandi?</button>
                </div>

                <button type="submit"
                    class="w-full py-3 bg-blue-500 text-white rounded-full font-semibold hover:bg-blue-600 transition disabled:opacity-50 disabled:cursor-not-allowed">
                    <span class="btn-text">Masuk</span>
                    <span class="btn-loading hidden">
                        <svg class="animate-spin h-5 w-5 mx-auto" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor"
                                d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                            </path>
                        </svg>
                    </span>
                </button>
            </form>

            <div class="mt-6 text-center text-gray-600 text-sm">atau</div>

            {{-- Social Login --}}
            <div class="mt-4 space-y-3">
                <button type="button"
                    class="w-full py-3 border border-gray-300 rounded-full flex items-center justify-center gap-3 hover:bg-gray-50 transition">
                    <svg class="w-5 h-5" viewBox="0 0 24 24">
                        <path fill="#4285F4"
                            d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" />
                        <path fill="#34A853"
                            d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" />
                        <path fill="#FBBC05"
                            d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z" />
                        <path fill="#EA4335"
                            d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" />
                    </svg>
                    <span class="font-medium text-gray-700">Lanjutkan dengan Google</span>
                </button>
            </div>
        </div>

        {{-- MODAL REGISTER --}}
        <div id="modal-register"
            class="modal-content bg-white rounded-3xl shadow-2xl max-w-md w-full p-8 transform scale-95 opacity-0 transition-all duration-300 hidden relative">
            <button type="button"
                class="modal-close absolute top-4 right-4 text-gray-400 hover:text-gray-600 transition z-10">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>

            <div class="text-center mb-6">
                <h2 class="text-3xl font-bold text-gray-900 mb-2">Daftar</h2>
                <p class="text-gray-600">Silahkan masuk atau daftar menggunakan akun anda</p>
            </div>

            {{-- Tab Buttons --}}
            <div class="flex gap-2 mb-6">
                <button type="button" id="tab-login-2"
                    class="flex-1 py-2.5 rounded-full text-sm font-semibold bg-gray-100 text-gray-600 hover:bg-gray-200 transition">
                    Masuk
                </button>
                <button type="button" id="tab-register-2"
                    class="flex-1 py-2.5 rounded-full text-sm font-semibold bg-blue-500 text-white transition">
                    Daftar
                </button>
            </div>

            {{-- Form Register --}}
            <form id="form-register" class="space-y-3 max-h-96 overflow-y-auto pr-2">
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <input type="text" name="username" placeholder="Username" required
                            class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 outline-none transition text-sm">
                        <span class="text-red-500 text-xs hidden" data-error="username"></span>
                    </div>
                    <div>
                        <input type="email" name="email" placeholder="Email" required
                            class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 outline-none transition text-sm">
                        <span class="text-red-500 text-xs hidden" data-error="email"></span>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <input type="text" name="name" placeholder="Nama Lengkap" required
                            class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 outline-none transition text-sm">
                        <span class="text-red-500 text-xs hidden" data-error="name"></span>
                    </div>
                    <div>
                        <input type="tel" name="phone" placeholder="No Telepon" required
                            class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 outline-none transition text-sm">
                        <span class="text-red-500 text-xs hidden" data-error="phone"></span>
                    </div>
                </div>

                <div>
                    <textarea name="address" placeholder="Alamat" required rows="2"
                        class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 outline-none transition text-sm resize-none"></textarea>
                    <span class="text-red-500 text-xs hidden" data-error="address"></span>
                </div>

                <div>
                    <select name="gender" required
                        class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 outline-none transition text-sm">
                        <option value="">Jenis Kelamin</option>
                        <option value="laki-laki">Laki-laki</option>
                        <option value="perempuan">Perempuan</option>
                    </select>
                    <span class="text-red-500 text-xs hidden" data-error="gender"></span>
                </div>

                <div class="relative">
                    <input type="password" name="password" id="register-password" placeholder="Kata Sandi" required
                        class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 outline-none transition text-sm pr-12">
                    <button type="button"
                        class="toggle-password absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600"
                        data-target="register-password">
                        <svg class="w-5 h-5 eye-open" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                        <svg class="w-5 h-5 eye-closed hidden" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                        </svg>
                    </button>
                    <span class="text-red-500 text-xs hidden" data-error="password"></span>
                </div>

                <div class="relative">
                    <input type="password" name="password_confirmation" id="register-password-confirm"
                        placeholder="Konfirmasi Kata Sandi" required
                        class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 outline-none transition text-sm pr-12">
                    <button type="button"
                        class="toggle-password absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600"
                        data-target="register-password-confirm">
                        <svg class="w-5 h-5 eye-open" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                        <svg class="w-5 h-5 eye-closed hidden" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                        </svg>
                    </button>
                    <span class="text-red-500 text-xs hidden" data-error="password_confirmation"></span>
                </div>

                <button type="submit"
                    class="w-full py-3 bg-blue-500 text-white rounded-full font-semibold hover:bg-blue-600 transition disabled:opacity-50 disabled:cursor-not-allowed">
                    <span class="btn-text">Daftar</span>
                    <span class="btn-loading hidden">
                        <svg class="animate-spin h-5 w-5 mx-auto" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor"
                                d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                            </path>
                        </svg>
                    </span>
                </button>
            </form>
        </div>

        {{-- MODAL OTP VERIFICATION --}}
        <div id="modal-otp"
            class="modal-content bg-white rounded-3xl shadow-2xl max-w-md w-full p-8 transform scale-95 opacity-0 transition-all duration-300 hidden relative">
            <button type="button"
                class="modal-close absolute top-4 right-4 text-gray-400 hover:text-gray-600 transition">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>

            <div class="text-center mb-8">
                <div class="w-20 h-20 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-10 h-10 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                    </svg>
                </div>
                <h2 class="text-2xl font-bold text-gray-900 mb-2">Verifikasi Kode</h2>
                <p class="text-gray-600 text-sm">Masukkan Kode Untuk Melanjutkan</p>
                <p class="text-sm text-gray-500 mt-2">Silahkan masukkan kode konfirmasi yang anda terima</p>
            </div>

            <form id="form-otp" class="space-y-6">
                <input type="hidden" name="user_id" id="otp-user-id">

                {{-- OTP Input Boxes --}}
                <div class="flex justify-center gap-3">
                    <input type="text" maxlength="1"
                        class="otp-input w-14 h-14 text-center text-2xl font-bold border-2 border-gray-300 rounded-lg focus:border-blue-500 focus:ring-2 focus:ring-blue-200 outline-none transition"
                        data-index="0">
                    <input type="text" maxlength="1"
                        class="otp-input w-14 h-14 text-center text-2xl font-bold border-2 border-gray-300 rounded-lg focus:border-blue-500 focus:ring-2 focus:ring-blue-200 outline-none transition"
                        data-index="1">
                    <input type="text" maxlength="1"
                        class="otp-input w-14 h-14 text-center text-2xl font-bold border-2 border-gray-300 rounded-lg focus:border-blue-500 focus:ring-2 focus:ring-blue-200 outline-none transition"
                        data-index="2">
                    <input type="text" maxlength="1"
                        class="otp-input w-14 h-14 text-center text-2xl font-bold border-2 border-gray-300 rounded-lg focus:border-blue-500 focus:ring-2 focus:ring-blue-200 outline-none transition"
                        data-index="3">
                </div>

                <button type="submit"
                    class="w-full py-3 bg-blue-500 text-white rounded-full font-semibold hover:bg-blue-600 transition disabled:opacity-50 disabled:cursor-not-allowed">
                    <span class="btn-text">Konfirmasi</span>
                    <span class="btn-loading hidden">
                        <svg class="animate-spin h-5 w-5 mx-auto" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor"
                                d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                            </path>
                        </svg>
                    </span>
                </button>

                <div class="text-center">
                    <p class="text-sm text-gray-600">Belum Terima Kode?
                        <button type="button" id="btn-resend-otp" class="text-blue-500 hover:underline font-medium">
                            Kirim Ulang Kode
                        </button>
                    </p>
                </div>
            </form>
        </div>

        {{-- MODAL SUCCESS --}}
        <div id="modal-success"
            class="modal-content bg-white rounded-3xl shadow-2xl max-w-md w-full p-8 transform scale-95 opacity-0 transition-all duration-300 hidden relative">
            <div class="text-center">
                <div class="w-24 h-24 mx-auto mb-6">
                    <img src="{{ asset('User/img/logo/iSewa.png') }}" alt="iSewa Logo"
                        class="w-full h-full object-contain">
                </div>

                <h2 class="text-2xl font-bold text-gray-900 mb-3">Selamat Datang</h2>
                <p class="text-gray-600 mb-2">Pembuatan Akun Berhasil</p>
                <p class="text-sm text-gray-500">Silahkan konfirmasi untuk melanjutkan</p>

                <button type="button" id="btn-confirm-success"
                    class="mt-8 w-full py-3 bg-blue-500 text-white rounded-full font-semibold hover:bg-blue-600 transition">
                    Konfirmasi
                </button>
            </div>
        </div>
        
        {{-- MODAL FORGOT PASSWORD STEP 1: Input Email --}}
        <div id="modal-forgot-password"
            class="modal-content bg-white rounded-3xl shadow-2xl max-w-md w-full p-8 transform scale-95 opacity-0 transition-all duration-300 hidden relative">
            <button type="button"
                class="modal-close absolute top-4 right-4 text-gray-400 hover:text-gray-600 transition">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>

            <div class="text-center mb-8">
                <h2 class="text-2xl font-bold text-gray-900 mb-2">Lupa Kata Sandi</h2>
                <p class="text-sm text-gray-600">Masukkan Email terkait untuk perbarui Password</p>
            </div>

            <div class="flex justify-center mb-8">
                <img src="{{ asset('User/img/logo/iSewa.png') }}" alt="iSewa Logo" class="h-24">
            </div>

            <form id="form-forgot-password" class="space-y-6">
                <div>
                    <input type="email" name="email" placeholder="Email" required
                        class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 outline-none transition">
                    <span class="text-red-500 text-sm hidden" data-error="email"></span>
                </div>

                <button type="submit"
                    class="w-full py-3 bg-blue-500 text-white rounded-full font-semibold hover:bg-blue-600 transition disabled:opacity-50 disabled:cursor-not-allowed">
                    <span class="btn-text">Masuk</span>
                    <span class="btn-loading hidden">
                        <svg class="animate-spin h-5 w-5 mx-auto" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor"
                                d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                            </path>
                        </svg>
                    </span>
                </button>
            </form>
        </div>

        {{-- MODAL FORGOT PASSWORD STEP 2: Verify OTP --}}
        <div id="modal-forgot-otp"
            class="modal-content bg-white rounded-3xl shadow-2xl max-w-md w-full p-8 transform scale-95 opacity-0 transition-all duration-300 hidden relative">
            <button type="button"
                class="modal-close absolute top-4 right-4 text-gray-400 hover:text-gray-600 transition">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>

            <div class="text-center mb-8">
                <h2 class="text-2xl font-bold text-gray-900 mb-4">Verifikasi Kode</h2>

                <div class="w-24 h-24 mx-auto mb-6">
                    <svg viewBox="0 0 100 100" class="w-full h-full">
                        <defs>
                            <linearGradient id="shieldGradient" x1="0%" y1="0%" x2="0%"
                                y2="100%">
                                <stop offset="0%" style="stop-color:#3b82f6;stop-opacity:1" />
                                <stop offset="100%" style="stop-color:#1d4ed8;stop-opacity:1" />
                            </linearGradient>
                        </defs>
                        <path d="M50 10 L20 25 L20 50 Q20 75 50 90 Q80 75 80 50 L80 25 Z" fill="url(#shieldGradient)"
                            stroke="#1e40af" stroke-width="2" />
                        <rect x="40" y="35" width="20" height="25" rx="2" fill="white" />
                        <circle cx="50" cy="42" r="3" fill="#3b82f6" />
                        <rect x="47" y="45" width="6" height="12" rx="1" fill="#3b82f6" />
                    </svg>
                </div>

                <p class="text-base font-semibold text-gray-900 mb-2">Masukkan Kode Untuk Melanjutkan</p>
                <p class="text-sm text-gray-500">Silahkan masukkan kode konfirmasi yang anda terima</p>
            </div>

            <form id="form-forgot-otp" class="space-y-6">
                {{-- OTP Input Boxes --}}
                <div class="flex justify-center gap-3">
                    <input type="text" maxlength="1"
                        class="forgot-otp-input w-14 h-14 text-center text-2xl font-bold border-2 border-gray-300 rounded-lg focus:border-blue-500 focus:ring-2 focus:ring-blue-200 outline-none transition"
                        data-index="0">
                    <input type="text" maxlength="1"
                        class="forgot-otp-input w-14 h-14 text-center text-2xl font-bold border-2 border-gray-300 rounded-lg focus:border-blue-500 focus:ring-2 focus:ring-blue-200 outline-none transition"
                        data-index="1">
                    <input type="text" maxlength="1"
                        class="forgot-otp-input w-14 h-14 text-center text-2xl font-bold border-2 border-gray-300 rounded-lg focus:border-blue-500 focus:ring-2 focus:ring-blue-200 outline-none transition"
                        data-index="2">
                    <input type="text" maxlength="1"
                        class="forgot-otp-input w-14 h-14 text-center text-2xl font-bold border-2 border-gray-300 rounded-lg focus:border-blue-500 focus:ring-2 focus:ring-blue-200 outline-none transition"
                        data-index="3">
                </div>

                <button type="submit"
                    class="w-full py-3 bg-blue-500 text-white rounded-full font-semibold hover:bg-blue-600 transition disabled:opacity-50 disabled:cursor-not-allowed">
                    <span class="btn-text">Konfirmasi</span>
                    <span class="btn-loading hidden">
                        <svg class="animate-spin h-5 w-5 mx-auto" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor"
                                d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                            </path>
                        </svg>
                    </span>
                </button>

                <div class="text-center">
                    <p class="text-sm text-gray-600">Belum Terima Kode?
                        <button type="button" id="btn-resend-forgot-otp"
                            class="text-blue-500 hover:underline font-medium">
                            Kirim Ulang Kode
                        </button>
                    </p>
                </div>
            </form>
        </div>

        {{-- MODAL FORGOT PASSWORD STEP 3: New Password --}}
        <div id="modal-forgot-new-password"
            class="modal-content bg-white rounded-3xl shadow-2xl max-w-md w-full p-8 transform scale-95 opacity-0 transition-all duration-300 hidden relative">
            <button type="button"
                class="modal-close absolute top-4 right-4 text-gray-400 hover:text-gray-600 transition">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>

            <div class="text-center mb-8">
                <h2 class="text-2xl font-bold text-gray-900 mb-2">Kata Sandi Baru</h2>
            </div>

            <form id="form-forgot-new-password" class="space-y-4">
                <div class="relative">
                    <input type="password" name="new_password" id="forgot-new-password"
                        placeholder="Kata Sandi Baru" required
                        class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 outline-none transition pr-12">
                    <button type="button"
                        class="toggle-password absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600"
                        data-target="forgot-new-password">
                        <svg class="w-5 h-5 eye-open" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                        <svg class="w-5 h-5 eye-closed hidden" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                        </svg>
                    </button>
                    <span class="text-red-500 text-sm hidden" data-error="new_password"></span>
                </div>

                <div class="relative">
                    <input type="password" name="new_password_confirmation" id="forgot-new-password-confirm"
                        placeholder="Konfirmasi Kata Sandi Baru" required
                        class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 outline-none transition pr-12">
                    <button type="button"
                        class="toggle-password absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600"
                        data-target="forgot-new-password-confirm">
                        <svg class="w-5 h-5 eye-open" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                        <svg class="w-5 h-5 eye-closed hidden" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                        </svg>
                    </button>
                    <span class="text-red-500 text-sm hidden" data-error="new_password_confirmation"></span>
                </div>

                <p class="text-sm text-gray-500 text-center">Silahkan konfirmasi untuk melanjutkan</p>

                <button type="submit"
                    class="w-full py-3 bg-blue-500 text-white rounded-full font-semibold hover:bg-blue-600 transition disabled:opacity-50 disabled:cursor-not-allowed">
                    <span class="btn-text">Konfirmasi</span>
                    <span class="btn-loading hidden">
                        <svg class="animate-spin h-5 w-5 mx-auto" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor"
                                d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                            </path>
                        </svg>
                    </span>
                </button>
            </form>
        </div>

        {{-- MODAL FORGOT PASSWORD STEP 4: Success --}}
        <div id="modal-forgot-success"
            class="modal-content bg-white rounded-3xl shadow-2xl max-w-md w-full p-8 transform scale-95 opacity-0 transition-all duration-300 hidden relative">
            <div class="text-center">
                <h2 class="text-2xl font-bold text-gray-900 mb-6">Berhasil Diperbarui</h2>

                <div class="w-32 h-32 mx-auto mb-6">
                    <img src="{{ asset('User/img/logo/iSewa.png') }}" alt="iSewa Logo"
                        class="w-full h-full object-contain">
                </div>

                <p class="text-lg font-semibold text-gray-900 mb-2">Kata Sandi Telah Diperbarui</p>
                <p class="text-sm text-gray-500 mb-8">Silahkan konfirmasi untuk melanjutkan</p>

                <button type="button" id="btn-confirm-forgot-success"
                    class="w-full py-3 bg-blue-500 text-white rounded-full font-semibold hover:bg-blue-600 transition">
                    Konfirmasi
                </button>
            </div>
        </div>
    </div>
</div>

<style>
    /* Modal Animation */
    #auth-modal-overlay.show {
        opacity: 1;
    }

    #auth-modal-overlay.show .modal-content {
        transform: scale(1);
        opacity: 1;
    }

    /* Custom scrollbar untuk form register */
    #form-register::-webkit-scrollbar {
        width: 6px;
    }

    #form-register::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 10px;
    }

    #form-register::-webkit-scrollbar-thumb {
        background: #cbd5e1;
        border-radius: 10px;
    }

    #form-register::-webkit-scrollbar-thumb:hover {
        background: #94a3b8;
    }

    /* OTP Input Animation */
    .otp-input:focus {
        animation: pulse 0.3s ease-in-out;
    }

    @keyframes pulse {

        0%,
        100% {
            transform: scale(1);
        }

        50% {
            transform: scale(1.05);
        }
    }
</style>
