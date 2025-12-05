@extends('layouts.app')

@section('content')
    {{-- USER NAVBAR --}}
    @include('partials.navbar')

    <main class="flex-grow relative w-full">
        @yield('page')
    </main>

    {{-- USER FOOTER --}}
    @include('partials.footer')

    {{-- AUTH MODALS --}}
    @include('auth.modals')

@endsection

@push('scripts')
    {{-- Global Scripts (Inline to avoid cache issues) --}}
    <script>
        /**
         * Navbar & Mobile Menu Functionality
         */
        // Navbar & Sidebar Logic
        const Navbar = {
            init() {
                this.initSidebar();
                this.initMobileDropdowns();
                this.initScrollEffect();
            },

            // Mobile Sidebar
            initSidebar() {
                const menuBtn = document.getElementById('mobile-menu-btn');
                const sidebar = document.getElementById('mobile-sidebar');
                const overlay = document.getElementById('mobile-overlay');
                const closeBtn = document.getElementById('sidebar-close');

                if (!menuBtn || !sidebar || !overlay) return;

                const openSidebar = () => {
                    sidebar.classList.remove('-translate-x-full');
                    overlay.classList.remove('hidden');
                    setTimeout(() => overlay.classList.remove('opacity-0'), 10);
                    document.body.style.overflow = 'hidden';
                };

                const closeSidebar = () => {
                    sidebar.classList.add('-translate-x-full');
                    overlay.classList.add('opacity-0');
                    setTimeout(() => overlay.classList.add('hidden'), 300);
                    document.body.style.overflow = '';
                };

                menuBtn.addEventListener('click', openSidebar);
                closeBtn?.addEventListener('click', closeSidebar);
                overlay.addEventListener('click', closeSidebar);

                // Close on link click
                sidebar.querySelectorAll('a:not(#bumdes-toggle)').forEach(link => {
                    link.addEventListener('click', closeSidebar);
                });
            },

            // Mobile Dropdowns (BUMDes)
            initMobileDropdowns() {
                const toggle = document.getElementById('bumdes-toggle');
                const subMenu = document.getElementById('bumdes-sub');
                const arrow = document.getElementById('bumdes-arrow');

                if (!toggle || !subMenu) return;

                toggle.addEventListener('click', () => {
                    subMenu.classList.toggle('hidden');
                    if (arrow) {
                        arrow.classList.toggle('rotate-180');
                    }
                });
            },

            // Navbar Scroll Effect
            initScrollEffect() {
                const navbar = document.querySelector('nav');
                if (!navbar) return;

                window.addEventListener('scroll', () => {
                    if (window.scrollY > 10) {
                        navbar.classList.add('bg-white/90', 'backdrop-blur-md', 'shadow-sm');
                        navbar.classList.remove('bg-white/10');
                    } else {
                        navbar.classList.remove('bg-white/90', 'backdrop-blur-md', 'shadow-sm');
                        navbar.classList.add('bg-white/10');
                    }
                });
            }
<<<<<<< HEAD
            
            // Re-init on AJAX navigation
            document.addEventListener('ajaxContentLoaded', () => {
                setTimeout(() => Navbar.init(), 100);
            });

        })();
=======
        };
>>>>>>> 9291aa651412ef0d9bc6baefcedd947ab2483923
    </script>

    {{-- Trigger Login Modal if Session Exists --}}
    @if(session('open_login_modal'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Tunggu sampai DOM dan scripts.blade.php ter-load
                setTimeout(() => {
                    const overlay = document.getElementById('auth-modal-overlay');
                    const modalLogin = document.getElementById('modal-login');
                    
                    if (overlay && modalLogin) {
                        // ⭐ EXACT LOGIC dari openModal() function untuk smooth transition yang SAMA
                        document.querySelectorAll('.modal-content').forEach(m => {
                            m.classList.add('hidden');
                            m.classList.remove('scale-100', 'opacity-100');
                        });

                        overlay.classList.remove('hidden');
                        setTimeout(() => {
                            overlay.classList.add('show');
                            modalLogin.classList.remove('hidden');
                            setTimeout(() => {
                                modalLogin.classList.add('scale-100', 'opacity-100');
                            }, 50);
                        }, 10);
                    }
                }, 300);
            });
        </script>
    @endif

    @include('auth.scripts')
@endpush