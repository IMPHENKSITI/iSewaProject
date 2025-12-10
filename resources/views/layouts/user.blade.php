@extends('layouts.app')

@push('styles')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <style>
        /* Animasi Pemuatan Halaman Global */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .animate-section {
            opacity: 0;
            transform: translateY(30px);
        }
        
        .animate-section.show {
            animation: fadeInUp 0.8s ease-out forwards;
        }
        
        .animate-section:nth-child(1) { animation-delay: 0.1s; }
        .animate-section:nth-child(2) { animation-delay: 0.2s; }
        .animate-section:nth-child(3) { animation-delay: 0.3s; }
        .animate-section:nth-child(4) { animation-delay: 0.4s; }
        .animate-section:nth-child(5) { animation-delay: 0.5s; }
        .animate-section:nth-child(6) { animation-delay: 0.6s; }
        .animate-section:nth-child(7) { animation-delay: 0.7s; }
        .animate-section:nth-child(8) { animation-delay: 0.8s; }
    </style>
@endpush

@section('content')
    {{-- NAVBAR PENGGUNA --}}
    @include('partials.navbar')

    <main class="flex-grow relative w-full">
        @yield('page')
    </main>

    {{-- FOOTER PENGGUNA --}}
    @include('partials.footer')

    {{-- MODAL AUTENTIKASI --}}
    @include('auth.modals')

@endsection

@push('scripts')
    {{-- Skrip Global (Inline untuk menghindari masalah cache) --}}
    <script>
        /**
         * Fungsionalitas Navbar & Menu Seluler
         */
        // Logika Navbar & Sidebar
        const Navbar = {
            init() {
                this.initSidebar();
                this.initMobileDropdowns();
                this.initScrollEffect();
            },

            // Sidebar Seluler
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

                // Tutup saat link diklik
                sidebar.querySelectorAll('a:not(#bumdes-toggle)').forEach(link => {
                    link.addEventListener('click', closeSidebar);
                });
            },

            // Dropdown Seluler (BUMDes)
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

            // Efek Scroll Navbar
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
        };
    </script>

    {{-- Picu Modal Login jika Sesi Ada --}}
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

    {{-- Pemicu Animasi Global --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const sections = document.querySelectorAll('.animate-section');
            sections.forEach((section, index) => {
                setTimeout(() => {
                    section.classList.add('show');
                }, index * 100);
            });
        });
    </script>

    @include('auth.scripts')
@endpush