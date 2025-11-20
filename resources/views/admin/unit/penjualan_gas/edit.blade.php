@extends('layouts.admin')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <!-- Breadcrumb -->
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Unit Layanan / Penjualan Gas /</span> Ubah Gas</h4>

    <!-- Form Card -->
    <div class="row">
        <div class="col-xl-12">
            <div class="card mb-4 animate-fade-in">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Form Edit Gas</h5>
                </div>
                <div class="card-body">
                    {{-- ✅ DITAMBAHKAN: Tampilan error validasi --}}
                    @if ($errors->any())
                        <div class="alert alert-danger animate__animated animate__fadeIn">
                            <strong>Perhatian!</strong>
                            <ul class="mb-0 mt-2">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('admin.unit.penjualan_gas.update', $gas->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label class="form-label" for="jenis_gas">Jenis Gas</label>
                            <input type="text" class="form-control" id="jenis_gas" name="jenis_gas" value="{{ old('jenis_gas', $gas->jenis_gas) }}" required />
                        </div>

                        <div class="mb-3">
                            <label class="form-label" for="deskripsi">Deskripsi</label>
                            <textarea class="form-control" id="deskripsi" name="deskripsi" rows="3" required>{{ old('deskripsi', $gas->deskripsi) }}</textarea>
                        </div>

                        <div class="mb-3">
                            <label class="form-label" for="harga_satuan">Harga Satuan (Rp)</label>
                            <input type="text" class="form-control" id="harga_satuan" name="harga_satuan"
                                value="{{ old('harga_satuan', number_format($gas->harga_satuan, 0, ',', '.')) }}"
                                required oninput="formatRupiah(this)" />
                            <small class="form-text text-muted">Masukkan angka tanpa titik atau koma. Contoh: 21000</small>
                        </div>

                        <div class="mb-3">
                            <label class="form-label" for="stok">Stok Tersedia</label>
                            <div class="input-group">
                                <input type="number" class="form-control" id="stok" name="stok"
                                    value="{{ old('stok', $gas->stok) }}" required />
                                <select class="form-select" id="satuan" name="satuan" required>
                                    <option value="" disabled>Pilih Satuan</option>
                                    <option value="Unit" {{ old('satuan', $gas->satuan) == 'Unit' ? 'selected' : '' }}>Unit</option>
                                    <option value="Paket" {{ old('satuan', $gas->satuan) == 'Paket' ? 'selected' : '' }}>Paket</option>
                                    <option value="Set" {{ old('satuan', $gas->satuan) == 'Set' ? 'selected' : '' }}>Set</option>
                                </select>
                                <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#addSatuanModal">
                                    <i class="bx bx-plus"></i> Tambah Satuan
                                </button>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label" for="status">Status</label>
                            <select class="form-select" id="status" name="status" required>
                                <option value="tersedia" {{ old('status', $gas->status) == 'tersedia' ? 'selected' : '' }}>Tersedia</option>
                                <option value="dipesan" {{ old('status', $gas->status) == 'dipesan' ? 'selected' : '' }}>Dipesan</option>
                                <option value="rusak" {{ old('status', $gas->status) == 'rusak' ? 'selected' : '' }}>Rusak</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label" for="kategori">Kategori</label>
                            <div class="input-group">
                                <select class="form-select" id="kategori" name="kategori" required>
                                    <option value="" disabled>Pilih Kategori</option>
                                    <option value="Perlengkapan Acara" {{ old('kategori', $gas->kategori) == 'Perlengkapan Acara' ? 'selected' : '' }}>Perlengkapan Acara</option>
                                    <option value="Tenda Acara" {{ old('kategori', $gas->kategori) == 'Tenda Acara' ? 'selected' : '' }}>Tenda Acara</option>
                                    <option value="Dekorasi" {{ old('kategori', $gas->kategori) == 'Dekorasi' ? 'selected' : '' }}>Dekorasi</option>
                                </select>
                                <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#addCategoryModal">
                                    <i class="bx bx-plus"></i> Tambah Kategori
                                </button>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label" for="lokasi">Lokasi</label>
                            <input type="text" class="form-control" id="lokasi" name="lokasi"
                                value="{{ old('lokasi', $gas->lokasi ?? 'Desa Pematang Duku Timur') }}" required />
                        </div>

                        <!-- Foto Utama -->
                        <div class="mb-3">
                            <label class="form-label" for="foto">Foto Utama</label>
                            <div class="input-group">
                                <input type="file" class="form-control" id="foto" name="foto"
                                    accept="image/*" onchange="previewFile(this, 'preview_foto')" />
                                <button type="button" class="btn btn-outline-secondary" onclick="clearFile('foto', 'preview_foto')">Hapus</button>
                            </div>
                            @if($gas->foto)
                                <div id="preview_foto" class="mt-2">
                                    <img src="{{ asset('storage/' . $gas->foto) }}" alt="{{ $gas->jenis_gas }}"
                                        class="img-fluid rounded" style="max-height: 200px;" />
                                </div>
                            @else
                                <div id="preview_foto" class="mt-2" style="display:none;">
                                    <img src="#" alt="Preview" class="img-fluid rounded" style="max-height: 200px;" />
                                </div>
                            @endif
                        </div>

                        <!-- Foto Tambahan 1 -->
                        <div class="mb-3">
                            <label class="form-label" for="foto_2">Foto Tambahan 1</label>
                            <div class="input-group">
                                <input type="file" class="form-control" id="foto_2" name="foto_2"
                                    accept="image/*" onchange="previewFile(this, 'preview_foto_2')" />
                                <button type="button" class="btn btn-outline-secondary" onclick="clearFile('foto_2', 'preview_foto_2')">Hapus</button>
                            </div>
                            @if($gas->foto_2)
                                <div id="preview_foto_2" class="mt-2">
                                    <img src="{{ asset('storage/' . $gas->foto_2) }}" alt="{{ $gas->jenis_gas }}"
                                        class="img-fluid rounded" style="max-height: 200px;" />
                                </div>
                            @else
                                <div id="preview_foto_2" class="mt-2" style="display:none;">
                                    <img src="#" alt="Preview" class="img-fluid rounded" style="max-height: 200px;" />
                                </div>
                            @endif
                        </div>

                        <!-- Foto Tambahan 2 -->
                        <div class="mb-3">
                            <label class="form-label" for="foto_3">Foto Tambahan 2</label>
                            <div class="input-group">
                                <input type="file" class="form-control" id="foto_3" name="foto_3"
                                    accept="image/*" onchange="previewFile(this, 'preview_foto_3')" />
                                <button type="button" class="btn btn-outline-secondary" onclick="clearFile('foto_3', 'preview_foto_3')">Hapus</button>
                            </div>
                            @if($gas->foto_3)
                                <div id="preview_foto_3" class="mt-2">
                                    <img src="{{ asset('storage/' . $gas->foto_3) }}" alt="{{ $gas->jenis_gas }}"
                                        class="img-fluid rounded" style="max-height: 200px;" />
                                </div>
                            @else
                                <div id="preview_foto_3" class="mt-2" style="display:none;">
                                    <img src="#" alt="Preview" class="img-fluid rounded" style="max-height: 200px;" />
                                </div>
                            @endif
                        </div>

                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('admin.unit.penjualan_gas.index') }}" class="btn btn-secondary">Batal</a>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Tambah Kategori -->
<div class="modal fade" id="addCategoryModal" tabindex="-1" aria-labelledby="addCategoryModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addCategoryModalLabel">Tambah Kategori Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label for="new_kategori" class="form-label">Nama Kategori</label>
                    <input type="text" class="form-control" id="new_kategori" placeholder="Contoh: Perlengkapan Pesta">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-primary" id="saveCategoryBtn">Simpan</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Tambah Satuan -->
<div class="modal fade" id="addSatuanModal" tabindex="-1" aria-labelledby="addSatuanModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addSatuanModalLabel">Tambah Satuan Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label for="new_satuan" class="form-label">Nama Satuan</label>
                    <input type="text" class="form-control" id="new_satuan" placeholder="Contoh: Paket">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-primary" id="saveSatuanBtn">Simpan</button>
            </div>
        </div>
    </div>
</div>

<!-- Script (COPIED langsung dari create.blade.php - 100% konsisten) -->
<script>
function formatRupiah(input) {
    let value = input.value.replace(/\D/g, '');
    if (value) {
        value = new Intl.NumberFormat('id-ID').format(value);
        input.value = value;
    }
}

function previewFile(input, previewId) {
    const preview = document.getElementById(previewId);
    const img = preview.querySelector('img');
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            img.src = e.target.result;
            preview.style.display = 'block';
        };
        reader.readAsDataURL(input.files[0]);
    } else {
        preview.style.display = 'none';
    }
}

function clearFile(inputId, previewId) {
    const input = document.getElementById(inputId);
    const preview = document.getElementById(previewId);
    const img = preview.querySelector('img');

    input.value = '';
    img.src = '#';
    preview.style.display = 'none';
}

// Tambah Kategori
document.getElementById('saveCategoryBtn')?.addEventListener('click', function() {
    const newKategori = document.getElementById('new_kategori')?.value.trim();
    if (newKategori) {
        const select = document.getElementById('kategori');
        const option = document.createElement('option');
        option.value = newKategori;
        option.textContent = newKategori;
        select.appendChild(option);
        select.value = newKategori;
        bootstrap.Modal.getInstance(document.getElementById('addCategoryModal'))?.hide();
        document.getElementById('new_kategori').value = '';
    } else {
        alert('Silakan masukkan nama kategori.');
    }
});

// Tambah Satuan
document.getElementById('saveSatuanBtn')?.addEventListener('click', function() {
    const newSatuan = document.getElementById('new_satuan')?.value.trim();
    if (newSatuan) {
        const select = document.getElementById('satuan');
        const option = document.createElement('option');
        option.value = newSatuan;
        option.textContent = newSatuan;
        select.appendChild(option);
        select.value = newSatuan;
        bootstrap.Modal.getInstance(document.getElementById('addSatuanModal'))?.hide();
        document.getElementById('new_satuan').value = '';
    } else {
        alert('Silakan masukkan nama satuan.');
    }
});
</script>
@endsection