@extends('admin.layouts.admin')

@section('title', 'Profil iSewa')

@section('content')
<link rel="stylesheet" href="{{ asset('css/isewa-profile.css') }}">

<div class="isewa-">

    <!-- HERO -->
    <header class="hero">
        <div class="hero-inner container-xxl">
            <!-- LEFT -->
            <div class="hero-left">
                <h2 class="heading-small">Cerita <span class="accent">Kami</span></h2>
                <h1 class="hero-title">Memberikan Solusi Digital untuk Kemajuan Desa</h1>

                <div class="hero-paragraphs">
                    <p>
                        iSewa merupakan platform digital terpadu yang dirancang untuk mendukung kegiatan operasional dan pelayanan BUMDes secara modern dan efisien. Sistem ini hadir sebagai solusi inovatif untuk mengelola berbagai unit usaha desa, seperti penyewaan alat dan layanan pembelian gas.
                    </p>
                    <p>
                        Melalui iSewa, proses administrasi dan transaksi menjadi lebih cepat, transparan, dan mudah dijangkau oleh masyarakat desa. Dengan berbasis sistem terintegrasi, seluruh data penyewaan, transaksi, dan laporan dapat dikelola secara otomatis dan terdokumentasi dengan baik. Dengan mengedepankan kemudahan akses dan efisiensi layanan, iSewa membantu BUMDes dalam meningkatkan produktivitas, serta memperkuat perekonomian desa secara berkelanjutan.
                    </p>
                </div>
            </div>

            <!-- RIGHT LOGO -->
            <div class="hero-right">
                <div class="logo-wrap">
                    <img src="{{ asset('http://isewaproject.test/Admin/img/avatars/sewais.png') }}" alt="Logo iSewa">
                </div>
            </div>
        </div>
    </header>

    <!-- NILAI KAMI -->
    <section class="section nilai-kami container-xxl">
        <h2 class="section-title">Nilai <span class="accent">Kami</span></h2>
        
        <div class="nilai-grid">
            <ul class="nilai-list">
                <li><span class="dot"></span> <strong>Transparansi</strong> Semua transaksi dan laporan dilakukan secara terbuka dan dapat diawasi oleh pihak terkait</li>
                <li><span class="dot"></span> <strong>Efisiensi</strong> Memangkas proses manual menjadi otomatis agar pelayanan lebih cepat dan akurat</li>
                <li><span class="dot"></span> <strong>Inovasi</strong> Menghadirkan teknologi digital yang relevan dengan kebutuhan desa</li>
                <li><span class="dot"></span> <strong>Kemandirian</strong> Mendorong BUMDes agar mampu mengelola unit usaha secara mandiri dan profesional</li>
                <li><span class="dot"></span> <strong>Akuntabilitas</strong> Menjamin setiap data tercatat dan dapat dipertanggungjawabkan</li>
            </ul>
        </div>
    </section>

    <!-- FUNGSI UTAMA -->
    <section class="section fungsi container-xxl">
        <h2 class="section-title">Fungsi <span class="accent">Utama</span></h2>

        <div class="card functions-card">
            <div class="card-inner">
                <div class="func-grid">

                    <div class="func-item">
                    
                        <div class="func-body">
                            <h4>Digitalisasi Penyewaan Alat Desa</h4>
                            <p>Menyediakan layanan pemesanan alat (tenda, kursi, meja, sound system, diesel) secara online dengan pencatatan otomatis</p>
                        </div>
                    </div>

                    <div class="func-item">
                    
                        <div class="func-body">
                            <h4>Pengelolaan Unit Usaha</h4>
                            <p>Mengatur transaksi dan laporan pada unit gas</p>
                        </div>
                    </div>

                    <div class="func-item">
                    
                        <div class="func-body">
                            <h4>Pelaporan dan Monitoring</h4>
                            <p>Menyediakan laporan penyewaan, transaksi, dan keuangan yang dapat diakses oleh BUMDes dan Pemerintah Desa</p>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>

    <!-- MISI -->
    <section class="section misi container-xxl">
        <h2 class="section-title">Misi</h2>

        <div class="card misi-card">
            <div class="card-inner">
                <ul class="misi-list">
                    <li><span class="check">✔</span> Meningkatkan efisiensi dan profesionalitas pengelolaan unit usaha desa</li>
                    <li><span class="check">✔</span> Menyediakan layanan digital yang mudah diakses oleh masyarakat dan pelaku usaha desa</li>
                    <li><span class="check">✔</span> Membangun kepercayaan masyarakat melalui transparansi data digital</li>
                    <li><span class="check">✔</span> Mendorong digitalisasi desa menuju tata kelola ekonomi mandiri & modern</li>
                </ul>
            </div>
        </div>
    </section>

    <!-- STRUKTUR PENGEMBANG -->
    <section class="section pengembang container-xxl">
        <h2 class="section-title">Struktur <span class="accent">Pengembang iSewa</span></h2>

        <div class="pengembang-row">

            <div class="dev-card">
                <div class="dev-card-bg"></div>
                <div class="avatar">
                    <img src="{{ asset('http://isewaproject.test/Admin/img/avatars/wahid1.jpg') }}" alt="M.Wahid Riono">
                </div>
                <h5>M.Wahid Riono</h5>

            </div>

            <div class="dev-card">
                <div class="dev-card-bg"></div>
                <div class="avatar">
                    <img src="{{ asset('http://isewaproject.test/Admin/img/avatars/ayep12.jpg') }}" alt="Mushlihul Arif">
                </div>
                <h5>Mushlihul Arif</h5>
                
            </div>

            <div class="dev-card">
                <div class="dev-card-bg"></div>
                <div class="avatar">
                    <img src="{{ asset('http://isewaproject.test/Admin/img/avatars/wanita.png') }}" alt="Safika">
                </div>
                <h5>Safika</h5>
                
            </div>

        </div>
    </section>
</div>
@endsection


@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {

    const items = document.querySelectorAll('.section, .hero-inner, .pengembang-row, .partners-row');

    const observer = new IntersectionObserver(entries => {
        entries.forEach(e => {
            if (e.isIntersecting) e.target.classList.add('inview');
        });
    }, { threshold: 0.15 });

    items.forEach(el => observer.observe(el));

    // Sidebar Active
    const path = window.location.pathname;
    const link = document.querySelector(`a[href="${path}"]`);
    if (link) {
        const li = link.closest('li');
        if (li) li.classList.add('active');
    }
});
</script>
@endsection