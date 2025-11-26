<nav class="absolute top-0 left-0 w-full z-50 bg-white/10 backdrop-blur-sm shadow-sm">
        <div class="max-w-screen-2xl mx-auto px-5 py-0">
            <div class="flex items-center justify-between">
                <div class="flex-shrink-0">
                    <a href="/">
                        <img src="{{ asset('User/img/logo/iSewa.png') }}" alt="iSewa Logo"
                            class="h-30 w-auto object-contain">
                    </a>
                </div>

                <div class="hidden md:flex items-center space-x-8 ml-auto">
                    <a href="#beranda"
                        class="text-gray-900 hover:text-blue-600 text-[15px] font-medium border-b-2 border-blue-500 pb-0,5 transition-colors duration-200">
                        Beranda
                    </a>
                    <a href="#pelayanan"
                        class="text-gray-900 hover:text-blue-600 text-[15px] font-medium transition-colors duration-200">
                        Pelayanan
                    </a>
                    <a href="#bumdes"
                        class="text-gray-900 hover:text-blue-600 text-[15px] font-medium transition-colors duration-200">
                        BUMDes
                    </a>
                    <a href="#profil"
                        class="text-gray-900 hover:text-blue-600 text-[15px] font-medium transition-colors duration-200">
                        Profil iSewa
                    </a>

                    <div class="flex items-center gap-3">
                        <div class="relative inline-block group">
                            <div
                                class="absolute -inset-0.5 bg-gradient-to-r from-blue-400 to-amber-500 rounded-full opacity-70 group-hover:opacity-100 group-hover:blur-[2px] transition-all duration-300">
                            </div>
                            <a href="/login"
                                class="relative inline-block px-10 py-2.5 text-blue-600 rounded-full text-[15px] font-medium bg-white hover:shadow-lg transition-all duration-300">
                                Masuk
                            </a>
                        </div>

                        <a href="/register"
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

            <div id="mobile-menu" class="hidden md:hidden mt-4 pb-4 space-y-3">
                <a href="#beranda"
                    class="block text-gray-900 hover:text-blue-600 px-4 py-2 transition-colors border-l-4 border-blue-500">
                    Beranda
                </a>
                <a href="#pelayanan" class="block text-gray-900 hover:text-blue-600 px-4 py-2 transition-colors">
                    Pelayanan
                </a>
                <a href="#bumdes" class="block text-gray-900 hover:text-blue-600 px-4 py-2 transition-colors">
                    BUMDes
                </a>
                <a href="#profil" class="block text-gray-900 hover:text-blue-600 px-4 py-2 transition-colors">
                    Profil iSewa
                </a>
                <div class="px-4 pt-4 border-t border-gray-200 space-y-3">
                    <div class="relative group">
                        <div class="absolute -inset-0.5 bg-gradient-to-r from-amber-400 to-blue-500 rounded-full">
                        </div>
                        <a href="/login"
                            class="relative block text-center px-6 py-2.5 text-blue-600 rounded-full font-medium bg-white hover:bg-gray-50 transition-all">
                            Masuk
                        </a>
                    </div>
                    <a href="/register"
                        class="block text-center px-6 py-2.5 text-white rounded-full font-medium hover:shadow-lg transition-all"
                        style="background: linear-gradient(to right, #7dc8f0 0%, #45aaf2 100%);">
                        Daftar
                    </a>
                </div>
            </div>
        </div>
    </nav>
