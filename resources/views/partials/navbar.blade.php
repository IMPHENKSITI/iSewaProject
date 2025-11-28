<nav class="absolute top-0 left-0 w-full z-50 bg-white/10 backdrop-blur-sm shadow-sm">
    <div class="max-w-screen-2xl mx-auto px-5 py-0">
        <div class="flex items-center justify-between">
            <div class="flex-shrink-0">
                <a href="{{ route('beranda') }}">
                    <img src="{{ asset('User/img/logo/iSewa.png') }}" alt="iSewa Logo" class="h-30 w-auto object-contain">
                </a>
            </div>

            <div class="hidden md:flex items-center space-x-8 ml-auto">
                <a href="{{ route('beranda') }}"
                    class="text-gray-900 hover:text-blue-600 text-[15px] font-medium transition-colors duration-200 {{ request()->routeIs('beranda') ? 'border-b-2 border-blue-500 pb-0.5' : '' }}">
                    Beranda
                </a>
                <a href="{{ route('pelayanan') }}"
                    class="text-gray-900 hover:text-blue-600 text-[15px] font-medium transition-colors duration-200 {{ request()->routeIs('pelayanan') ? 'border-b-2 border-blue-500 pb-0.5' : '' }}">
                    Pelayanan
                </a>

                <!-- BUMDes Dropdown -->
                <div class="relative group">
                    <button
                        class="text-gray-900 hover:text-blue-600 text-[15px] font-medium transition-colors duration-200 {{ request()->routeIs('bumdes.*') ? 'text-blue-600 border-b-2 border-blue-500 pb-0.5' : '' }}">
                        BUMDes
                    </button>

                    <!-- Dropdown Menu -->
                    <div
                        class="absolute top-full left-1/2 -translate-x-1/2 mt-2 w-52 bg-white rounded-xl shadow-[0_4px_20px_rgba(0,0,0,0.08)] border border-gray-100 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 z-50 overflow-hidden">
                        <div class="py-1">
                            <a href="{{ route('bumdes.profil') }}"
                                class="block px-5 py-3 text-gray-700 hover:bg-blue-50 hover:text-blue-600 text-[14px] font-medium transition-colors duration-150">
                                Profil dan Layanan
                            </a>
                            <div class="h-px bg-gray-100 mx-3"></div>
                            <a href="{{ route('bumdes.laporan') }}"
                                class="block px-5 py-3 text-gray-700 hover:bg-blue-50 hover:text-blue-600 text-[14px] font-medium transition-colors duration-150">
                                Laporan
                            </a>
                        </div>
                    </div>
                </div>

                <a href="#profil"
                    class="text-gray-900 hover:text-blue-600 text-[15px] font-medium transition-colors duration-200">
                    Profil iSewa
                </a>

                <div class="flex items-center gap-3">
                    <div class="relative inline-block group">
                        <div
                            class="absolute -inset-0.5 bg-gradient-to-r from-blue-400 to-amber-500 rounded-full opacity-70 group-hover:opacity-100 group-hover:blur-[2px] transition-all duration-300">
                        </div>
                        <button id="btn-open-login" type="button"
                            class="relative inline-block px-10 py-2.5 text-blue-600 rounded-full text-[15px] font-medium bg-white hover:shadow-lg transition-all duration-300">
                            Masuk
                        </a>
                    </div>

                    <button id="btn-open-register" type="button"
                        class="inline-block px-10 py-3 text-white rounded-full text-[15px] font-medium hover:shadow-lg transition-all duration-300"
                        style="background: linear-gradient(to right, #7dc8f0 0%, #78c7f0 3%, #73c6f0 6%, #6ec5f0 9%, #69c4f0 12%, #64c3f0 15%, #5fc2f0 18%, #5ac1f0 21%, #55c0f0 24%, #50bff0 27%, #4bbef0 30%, #4abdf1 33%, #49bcf1 36%, #48bbf1 39%, #47baf1 42%, #46b9f1 45%, #45b8f2 48%, #45b7f2 51%, #45b6f2 54%, #45b5f2 57%, #45b4f2 60%, #45b3f2 63%, #45b2f2 66%, #45b1f2 69%, #45b0f2 72%, #45aff2 75%, #45aef2 78%, #45adf2 81%, #45acf2 84%, #45abf2 87%, #45aaf2 90%, #45aaf2 93%, #45aaf2 96%, #45aaf2 100%);">
                        Daftar
                    </a>
                </div>

                <div class="md:hidden">
                    <button id="mobile-menu-button"
                        class="text-gray-700 hover:text-blue-600 focus:outline-none transition-colors duration-200">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        {{-- Overlay --}}
        <div id="sidebar-overlay" class="fixed inset-0 bg-black/40 hidden z-40 transition-opacity duration-300"></div>

        {{-- Sidebar Mobile --}}
        <div id="mobile-sidebar"
            class="fixed inset-y-0 left-0 w-72 bg-white shadow-xl transform -translate-x-full transition-transform duration-300 z-50 overflow-y-auto">

            <div class="py-6 px-5 flex items-center justify-between">
                <img src="{{ asset('User/img/logo/iSewa.png') }}" class="h-10">
                <button id="sidebar-close" class="p-2">
                    <svg class="w-6 h-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <nav class="mt-2 space-y-1 font-medium">
                <a href="#beranda" class="block px-6 py-3 hover:text-blue-600 transition">Beranda</a>
                <a href="#pelayanan" class="block px-6 py-3 hover:text-blue-600 transition">Pelayanan</a>

                <button id="bumdes-toggle"
                    class="w-full text-left px-6 py-3 flex items-center justify-between hover:text-blue-600 transition">
                    BUMDes
                    <svg id="bumdes-arrow" class="w-4 h-4 transition-transform duration-200">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>

                <div id="bumdes-sub" class="hidden pl-8 space-y-1">
                    <a href="#layanan" class="block py-2 hover:text-blue-600 transition">Profil & Layanan</a>
                    <a href="#laporan" class="block py-2 hover:text-blue-600 transition">Laporan</a>
                </div>

                <a href="#profil" class="block px-6 py-3 hover:text-blue-600 transition">Profil iSewa</a>
            </nav>

            <div class="px-6 pt-6 pb-12 border-t mt-4 space-y-3">
                <a href=/login
                    class="block text-center px-6 py-2 rounded-full font-medium bg-white text-blue-600 border border-blue-600 hover:bg-blue-600 hover:text-white transition">
                    Masuk
                </a>

                <a href=/register
                    class="block text-center px-6 py-2 rounded-full font-medium text-white hover:shadow-lg transition"
                    style="background: linear-gradient(to right, #7dc8f0 0%, #45aaf2 100%);">
                    Daftar
                </a>
            </div>
        </div>
</nav>
