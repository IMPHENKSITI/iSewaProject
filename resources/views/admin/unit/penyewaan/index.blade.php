@extends('layouts.admin')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Unit Layanan /</span> Penyewaan Alat</h4>
        <a href="{{ route('admin.unit.penyewaan.create') }}" class="btn btn-primary">Tambah Alat</a>
    </div>

    <!-- Search Bar -->
    <div class="mb-4">
        <form action="{{ route('admin.unit.penyewaan.index') }}" method="GET">
            <div class="input-group">
                <input type="text" name="search" class="form-control" placeholder="Cari alat..." value="{{ request('search') }}">
                <button class="btn btn-outline-secondary" type="submit">Cari</button>
            </div>
        </form>
    </div>

    <!-- Products Grid -->
    <div class="row row-cols-1 row-cols-md-2 row-cols-xl-3 g-4">
        @foreach($barangs as $barang)
        <div class="col">
            <div class="card h-100 product-card">
                <div class="position-relative">
                    <div id="carouselExample{{ $barang->id }}" class="carousel slide" data-bs-ride="carousel">
                        <div class="carousel-inner">
                            <div class="carousel-item active">
                                <img src="{{ asset('storage/' . $barang->foto) }}" class="card-img-top" alt="{{ $barang->nama_barang }}">
                            </div>
                            @if($barang->foto_2)
                            <div class="carousel-item">
                                <img src="{{ asset('storage/' . $barang->foto_2) }}" class="card-img-top" alt="{{ $barang->nama_barang }}">
                            </div>
                            @endif
                            @if($barang->foto_3)
                            <div class="carousel-item">
                                <img src="{{ asset('storage/' . $barang->foto_3) }}" class="card-img-top" alt="{{ $barang->nama_barang }}">
                            </div>
                            @endif
                        </div>
                        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExample{{ $barang->id }}" data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Previous</span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#carouselExample{{ $barang->id }}" data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Next</span>
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <h5 class="card-title">{{ $barang->nama_barang }}</h5>
                    <p class="card-text">{{ Str::limit($barang->deskripsi, 100) }}</p>
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="badge bg-primary">Rp. {{ number_format($barang->harga_sewa, 0, ',', '.') }}</span>
                        <span class="badge bg-success">{{ $barang->stok }} Unit</span>
                    </div>
                    <div class="mt-3 d-flex gap-2">
                        <a href="{{ route('admin.unit.penyewaan.show', $barang->id) }}" class="btn btn-sm btn-outline-info">Detail</a>
                        <a href="{{ route('admin.unit.penyewaan.edit', $barang->id) }}" class="btn btn-sm btn-outline-warning">Edit</a>
                        <form action="{{ route('admin.unit.penyewaan.destroy', $barang->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus alat ini?');">
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
    <div class="mt-4">
        {{ $barangs->links() }}
    </div>
</div>
@endsection