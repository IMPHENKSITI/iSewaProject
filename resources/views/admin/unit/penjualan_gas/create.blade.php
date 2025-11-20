@extends('layouts.admin')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <!-- Breadcrumb -->
        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Unit Layanan / Penjualan Gas /</span> Tambah Gas</h4>

        <!-- Form Card -->
        <div class="row">
            <div class="col-xl-12">
                <div class="card mb-4 animate-fade-in">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Form Tambah Gas</h5>
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

                        <form action="{{ route('admin.unit.penjualan_gas.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf <!-- ⚠️ Pastikan ini ada -->
                            <div class="mb-3">
                                <label class="form-label" for="jenis_gas">Jenis Gas</label>
                                <input type="text" class="form-control" id="jenis_gas" name="jenis_gas" required />
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="deskripsi">Deskripsi</label>
                                <textarea class="form-control" id="deskripsi" name="deskripsi" rows="3" required></textarea>
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="harga_satuan">Harga Satuan (Rp)</label>
                                <input type="text" class="form-control" id="harga_satuan" name="harga_satuan" required oninput="formatRupiah(this)" />
                                <small class="form-text text-muted">Masukkan angka tanpa titik atau koma. Contoh: 21000</small>
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="stok">Stok Tersedia</label>
                                <div class="input-group">
                                    <input type="number" class="form-control" id="stok" name="stok" required />
                                    <select class="form-select" id="satuan" name="satuan" required>
                                        <option value="" disabled selected>Pilih Satuan</option>
                                        <option value="Unit">Unit</option>
                                        <option value="Paket">Paket</option>
                                        <option value="Set">Set</option>
                                    </select>
                                    <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#addSatuanModal">
                                        <i class="bx bx-plus"></i> Tambah Satuan
                                    </button>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="status">Status</label>
                                <select class="form-select" id="status" name="status" required>
                                    <option value="tersedia">Tersedia</option>
                                    <option value="dipesan">Dipesan</option>
                                    <option value="rusak">Rusak</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="kategori">Kategori</label>
                                <div class="input-group">
                                    <select class="form-select" id="kategori" name="kategori" required>
                                        <option value="" disabled selected>Pilih Kategori</option>
                                        <option value="Perlengkapan Acara">Perlengkapan Acara</option>
                                        <option value="Tenda Acara">Tenda Acara</option>
                                        <option value="Dekorasi">Dekorasi</option>
                                    </select>
                                    <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#addCategoryModal">
                                        <i class="bx bx-plus"></i> Tambah Kategori
                                    </button>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="lokasi">Lokasi</label>
                                <input type="text" class="form-control" id="lokasi" name="lokasi" value="Desa Pematang Duku Timur" required />
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="foto">Foto Utama</label>
                                <div class="input-group">
                                    <input type="file" class="form-control" id="foto" name="foto" accept="image/*" onchange="previewFile(this, 'preview_foto')" />
                                    <button type="button" class="btn btn-outline-secondary" onclick="clearFile('foto', 'preview_foto')">Hapus</button>
                                </div>
                                <div id="preview_foto" class="mt-2" style="display:none;">
                                    <img src="#" alt="Preview" class="img-fluid rounded" style="max-height: 200px;" />
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="foto_2">Foto Tambahan 1</label>
                                <div class="input-group">
                                    <input type="file" class="form-control" id="foto_2" name="foto_2" accept="image/*" onchange="previewFile(this, 'preview_foto_2')" />
                                    <button type="button" class="btn btn-outline-secondary" onclick="clearFile('foto_2', 'preview_foto_2')">Hapus</button>
                                </div>
                                <div id="preview_foto_2" class="mt-2" style="display:none;">
                                    <img src="#" alt="Preview" class="img-fluid rounded" style="max-height: 200px;" />
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="foto_3">Foto Tambahan 2</label>
                                <div class="input-group">
                                    <input type="file" class="form-control" id="foto_3" name="foto_3" accept="image/*" onchange="previewFile(this, 'preview_foto_3')" />
                                    <button type="button" class="btn btn-outline-secondary" onclick="clearFile('foto_3', 'preview_foto_3')">Hapus</button>
                                </div>
                                <div id="preview_foto_3" class="mt-2" style="display:none;">
                                    <img src="#" alt="Preview" class="img-fluid rounded" style="max-height: 200px;" />
                                </div>
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

    <!-- Script untuk format Rupiah, preview foto, dan tambah kategori/satuan -->
    <script>
    // Fungsi untuk format angka menjadi Rupiah (contoh: 150000 -> 150.000)
    function formatRupiah(input) {
        let value = input.value.replace(/\D/g, ''); // Hapus semua karakter non-digit
        if (value) {
            // Format dengan titik sebagai pemisah ribuan
            value = new Intl.NumberFormat('id-ID').format(value);
            input.value = value;
        }
    }

    // Fungsi untuk preview file gambar
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

    // Fungsi untuk menghapus file dan reset input
    function clearFile(inputId, previewId) {
        const input = document.getElementById(inputId);
        const preview = document.getElementById(previewId);
        const img = preview.querySelector('img');

        input.value = '';
        img.src = '#';
        preview.style.display = 'none';
    }

    // Fungsi untuk menambah kategori
    document.getElementById('saveCategoryBtn').addEventListener('click', function() {
        const newKategori = document.getElementById('new_kategori').value.trim();
        if (newKategori) {
            const select = document.getElementById('kategori');
            const option = document.createElement('option');
            option.value = newKategori;
            option.textContent = newKategori;
            select.appendChild(option);
            // Setelah ditambah, pilih opsi baru
            select.value = newKategori;
            // Tutup modal
            bootstrap.Modal.getInstance(document.getElementById('addCategoryModal')).hide();
            // Kosongkan input
            document.getElementById('new_kategori').value = '';
        } else {
            alert('Silakan masukkan nama kategori.');
        }
    });

    // Fungsi untuk menambah satuan
    document.getElementById('saveSatuanBtn').addEventListener('click', function() {
        const newSatuan = document.getElementById('new_satuan').value.trim();
        if (newSatuan) {
            const select = document.getElementById('satuan');
            const option = document.createElement('option');
            option.value = newSatuan;
            option.textContent = newSatuan;
            select.appendChild(option);
            // Setelah ditambah, pilih opsi baru
            select.value = newSatuan;
            // Tutup modal
            bootstrap.Modal.getInstance(document.getElementById('addSatuanModal')).hide();
            // Kosongkan input
            document.getElementById('new_satuan').value = '';
        } else {
            alert('Silakan masukkan nama satuan.');
        }
    });
    </script>
@endsection