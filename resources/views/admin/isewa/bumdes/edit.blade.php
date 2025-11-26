@extends('admin.layouts.admin')

@section('title', 'Edit Anggota BUMDes')

@section('content')
<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-12 col-lg-8">
            <!-- HEADER -->
            <h2 class="text-primary fw-bold mb-4">Edit <span class="text-info">Anggota BUMDes</span></h2>

            <!-- FORM -->
            <div class="card shadow-sm border-0 rounded-4 p-4" style="background: linear-gradient(135deg, #ffffff 0%, #fff9e6 100%);">
                <form action="{{ route('admin.isewa.bumdes.update', $member->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <!-- FOTO PROFIL -->
                    <div class="mb-4">
                        <label class="form-label fw-semibold">Foto Profil</label>
                        <div class="d-flex align-items-center gap-3">
                            <div id="preview-container" class="border rounded-circle overflow-hidden" style="width: 120px; height: 120px; background: #f5f7fa;">
                                <img id="preview-image" src="{{ $member->photo_url }}" alt="Preview" class="w-100 h-100 object-fit-cover">
                            </div>
                            <div>
                                <input type="file" name="photo" id="photo-input" class="form-control form-control-lg" accept="image/*" onchange="previewImage(event)">
                                <small class="text-muted">Ukuran maks: 2MB. Format: JPG, PNG, GIF.</small>
                                <br>
                                <button type="button" id="clear-photo-btn" class="btn btn-sm btn-outline-secondary mt-2" onclick="clearPhoto()">
                                    <i class="bi bi-x"></i> Hapus Foto
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- NAMA -->
                    <div class="mb-4">
                        <label class="form-label fw-semibold">Nama Lengkap</label>
                        <input type="text" name="name" class="form-control form-control-lg" value="{{ $member->name }}" placeholder="Contoh: Muhammad Mawardi" required>
                    </div>

                    <!-- JABATAN -->
                    <div class="mb-4">
                        <label class="form-label fw-semibold">Jabatan</label>
                        <input type="text" name="position" class="form-control form-control-lg" value="{{ $member->position }}" placeholder="Contoh: Sekretaris Desa" required>
                    </div>

                    <!-- ACTION BUTTONS -->
                    <div class="d-flex gap-3">
                        <a href="{{ route('admin.isewa.bumdes.index') }}" class="btn btn-outline-secondary px-4">
                            <i class="bi bi-arrow-left"></i> Batal
                        </a>
                        <button type="submit" class="btn btn-primary px-4">
                            <i class="bi bi-check"></i> Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
function previewImage(event) {
    const input = event.target;
    const preview = document.getElementById('preview-image');
    const container = document.getElementById('preview-container');

    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            preview.src = e.target.result;
            container.style.background = 'transparent';
        };
        reader.readAsDataURL(input.files[0]);
    }
}

function clearPhoto() {
    const input = document.getElementById('photo-input');
    const preview = document.getElementById('preview-image');
    const container = document.getElementById('preview-container');

    input.value = '';
    preview.src = '{{ $member->photo_url }}'; // Kembali ke foto lama jika ada
    container.style.background = '#f5f7fa';
}
</script>
@endsection