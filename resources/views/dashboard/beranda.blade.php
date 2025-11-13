@extends('layouts.app')

@section('title', 'Beranda - iSewa')

@section('content')
<!-- Hero Section with Slider -->
<section class="hero-section">
    <div class="hero-slider">
        <div class="slider-container">
            <div class="slide active">
                <img src="{{ asset('images/hero-slide-1.jpg') }}" alt="Digitalisasi Desa">
                <div class="slide-content">
                    <h1>"Digitalisasi Desa, Majukan Usaha"</h1>
                    <p>Ayo, Gunakan Unit Layanan Desa mu!!</p>
                </div>
            </div>
            <div class="slide">
                <img src="{{ asset('images/hero-slide-2.jpg') }}" alt="BUMDes Indonesia">
                <div class="slide-content">
                    <h1>BUMDes Digital untuk Indonesia Maju</h1>
                    <p>Tingkatkan ekonomi desa bersama teknologi</p>
                </div>
            </div>
        </div>
        <div class="slider-dots">
            <span class="dot active" data-slide="0"></span>
            <span class="dot" data-slide="1"></span>
        </div>
    </div>
</section>

<!-- Search Bar -->
<section class="search-section">
    <div class="container">
        <div class="search-wrapper fade-in">
            <input type="text" class="search-input" placeholder="Cari">
            <button class="search-btn">
                <svg width="20" height="20" viewBox="0 0 20 20" fill="none">
                    <path d="M9 17A8 8 0 1 0 9 1a8 8 0 0 0 0 16zM19 19l-4.35-4.35" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </button>
        </div>
    </div>
</section>

<!-- Populer Section -->
<section class="populer-section">
    <div class="container">
        <h2 class="section-title fade-in">Populer</h2>
        <div class="populer-grid">
            <div class="populer-card fade-in" data-delay="0">
                <img src="{{ asset('images/gas-lpg.png') }}" alt="Gas LPG 3Kg">
                <p>Gas LPG 3Kg</p>
            </div>
            <div class="populer-card fade-in" data-delay="100">
                <img src="{{ asset('images/tenda-manual.png') }}" alt="Tenda Manual">
                <p>Tenda Manual</p>
            </div>
            <div class="populer-card fade-in" data-delay="200">
                <img src="{{ asset('images/sound-system.png') }}" alt="Sound System">
                <p>Sound System</p>
            </div>
            <div class="populer-card fade-in" data-delay="300">
                <img src="{{ asset('images/bertania.png') }}" alt="Bertania">
                <p>Bertania</p>
            </div>
        </div>
    </div>
</section>

<!-- Unit Pelayanan Section -->
<section class="unit-pelayanan-section">
    <div class="container">
        <h2 class="section-title fade-in">Unit <span class="text-primary">Pelayanan</span></h2>
        <div class="unit-slider-wrapper fade-in">
            <button class="slider-nav prev">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none">
                    <path d="M15 18l-6-6 6-6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </button>
            
            <div class="unit-slider">
                <div class="unit-track">
                    <div class="unit-item" data-unit="penyewaan-alat">
                        <img src="{{ asset('images/unit-penyewaan-alat.png') }}" alt="Unit Penyewaan Alat">
                        <h3>Unit Penyewaan Alat</h3>
                    </div>
                    <div class="unit-item" data-unit="penjualan-gas">
                        <img src="{{ asset('images/unit-penjualan-gas.png') }}" alt="Unit Penjualan Gas">
                        <h3>Unit Penjualan Gas</h3>
                    </div>
                    <div class="unit-item" data-unit="pertanian-perkebunan">
                        <img src="{{ asset('images/unit-pertanian.png') }}" alt="Unit Pertanian dan Perkebunan">
                        <h3>Unit Pertanian dan Perkebunan</h3>
                    </div>
                    <div class="unit-item" data-unit="simpan-pinjam">
                        <img src="{{ asset('images/unit-simpan-pinjam.png') }}" alt="Unit Simpan Pinjam">
                        <h3>Unit Simpan Pinjam</h3>
                    </div>
                </div>
            </div>
            
            <button class="slider-nav next">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none">
                    <path d="M9 18l6-6-6-6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </button>
        </div>
    </div>
</section>

<!-- Grafik Umum Section -->
<section class="grafik-umum-section">
    <div class="container">
        <div class="grafik-header fade-in">
            <h2 class="section-title">Grafik <span class="text-primary">Umum</span></h2>
            <div class="grafik-controls">
                <select class="desa-select" id="desaSelect">
                    <option value="pematang-duku-timur">Desa Pematang Duku Timur</option>
                    <option value="desa-lain">Desa Lain</option>
                </select>
                <select class="tahun-select" id="tahunSelect">
                    <option value="2025">2025</option>
                    <option value="2024">2024</option>
                </select>
            </div>
        </div>
        <div class="grafik-card fade-in">
            <h3>Kinerja BUMDES</h3>
            <canvas id="kinerjaChart"></canvas>
        </div>
    </div>
</section>

<!-- Unit Populer Section -->
<section class="unit-populer-section">
    <div class="container">
        <div class="grafik-header fade-in">
            <h2 class="section-title">Unit Populer</h2>
            <select class="tahun-select">
                <option value="2025">2025</option>
            </select>
        </div>
        <div class="grafik-card fade-in">
            <canvas id="unitPopulerChart"></canvas>
            <div class="chart-legend">
                <div class="legend-item">
                    <span class="legend-color" style="background: #3B82F6;"></span>
                    <span>Unit Penyewaan Alat</span>
                </div>
                <div class="legend-item">
                    <span class="legend-color" style="background: #10B981;"></span>
                    <span>Unit Pertanian dan Perkebunan</span>
                </div>
                <div class="legend-item">
                    <span class="legend-color" style="background: #F59E0B;"></span>
                    <span>Unit Penjualan Gas</span>
                </div>
                <div class="legend-item">
                    <span class="legend-color" style="background: #EF4444;"></span>
                    <span>Unit Simpan Pinjam</span>
                </div>
            </div>
        </div>
        <div class="text-center fade-in">
            <button class="btn-lihat-lengkap">Lihat Lengkap</button>
        </div>
    </div>
</section>

<!-- Tentang Kami Section -->
<section class="tentang-section">
    <div class="container">
        <h2 class="section-title fade-in">Tentang <span class="text-primary">Kami</span></h2>
        <div class="tentang-content fade-in">
            <p>iSewa hadir sebagai platform digital terpadu yang dirancang untuk memudahkan layanan operasional dan manajemen BUMDES secara digital. iSewa dikelola berdasarkan peraturan perundang-undangan yang menjaga prinsip transparansi, akuntabilitas, partisipatif, serta Selama hanya untuk kesejahteraan masyarakat desa.</p>
            
            <p>Dengan menghadirkan satu akses multi layanan, iSewa menjadi jembatan untuk Sewa secara lengkap dan efisien pada unit usaha yang dimiliki BUMDES DALAM memberikan solusi yang inovatif. Dengan Sistem berbasis digital yang mudah digunakan, iSewa memungkinkan seluruh pihak berinteraksi dengan cepat, selain itu, mudah, antara lain berkomunikasi dengan mudah.</p>
            
            <p>iSewa tidak hanya berkomitmen memberikan kemudahan pada akses layanan di BUMDES, namun juga memastikan bahwa setiap transaksi dilakukan dengan transparan dan aman. Dengan tampilan antarmuka pengguna yang intuitif, iSewa membuka ruang bagi masyarakat desa untuk berperan aktif dalam ekonomi desa melalui BUMDES sebagai penggerak utama ekonomi lokal.</p>
        </div>
    </div>
</section>
@endsection

@push('scripts')
<script src="{{ asset('js/dashboard.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.js"></script>
<script src="{{ asset('js/charts.js') }}"></script>
@endpush