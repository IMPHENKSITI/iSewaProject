<script>
document.addEventListener('DOMContentLoaded', function() {
    const overlay = document.getElementById('auth-modal-overlay');
    const modalLogin = document.getElementById('modal-login');
    const modalRegister = document.getElementById('modal-register');
    const modalOtp = document.getElementById('modal-otp');
    const modalSuccess = document.getElementById('modal-success');

    // ========================================
    // UTILITY FUNCTIONS
    // ========================================
    function openModal(modal) {
        document.querySelectorAll('.modal-content').forEach(m => {
            m.classList.add('hidden');
            m.classList.remove('scale-100', 'opacity-100');
        });

        overlay.classList.remove('hidden');
        setTimeout(() => {
            overlay.classList.add('show');
            modal.classList.remove('hidden');
            setTimeout(() => {
                modal.classList.add('scale-100', 'opacity-100');
            }, 50);
        }, 10);
    }

    function closeModal() {
        overlay.classList.remove('show');
        setTimeout(() => {
            overlay.classList.add('hidden');
            document.querySelectorAll('.modal-content').forEach(m => {
                m.classList.add('hidden');
                m.classList.remove('scale-100', 'opacity-100');
            });
        }, 300);
    }

    // ⭐ FIX: SMOOTH MODAL SWITCH (Tanpa Hilang)
    function switchModal(fromModal, toModal) {
        fromModal.classList.remove('scale-100', 'opacity-100');
        fromModal.classList.add('scale-95', 'opacity-0');
        
        setTimeout(() => {
            fromModal.classList.add('hidden');
            toModal.classList.remove('hidden');
            
            setTimeout(() => {
                toModal.classList.remove('scale-95', 'opacity-0');
                toModal.classList.add('scale-100', 'opacity-100');
            }, 50);
        }, 200);
    }

    function showError(form, field, message) {
        const errorSpan = form.querySelector(`[data-error="${field}"]`);
        if (errorSpan) {
            errorSpan.textContent = message;
            errorSpan.classList.remove('hidden');
            
            // ⭐ FIX: Auto-hide setelah 3 detik
            setTimeout(() => {
                errorSpan.classList.add('opacity-0');
                setTimeout(() => {
                    errorSpan.classList.add('hidden');
                    errorSpan.classList.remove('opacity-0');
                }, 300);
            }, 3000);
        }
    }

    function clearErrors(form) {
        form.querySelectorAll('[data-error]').forEach(span => {
            span.textContent = '';
            span.classList.add('hidden');
        });
    }

    function setButtonLoading(button, loading) {
        const btnText = button.querySelector('.btn-text');
        const btnLoading = button.querySelector('.btn-loading');
        
        if (loading) {
            btnText.classList.add('hidden');
            btnLoading.classList.remove('hidden');
            button.disabled = true;
        } else {
            btnText.classList.remove('hidden');
            btnLoading.classList.add('hidden');
            button.disabled = false;
        }
    }

    function showToast(message, type = 'success') {
        const toast = document.createElement('div');
        toast.className = `fixed top-4 right-4 px-6 py-3 rounded-lg shadow-lg text-white z-[60] transform transition-all duration-300 translate-x-full ${
            type === 'success' ? 'bg-green-500' : 'bg-red-500'
        }`;
        toast.textContent = message;
        document.body.appendChild(toast);

        setTimeout(() => toast.classList.remove('translate-x-full'), 100);
        setTimeout(() => {
            toast.classList.add('translate-x-full');
            setTimeout(() => toast.remove(), 300);
        }, 3000);
    }

    // ========================================
    // MODAL TRIGGERS
    // ========================================
    document.getElementById('btn-open-login')?.addEventListener('click', () => openModal(modalLogin));
    document.getElementById('btn-open-register')?.addEventListener('click', () => openModal(modalRegister));
    
    document.getElementById('btn-open-login-mobile')?.addEventListener('click', () => {
        document.getElementById('mobile-sidebar')?.classList.add('-translate-x-full');
        setTimeout(() => openModal(modalLogin), 300);
    });
    
    document.getElementById('btn-open-register-mobile')?.addEventListener('click', () => {
        document.getElementById('mobile-sidebar')?.classList.add('-translate-x-full');
        setTimeout(() => openModal(modalRegister), 300);
    });

    document.querySelectorAll('.modal-close').forEach(btn => {
        btn.addEventListener('click', closeModal);
    });

    overlay.addEventListener('click', function(e) {
        if (e.target === overlay) closeModal();
    });

    // ========================================
    // TAB SWITCHING - ⭐ SMOOTH!
    // ========================================
    document.getElementById('tab-login')?.addEventListener('click', () => switchModal(modalRegister, modalLogin));
    document.getElementById('tab-register')?.addEventListener('click', () => switchModal(modalLogin, modalRegister));
    document.getElementById('tab-login-2')?.addEventListener('click', () => switchModal(modalRegister, modalLogin));
    document.getElementById('tab-register-2')?.addEventListener('click', () => switchModal(modalLogin, modalRegister));

    // ========================================
    // PASSWORD TOGGLE
    // ========================================
    document.querySelectorAll('.toggle-password').forEach(btn => {
        btn.addEventListener('click', function() {
            const targetId = this.getAttribute('data-target');
            const input = document.getElementById(targetId);
            const eyeOpen = this.querySelector('.eye-open');
            const eyeClosed = this.querySelector('.eye-closed');

            if (input.type === 'password') {
                input.type = 'text';
                eyeOpen.classList.add('hidden');
                eyeClosed.classList.remove('hidden');
            } else {
                input.type = 'password';
                eyeOpen.classList.remove('hidden');
                eyeClosed.classList.add('hidden');
            }
        });
    });

    // ========================================
    // LOGIN FORM
    // ========================================
    const formLogin = document.getElementById('form-login');
    formLogin?.addEventListener('submit', async function(e) {
        e.preventDefault();
        clearErrors(this);

        const formData = new FormData(this);
        const submitBtn = this.querySelector('button[type="submit"]');
        setButtonLoading(submitBtn, true);

        try {
            const response = await fetch('{{ route('auth.login') }}', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json',
                },
                body: formData
            });

            const data = await response.json();

            if (response.ok) {
                showToast(data.message, 'success');
                closeModal();
                setTimeout(() => window.location.href = data.redirect, 1000);
            } else {
                if (data.errors) {
                    Object.keys(data.errors).forEach(field => {
                        showError(this, field, data.errors[field][0]);
                    });
                } else {
                    showToast(data.message || 'Login gagal', 'error');
                }
            }
        } catch (error) {
            console.error('Login error:', error);
            showToast('Terjadi kesalahan', 'error');
        } finally {
            setButtonLoading(submitBtn, false);
        }
    });

    // ========================================
    // REGISTER FORM
    // ========================================
    const formRegister = document.getElementById('form-register');
    let registeredUserId = null;

    formRegister?.addEventListener('submit', async function(e) {
        e.preventDefault();
        clearErrors(this);

        const formData = new FormData(this);
        const submitBtn = this.querySelector('button[type="submit"]');
        setButtonLoading(submitBtn, true);

        try {
            const response = await fetch('{{ route('auth.register') }}', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json',
                },
                body: formData
            });

            const data = await response.json();

            if (response.ok) {
                registeredUserId = data.data.temp_user_id;
                document.getElementById('otp-user-id').value = registeredUserId;
                
                alert('🔑 OTP Anda: ' + data.data.otp);
                showToast(data.message, 'success');
                
                setTimeout(() => {
                    switchModal(modalRegister, modalOtp);
                    document.querySelector('.otp-input[data-index="0"]')?.focus();
                }, 500);
            } else {
                if (data.errors) {
                    Object.keys(data.errors).forEach(field => {
                        showError(this, field, data.errors[field][0]);
                    });
                } else {
                    showToast(data.message || 'Registrasi gagal', 'error');
                }
            }
        } catch (error) {
            console.error('Register error:', error);
            showToast('Terjadi kesalahan', 'error');
        } finally {
            setButtonLoading(submitBtn, false);
        }
    });

    // ========================================
    // OTP INPUT HANDLING
    // ========================================
    const otpInputs = document.querySelectorAll('.otp-input');
    
    otpInputs.forEach((input, index) => {
        input.addEventListener('input', function(e) {
            const value = e.target.value;
            if (!/^\d*$/.test(value)) {
                e.target.value = '';
                return;
            }
            if (value.length === 1 && index < otpInputs.length - 1) {
                otpInputs[index + 1].focus();
            }
        });

        input.addEventListener('keydown', function(e) {
            if (e.key === 'Backspace' && !e.target.value && index > 0) {
                otpInputs[index - 1].focus();
            }
        });

        input.addEventListener('paste', function(e) {
            e.preventDefault();
            const pasteData = e.clipboardData.getData('text').trim();
            if (/^\d{4}$/.test(pasteData)) {
                pasteData.split('').forEach((char, i) => {
                    if (otpInputs[i]) otpInputs[i].value = char;
                });
                otpInputs[3].focus();
            }
        });
    });

    // ========================================
    // OTP VERIFICATION
    // ========================================
    const formOtp = document.getElementById('form-otp');
    formOtp?.addEventListener('submit', async function(e) {
        e.preventDefault();

        const otp = Array.from(otpInputs).map(input => input.value).join('');
        if (otp.length !== 4) {
            showToast('Kode OTP harus 4 digit', 'error');
            return;
        }

        const tempUserId = document.getElementById('otp-user-id').value;
        const submitBtn = this.querySelector('button[type="submit"]');
        setButtonLoading(submitBtn, true);

        try {
            const response = await fetch('{{ route('auth.verify-otp') }}', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                },
                body: JSON.stringify({
                    temp_user_id: tempUserId,
                    otp: otp
                })
            });

            const data = await response.json();

            if (response.ok) {
                showToast(data.message, 'success');
                switchModal(modalOtp, modalSuccess);
            } else {
                showToast(data.message || 'Verifikasi gagal', 'error');
                otpInputs.forEach(input => input.value = '');
                otpInputs[0].focus();
            }
        } catch (error) {
            console.error('OTP error:', error);
            showToast('Terjadi kesalahan', 'error');
        } finally {
            setButtonLoading(submitBtn, false);
        }
    });

    // ========================================
    // RESEND OTP
    // ========================================
    document.getElementById('btn-resend-otp')?.addEventListener('click', async function() {
        const tempUserId = document.getElementById('otp-user-id').value;
        this.disabled = true;

        try {
            const response = await fetch('{{ route('auth.resend-otp') }}', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                },
                body: JSON.stringify({ temp_user_id: tempUserId })
            });

            const data = await response.json();

            if (response.ok) {
                showToast(data.message, 'success');
                if (data.data && data.data.otp) {
                    alert('🔑 OTP Baru: ' + data.data.otp);
                }
                otpInputs.forEach(input => input.value = '');
                otpInputs[0].focus();
            } else {
                showToast(data.message || 'Gagal kirim OTP', 'error');
            }
        } catch (error) {
            console.error('Resend error:', error);
            showToast('Terjadi kesalahan', 'error');
        } finally {
            setTimeout(() => this.disabled = false, 30000);
        }
    });

    // ========================================
    // SUCCESS CONFIRMATION
    // ========================================
    document.getElementById('btn-confirm-success')?.addEventListener('click', function() {
        closeModal();
        setTimeout(() => window.location.href = '{{ route('beranda') }}', 300);
    });
});
</script>