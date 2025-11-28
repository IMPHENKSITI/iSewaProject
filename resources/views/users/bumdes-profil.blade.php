@extends('layouts.user')

@section('page')
<section class="relative z-10 min-h-screen pt-32 pb-16">
    <div class="max-w-7xl mx-auto px-6">
        <!-- Header -->
        <div class="text-center mb-12">
            <h1 class="text-4xl font-bold bg-gradient-to-r from-[#115789] to-blue-300 bg-clip-text text-transparent relative inline-block drop-shadow-[0_0_15px_rgba(59,130,246,0.5)]">
                Profil dan Layanan BUMDes
            </h1>
            <p class="text-gray-600 mt-4 text-lg">
                Informasi lengkap mengenai BUMDes dan layanan yang tersedia
            </p>
        </div>

        <!-- Content -->
        <div class="backdrop-blur-sm bg-white/60 rounded-3xl p-8 md:p-12 border border-white/70 shadow-xl">
            <div class="space-y-6 text-gray-700 text-base leading-relaxed">
                <p>
                    Halaman ini akan menampilkan profil dan layanan BUMDes yang tersedia di wilayah Bengkalis.
                </p>
                <p>
                    Konten akan disesuaikan dengan kebutuhan proyek Anda.
                </p>
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
</style>
@endpush