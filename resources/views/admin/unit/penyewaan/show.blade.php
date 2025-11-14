@extends('admin.layouts.app')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Unit Layanan / Penyewaan Alat /</span> Detail Alat</h4>

    <div class="row">
        <div class="col-xl-8">
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">{{ $barang->nama_barang }}</h5>
                    <a href="{{ route('admin.unit.penyewaan.edit', $barang->id) }}" class="btn btn-sm btn-outline-warning">Edit</a>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div id="carouselExample{{ $barang->id }}" class="carousel slide" data-bs-ride="carousel">
                                <div class="carousel-inner">
                                    <div class="carousel-item active">
                                        <img src="{{ asset('storage/' . $barang->foto) }}" class="d-block w-100" alt="{{ $barang->nama_barang }}">
                                    </div>
                                    @if($barang->foto_2)
                                    <div class="carousel-item">
                                        <img src="{{ asset('storage/' . $barang->foto_2) }}" class="d-block w-100" alt="{{ $barang->nama_barang }}">
                                    </div>
                                    @endif
                                    @if($barang->foto_3)
                                    <div class="carousel-item">
                                        <img src="{{ asset('storage/' . $barang->foto_3) }}" class="d-block w-100" alt="{{ $barang->nama_barang }}">
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
                        <div class="col-md-6">
                            <h5>Deskripsi</h5>
                            <p>{{ $barang->deskripsi }}</p>
                            <div class="mb-3">
                                <strong>Harga Sewa dihitung Sekali Pakai:</strong><br>
                                <span class="text-danger fs-4">Rp. {{ number_format($barang->harga_sewa, 0, ',', '.') }}</span>
                            </div>
                            <div class="mb-3">
                                <strong>Stok Tersedia:</strong> {{ $barang->stok }} Unit<br>
                                <strong>Status:</strong> {{ $barang->status }}<br>
                                <strong>Kategori:</strong> {{ $barang->kategori }}<br>
                                <strong>Lokasi:</strong> {{ $barang->lokasi }}
                            </div>
                            <div class="d-flex gap-2">
                                <a href="{{ route('admin.unit.penyewaan.index') }}" class="btn btn-secondary">Kembali</a>
                                <form action="{{ route('admin.unit.penyewaan.destroy', $barang->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus alat ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">Hapus</button>
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