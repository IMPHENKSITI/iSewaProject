@extends('layouts.user')

@section('page')
{{-- NAV --}}

    <!-- Carousel Section -->


    {{-- MAIN --}}<main class="flex-grow relative w-full">

        {{-- SECTION BERANDA --}}<section id="beranda" class="relative z-10">
            <div class="w-full mx-auto">
                <div class="relative overflow-hidden group">
                    <!-- Slides Container -->
                    <div id="carousel-slides" class="flex transition-transform duration-500 ease-out">
                        <!-- Slide 1 -->
                        <div class="carousel-slide min-w-full flex-shrink-0">
                            <img src="{{ asset('User/img/elemen/slide1.png') }}" alt="Slide 1"
                                class="w-full h-[400px] md:h-[40vw] lg:h-[45vw] object-cover">
                        </div>
                        <!-- Slide 2 -->
                        <div class="carousel-slide min-w-full flex-shrink-0">
                            <img src="{{ asset('User/img/elemen/slide2.png') }}" alt="Slide 2"
                                class="w-full h-[400px] md:h-[40vw] lg:h-[45vw] object-cover">
                        </div>
                    </div>

                    <!-- Navigation Buttons -->
                    <button id="carousel-prev"
                        class="absolute left-4 top-1/2 -translate-y-1/2 bg-white hover:bg-gray-50 text-gray-800 rounded-full p-3 shadow-lg opacity-0 group-hover:opacity-100 transition-all duration-300 hover:scale-110 z-10">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                d="M15 19l-7-7 7-7" />
                        </svg>
                    </button>

                    <button id="carousel-next"
                        class="absolute right-4 top-1/2 -translate-y-1/2 bg-white hover:bg-gray-50 text-gray-800 rounded-full p-3 shadow-lg opacity-0 group-hover:opacity-100 transition-all duration-300 hover:scale-110 z-10">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7" />
                        </svg>
                    </button>

                    <!-- Indicators - 2 Dots Only -->
                    <div class="absolute bottom-6 left-1/2 -translate-x-1/2 flex gap-2.5 z-10">
                        <button
                            class="carousel-indicator w-8 h-2.5 rounded-full bg-white shadow-md transition-all duration-300"
                            data-slide="0"></button>
                        <button
                            class="carousel-indicator w-2.5 h-2.5 rounded-full bg-white/50 hover:bg-white/75 shadow-md transition-all duration-300"
                            data-slide="1"></button>
                    </div>
                </div>
            </div>

            <!-- Search Bar with Gradient Border -->
            <div class="max-w-screen-2xl mx-auto px-5 py-8">
                <div class="max-w-2xl mx-auto">
                    <div class="relative group">
                        <!-- Gradient Border -->
                        <div
                            class="absolute -inset-0.5 bg-gradient-to-r from-blue-500 via-blue-400 to-amber-400 rounded-full opacity-80 group-hover:opacity-100 transition-opacity duration-300">
                        </div>

                        <!-- Search Input -->
                        <div class="relative flex items-center bg-white rounded-full overflow-hidden">
                            <input type="text" placeholder="Cari"
                                class="flex-1 px-8 py-3.5 text-gray-700 text-[15px] focus:outline-none bg-transparent">

                            <!-- Search Button -->
                            <button
                                class="flex-shrink-0 px-6 py-3.5 text-blue-600 hover:text-blue-700 transition-colors duration-200">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Section Populer -->
            <div class="max-w-7xl mx-auto px-6 py-12">
                <div class="max-w-7xl mx-auto">
                    <!-- Judul Populer -->
                    <div class="text-center mb-8 relative">
                        <h2
                            class="text-3xl font-bold bg-gradient-to-r from-[#115789] to-blue-300 bg-clip-text text-transparent relative inline-block drop-shadow-[0_0_15px_rgba(59,130,246,0.5)]">
                            Populer
                        </h2>
                    </div>

                    <!-- Grid Cards 2x2 -->
                    <div class="grid grid-cols-2 sm:grid-cols-4 gap-x-2 gap-y-3">
                        <!-- Card 1 - Gas LPG 3Kg -->
                        <div class="flex flex-col items-center">
                            <div
                                class="bg-white/80 backdrop-blur-sm rounded-lg border border-white shadow-md hover:shadow-xl transition-all duration-300 overflow-hidden group cursor-pointer w-[65%]">
                                <div
                                    class="aspect-square p-4 flex items-center justify-center bg-gradient-to-br from-white/50 to-blue-50/30">
                                    <img src="{{ asset('User/img/elemen/gas.png') }}" alt="Gas LPG 3Kg"
                                        class="max-h-full max-w-full object-contain group-hover:scale-105 transition-transform duration-300">
                                </div>
                                <div class="p-3 text-center bg-white/90 backdrop-blur-sm">
                                    <h3 class="text-sm font-semibold text-gray-800">Gas LPG 3Kg</h3>
                                </div>
                            </div>
                        </div>

                        <!-- Card 2 - Tenda Kerucut -->
                        <div class="flex flex-col items-center">
                            <div
                                class="bg-white/80 backdrop-blur-sm rounded-lg border border-white shadow-md hover:shadow-xl transition-all duration-300 overflow-hidden group cursor-pointer w-[65%]">
                                <div
                                    class="aspect-square p-4 flex items-center justify-center bg-gradient-to-br from-white/50 to-blue-50/30">
                                    <img src="{{ asset('User/img/elemen/tendakerucut.jpeg') }}" alt="Tenda Kerucut"
                                        class="max-h-full max-w-full object-contain group-hover:scale-105 transition-transform duration-300">
                                </div>
                                <div class="p-3 text-center bg-white/90 backdrop-blur-sm">
                                    <h3 class="text-sm font-semibold text-gray-800">Tenda Kerucut</h3>
                                </div>
                            </div>
                        </div>

                        <!-- Card 3 - Sound System -->
                        <div class="flex flex-col items-center">
                            <div
                                class="bg-white/80 backdrop-blur-sm rounded-lg border border-white shadow-md hover:shadow-xl transition-all duration-300 overflow-hidden group cursor-pointer w-[65%]">
                                <div
                                    class="aspect-square p-4 flex items-center justify-center bg-gradient-to-br from-white/50 to-blue-50/30">
                                    <img src="{{ asset('User/img/elemen/soundsystem.png') }}" alt="Sound System"
                                        class="max-h-full max-w-full object-contain group-hover:scale-105 transition-transform duration-300">
                                </div>
                                <div class="p-3 text-center bg-white/90 backdrop-blur-sm">
                                    <h3 class="text-sm font-semibold text-gray-800">Sound System</h3>
                                </div>
                            </div>
                        </div>

                        <!-- Card 4 - Bermitra -->
                        <div class="flex flex-col items-center">
                            <div
                                class="bg-white/80 backdrop-blur-sm rounded-lg border border-white shadow-md hover:shadow-xl transition-all duration-300 overflow-hidden group cursor-pointer w-[65%]">
                                <div
                                    class="aspect-square p-4 flex items-center justify-center bg-gradient-to-br from-white/50 to-blue-50/30">
                                    <img src="{{ asset('User/img/elemen/bermitra.png') }}" alt="Bermitra"
                                        class="max-h-full max-w-full object-contain group-hover:scale-105 transition-transform duration-300">
                                </div>
                                <div class="p-3 text-center bg-white/90 backdrop-blur-sm">
                                    <h3 class="text-sm font-semibold text-gray-800">Bermitra</h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Section Unit Pelayanan -->
            <div id="unit-carousel-container" class="max-w-7xl mx-auto px-6 py-16 overflow-hidden">
                <div class="max-w-7xl mx-auto">

                    <div class="text-center mb-16 relative">
                        <h2
                            class="text-3xl font-bold bg-gradient-to-r from-[#115789] to-blue-300 bg-clip-text text-transparent relative inline-block drop-shadow-[0_0_15px_rgba(59,130,246,0.5)]">
                            Unit Pelayanan
                        </h2>
                    </div>

                    <div class="relative h-[400px] w-full flex justify-center items-center">

                        <div class="relative w-full max-w-6xl mx-auto h-full">

                            <div class="unit-card" data-index="0" data-name="Unit Penyewaan Alat">
                                <img src="{{ asset('User/img/elemen/F1.png') }}" alt="Alat">
                            </div>

                            <div class="unit-card" data-index="1" data-name="Unit Penjualan Gas">
                                <img src="{{ asset('User/img/elemen/F2.png') }}" alt="Gas">
                            </div>

                            <div class="unit-card" data-index="2" data-name="Unit Pertanian dan Perkebunan">
                                <img src="{{ asset('User/img/elemen/F3.png') }}" alt="Tani">
                            </div>

                            <div class="unit-card" data-index="3" data-name="Unit Simpan Pinjam">
                                <img src="{{ asset('User/img/elemen/F4.png') }}" alt="Pocket">
                            </div>

                        </div>

                        <div
                            class="absolute -bottom-6 left-0 right-0 flex items-center justify-center gap-4 md:gap-12 z-60">

                            <button id="unit-prev"
                                class="bg-white hover:bg-gray-50 text-gray-800 rounded-full p-3 shadow-lg border border-gray-100 transition-transform active:scale-95">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                        d="M15 19l-7-7 7-7" />
                                </svg>
                            </button>

                            <div class="min-w-[300px] text-center">
                                <h3 id="unit-title"
                                    class="text-xl md:text-2xl font-bold text-black transition-all duration-300">
                                    Unit Penyewaan Alat
                                </h3>
                            </div>

                            <button id="unit-next"
                                class="bg-white hover:bg-gray-50 text-gray-800 rounded-full p-3 shadow-lg border border-gray-100 transition-transform active:scale-95">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                        d="M9 5l7 7-7 7" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Section Grafik Umum -->
            <div class="max-w-7xl mx-auto px-6 py-16">
                <!-- Title dengan gradient -->
                <div class="text-center mb-12">
                    <h2
                        class="text-3xl font-bold bg-gradient-to-r from-[#115789] to-blue-300 bg-clip-text text-transparent relative inline-block drop-shadow-[0_0_15px_rgba(59,130,246,0.5)]">
                        Grafik Umum
                    </h2>
                </div>
                <!-- Grafik Kinerja BUMDES -->
                <div class="mb-16">
                    <!-- Glass Effect Container - Lebih Transparan -->
                    <div
                        class="relative rounded-3xl p-6 backdrop-blur-md bg-white/20 border border-white/30 shadow-[0_8px_32px_0_rgba(31,38,135,0.15)]">
                        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-5">
                            <h3 class="text-xl font-bold text-gray-800 mb-3 md:mb-0">Kinerja BUMDES</h3>
                            <div class="flex flex-col sm:flex-row gap-2">
                                <select
                                    class="px-4 py-2 text-sm border border-white/40 rounded-lg bg-white/60 backdrop-blur-sm text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:bg-white/80 transition-all">
                                    <option>Desa Pematang Duku Timur</option>
                                    <option>Desa Pematang Duku Barat</option>
                                    <option>Sungai Pakning</option>
                                </select>
                                <select
                                    class="px-4 py-2 text-sm border border-white/40 rounded-lg bg-white/60 backdrop-blur-sm text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:bg-white/80 transition-all">
                                    <option>2025</option>
                                    <option>2024</option>
                                    <option>2023</option>
                                </select>
                            </div>
                        </div>
                        <!-- Inner Container - Sangat Transparan seperti Kaca -->
                        <div class="bg-white/30 backdrop-blur-sm rounded-2xl p-5 border border-white/20">
                            <div id="kinerjaChart"></div>
                        </div>
                    </div>
                </div>
                <!-- Grafik Unit Populer -->
                <div class="mb-12">
                    <!-- Glass Effect Container - Lebih Transparan -->
                    <div
                        class="relative rounded-3xl p-6 backdrop-blur-md bg-white/20 border border-white/30 shadow-[0_8px_32px_0_rgba(31,38,135,0.15)]">
                        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-5">
                            <h3 class="text-xl font-bold text-gray-800 mb-3 md:mb-0">Unit Populer</h3>
                            <select
                                class="px-4 py-2 text-sm border border-white/40 rounded-lg bg-white/60 backdrop-blur-sm text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:bg-white/80 transition-all">
                                <option>2025</option>
                                <option>2024</option>
                                <option>2023</option>
                            </select>
                        </div>
                        <!-- Inner Container - Sangat Transparan seperti Kaca -->
                        <div class="bg-white/30 backdrop-blur-sm rounded-2xl p-5 mb-5 border border-white/20">
                            <div id="unitChart"></div>
                        </div>
                        <!-- Legend - Compact -->
                        <div class="flex flex-wrap justify-center gap-4 text-xs">
                            <div class="flex items-center gap-1.5">
                                <div class="w-3 h-3 bg-[#f59e0b] rounded"></div>
                                <span class="text-gray-700 font-medium">Unit Penyewaan Alat</span>
                            </div>
                            <div class="flex items-center gap-1.5">
                                <div class="w-3 h-3 bg-[#3b82f6] rounded"></div>
                                <span class="text-gray-700 font-medium">Unit Penjualan Gas</span>
                            </div>
                            <div class="flex items-center gap-1.5">
                                <div class="w-3 h-3 bg-[#10b981] rounded"></div>
                                <span class="text-gray-700 font-medium">Unit Pertanian dan Perkebunan</span>
                            </div>
                            <div class="flex items-center gap-1.5">
                                <div class="w-3 h-3 bg-[#d1d5db] rounded"></div>
                                <span class="text-gray-700 font-medium">Unit Simpan Pinjam</span>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Tombol Lihat Lainnya -->
                <div class="text-center">
                    <button
                        class="px-10 py-3 bg-white/70 backdrop-blur-sm text-[#45aaf2] border-2 border-[#45aaf2] rounded-full font-semibold hover:bg-[#45aaf2] hover:text-white transition-all duration-300 shadow-md hover:shadow-xl">
                        Lihat Lainnya
                    </button>
                </div>
            </div>

            <!-- Section Tentang Kami -->
            <div class="relative max-w-7xl mx-auto px-6 py-16 overflow-visible">
                <!-- Background Elements - Hanya 2 Oval -->
                <div class="absolute inset-0 pointer-events-none" style="left: -200px; right: -200px;">
                    <svg class="absolute inset-0 w-full h-full" preserveAspectRatio="none" viewBox="0 0 1440 500" xmlns="http://www.w3.org/2000/svg">
                        <defs>
                            <linearGradient id="ovalGradient" x1="0%" y1="0%" x2="100%" y2="100%">
                                <stop offset="0%" style="stop-color:#7dd3fc;stop-opacity:0.45" />
                                <stop offset="100%" style="stop-color:#bae6fd;stop-opacity:0.25" />
                            </linearGradient>
                        </defs>
                        
                        <!-- Oval Kiri -->
                        <ellipse cx="120" cy="250" rx="320" ry="280" fill="url(#ovalGradient)" />
                        
                        <!-- Oval Kanan Bawah -->
                        <ellipse cx="1350" cy="420" rx="280" ry="240" fill="url(#ovalGradient)" />
                    </svg>
                </div>

                <!-- Content -->
                <div class="relative z-10">
                    <!-- Title -->
                    <div class="text-center mb-10">
                        <h2 class="text-3xl font-bold bg-gradient-to-r from-[#115789] to-blue-300 bg-clip-text text-transparent relative inline-block drop-shadow-[0_0_15px_rgba(59,130,246,0.5)]">
                            Tentang Kami
                        </h2>
                    </div>

                    <!-- Text Content dengan Glass Effect -->
                    <div class="max-w-5xl mx-auto">
                        <div class="backdrop-blur-sm bg-white/60 rounded-3xl p-8 md:p-12 border border-white/70 shadow-xl">
                            <div class="space-y-5 text-gray-700 text-base leading-relaxed text-justify">
                                <p>
                                    <span class="font-semibold text-gray-800">iSewa</span> merupakan platform digital terpadu yang dirancang untuk mendukung kegiatan operasional dan pelayanan BUMDes secara modern dan efisien. Sistem ini hadir sebagai solusi inovatif untuk mengelola berbagai unit usaha desa seperti penyewaan alat, layanan pembelian gas, serta simpan pinjam. Melalui iSewa, proses administrasi dan transaksi menjadi lebih cepat, transparan, dan mudah dijangkau oleh masyarakat.
                                </p>
                                <p>
                                    Dengan mengedepankan kemudahan akses dan efisiensi layanan, iSewa membantu BUMDes dalam meningkatkan produktivitas, memperluas jangkauan usaha, serta memperkuat perekonomian desa secara berkelanjutan. Kami percaya bahwa digitalisasi layanan desa merupakan langkah penting menuju kemandirian ekonomi masyarakat, dan iSewa hadir untuk mewujudkan hal tersebut dengan sistem yang modern, aman, dan berorientasi pada kemajuan desa.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>



        {{-- DECORATIONS --}}

        <!-- ============================================ -->
        <!-- AREA POPULER - Pakai 4.webp (BLUR) Kiri & Kanan -->
        <!-- ============================================ -->
        <svg class="bg-element bg-blur-left-populer">
            <image href="{{ asset('User/img/backgrounds/4.webp') }}" width="100%" height="100%" />
        </svg>

        <svg class="bg-element bg-blur-right-populer">
            <image href="{{ asset('User/img/backgrounds/4.webp') }}" width="100%" height="100%" />
        </svg>

        <!-- ============================================ -->
        <!-- BAWAH POPULER - Pakai 2.webp (WAVE) Kiri -->
        <!-- ============================================ -->
        <img src="{{ asset('User/img/backgrounds/2.webp') }}" class="bg-element bg-wave-left-lower-populer" />

        <!-- ============================================ -->
        <!-- AREA UNIT PELAYANAN - Pakai 2.webp (WAVE) Kanan + 5.webp (GEOMETRIS ROTASI) -->
        <!-- ============================================ -->
        <img src="{{ asset('User/img/backgrounds/2.webp') }}" class="bg-element bg-wave-right-unit" />

        <svg class="bg-element bg-squares-right-unit">
            <image href="{{ asset('User/img/backgrounds/5.webp') }}" width="100%" height="100%" />
        </svg>

        <!-- ============================================ -->
        <!-- AREA GRAFIK UMUM - Pakai 3.webp (WAVE BESAR TENGAH) -->
        <!-- ============================================ -->
        <img src="{{ asset('User/img/backgrounds/3.webp') }}" class="bg-element bg-wave-center-grafik" />

    </main>

    {{-- FOOTER --}}

    {{-- SCRIPT --}}
@endsection


@push('styles')
<style>
        * {
            font-family: 'Inter', sans-serif;
        }

        /* Gradient Radial untuk Background Tentang Kami */
        .bg-gradient-radial {
            background-image: radial-gradient(circle, var(--tw-gradient-stops));
        }

        /* Background Elements - kept as they require precise positioning */
        .bg-element {
            position: absolute;
            pointer-events: none;
            user-select: none;
            object-fit: contain;
        }

        /* Area Carousel/Hero - TIDAK PAKAI BACKGROUND */

        /* Area POPULER - Pakai 4.webp (BLUR) KIRI BESAR + KANAN BAWAH BESAR (KEMBAR) */
        .bg-blur-left-populer {
            top: 21%;
            left: -220px;
            width: 650px;
            transform: rotate(-15deg) scaleX(1.2) scale(3.0);
            opacity: 0.88;
            z-index: 2;
        }

        /* KEMBARAN 4.webp di KANAN BAWAH - MIRROR HORIZONTAL */
        .bg-blur-right-populer {
            top: 27%;
            right: -180px;
            width: 680px;
            transform: rotate(18deg) scaleX(-1.5) scale(3.0);
            opacity: 0.90;
            z-index: 2;
        }

        /* Bawah POPULER / Atas UNIT PELAYANAN - Pakai 2.webp (WAVE) BESAR */
        .bg-wave-left-lower-populer {
            top: 30%;
            left: -140px;
            width: 550px;
            transform: rotate(-8deg);
            opacity: 0.90;
            z-index: 2;
        }

        /* Area UNIT PELAYANAN - Pakai 2.webp (WAVE) BESAR + 5.webp (GEOMETRIS) SUPER BESAR */
        .bg-wave-right-unit {
            top: 40%;
            right: -150px;
            width: 580px;
            transform: rotate(15deg) scaleX(-1);
            opacity: 0.92;
            z-index: 2;
        }

        /* 5.webp DIPERBESAR LAGI - SUPER BESAR! */
        .bg-squares-right-unit {
            top: 35%;
            right: -230px;
            width: 580px;
            transform: rotate(-100deg) scale(1.5);
            opacity: 0.90;
            z-index: 2;
        }

        /* Area GRAFIK UMUM - Pakai 3.webp (WAVE BESAR TENGAH) */
        .bg-wave-center-grafik {
            top: 45%;
            left: 50%;
            width: 115%;
            transform: translateX(-50%) scale(1.1);
            opacity: 0.95;
            z-index: 1;
        }

        /* --- UNIT CAROUSEL STYLES (4 VISIBLE ITEMS) --- */
        .unit-card {
            width: 280px;
            height: 280px;
            position: absolute;
            top: 45%;
            transform-origin: center center;
            /* Transisi halus saat tukar tempat */
            transition: all 0.6s cubic-bezier(0.25, 1, 0.5, 1);
            will-change: transform, left, opacity;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .unit-card img {
            width: 100%;
            height: 100%;
            object-fit: contain;
            filter: drop-shadow(0 15px 25px rgba(0, 0, 0, 0.15));
        }

        /* POSISI 0: KIRI */
        .state-0 {
            left: 15% !important;
            transform: translate(-50%, -50%) scale(0.65) !important;
            opacity: 0.8;
            z-index: 20;
            filter: grayscale(10%);
        }

        /* POSISI 1: (TENGAH FOKUS) */
        .state-1 {
            left: 50% !important;
            transform: translate(-50%, -50%) scale(1.5) !important;
            opacity: 1;
            z-index: 50;
            filter: grayscale(0%) drop-shadow(0 25px 35px rgba(0, 0, 0, 0.25));
        }

        /* POSISI 2: KANAN  */
        .state-2 {
            left: 80% !important;
            transform: translate(-50%, -50%) scale(0.65) !important;
            opacity: 0.8;
            z-index: 20;
            filter: grayscale(10%);
        }

        /* POSISI 3: KANAN UJUNG*/
        .state-3 {
            left: 100% !important;
            /* Benar-benar di ujung kanan */
            transform: translate(-50%, -50%) scale(0.5) !important;
            opacity: 0.6;
            z-index: 10;
            filter: grayscale(30%);
        }

        /* RESPONSIVE MOBILE */
        @media (max-width: 768px) {
            .unit-card {
                width: 160px;
                height: 160px;
            }

            .state-0 {
                left: 10% !important;
                scale: 0.5 !important;
            }

            .state-1 {
                left: 50% !important;
                scale: 1.2 !important;
            }

            .state-2 {
                left: 90% !important;
                scale: 0.5 !important;
            }

            /* Di HP item ke-4 disembunyikan biar layar tidak penuh */
            .state-3 {
                left: 110% !important;
                opacity: 0;
            }
        }
    </style>
@endpush
@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script>
        // ========================================
        // CAROUSEL FUNCTIONALITY - FULL CODE
        // ========================================
        const carouselSlides = document.getElementById('carousel-slides');
        const prevButton = document.getElementById('carousel-prev');
        const nextButton = document.getElementById('carousel-next');
        const indicators = document.querySelectorAll('.carousel-indicator');

        let currentSlide = 0;
        const totalSlides = 2;
        let mainAutoSlideInterval; // RENAMED: tambah prefix 'main'
        const autoSlideDelay = 7000;

        function goToSlide(slideIndex) {
            currentSlide = slideIndex;
            const offset = -slideIndex * 100;
            carouselSlides.style.transform = `translateX(${offset}%)`;

            indicators.forEach((indicator, index) => {
                if (index === slideIndex) {
                    indicator.classList.remove('bg-white/50', 'hover:bg-white/75', 'w-2.5');
                    indicator.classList.add('bg-white', 'w-8');
                } else {
                    indicator.classList.remove('bg-white', 'w-8');
                    indicator.classList.add('bg-white/50', 'hover:bg-white/75', 'w-2.5');
                }
            });
        }

        function nextSlide() {
            currentSlide = (currentSlide + 1) % totalSlides;
            goToSlide(currentSlide);
        }

        function prevSlide() {
            currentSlide = (currentSlide - 1 + totalSlides) % totalSlides;
            goToSlide(currentSlide);
        }

        function startMainAutoSlide() { // RENAMED: tambah prefix 'Main'
            mainAutoSlideInterval = setInterval(nextSlide, autoSlideDelay);
        }

        function stopMainAutoSlide() { // RENAMED: tambah prefix 'Main'
            clearInterval(mainAutoSlideInterval);
        }

        function resetMainAutoSlide() { // RENAMED: tambah prefix 'Main'
            stopMainAutoSlide();
            startMainAutoSlide();
        }

        nextButton.addEventListener('click', () => {
            nextSlide();
            resetMainAutoSlide(); // UPDATED
        });

        prevButton.addEventListener('click', () => {
            prevSlide();
            resetMainAutoSlide(); // UPDATED
        });

        indicators.forEach((indicator, index) => {
            indicator.addEventListener('click', () => {
                goToSlide(index);
                resetMainAutoSlide(); // UPDATED
            });
        });

        // Touch/swipe support
        let touchStartX = 0;
        let touchEndX = 0;

        carouselSlides.addEventListener('touchstart', (e) => {
            touchStartX = e.changedTouches[0].screenX;
            stopMainAutoSlide(); // UPDATED
        });

        carouselSlides.addEventListener('touchend', (e) => {
            touchEndX = e.changedTouches[0].screenX;
            handleSwipe();
            startMainAutoSlide(); // UPDATED
        });

        function handleSwipe() {
            const swipeThreshold = 50;
            const diff = touchStartX - touchEndX;

            if (Math.abs(diff) > swipeThreshold) {
                if (diff > 0) {
                    nextSlide();
                } else {
                    prevSlide();
                }
            }
        }

        // Pause on hover
        const carouselContainer = carouselSlides.parentElement;
        carouselContainer.addEventListener('mouseenter', stopMainAutoSlide); // UPDATED
        carouselContainer.addEventListener('mouseleave', startMainAutoSlide); // UPDATED

        startMainAutoSlide(); // UPDATED

        // ========================================
        // UNIT PELAYANAN CAROUSEL 
        // ========================================
        document.addEventListener('DOMContentLoaded', () => {
            const cards = Array.from(document.querySelectorAll('.unit-card'));
            const titleElement = document.getElementById('unit-title');
            const nextBtn = document.getElementById('unit-next');
            const prevBtn = document.getElementById('unit-prev');

            // Definisi nama class posisi di CSS
            const stateClasses = ['state-0', 'state-1', 'state-2', 'state-3'];

            let positions = [1, 2, 3, 0];

            function updateCarousel() {
                cards.forEach((card, index) => {
                    // Hapus class lama
                    card.classList.remove(...stateClasses);

                    // Ambil posisi baru dari array
                    const currentPos = positions[index];

                    // Tambah class baru
                    card.classList.add(stateClasses[currentPos]);

                    // Jika kartu ini ada di posisi 1 (Tengah), update judul
                    if (currentPos === 1) {
                        titleElement.style.opacity = '0';
                        titleElement.style.transform = 'translateY(10px)';

                        setTimeout(() => {
                            titleElement.textContent = card.getAttribute('data-name');
                            titleElement.style.opacity = '1';
                            titleElement.style.transform = 'translateY(0)';
                        }, 200);
                    }
                });
            }

            // Tombol Next (Geser ke Kiri)
            function handleNext() {
                positions = positions.map(pos => {
                    let newPos = pos - 1;
                    if (newPos < 0) newPos = 3; // Loop ke ujung kanan
                    return newPos;
                });
                updateCarousel();
            }

            // Tombol Prev (Geser ke Kanan)
            function handlePrev() {
                positions = positions.map(pos => {
                    let newPos = pos + 1;
                    if (newPos > 3) newPos = 0; // Loop ke kiri
                    return newPos;
                });
                updateCarousel();
            }

            if (nextBtn) {
                nextBtn.addEventListener('click', () => {
                    handleNext();
                    resetAutoPlay();
                });
            }

            if (prevBtn) {
                prevBtn.addEventListener('click', () => {
                    handlePrev();
                    resetAutoPlay();
                });
            }

            // Auto Play (Ganti angka 4000 untuk kecepatan)
            let autoPlayTimer = setInterval(handleNext, 4000);

            function resetAutoPlay() {
                clearInterval(autoPlayTimer);
                autoPlayTimer = setInterval(handleNext, 4000);
            }

            // Mulai
            updateCarousel();
        });
        // ========================================
        // GRAFIK KINERJA BUMDES (AREA CHART)
        // ========================================
        const kinerjaOptions = {
            series: [{
                name: 'Kinerja',
                data: [25, 20.8, 17.6, 20.2, 19.8, 22.5]
            }],
            chart: {
                type: 'area',
                height: 280,
                toolbar: {
                    show: false
                },
                zoom: {
                    enabled: false
                },
                background: 'transparent'
            },
            colors: ['#f59e0b'],
            stroke: {
                curve: 'smooth',
                width: 2.5
            },
            fill: {
                type: 'gradient',
                gradient: {
                    shadeIntensity: 1,
                    opacityFrom: 0.45,
                    opacityTo: 0.05,
                    stops: [0, 90, 100]
                }
            },
            dataLabels: {
                enabled: false
            },
            markers: {
                size: 0,
                hover: {
                    size: 5
                }
            },
            xaxis: {
                categories: ['Januari', 'Februari', 'Maret', 'April', 'Mei'],
                labels: {
                    style: {
                        colors: '#374151',
                        fontSize: '12px',
                        fontWeight: 500
                    }
                },
                axisBorder: {
                    show: false
                },
                axisTicks: {
                    show: false
                }
            },
            yaxis: {
                min: 15,
                max: 25,
                tickAmount: 5,
                labels: {
                    formatter: (val) => val.toFixed(1),
                    style: {
                        colors: '#6b7280',
                        fontSize: '11px'
                    }
                }
            },
            grid: {
                borderColor: '#e5e7eb',
                strokeDashArray: 3,
                xaxis: {
                    lines: {
                        show: true
                    }
                },
                yaxis: {
                    lines: {
                        show: true
                    }
                },
                padding: {
                    top: 0,
                    right: 5,
                    bottom: 0,
                    left: 5
                }
            },
            tooltip: {
                y: {
                    formatter: (val) => val.toFixed(1) + 'Jt'
                }
            }
        };

        const kinerjaChart = new ApexCharts(document.querySelector("#kinerjaChart"), kinerjaOptions);
        kinerjaChart.render();

        // ========================================
        // GRAFIK UNIT POPULER (BAR CHART)
        // ========================================
        const unitOptions = {
            series: [{
                    name: 'Unit Penyewaan Alat',
                    data: [20, 15, 30, 22, 17]
                },
                {
                    name: 'Unit Penjualan Gas',
                    data: [16, 17, 18, 20, 10]
                },
                {
                    name: 'Unit Pertanian dan Perkebunan',
                    data: [18, 10, 16, 20, 19]
                },
                {
                    name: 'Unit Simpan Pinjam',
                    data: [30, 12, 15, 10, 5]
                }
            ],
            chart: {
                type: 'bar',
                height: 280,
                toolbar: {
                    show: false
                },
                stacked: false,
                background: 'transparent'
            },
            colors: ['#f59e0b', '#3b82f6', '#10b981', '#d1d5db'],
            plotOptions: {
                bar: {
                    horizontal: false,
                    columnWidth: '45%',
                    borderRadius: 3,
                    dataLabels: {
                        position: 'top'
                    }
                }
            },
            dataLabels: {
                enabled: false
            },
            xaxis: {
                categories: ['Januari', 'Februari', 'Maret', 'April', 'Mei'],
                labels: {
                    style: {
                        colors: '#374151',
                        fontSize: '12px',
                        fontWeight: 500
                    }
                },
                axisBorder: {
                    show: false
                },
                axisTicks: {
                    show: false
                }
            },
            yaxis: {
                min: 0,
                max: 25,
                tickAmount: 5,
                labels: {
                    style: {
                        colors: '#6b7280',
                        fontSize: '11px'
                    }
                }
            },
            grid: {
                borderColor: '#e5e7eb',
                strokeDashArray: 3,
                padding: {
                    top: 0,
                    right: 5,
                    bottom: 0,
                    left: 5
                }
            },
            legend: {
                show: false
            },
            tooltip: {
                shared: true,
                intersect: false
            }
        };

        const unitChart = new ApexCharts(document.querySelector("#unitChart"), unitOptions);
        unitChart.render();
        // ========================================
        // MOBILE MENU FUNCTIONALITY
        // ========================================
        const mobileMenuButton = document.getElementById('mobile-menu-button');
        const mobileMenu = document.getElementById('mobile-menu');

        if (mobileMenuButton && mobileMenu) {
            mobileMenuButton.addEventListener('click', () => {
                mobileMenu.classList.toggle('hidden');
            });

            document.addEventListener('click', (event) => {
                const isClickInsideMenu = mobileMenu.contains(event.target);
                const isClickOnButton = mobileMenuButton.contains(event.target);

                if (!isClickInsideMenu && !isClickOnButton && !mobileMenu.classList.contains('hidden')) {
                    mobileMenu.classList.add('hidden');
                }
            });
        }

        // ========================================
        // SMOOTH SCROLLING
        // ========================================
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                e.preventDefault();
                const href = this.getAttribute('href');
                if (href === '#') return;

                const target = document.querySelector(href);
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });

                    if (mobileMenu && !mobileMenu.classList.contains('hidden')) {
                        mobileMenu.classList.add('hidden');
                    }
                }
            });
        });
    </script>
@endpush
