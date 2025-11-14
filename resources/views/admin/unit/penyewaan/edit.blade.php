@extends('admin.layouts.app')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Unit Layanan / Penyewaan Alat /</span> Edit Alat</h4>

    <div class="row">
        <div class="col-xl-8">
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Form Edit Alat</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.unit.penyewaan.update', $barang->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label class="form-label" for="nama_barang">Nama Barang</label>
                            <input type="text" class="form-control" id="nama_barang" name="nama_barang" value="{{ old('nama_barang', $barang->nama_barang) }}" required />
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="deskripsi">Deskripsi</label>
                            <textarea class="form-control" id="deskripsi" name="deskripsi" rows="3" required>{{ old('deskripsi', $barang->deskripsi) }}</textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="harga_sewa">Harga Sewa (per pakai)</label>
                            <input type="number" class="form-control" id="harga_sewa" name="harga_sewa" step="0.01" value="{{ old('harga_sewa', $barang->harga_sewa) }}" required />
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="stok">Stok Tersedia</label>
                            <input type="number" class="form-control" id="stok" name="stok" value="{{ old('stok', $barang->stok) }}" required />
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="status">Status</label>
                            <select class="form-select" id="status" name="status" required>
                                <option value="tersedia" {{ $barang->status == 'tersedia' ? 'selected' : '' }}>Tersedia</option>
                                <option value="disewa" {{ $barang->status == 'disewa' ? 'selected' : '' }}>Disewa</option>
                                <option value="rusak" {{ $barang->status == 'rusak' ? 'selected' : '' }}>Rusak</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="kategori">Kategori</label>
                            <input type="text" class="form-control" id="kategori" name="kategori" value="{{ old('kategori', $barang->kategori) }}" readonly />
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="lokasi">Lokasi</label>
                            <input type="text" class="form-control" id="lokasi" name="lokasi" value="{{ old('lokasi', $barang->lokasi) }}" required />
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="foto">Foto Utama</label>
                            <input class="form-control" type="file" id="foto" name="foto" accept="image/*" />
                            @if($barang->foto)
                            <div class="mt-2">
                                <img src="{{ asset('storage/' . $barang->foto) }}" alt="{{ $barang->nama_barang }}" width="100">
                            </div>
                            @endif
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="foto_2">Foto Tambahan 1</label>
                            <input class="form-control" type="file" id="foto_2" name="foto_2" accept="image/*" />
                            @if($barang->foto_2)
                            <div class="mt-2">
                                <img src="{{ asset('storage/' . $barang->foto_2) }}" alt="{{ $barang->nama_barang }}" width="100">
                            </div>
                            @endif
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="foto_3">Foto Tambahan 2</label>
                            <input class="form-control" type="file" id="foto_3" name="foto_3" accept="image/*" />
                            @if($barang->foto_3)
                            <div class="mt-2">
                                <img src="{{ asset('storage/' . $barang->foto_3) }}" alt="{{ $barang->nama_barang }}" width="100">
                            </div>
                            @endif
                        </div>
                        <button type="submit" class="btn btn-primary">Update</button>
                        <a href="{{ route('admin.unit.penyewaan.index') }}" class="btn btn-secondary">Batal</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection