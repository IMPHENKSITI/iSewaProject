@extends('admin.layouts.admin')

@section('title', 'Pengaturan Sistem')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    
    <!-- Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h4 class="fw-bold py-3 mb-0">
                        <span class="text-muted fw-light">Admin /</span> Pengaturan Sistem
                    </h4>
                    <p class="text-muted mb-0">Kelola konfigurasi utama aplikasi, lokasi, dan pembayaran.</p>
                </div>
                <div>
                    <form action="{{ route('admin.system-settings.reset') }}" method="POST" style="display:inline;" onsubmit="return confirm('Yakin ingin mereset semua pengaturan ke default?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-outline-danger">
                            <i class="bx bx-reset me-1"></i> Reset Default
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm border-0 overflow-hidden">
                <div class="card-body p-0">
                    <form action="{{ route('admin.system-settings.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="row g-0">
                            <!-- Left Sidebar Navigation -->
                            <div class="col-md-3 border-end bg-light bg-opacity-50">
                                <div class="p-4">
                                    <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                                        <button class="nav-link active text-start mb-2" id="v-pills-location-tab" data-bs-toggle="pill" data-bs-target="#v-pills-location" type="button" role="tab">
                                            <i class="bx bx-map me-2"></i> Lokasi BUMDes
                                        </button>
                                        <button class="nav-link text-start mb-2" id="v-pills-bank-tab" data-bs-toggle="pill" data-bs-target="#v-pills-bank" type="button" role="tab">
                                            <i class="bx bx-credit-card me-2"></i> Rekening & Pembayaran
                                        </button>
                                        <button class="nav-link text-start" id="v-pills-contact-tab" data-bs-toggle="pill" data-bs-target="#v-pills-contact" type="button" role="tab">
                                            <i class="bx bx-phone-call me-2"></i> Kontak & Layanan
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <!-- Right Content Area -->
                            <div class="col-md-9">
                                <div class="tab-content p-4" id="v-pills-tabContent">
                                    
                                    <!-- LOKASI TAB -->
                                    <div class="tab-pane fade show active" id="v-pills-location" role="tabpanel">
                                        <h5 class="fw-bold mb-4 text-primary"><i class="bx bx-map-pin me-2"></i>Pengaturan Lokasi</h5>
                                        
                                        <div class="row g-4">
                                            <div class="col-md-5">
                                                <div class="form-floating mb-3">
                                                    <input type="text" class="form-control" id="location_name" name="location_name" value="{{ old('location_name', $setting->location_name) }}" placeholder="Nama Lokasi">
                                                    <label for="location_name">Nama Lokasi / Kantor</label>
                                                </div>
                                                <div class="form-floating mb-3">
                                                    <textarea class="form-control" id="address" name="address" style="height: 120px" placeholder="Alamat Lengkap">{{ old('address', $setting->address) }}</textarea>
                                                    <label for="address">Alamat Lengkap</label>
                                                </div>
                                                <div class="row">
                                                    <div class="col-6">
                                                        <div class="form-floating mb-3">
                                                            <input type="text" class="form-control bg-light" id="latitude" name="latitude" value="{{ old('latitude', $setting->latitude) }}" readonly>
                                                            <label for="latitude">Latitude</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-6">
                                                        <div class="form-floating mb-3">
                                                            <input type="text" class="form-control bg-light" id="longitude" name="longitude" value="{{ old('longitude', $setting->longitude) }}" readonly>
                                                            <label for="longitude">Longitude</label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="alert alert-primary d-flex align-items-center" role="alert">
                                                    <i class="bx bx-info-circle me-2 fs-4"></i>
                                                    <div class="small">
                                                        Geser pin pada peta untuk menyesuaikan lokasi koordinat kantor BUMDes secara akurat.
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-7">
                                                <label class="form-label fw-semibold mb-2">Preview Peta (Satelit)</label>
                                                <div id="map" class="rounded-3 shadow-sm border" style="height: 450px; width: 100%;"></div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- BANK TAB -->
                                    <div class="tab-pane fade" id="v-pills-bank" role="tabpanel">
                                        <h5 class="fw-bold mb-4 text-primary"><i class="bx bx-wallet me-2"></i>Rekening & Metode Pembayaran</h5>
                                        
                                        <div class="row g-4">
                                            <div class="col-md-6">
                                                <div class="form-floating mb-3">
                                                    <select class="form-select" id="bank_name" name="bank_name" required onchange="updateCardPreview()">
                                                        <option value="">Pilih Bank</option>
                                                        <option value="Bank Syariah Indonesia" {{ old('bank_name', $setting->bank_name) == 'Bank Syariah Indonesia' ? 'selected' : '' }}>Bank Syariah Indonesia (BSI)</option>
                                                        <option value="BRI" {{ old('bank_name', $setting->bank_name) == 'BRI' ? 'selected' : '' }}>Bank Rakyat Indonesia (BRI)</option>
                                                        <option value="Mandiri" {{ old('bank_name', $setting->bank_name) == 'Mandiri' ? 'selected' : '' }}>Bank Mandiri</option>
                                                        <option value="BNI" {{ old('bank_name', $setting->bank_name) == 'BNI' ? 'selected' : '' }}>Bank Negara Indonesia (BNI)</option>
                                                        <option value="BCA" {{ old('bank_name', $setting->bank_name) == 'BCA' ? 'selected' : '' }}>Bank Central Asia (BCA)</option>
                                                        <option value="Bank Riau Kepri Syariah" {{ old('bank_name', $setting->bank_name) == 'Bank Riau Kepri Syariah' ? 'selected' : '' }}>Bank Riau Kepri Syariah</option>
                                                        <option value="CIMB Niaga" {{ old('bank_name', $setting->bank_name) == 'CIMB Niaga' ? 'selected' : '' }}>CIMB Niaga</option>
                                                        <option value="Danamon" {{ old('bank_name', $setting->bank_name) == 'Danamon' ? 'selected' : '' }}>Bank Danamon</option>
                                                    </select>
                                                    <label for="bank_name">Nama Bank</label>
                                                </div>
                                                
                                                <div class="form-floating mb-3">
                                                    <input type="text" class="form-control" id="bank_account_number" name="bank_account_number" value="{{ old('bank_account_number', $setting->bank_account_number) }}" placeholder="Nomor Rekening" required oninput="updateCardPreview()">
                                                    <label for="bank_account_number">Nomor Rekening</label>
                                                </div>
                                                
                                                <div class="form-floating mb-3">
                                                    <input type="text" class="form-control" id="bank_account_holder" name="bank_account_holder" value="{{ old('bank_account_holder', $setting->bank_account_holder) }}" placeholder="Atas Nama" required oninput="updateCardPreview()">
                                                    <label for="bank_account_holder">Atas Nama Rekening</label>
                                                </div>

                                                <div class="card bg-light border-0 mt-4">
                                                    <div class="card-body">
                                                        <h6 class="fw-bold mb-3">Metode Pembayaran Aktif</h6>
                                                        <div class="form-check mb-2">
                                                            <input class="form-check-input" type="checkbox" value="transfer" id="payment_transfer" name="payment_methods[]" {{ in_array('transfer', old('payment_methods', $setting->payment_methods ?? [])) ? 'checked' : '' }}>
                                                            <label class="form-check-label" for="payment_transfer">Transfer Bank</label>
                                                        </div>
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox" value="tunai" id="payment_tunai" name="payment_methods[]" {{ in_array('tunai', old('payment_methods', $setting->payment_methods ?? [])) ? 'checked' : '' }}>
                                                            <label class="form-check-label" for="payment_tunai">
                                                                Tunai (Bayar ke Petugas)
                                                            </label>
                                                        </div>
                                                        <div class="mt-2 ms-4">
                                                            <input type="text" class="form-control form-control-sm" name="tunai_to" placeholder="Nama Petugas (Opsional)" value="{{ old('tunai_to', $setting->payment_methods['tunai_to'] ?? '') }}">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-6 d-flex flex-column align-items-center justify-content-start pt-2">
                                                <label class="form-label fw-bold mb-3 text-uppercase text-muted small">Preview Tampilan User</label>
                                                
                                                <!-- ATM Card Preview -->
                                                <div class="atm-card shadow-lg mb-4" id="atm_card_preview">
                                                    <div class="atm-card-bg" id="card_bg_preview"></div>
                                                    <div class="atm-card-overlay"></div>
                                                    <div class="atm-content">
                                                        <div class="d-flex justify-content-between align-items-start mb-3">
                                                            <div class="chip">
                                                                <div class="chip-line"></div>
                                                                <div class="chip-line"></div>
                                                                <div class="chip-line"></div>
                                                                <div class="chip-line"></div>
                                                            </div>
                                                            <div class="contactless-icon">
                                                                <svg width="30" height="24" viewBox="0 0 30 24" fill="none">
                                                                    <path d="M7 12C7 8.13 10.13 5 14 5" stroke="white" stroke-width="2" stroke-linecap="round" opacity="0.6"/>
                                                                    <path d="M10 12C10 9.79 11.79 8 14 8" stroke="white" stroke-width="2" stroke-linecap="round" opacity="0.7"/>
                                                                    <path d="M13 12C13 11.45 13.45 11 14 11" stroke="white" stroke-width="2" stroke-linecap="round" opacity="0.8"/>
                                                                </svg>
                                                            </div>
                                                        </div>
                                                        
                                                        <div class="bank-logo-container mb-3" id="bank_logo_container">
                                                            <!-- Bank logo will be inserted here -->
                                                        </div>
                                                        
                                                        <div class="mb-3">
                                                            <div class="card-number" id="preview_account_number">#### #### #### ####</div>
                                                        </div>
                                                        
                                                        <div class="d-flex justify-content-between align-items-end">
                                                            <div>
                                                                <div class="card-label">Card Holder</div>
                                                                <div class="card-holder" id="preview_holder_name">HOLDER NAME</div>
                                                            </div>
                                                            <div class="card-type">
                                                                <svg width="60" height="20" viewBox="0 0 60 20" fill="none">
                                                                    <rect width="60" height="20" rx="3" fill="white" opacity="0.2"/>
                                                                    <text x="30" y="14" text-anchor="middle" fill="white" font-size="10" font-weight="bold" opacity="0.8">VISA</text>
                                                                </svg>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Background Customization -->
                                                <div class="w-100 px-3">
                                                    <label class="form-label fw-semibold mb-2">Pilih Background Kartu</label>
                                                    
                                                    <!-- Gradient Options -->
                                                    <div class="mb-3">
                                                        <small class="text-muted d-block mb-2">Warna Gradient:</small>
                                                        <div class="d-flex gap-2 justify-content-center flex-wrap">
                                                            <input type="hidden" name="card_style" id="card_style_input" value="{{ $setting->payment_methods['card_style'] ?? 'blue' }}">
                                                            
                                                            <button type="button" class="btn btn-outline-secondary p-1 border-2 rounded-circle card-style-btn" onclick="setCardStyle('blue', 'linear-gradient(135deg, #1e3c72 0%, #2a5298 100%)')" data-style="blue" title="Blue Ocean">
                                                                <div class="rounded-circle" style="width: 35px; height: 35px; background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);"></div>
                                                            </button>
                                                            <button type="button" class="btn btn-outline-secondary p-1 border-2 rounded-circle card-style-btn" onclick="setCardStyle('green', 'linear-gradient(135deg, #00a884 0%, #005c4b 100%)')" data-style="green" title="Emerald">
                                                                <div class="rounded-circle" style="width: 35px; height: 35px; background: linear-gradient(135deg, #00a884 0%, #005c4b 100%);"></div>
                                                            </button>
                                                            <button type="button" class="btn btn-outline-secondary p-1 border-2 rounded-circle card-style-btn" onclick="setCardStyle('purple', 'linear-gradient(135deg, #667eea 0%, #764ba2 100%)')" data-style="purple" title="Royal Purple">
                                                                <div class="rounded-circle" style="width: 35px; height: 35px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);"></div>
                                                            </button>
                                                            <button type="button" class="btn btn-outline-secondary p-1 border-2 rounded-circle card-style-btn" onclick="setCardStyle('dark', 'linear-gradient(135deg, #232526 0%, #414345 100%)')" data-style="dark" title="Carbon Black">
                                                                <div class="rounded-circle" style="width: 35px; height: 35px; background: linear-gradient(135deg, #232526 0%, #414345 100%);"></div>
                                                            </button>
                                                            <button type="button" class="btn btn-outline-secondary p-1 border-2 rounded-circle card-style-btn" onclick="setCardStyle('gold', 'linear-gradient(135deg, #f7971e 0%, #ffd200 100%)')" data-style="gold" title="Gold">
                                                                <div class="rounded-circle" style="width: 35px; height: 35px; background: linear-gradient(135deg, #f7971e 0%, #ffd200 100%);"></div>
                                                            </button>
                                                            <button type="button" class="btn btn-outline-secondary p-1 border-2 rounded-circle card-style-btn" onclick="setCardStyle('red', 'linear-gradient(135deg, #eb3349 0%, #f45c43 100%)')" data-style="red" title="Ruby Red">
                                                                <div class="rounded-circle" style="width: 35px; height: 35px; background: linear-gradient(135deg, #eb3349 0%, #f45c43 100%);"></div>
                                                            </button>
                                                        </div>
                                                    </div>

                                                    <!-- Image Upload Option -->
                                                    <div class="mb-3">
                                                        <small class="text-muted d-block mb-2">Atau Upload Gambar Custom:</small>
                                                        <input type="file" class="form-control form-control-sm" id="card_background_image" name="card_background_image" accept="image/*" onchange="previewCardImage(event)">
                                                        <small class="text-muted">Format: JPG, PNG, WEBP. Max: 2MB</small>
                                                        @if($setting->card_background_image)
                                                            <div class="mt-2">
                                                                <small class="text-success"><i class="bx bx-check-circle"></i> Gambar tersimpan</small>
                                                                <button type="button" class="btn btn-sm btn-link text-danger p-0 ms-2" onclick="clearCardImage()">Hapus</button>
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- KONTAK TAB -->
                                    <div class="tab-pane fade" id="v-pills-contact" role="tabpanel">
                                        <h5 class="fw-bold mb-4 text-primary"><i class="bx bx-support me-2"></i>Kontak & Jam Layanan</h5>
                                        
                                        <div class="row g-4">
                                            <div class="col-md-6">
                                                <div class="form-floating mb-3">
                                                    <input type="text" class="form-control" id="whatsapp_number" name="whatsapp_number" value="{{ old('whatsapp_number', $setting->whatsapp_number) }}" placeholder="628..." required oninput="updateContactPreview()">
                                                    <label for="whatsapp_number">Nomor WhatsApp (Format: 628...)</label>
                                                </div>
                                                <div class="form-floating mb-3">
                                                    <textarea class="form-control" id="office_address" name="office_address" style="height: 100px" placeholder="Alamat Kantor" oninput="updateContactPreview()">{{ old('office_address', $setting->office_address) }}</textarea>
                                                    <label for="office_address">Alamat Kantor</label>
                                                </div>
                                                <div class="form-floating mb-3">
                                                    <input type="text" class="form-control" id="operating_hours" name="operating_hours" value="{{ old('operating_hours', $setting->operating_hours) }}" placeholder="Jam Operasional" oninput="updateContactPreview()">
                                                    <label for="operating_hours">Jam Operasional</label>
                                                </div>
                                            </div>
                                            
                                            <div class="col-md-6">
                                                <label class="form-label fw-semibold mb-3">Preview Kontak</label>
                                                <div class="card border shadow-sm">
                                                    <div class="card-body">
                                                        <div class="d-flex align-items-center mb-3">
                                                            <div class="avatar avatar-md me-3">
                                                                <span class="avatar-initial rounded-circle bg-success text-white">
                                                                    <i class='bx bxl-whatsapp fs-3'></i>
                                                                </span>
                                                            </div>
                                                            <div>
                                                                <h6 class="mb-0 fw-bold">WhatsApp Admin</h6>
                                                                <a href="#" class="text-success text-decoration-none" id="preview_wa_link" target="_blank">
                                                                    <span id="preview_wa_number">+62 8xx-xxxx-xxxx</span> <i class="bx bx-link-external small ms-1"></i>
                                                                </a>
                                                            </div>
                                                        </div>
                                                        <hr class="my-3">
                                                        <div class="mb-2">
                                                            <i class="bx bx-map text-muted me-2"></i>
                                                            <span id="preview_address" class="text-dark">Alamat kantor...</span>
                                                        </div>
                                                        <div>
                                                            <i class="bx bx-time text-muted me-2"></i>
                                                            <span id="preview_hours" class="text-dark">Jam operasional...</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                        
                        <div class="card-footer bg-white border-top text-end p-3">
                            <button type="submit" class="btn btn-primary px-4">
                                <i class="bx bx-save me-1"></i> Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Leaflet CSS & JS -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin=""/>
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>

<style>
    /* Enhanced ATM Card Styles */
    .atm-card {
        width: 360px;
        height: 220px;
        border-radius: 18px;
        position: relative;
        overflow: hidden;
        color: white;
        font-family: 'Courier New', Courier, monospace;
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        box-shadow: 0 10px 40px rgba(0,0,0,0.3);
    }
    .atm-card:hover {
        transform: translateY(-5px) scale(1.02);
        box-shadow: 0 15px 50px rgba(0,0,0,0.4);
    }
    .atm-card-bg {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
        z-index: 1;
        transition: all 0.5s ease;
    }
    .atm-card-overlay {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: 
            radial-gradient(circle at 20% 50%, rgba(255,255,255,0.1) 0%, transparent 50%),
            radial-gradient(circle at 80% 80%, rgba(255,255,255,0.05) 0%, transparent 50%);
        z-index: 2;
        pointer-events: none;
    }
    .atm-content {
        position: relative;
        z-index: 3;
        padding: 28px;
        height: 100%;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }
    .chip {
        width: 52px;
        height: 38px;
        background: linear-gradient(135deg, #ffd700 0%, #d4af37 100%);
        border-radius: 6px;
        position: relative;
        overflow: hidden;
        box-shadow: 0 2px 8px rgba(0,0,0,0.3);
    }
    .chip-line {
        position: absolute;
        background: rgba(0,0,0,0.15);
        height: 1px;
        width: 100%;
    }
    .chip-line:nth-child(1) { top: 33%; }
    .chip-line:nth-child(2) { top: 66%; }
    .chip-line:nth-child(3) { left: 33%; width: 1px; height: 100%; top: 0; }
    .chip-line:nth-child(4) { left: 66%; width: 1px; height: 100%; top: 0; }
    
    .contactless-icon {
        opacity: 0.7;
        transition: opacity 0.3s;
    }
    .atm-card:hover .contactless-icon {
        opacity: 1;
    }
    
    .bank-logo-container {
        height: 40px;
        display: flex;
    .card-style-btn {
        transition: all 0.3s ease;
    }
    .card-style-btn:hover {
        transform: scale(1.1);
    }
</style>

<script>
    // Bank Logos SVG
    const bankLogos = {
        'Bank Syariah Indonesia': `<svg width="180" height="40" viewBox="0 0 180 40" fill="none">
            <rect width="180" height="40" rx="4" fill="white" opacity="0.95"/>
            <text x="90" y="25" text-anchor="middle" fill="#00A884" font-size="16" font-weight="bold" font-family="Arial">BSI</text>
        </svg>`,
        'BRI': `<svg width="180" height="40" viewBox="0 0 180 40" fill="none">
            <rect width="180" height="40" rx="4" fill="white" opacity="0.95"/>
            <text x="90" y="25" text-anchor="middle" fill="#0066CC" font-size="16" font-weight="bold" font-family="Arial">BRI</text>
        </svg>`,
        'Mandiri': `<svg width="180" height="40" viewBox="0 0 180 40" fill="none">
            <rect width="180" height="40" rx="4" fill="white" opacity="0.95"/>
            <text x="90" y="25" text-anchor="middle" fill="#003D79" font-size="14" font-weight="bold" font-family="Arial">MANDIRI</text>
        </svg>`,
        'BNI': `<svg width="180" height="40" viewBox="0 0 180 40" fill="none">
            <rect width="180" height="40" rx="4" fill="white" opacity="0.95"/>
            <text x="90" y="25" text-anchor="middle" fill="#F05A22" font-size="16" font-weight="bold" font-family="Arial">BNI</text>
        </svg>`,
        'BCA': `<svg width="180" height="40" viewBox="0 0 180 40" fill="none">
            <rect width="180" height="40" rx="4" fill="white" opacity="0.95"/>
            <text x="90" y="25" text-anchor="middle" fill="#003399" font-size="16" font-weight="bold" font-family="Arial">BCA</text>
        </svg>`,
        'Bank Riau Kepri Syariah': `<svg width="180" height="40" viewBox="0 0 180 40" fill="none">
            <rect width="180" height="40" rx="4" fill="white" opacity="0.95"/>
            <text x="90" y="25" text-anchor="middle" fill="#00A884" font-size="12" font-weight="bold" font-family="Arial">RIAU KEPRI</text>
        </svg>`,
        'CIMB Niaga': `<svg width="180" height="40" viewBox="0 0 180 40" fill="none">
            <rect width="180" height="40" rx="4" fill="white" opacity="0.95"/>
            <text x="90" y="25" text-anchor="middle" fill="#CC0000" font-size="14" font-weight="bold" font-family="Arial">CIMB NIAGA</text>
        </svg>`,
        'Danamon': `<svg width="180" height="40" viewBox="0 0 180 40" fill="none">
            <rect width="180" height="40" rx="4" fill="white" opacity="0.95"/>
            <text x="90" y="25" text-anchor="middle" fill="#0066CC" font-size="14" font-weight="bold" font-family="Arial">DANAMON</text>
        </svg>`
    };

    // Map Initialization
    document.addEventListener('DOMContentLoaded', function() {
        var lat = {{ old('latitude', $setting->latitude) ?? -1.1445 }};
        var lng = {{ old('longitude', $setting->longitude) ?? 102.1601 }};
        
        var map = L.map('map').setView([lat, lng], 16);

        L.tileLayer('https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}', {
            attribution: 'Tiles &copy; Esri'
        }).addTo(map);

        var marker = L.marker([lat, lng], {draggable: true}).addTo(map);

        marker.on('dragend', function(e) {
            var position = marker.getLatLng();
            document.getElementById('latitude').value = position.lat.toFixed(7);
            document.getElementById('longitude').value = position.lng.toFixed(7);
        });
        
        var tabEl = document.querySelector('button[data-bs-target="#v-pills-location"]');
        tabEl.addEventListener('shown.bs.tab', function (event) {
            map.invalidateSize();
        });

        updateCardPreview();
        updateContactPreview();
        
        var currentStyle = document.getElementById('card_style_input').value;
        var btn = document.querySelector(`.card-style-btn[data-style="${currentStyle}"]`);
        if(btn) {
            btn.click();
        }

        @if($setting->card_background_image)
            setCardBackgroundImage("{{ asset('storage/' . $setting->card_background_image) }}");
        @endif
    });

    function updateCardPreview() {
        var bankName = document.getElementById('bank_name').value || 'BANK NAME';
        var accNum = document.getElementById('bank_account_number').value || '#### #### #### ####';
        var holder = document.getElementById('bank_account_holder').value || 'HOLDER NAME';

        document.getElementById('preview_account_number').textContent = accNum;
        document.getElementById('preview_holder_name').textContent = holder;
        
        // Update bank logo
        var logoContainer = document.getElementById('bank_logo_container');
        if(bankLogos[bankName]) {
            logoContainer.innerHTML = bankLogos[bankName];
        } else {
            logoContainer.innerHTML = `<div style="color: white; font-size: 1.2rem; font-weight: bold; text-shadow: 2px 2px 4px rgba(0,0,0,0.5);">${bankName}</div>`;
        }
    }
    
    function setCardStyle(style, gradient) {
        document.getElementById('card_style_input').value = style;
        document.getElementById('card_bg_preview').style.background = gradient;
        document.getElementById('card_bg_preview').style.backgroundImage = '';
        
        document.querySelectorAll('.card-style-btn').forEach(b => b.classList.remove('active', 'border-primary'));
        var btn = document.querySelector(`.card-style-btn[data-style="${style}"]`);
        if(btn) {
            btn.classList.add('active', 'border-primary');
        }
    }

    function previewCardImage(event) {
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                setCardBackgroundImage(e.target.result);
            }
            reader.readAsDataURL(file);
        }
    }

    function setCardBackgroundImage(imageUrl) {
        var bg = document.getElementById('card_bg_preview');
        bg.style.backgroundImage = `url('${imageUrl}')`;
        bg.style.backgroundSize = 'cover';
        bg.style.backgroundPosition = 'center';
        
        document.querySelectorAll('.card-style-btn').forEach(b => b.classList.remove('active', 'border-primary'));
    }

    function clearCardImage() {
        document.getElementById('card_background_image').value = '';
        var currentStyle = document.getElementById('card_style_input').value || 'blue';
        var btn = document.querySelector(`.card-style-btn[data-style="${currentStyle}"]`);
        if(btn) {
            btn.click();
        }
    }

    function updateContactPreview() {
        var wa = document.getElementById('whatsapp_number').value || '-';
        var addr = document.getElementById('office_address').value || '-';
        var hours = document.getElementById('operating_hours').value || '-';

        document.getElementById('preview_wa_number').textContent = wa;
        document.getElementById('preview_address').textContent = addr;
        document.getElementById('preview_hours').textContent = hours;
        
        var cleanWa = wa.replace(/\D/g, '');
        if(cleanWa.startsWith('0')) cleanWa = '62' + cleanWa.substring(1);
        document.getElementById('preview_wa_link').href = 'https://wa.me/' + cleanWa;
    }
</script>
@endsection