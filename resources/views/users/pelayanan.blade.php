@extends('layouts.user')

@section('page')
    {{-- SECTION PELAYANAN --}}
    <section id="pelayanan" class="relative min-h-screen py-20">
        {{-- Background Decorations --}}
        <div class="absolute top-0 right-0 w-96 h-96 pointer-events-none overflow-hidden">
            <div class="absolute top-0 right-0 w-full h-full bg-gradient-to-bl from-blue-200/40 via-blue-300/30 to-transparent"
                style="clip-path: polygon(100% 0, 100% 100%, 40% 100%, 0 0);"></div>
        </div>

        <div class="absolute bottom-0 left-0 w-96 h-64 pointer-events-none">
            <div class="absolute bottom-0 left-0 w-full h-full bg-gradient-to-tr from-blue-300/30 via-yellow-200/20 to-transparent rounded-tr-full">
            </div>
        </div>

        <div class="absolute bottom-0 right-0 w-80 h-80 pointer-events-none">
            <div class="absolute bottom-0 right-0 w-full h-full bg-gradient-to-tl from-yellow-200/30 via-blue-200/20 to-transparent rounded-tl-full">
            </div>
        </div>

        <div class="relative z-10 max-w-6xl mx-auto px-6">
            {{-- Header --}}
            <div class="text-left mb-16 mt-8">
                <h1 class="text-5xl font-bold mb-2">
                    <span class="text-gray-900">Pela</span><span
                        class="bg-gradient-to-r from-[#115789] to-blue-400 bg-clip-text text-transparent">yanan</span>
                </h1>
            </div>

            {{-- Services Container --}}
            <div class="space-y-6">
                {{-- Service 1: Unit Penyewaan Alat --}}
                <div
                    class="bg-white/80 backdrop-blur-sm rounded-2xl p-8 shadow-md hover:shadow-xl transition-all duration-300 border border-white/50">
                    <div class="flex flex-col md:flex-row gap-8 items-start">
                        <div class="flex-shrink-0">
                            <div class="w-32 h-32 flex items-center justify-center">
                                <img src="{{ asset('User/img/elemen/F0.png') }}" alt="Unit Penyewaan Alat"
                                    class="w-full h-full object-contain drop-shadow-md">
                            </div>
                        </div>
                        <div class="flex-1">
                            <h3 class="text-2xl font-bold text-gray-900 mb-4">Unit Penyewaan Alat</h3>
                            <p class="text-gray-700 leading-relaxed text-justify">
                                Masyarakat dapat melakukan pemesanan sewa alat seperti tenda, kursi, meja, sound system, dan
                                diesel secara online. Sistem menampilkan ketersediaan alat secara real-time, harga sewa yang
                                transparan, serta bukti transaksi digital. Hal ini membantu menghindari bentrok jadwal dan
                                mempercepat pelayanan warga tanpa harus datang langsung ke kantor BUMDes
                            </p>
                        </div>
                    </div>
                </div>

                {{-- Service 2: Hasil Panen dan Penjualan Usaha Desa --}}
                <div
                    class="bg-white/80 backdrop-blur-sm rounded-2xl p-8 shadow-md hover:shadow-xl transition-all duration-300 border border-white/50">
                    <div class="flex flex-col md:flex-row gap-8 items-start">
                        <div class="flex-shrink-0">
                            <div class="w-32 h-32 flex items-center justify-center">
                                <img src="{{ asset('User/img/elemen/bermitra.png') }}"
                                    alt="Hasil Panen dan Penjualan Usaha Desa"
                                    class="w-full h-full object-cover rounded-xl drop-shadow-md">
                            </div>
                        </div>
                        <div class="flex-1">
                            <h3 class="text-2xl font-bold text-gray-900 mb-4">Hasil Panen dan Penjualan Usaha Desa</h3>
                            <p class="text-gray-700 leading-relaxed text-justify">
                                Petani dapat menginput data hasil panen seperti ubi dan pucuk ubi, termasuk jumlah, harga jual,
                                dan tanggal panen. Data tersebut kemudian diverifikasi dan dijadikan laporan penjualan dan
                                pendapatan unit pertanian. Layanan ini membantu petani dan BUMDes mencatat hasil usaha secara
                                lebih terstruktur, transparan, dan terdigitalisasi, sehingga mempermudah pengawasan serta
                                pelaporan kepada pemerintah desa.
                            </p>
                        </div>
                    </div>
                </div>

                {{-- Service 3: Layanan Kemitraan BUMDes --}}
                <div
                    class="bg-white/80 backdrop-blur-sm rounded-2xl p-8 shadow-md hover:shadow-xl transition-all duration-300 border border-white/50">
                    <div class="flex flex-col md:flex-row gap-8 items-start">
                        <div class="flex-shrink-0">
                            <div class="w-32 h-32 flex items-center justify-center">
                                <img src="{{ asset('User/img/elemen/C1.png') }}"
                                    alt="Layanan Kemitraan BUMDes"
                                    class="w-full h-full object-contain drop-shadow-md">
                            </div>
                        </div>
                        <div class="flex-1">
                            <h3 class="text-2xl font-bold text-gray-900 mb-4">Layanan Kemitraan BUMDes</h3>
                            <p class="text-gray-700 leading-relaxed text-justify">
                                Kemitraan memfasilitasi kerja sama antara petani, pelaku usaha, dan BUMDes. Melalui sistem ini,
                                pengajuan dan konfirmasi kemitraan dapat dilakukan secara transparan dan terdokumentasi. Setiap
                                proses akan diverifikasi oleh BUMDes, dan notifikasi akan dikirim otomatis ke masing-masing
                                pihak yang terlibat
                            </p>
                        </div>
                    </div>
                </div>

                {{-- Service 4: Pelaporan dan Monitoring Usaha --}}
                <div
                    class="bg-white/80 backdrop-blur-sm rounded-2xl p-8 shadow-md hover:shadow-xl transition-all duration-300 border border-white/50">
                    <div class="flex flex-col md:flex-row gap-8 items-start">
                        <div class="flex-shrink-0">
                            <div class="w-32 h-32 flex items-center justify-center">
                                <img src="{{ asset('User/img/elemen/C2.png') }}"
                                    alt="Pelaporan dan Monitoring Usaha"
                                    class="w-full h-full object-contain drop-shadow-md">
                            </div>
                        </div>
                        <div class="flex-1">
                            <h3 class="text-2xl font-bold text-gray-900 mb-4">Pelaporan dan Monitoring Usaha</h3>
                            <p class="text-gray-700 leading-relaxed text-justify">
                                Laporan keuangan, laporan transaksi, serta kinerja unit usaha secara otomatis dan real-time.
                                Sistem ini membantu meningkatkan akuntabilitas dan mempermudah evaluasi pengelolaan dana desa
                                dengan laporan digital yang rapi dan terintegrasi
                            </p>
                        </div>
                    </div>
                </div>

                {{-- Service 5: Simpan Pinjam dan Penjualan Gas Desa --}}
                <div
                    class="bg-white/80 backdrop-blur-sm rounded-2xl p-8 shadow-md hover:shadow-xl transition-all duration-300 border border-white/50">
                    <div class="flex flex-col md:flex-row gap-8 items-start">
                        <div class="flex-shrink-0">
                            <div class="w-32 h-32 flex items-center justify-center">
                                <img src="{{ asset('User/img/elemen/C3.png') }}"
                                    alt="Simpan Pinjam dan Penjualan Gas Desa"
                                    class="w-full h-full object-contain drop-shadow-md">
                            </div>
                        </div>
                        <div class="flex-1">
                            <h3 class="text-2xl font-bold text-gray-900 mb-4">Simpan Pinjam dan Penjualan Gas Desa</h3>
                            <p class="text-gray-700 leading-relaxed text-justify">
                                Warga dapat mengajukan pinjaman modal usaha atau membeli tabung gas seperti gas LPG 3 kg secara
                                digital melalui sistem iSewa. Proses pencatatan transaksi, validasi pembayaran, dan laporan
                                penjualan dilakukan otomatis oleh sistem untuk menjamin transparansi dan keakuratan data
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('styles')
    <style>
        * {
            font-family: 'Inter', sans-serif;
        }

        /* Smooth scroll behavior */
        html {
            scroll-behavior: smooth;
        }

        /* Additional responsive adjustments */
        @media (max-width: 768px) {
            .text-5xl {
                font-size: 2.5rem;
            }

            .text-2xl {
                font-size: 1.5rem;
            }
        }
    </style>
@endpush

@push('scripts')
    <script>
        // Smooth scrolling for navigation links
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
                }
            });
        });
    </script>
@endpush