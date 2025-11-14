@extends('admin.layouts.app')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Unit Layanan / Penyewaan Alat /</span> Tambah Alat</h4>

    <div class="row">
        <div class="col-xl-8">
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Form Tambah Alat</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.unit.penyewaan.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label" for="nama_barang">Nama Barang</label>
                            <input type="text" class="form-control" id="nama_barang" name="nama_barang" required />
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="deskripsi">Deskripsi</label>
                            <textarea class="form-control" id="deskripsi" name="deskripsi" rows="3" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="harga_sewa">Harga Sewa (per pakai)</label>
                            <input type="number" class="form-control" id="harga_sewa" name="harga_sewa" step="0.01" required />
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="stok">Stok Tersedia</label>
                            <input type="number" class="form-control" id="stok" name="stok" required />
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="status">Status</label>
                            <select class="form-select" id="status" name="status" required>
                                <option value="tersedia">Tersedia</option>
                                <option value="disewa">Disewa</option>
                                <option value="rusak">Rusak</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="kategori">Kategori</label>
                            <input type="text" class="form-control" id="kategori" name="kategori" value="Per lengkapan Acara" readonly />
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="lokasi">Lokasi</label>
                            <input type="text" class="form-control" id="lokasi" name="lokasi" value="Desa Pematang Duku Timur" required />
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="foto">Foto Utama</label>
                            <input class="form-control" type="file" id="foto" name="foto" accept="image/*" />
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="foto_2">Foto Tambahan 1</label>
                            <input class="form-control" type="file" id="foto_2" name="foto_2" accept="image/*" />
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="foto_3">Foto Tambahan 2</label>
                            <input class="form-control" type="file" id="foto_3" name="foto_3" accept="image/*" />
                        </div>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                        <a href="{{ route('admin.unit.penyewaan.index') }}" class="btn btn-secondary">Batal</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection