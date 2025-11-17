@extends('layouts.admin')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <!-- Breadcrumb -->
        <h4 class="fw-bold py-3 mb-4">
            <span class="text-muted fw-light">Unit Layanan / Penyewaan Alat /</span> Detail Alat
        </h4>

        <!-- Detail Card -->
<div class="row">
    <div class="col-xl-15">
        <div class="card mb-4 shadow-sm border-0">
            <div class="card-body">
                <div class="d-flex align-items-start">

                    <!-- Gambar Carousel -->
                    <div class="me-4 flex-shrink-0" style="width: 380px;">
                        <div class="position-relative">
                            <div id="carouselExample{{ $barang->id }}" class="carousel slide" data-bs-ride="carousel">
                                <div class="carousel-inner">
                                    <div class="carousel-item active">
                                        <img src="{{ asset('storage/' . $barang->foto) }}" class="card-img-top"
                                            alt="{{ $barang->nama_barang }}"
                                            style="height: 300px; object-fit: cover; object-position: center; border-radius: 8px;">
                                    </div>
                                    @if ($barang->foto_2)
                                        <div class="carousel-item">
                                            <img src="{{ asset('storage/' . $barang->foto_2) }}" class="card-img-top"
                                                alt="{{ $barang->nama_barang }}"
                                                style="height: 300px; object-fit: cover; object-position: center; border-radius: 8px;">
                                        </div>
                                    @endif
                                    @if ($barang->foto_3)
                                        <div class="carousel-item">
                                            <img src="{{ asset('storage/' . $barang->foto_3) }}" class="card-img-top"
                                                alt="{{ $barang->nama_barang }}"
                                                style="height: 300px; object-fit: cover; object-position: center; border-radius: 8px;">
                                        </div>
                                    @endif
                                </div>

                                <!-- Tombol Prev/Next (Diperbaiki sesuai gambar referensi) -->
                                <button class="carousel-control-prev" type="button"
                                    data-bs-target="#carouselExample{{ $barang->id }}" data-bs-slide="prev">
                                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                    <span class="visually-hidden">Previous</span>
                                </button>
                                <button class="carousel-control-next" type="button"
                                    data-bs-target="#carouselExample{{ $barang->id }}" data-bs-slide="next">
                                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                    <span class="visually-hidden">Next</span>
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Info Detail & Tombol Aksi (Diperluas ke kanan) -->
                    <div class="flex-grow-1" style="min-width: 0;"> <!-- Menambahkan min-width untuk mencegah kolaps -->
                        <h5 class="card-title fw-semibold">{{ $barang->nama_barang }}</h5>
                        <p class="text-muted mb-4">{{ $barang->deskripsi }}</p>

                        <div class="mb-3">
                            <strong>Harga Sewa:</strong> <span class="text-danger fs-5">Rp. {{ number_format($barang->harga_sewa, 0, ',', '.') }}</span>
                        </div>

                        <div class="row g-3 mb-4">
                            <div class="col-md-6">
                                <strong>Stok Tersedia:</strong> {{ $barang->stok }} {{ $barang->satuan }}
                            </div>
                            <div class="col-md-6">
                                <strong>Status:</strong> {{ ucfirst($barang->status) }}
                            </div>
                            <div class="col-md-6">
                                <strong>Kategori:</strong> {{ $barang->kategori }}
                            </div>
                            <div class="col-md-6">
                                <strong>Lokasi:</strong> {{ $barang->lokasi }}
                            </div>
                        </div>

                        <!-- Tombol Aksi (Dibuat sejajar dengan ujung bawah gambar) -->
                        <div class="d-flex gap-2 align-items-end">
                            <a href="{{ route('admin.unit.penyewaan.edit', $barang->id) }}"
                                class="btn btn-warning btn-sm">Ubah</a>
                            <a href="{{ route('admin.unit.penyewaan.index') }}"
                                class="btn btn-secondary btn-sm">Kembali</a>
                            <form action="{{ route('admin.unit.penyewaan.destroy', $barang->id) }}" method="POST"
                                onsubmit="return confirm('Apakah Anda yakin ingin menghapus alat ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
    </div>
@endsection

@push('styles')
<style>
    /* Elegan & bersih */
    .card {
        transition: all 0.2s ease;
    }
    .card:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 20px rgba(0,0,0,0.08);
    }
    .carousel-control-prev-icon,
    .carousel-control-next-icon {
        width: 30px;
        height: 30px;
        opacity: 0.8;
    }
    .carousel-control-prev-icon:hover,
    .carousel-control-next-icon:hover {
        opacity: 1;
    }
    .btn-sm {
        padding: 0.375rem 0.75rem;
        font-size: 0.875rem;
    }
</style>
@endpush