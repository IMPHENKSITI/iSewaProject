@extends('admin.layouts.admin')

@section('title', 'Kirim Notifikasi')

@section('content')
<div class="container-fluid py-4">
    
    <!-- Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <h4 class="fw-bold fs-3 mb-1 text-primary">
                        Buat Notifikasi Baru
                    </h4>
                    <p class="text-muted mb-0">Kirim notifikasi ke pengguna tertentu atau semua pengguna</p>
                </div>
                <a href="{{ route('admin.notifications.index') }}" class="btn btn-outline-secondary rounded-pill px-4">
                    <i class="bx bx-arrow-back me-1"></i> Kembali
                </a>
            </div>
        </div>
    </div>

    <!-- Form Card -->
    <div class="row justify-content-center">
        <div class="col-lg-9 col-xl-8">
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                <div class="card-body p-0">
                    <form action="{{ route('admin.notifications.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        
                        <!-- Form Section 1: Konten Notifikasi -->
                        <div class="p-4 border-bottom bg-light">
                            <div class="d-flex align-items-center gap-3 mb-3">
                                <div class="bg-primary bg-opacity-10 rounded-3 p-2">
                                    <i class="bx bx-edit-alt text-primary fs-4"></i>
                                </div>
                                <div>
                                    <h5 class="mb-0 fw-bold">Konten Notifikasi</h5>
                                    <small class="text-muted">Isi judul dan pesan notifikasi</small>
                                </div>
                            </div>
                        </div>

                        <div class="p-4 pb-3">
                            <!-- Title -->
                            <div class="mb-4">
                                <label for="title" class="form-label fw-semibold text-dark mb-2">
                                    Judul Notifikasi <span class="text-danger">*</span>
                                </label>
                                <input type="text" 
                                       class="form-control form-control-lg border-2 @error('title') is-invalid border-danger @else border-primary border-opacity-25 @enderror" 
                                       id="title" 
                                       name="title" 
                                       value="{{ old('title') }}" 
                                       placeholder="Contoh: Promo Spesial Hari Ini!"
                                       style="border-radius: 12px; padding: 14px 18px;"
                                       required>
                                @error('title')
                                    <div class="invalid-feedback d-flex align-items-center gap-1">
                                        <i class="bx bx-error-circle"></i> {{ $message }}
                                    </div>
                                @else
                                    <small class="text-muted d-flex align-items-center gap-1 mt-2">
                                        <i class="bx bx-info-circle"></i> Judul yang menarik akan lebih diperhatikan pengguna
                                    </small>
                                @enderror
                            </div>

                            <!-- Message -->
                            <div class="mb-4">
                                <label for="message" class="form-label fw-semibold text-dark mb-2">
                                    Pesan <span class="text-danger">*</span>
                                </label>
                                <textarea class="form-control border-2 @error('message') is-invalid border-danger @else border-primary border-opacity-25 @enderror" 
                                          id="message" 
                                          name="message" 
                                          rows="5" 
                                          placeholder="Tulis pesan notifikasi di sini..."
                                          style="border-radius: 12px; padding: 14px 18px; resize: vertical;"
                                          required>{{ old('message') }}</textarea>
                                @error('message')
                                    <div class="invalid-feedback d-flex align-items-center gap-1">
                                        <i class="bx bx-error-circle"></i> {{ $message }}
                                    </div>
                                @else
                                    <small class="text-muted d-flex align-items-center gap-1 mt-2">
                                        <i class="bx bx-info-circle"></i> Jelaskan informasi dengan jelas dan singkat
                                    </small>
                                @enderror
                            </div>
                        </div>

                        <!-- Divider -->
                        <div class="border-top border-2 border-primary border-opacity-10"></div>

                        <!-- Form Section 2: Media -->
                        <div class="p-4 border-bottom bg-light">
                            <div class="d-flex align-items-center gap-3 mb-3">
                                <div class="bg-success bg-opacity-10 rounded-3 p-2">
                                    <i class="bx bx-image text-success fs-4"></i>
                                </div>
                                <div>
                                    <h5 class="mb-0 fw-bold">Media Notifikasi</h5>
                                    <small class="text-muted">Tambahkan gambar untuk menarik perhatian (opsional)</small>
                                </div>
                            </div>
                        </div>

                        <div class="p-4 pb-3">
                            <!-- Image Upload (Optional) -->
                            <div class="mb-4">
                                <label for="image" class="form-label fw-semibold text-dark mb-2">
                                    Gambar (Opsional)
                                </label>
                                <div class="border-2 border-dashed border-primary border-opacity-25 rounded-3 p-4 text-center bg-light bg-opacity-50 hover-border-primary transition-all" style="cursor: pointer;" onclick="document.getElementById('image').click()">
                                    <input type="file" 
                                           class="d-none @error('image') is-invalid @enderror" 
                                           id="image" 
                                           name="image"
                                           accept="image/jpeg,image/png,image/jpg,image/gif"
                                           onchange="previewImage(event)">
                                    
                                    <div id="uploadPlaceholder">
                                        <i class="bx bx-cloud-upload text-primary fs-1 mb-2"></i>
                                        <p class="mb-1 fw-semibold text-dark">Klik untuk upload gambar</p>
                                        <small class="text-muted">atau drag & drop file di sini</small>
                                        <div class="mt-2">
                                            <span class="badge bg-primary bg-opacity-10 text-primary">JPG</span>
                                            <span class="badge bg-primary bg-opacity-10 text-primary">PNG</span>
                                            <span class="badge bg-primary bg-opacity-10 text-primary">GIF</span>
                                            <span class="badge bg-secondary bg-opacity-10 text-secondary">Max 2MB</span>
                                        </div>
                                    </div>
                                    
                                    <!-- Image Preview -->
                                    <div id="imagePreview" class="mt-3" style="display: none;">
                                        <div class="position-relative d-inline-block">
                                            <img id="preview" src="" alt="Preview" class="rounded-3 shadow-sm" style="max-width: 300px; max-height: 300px; object-fit: cover;">
                                            <button type="button" class="btn btn-sm btn-danger position-absolute top-0 end-0 m-2 rounded-circle" onclick="removeImage()" style="width: 32px; height: 32px; padding: 0;">
                                                <i class="bx bx-x fs-5"></i>
                                            </button>
                                        </div>
                                        <p class="small text-success mt-2 mb-0">
                                            <i class="bx bx-check-circle"></i> Gambar siap diupload
                                        </p>
                                    </div>
                                </div>
                                @error('image')
                                    <div class="text-danger small d-flex align-items-center gap-1 mt-2">
                                        <i class="bx bx-error-circle"></i> {{ $message }}
                                    </div>
                                @else
                                    <small class="text-muted d-flex align-items-center gap-1 mt-2">
                                        <i class="bx bx-info-circle"></i> Jika tidak diisi, sistem akan menggunakan icon SVG otomatis sesuai tipe notifikasi
                                    </small>
                                @enderror
                            </div>
                        </div>

                        <!-- Divider -->
                        <div class="border-top border-2 border-primary border-opacity-10"></div>

                        <!-- Form Section 3: Penerima -->
                        <div class="p-4 border-bottom bg-light">
                            <div class="d-flex align-items-center gap-3 mb-3">
                                <div class="bg-info bg-opacity-10 rounded-3 p-2">
                                    <i class="bx bx-user text-info fs-4"></i>
                                </div>
                                <div>
                                    <h5 class="mb-0 fw-bold">Penerima Notifikasi</h5>
                                    <small class="text-muted">Pilih siapa yang akan menerima notifikasi ini</small>
                                </div>
                            </div>
                        </div>

                        <div class="p-4">
                            <!-- Recipient -->
                            <div class="mb-4">
                                <label for="user_id" class="form-label fw-semibold text-dark mb-2">
                                    Kirim Kepada
                                </label>
                                <select class="form-select form-select-lg border-2 @error('user_id') is-invalid border-danger @else border-primary border-opacity-25 @enderror" 
                                        id="user_id" 
                                        name="user_id"
                                        style="border-radius: 12px; padding: 14px 18px;">
                                    <option value="">📢 Semua Pengguna (Broadcast)</option>
                                    <optgroup label="👤 Pengguna Spesifik">
                                        @foreach($users as $user)
                                            <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>
                                                {{ $user->name }} ({{ $user->email }})
                                            </option>
                                        @endforeach
                                    </optgroup>
                                </select>
                                @error('user_id')
                                    <div class="invalid-feedback d-flex align-items-center gap-1">
                                        <i class="bx bx-error-circle"></i> {{ $message }}
                                    </div>
                                @else
                                    <small class="text-muted d-flex align-items-center gap-1 mt-2">
                                        <i class="bx bx-info-circle"></i> Kosongkan untuk mengirim ke semua pengguna
                                    </small>
                                @enderror
                            </div>

                            <!-- Preview Card -->
                            <div class="alert alert-info border-0 rounded-3 mb-0 d-flex align-items-start gap-3" style="background: linear-gradient(135deg, #e0f2fe 0%, #dbeafe 100%);">
                                <i class="bx bx-info-circle fs-3 text-info"></i>
                                <div>
                                    <strong class="text-info">Preview Notifikasi</strong>
                                    <p class="mb-0 mt-1 small text-dark">Notifikasi akan muncul di halaman notifikasi pengguna dengan icon megaphone dan badge "Pesan Admin". Pengguna akan menerima notifikasi secara real-time.</p>
                                </div>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="p-4 bg-light border-top">
                            <div class="d-flex gap-3 justify-content-end">
                                <a href="{{ route('admin.notifications.index') }}" class="btn btn-lg btn-light border-2 border-secondary border-opacity-25 text-secondary px-5 rounded-pill">
                                    <i class="bx bx-x me-1"></i> Batal
                                </a>
                                <button type="submit" class="btn btn-lg btn-primary px-5 rounded-pill shadow-sm">
                                    <i class="bx bx-send me-1"></i> Kirim Notifikasi
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Tips Card -->
            <div class="card border-0 shadow-sm rounded-4 mt-4 overflow-hidden">
                <div class="card-body p-0">
                    <div class="p-4 bg-warning bg-opacity-10 border-bottom">
                        <div class="d-flex align-items-center gap-3">
                            <div class="bg-warning bg-opacity-25 rounded-3 p-2">
                                <i class="bx bx-bulb text-warning fs-4"></i>
                            </div>
                            <h5 class="mb-0 fw-bold">Tips Menulis Notifikasi Efektif</h5>
                        </div>
                    </div>
                    <div class="p-4">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="d-flex gap-3">
                                    <div class="flex-shrink-0">
                                        <div class="bg-primary bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                            <i class="bx bx-text text-primary fs-5"></i>
                                        </div>
                                    </div>
                                    <div>
                                        <h6 class="fw-bold mb-1">Judul Menarik</h6>
                                        <p class="small text-muted mb-0">Gunakan kata-kata yang menarik perhatian (max 50 karakter)</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="d-flex gap-3">
                                    <div class="flex-shrink-0">
                                        <div class="bg-success bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                            <i class="bx bx-message-detail text-success fs-5"></i>
                                        </div>
                                    </div>
                                    <div>
                                        <h6 class="fw-bold mb-1">Pesan Singkat</h6>
                                        <p class="small text-muted mb-0">Sampaikan informasi penting di awal kalimat</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="d-flex gap-3">
                                    <div class="flex-shrink-0">
                                        <div class="bg-info bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                            <i class="bx bx-time text-info fs-5"></i>
                                        </div>
                                    </div>
                                    <div>
                                        <h6 class="fw-bold mb-1">Waktu Tepat</h6>
                                        <p class="small text-muted mb-0">Kirim notifikasi di waktu yang tepat (pagi/siang)</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="d-flex gap-3">
                                    <div class="flex-shrink-0">
                                        <div class="bg-warning bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                            <i class="bx bx-bell text-warning fs-5"></i>
                                        </div>
                                    </div>
                                    <div>
                                        <h6 class="fw-bold mb-1">Frekuensi</h6>
                                        <p class="small text-muted mb-0">Jangan terlalu sering mengirim notifikasi</p>
                                    </div>
                                </div>
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
    .hover-border-primary:hover {
        border-color: rgba(13, 110, 253, 0.5) !important;
        background-color: rgba(13, 110, 253, 0.02) !important;
    }
    
    .transition-all {
        transition: all 0.3s ease;
    }
    
    .form-control:focus,
    .form-select:focus {
        border-color: #0d6efd !important;
        box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.15) !important;
    }
</style>
@endpush

@push('scripts')
<script>
    // Auto-resize textarea
    const textarea = document.getElementById('message');
    if (textarea) {
        textarea.addEventListener('input', function() {
            this.style.height = 'auto';
            this.style.height = (this.scrollHeight) + 'px';
        });
    }
    
    // Image preview function
    function previewImage(event) {
        const file = event.target.files[0];
        const preview = document.getElementById('preview');
        const previewContainer = document.getElementById('imagePreview');
        const placeholder = document.getElementById('uploadPlaceholder');
        
        if (file) {
            // Validate file size (2MB)
            if (file.size > 2 * 1024 * 1024) {
                alert('Ukuran file terlalu besar! Maksimal 2MB');
                event.target.value = '';
                return;
            }
            
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.src = e.target.result;
                previewContainer.style.display = 'block';
                placeholder.style.display = 'none';
            }
            reader.readAsDataURL(file);
        } else {
            removeImage();
        }
    }
    
    // Remove image function
    function removeImage() {
        const input = document.getElementById('image');
        const previewContainer = document.getElementById('imagePreview');
        const placeholder = document.getElementById('uploadPlaceholder');
        
        input.value = '';
        previewContainer.style.display = 'none';
        placeholder.style.display = 'block';
    }
</script>
@endpush