@extends('admin.layouts.admin')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Unit Layanan /</span> Penyewaan Alat</h4>
            <a href="{{ route('admin.unit.penyewaan.create') }}" class="btn btn-primary">Tambah Alat</a>
        </div>

        <!-- Products Grid -->
        <div class="row row-cols-1 row-cols-md-2 row-cols-xl-3 g-4">
            @foreach ($barangs as $barang)
                <div class="col">
                    <div class="card h-100 product-card">
                        <div class="position-relative">
                            <div id="carouselExample{{ $barang->id }}" class="carousel slide" data-bs-ride="carousel">
                                <div class="carousel-inner">
                                    <div class="carousel-item active">
                                        <img src="{{ asset('storage/' . $barang->foto) }}" class="card-img-top"
                                            alt="{{ $barang->nama_barang }}"
                                            style="height: 300px; object-fit: cover; object-position: center;">
                                    </div>
                                    @if ($barang->foto_2)
                                        <div class="carousel-item">
                                            <img src="{{ asset('storage/' . $barang->foto_2) }}" class="card-img-top"
                                                alt="{{ $barang->nama_barang }}"
                                                style="height: 300px; object-fit: cover; object-position: center;">
                                        </div>
                                    @endif
                                    @if ($barang->foto_3)
                                        <div class="carousel-item">
                                            <img src="{{ asset('storage/' . $barang->foto_3) }}" class="card-img-top"
                                                alt="{{ $barang->nama_barang }}"
                                                style="height: 300px; object-fit: cover; object-position: center;">
                                        </div>
                                    @endif
                                </div>
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
                        <div class="card-body">
                            <h5 class="card-title">{{ $barang->nama_barang }}</h5>
                            <p class="card-text">{{ Str::limit($barang->deskripsi, 100) }}</p>
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="badge bg-primary">Rp.
                                    {{ number_format($barang->harga_sewa, 0, ',', '.') }}</span>
                                <span class="badge bg-success">{{ $barang->stok }} {{ $barang->satuan }}</span>
                            </div>
                            <div class="mt-3 d-flex gap-2">
                                <a href="{{ route('admin.unit.penyewaan.show', $barang->id) }}"
                                    class="btn btn-sm btn-outline-info">Detail</a>
                                <a href="{{ route('admin.unit.penyewaan.edit', $barang->id) }}"
                                    class="btn btn-sm btn-outline-warning">Ubah</a>
                                <form action="{{ route('admin.unit.penyewaan.destroy', $barang->id) }}" method="POST"
                                    onsubmit="return confirm('Apakah Anda yakin ingin menghapus alat ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger">Hapus</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Pagination -->
        @if ($barangs->hasPages())
            <div class="mt-4 d-flex justify-content-center">
                <nav>
                    <ul class="pagination mb-0">
                        {{-- Sebelumnya --}}
                        @if ($barangs->onFirstPage())
                            <li class="page-item disabled">
                                <span class="page-link">« Sebelumnya</span>
                            </li>
                        @else
                            <li class="page-item">
                                <a class="page-link" href="{{ $barangs->previousPageUrl() }}" rel="prev">« Sebelumnya</a>
                            </li>
                        @endif

                        {{-- Selanjutnya --}}
                        @if ($barangs->hasMorePages())
                            <li class="page-item">
                                <a class="page-link" href="{{ $barangs->nextPageUrl() }}" rel="next">Selanjutnya »</a>
                            </li>
                        @else
                            <li class="page-item disabled">
                                <span class="page-link">Selanjutnya »</span>
                            </li>
                        @endif
                    </ul>
                </nav>
            </div>
        @endif
    </div>
@endsection

@push('styles')
<style>
    
    .card {
        transition: transform 0.2s ease;
        border-radius: 0.5rem;
        box-shadow: 0 4px 6px rgba(0,0,0,0.03);
    }
    .card:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 16px rgba(0,0,0,0.08);
    }
    .pagination .page-link {
        color: #495057;
        border: 1px solid #dee2e6;
        padding: 0.5rem 1rem;
        font-size: 0.875rem;
        border-radius: 0.375rem;
        transition: all 0.2s ease;
    }
    .pagination .page-link:hover {
        background-color: #f8f9fa;
        color: #0d6efd;
    }
    .pagination .page-item.active .page-link {
        background-color: #0d6efd;
        border-color: #0d6efd;
        color: white;
    }
    .pagination .page-item.disabled .page-link {
        color: #6c757d;
        background-color: #fff;
    }
</style>
@endpush