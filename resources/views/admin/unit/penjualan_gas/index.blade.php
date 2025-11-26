@extends('admin.layouts.admin')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Unit Layanan /</span> Penjualan Gas</h4>
            <a href="{{ route('admin.unit.penjualan_gas.create') }}" class="btn btn-primary">Tambah Gas</a>
        </div>

        <!-- Products Grid -->
        <div class="row row-cols-1 row-cols-md-2 row-cols-xl-3 g-4">
            @foreach ($gases as $gas)
                <div class="col">
                    <div class="card h-100 product-card">
                        <div class="position-relative">
                            <div id="carouselExample{{ $gas->id }}" class="carousel slide" data-bs-ride="carousel">
                                <div class="carousel-inner">
                                    <div class="carousel-item active">
                                        <img src="{{ asset('storage/' . $gas->foto) }}" class="card-img-top"
                                            alt="{{ $gas->jenis_gas }}"
                                            style="height: 300px; object-fit: cover; object-position: center;">
                                    </div>
                                    @if ($gas->foto_2)
                                        <div class="carousel-item">
                                            <img src="{{ asset('storage/' . $gas->foto_2) }}" class="card-img-top"
                                                alt="{{ $gas->jenis_gas }}"
                                                style="height: 300px; object-fit: cover; object-position: center;">
                                        </div>
                                    @endif
                                    @if ($gas->foto_3)
                                        <div class="carousel-item">
                                            <img src="{{ asset('storage/' . $gas->foto_3) }}" class="card-img-top"
                                                alt="{{ $gas->jenis_gas }}"
                                                style="height: 300px; object-fit: cover; object-position: center;">
                                        </div>
                                    @endif
                                </div>
                                <button class="carousel-control-prev" type="button"
                                    data-bs-target="#carouselExample{{ $gas->id }}" data-bs-slide="prev">
                                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                    <span class="visually-hidden">Previous</span>
                                </button>
                                <button class="carousel-control-next" type="button"
                                    data-bs-target="#carouselExample{{ $gas->id }}" data-bs-slide="next">
                                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                    <span class="visually-hidden">Next</span>
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <h5 class="card-title">{{ $gas->jenis_gas }}</h5>
                            <p class="card-text">{{ Str::limit($gas->deskripsi, 100) }}</p>
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="badge bg-primary">Rp.
                                    {{ number_format($gas->harga_satuan, 0, ',', '.') }}</span>
                                <span class="badge bg-success">{{ $gas->stok }} {{ Str::upper($gas->satuan) }}</span>
                            </div>
                            <div class="mt-3 d-flex gap-2">
                                <a href="{{ route('admin.unit.penjualan_gas.show', $gas->id) }}"
                                    class="btn btn-sm btn-outline-info">Detail</a>
                                <a href="{{ route('admin.unit.penjualan_gas.edit', $gas->id) }}"
                                    class="btn btn-sm btn-outline-warning">Ubah</a>
                                <form action="{{ route('admin.unit.penjualan_gas.destroy', $gas->id) }}" method="POST"
                                    onsubmit="return confirm('Apakah Anda yakin ingin menghapus gas ini?');">
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

        <!-- Pagination: Bahasa Indonesia -->
        @if ($gases->hasPages())
            <div class="mt-4 d-flex justify-content-center">
                <nav>
                    <ul class="pagination mb-0">
                        {{-- Sebelumnya --}}
                        @if ($gases->onFirstPage())
                            <li class="page-item disabled">
                                <span class="page-link">« Sebelumnya</span>
                            </li>
                        @else
                            <li class="page-item">
                                <a class="page-link" href="{{ $gases->previousPageUrl() }}" rel="prev">« Sebelumnya</a>
                            </li>
                        @endif

                        {{-- Selanjutnya --}}
                        @if ($gases->hasMorePages())
                            <li class="page-item">
                                <a class="page-link" href="{{ $gases->nextPageUrl() }}" rel="next">Selanjutnya »</a>
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