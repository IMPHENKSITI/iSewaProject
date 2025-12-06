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
                        <form action="{{ route('admin.system-settings.reset') }}" method="POST" style="display:inline;"
                            onsubmit="return confirm('Yakin ingin mereset semua pengaturan ke default?')">
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
                        <form action="{{ route('admin.system-settings.update') }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div class="row g-0">
                                <!-- Left Sidebar Navigation -->
                                <div class="col-md-3 border-end bg-light bg-opacity-50">
                                    <div class="p-4">
                                        <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist"
                                            aria-orientation="vertical">
                                            <button class="nav-link active text-start mb-2" id="v-pills-location-tab"
                                                data-bs-toggle="pill" data-bs-target="#v-pills-location" type="button"
                                                role="tab">
                                                <i class="bx bx-map me-2"></i> Lokasi BUMDes
                                            </button>
                                            <button class="nav-link text-start mb-2" id="v-pills-bank-tab"
                                                data-bs-toggle="pill" data-bs-target="#v-pills-bank" type="button"
                                                role="tab">
                                                <i class="bx bx-credit-card me-2"></i> Rekening & Pembayaran
                                            </button>
                                            <button class="nav-link text-start" id="v-pills-contact-tab"
                                                data-bs-toggle="pill" data-bs-target="#v-pills-contact" type="button"
                                                role="tab">
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
                                            <h5 class="fw-bold mb-4 text-primary"><i
                                                    class="bx bx-map-pin me-2"></i>Pengaturan Lokasi</h5>

                                            <div class="row g-4">
                                                <div class="col-md-5">
                                                    <div class="form-floating mb-3">
                                                        <input type="text" class="form-control" id="location_name"
                                                            name="location_name"
                                                            value="{{ old('location_name', $setting->location_name) }}"
                                                            placeholder="Nama Lokasi">
                                                        <label for="location_name">Nama Lokasi / Kantor</label>
                                                    </div>
                                                    <div class="form-floating mb-3">
                                                        <textarea class="form-control" id="address" name="address" style="height: 120px" placeholder="Alamat Lengkap">{{ old('address', $setting->address) }}</textarea>
                                                        <label for="address">Alamat Lengkap</label>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-6">
                                                            <div class="form-floating mb-3">
                                                                <input type="text" class="form-control bg-light"
                                                                    id="latitude" name="latitude"
                                                                    value="{{ old('latitude', $setting->latitude) }}"
                                                                    readonly>
                                                                <label for="latitude">Latitude</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="form-floating mb-3">
                                                                <input type="text" class="form-control bg-light"
                                                                    id="longitude" name="longitude"
                                                                    value="{{ old('longitude', $setting->longitude) }}"
                                                                    readonly>
                                                                <label for="longitude">Longitude</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="alert alert-primary d-flex align-items-center"
                                                        role="alert">
                                                        <i class="bx bx-info-circle me-2 fs-4"></i>
                                                        <div class="small">
                                                            Geser pin pada peta untuk menyesuaikan lokasi koordinat kantor
                                                            BUMDes secara akurat.
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-7">
                                                    <label class="form-label fw-semibold mb-2">Preview Peta</label>

                                                    <!-- Search Box for Location -->
                                                    <div class="input-group mb-3">
                                                        <input type="text" class="form-control" id="map_search"
                                                            placeholder="Cari lokasi (contoh: Jl. Sudirman Jakarta, atau nama desa/kota)">
                                                        <button class="btn btn-primary" type="button"
                                                            onclick="searchLocation()">
                                                            <i class="bx bx-search-alt"></i> Cari
                                                        </button>
                                                    </div>

                                                    <div id="map" class="rounded-3 shadow-sm border"
                                                        style="height: 450px; width: 100%;"></div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- BANK TAB -->
                                        <div class="tab-pane fade" id="v-pills-bank" role="tabpanel">
                                            <h5 class="fw-bold mb-4 text-primary"><i
                                                    class="bx bx-wallet me-2"></i>Rekening & Metode Pembayaran</h5>

                                            <div class="row g-4">
                                                <!-- Form Section -->
                                                <div class="col-md-6">
                                                    <div class="form-floating mb-3">
                                                        <select class="form-select bank-select" id="bank_name"
                                                            name="bank_name" required onchange="updateCardPreview()">
                                                            <option value="">Pilih Bank</option>
                                                            <option value="Bank Syariah Indonesia"
                                                                data-logo="/admin/img/banks/bsi.png"
                                                                {{ old('bank_name', $setting->bank_name) == 'Bank Syariah Indonesia' ? 'selected' : '' }}>
                                                                Bank Syariah Indonesia (BSI)</option>
                                                            <option value="BRI" data-logo="/admin/img/banks/bri.png"
                                                                {{ old('bank_name', $setting->bank_name) == 'BRI' ? 'selected' : '' }}>
                                                                Bank Rakyat Indonesia (BRI)</option>
                                                            <option value="Mandiri" data-logo="/admin/img/banks/mandiri.png"
                                                                {{ old('bank_name', $setting->bank_name) == 'Mandiri' ? 'selected' : '' }}>
                                                                Bank Mandiri</option>
                                                            <option value="BNI" data-logo="/admin/img/banks/bni.png"
                                                                {{ old('bank_name', $setting->bank_name) == 'BNI' ? 'selected' : '' }}>
                                                                Bank Negara Indonesia (BNI)</option>
                                                            <option value="BCA" data-logo="/admin/img/banks/bca.png"
                                                                {{ old('bank_name', $setting->bank_name) == 'BCA' ? 'selected' : '' }}>
                                                                Bank Central Asia (BCA)</option>
                                                            <option value="Bank Riau Kepri Syariah"
                                                                data-logo="/admin/img/banks/brk.png"
                                                                {{ old('bank_name', $setting->bank_name) == 'Bank Riau Kepri Syariah' ? 'selected' : '' }}>
                                                                Bank Riau Kepri Syariah</option>
                                                            <option value="Bank Mega" data-logo="/admin/img/banks/mega.png"
                                                                {{ old('bank_name', $setting->bank_name) == 'Bank Mega' ? 'selected' : '' }}>
                                                                Bank Mega</option>
                                                        </select>
                                                        <label for="bank_name">Nama Bank</label>
                                                    </div>

                                                    <div class="form-floating mb-3">
                                                        <input type="text" class="form-control"
                                                            id="bank_account_number" name="bank_account_number"
                                                            value="{{ old('bank_account_number', $setting->bank_account_number) }}"
                                                            placeholder="Nomor Rekening" required
                                                            oninput="updateCardPreview()">
                                                        <label for="bank_account_number">Nomor Rekening</label>
                                                    </div>

                                                    <div class="form-floating mb-3">
                                                        <input type="text" class="form-control"
                                                            id="bank_account_holder" name="bank_account_holder"
                                                            value="{{ old('bank_account_holder', $setting->bank_account_holder) }}"
                                                            placeholder="Atas Nama" required
                                                            oninput="updateCardPreview()">
                                                        <label for="bank_account_holder">Atas Nama Rekening</label>
                                                    </div>

                                                    <div class="card bg-light border-0 mt-4">
                                                        <div class="card-body">
                                                            <h6 class="fw-bold mb-3">Metode Pembayaran Aktif</h6>
                                                            <div class="form-check mb-2">
                                                                <input class="form-check-input" type="checkbox"
                                                                    value="transfer" id="payment_transfer"
                                                                    name="payment_methods[]"
                                                                    {{ in_array('transfer', old('payment_methods', $setting->payment_methods ?? [])) ? 'checked' : '' }}>
                                                                <label class="form-check-label"
                                                                    for="payment_transfer">Transfer Bank</label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox"
                                                                    value="tunai" id="payment_tunai"
                                                                    name="payment_methods[]"
                                                                    {{ in_array('tunai', old('payment_methods', $setting->payment_methods ?? [])) ? 'checked' : '' }}>
                                                                <label class="form-check-label" for="payment_tunai">
                                                                    Tunai (Bayar ke Petugas)
                                                                </label>
                                                            </div>
                                                            <div class="mt-2 ms-4">
                                                                <input type="text" class="form-control form-control-sm"
                                                                    name="cash_payment_description"
                                                                    placeholder="Contoh: Yani - Bendahara BUMDes"
                                                                    value="{{ old('cash_payment_description', $setting->cash_payment_description ?? '') }}">
                                                                <small class="text-muted">Keterangan yang akan ditampilkan
                                                                    ke user saat memilih pembayaran tunai</small>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Preview Section -->
                                                <div
                                                    class="col-md-6 d-flex flex-column align-items-center justify-content-start pt-2">
                                                    <label
                                                        class="form-label fw-bold mb-3 text-uppercase text-muted small">Preview
                                                        Tampilan User</label>

                                                    <!-- Bank Card Preview -->
                                                    <div class="bank-card shadow-lg mb-4" id="bank_card_preview">
                                                        <div class="bank-card-bg" id="card_bg_preview"></div>
                                                        <div class="bank-card-overlay"></div>
                                                        <div class="bank-card-content">
                                                            <!-- Bank Logo Section -->
                                                            <div
                                                                class="d-flex justify-content-start align-items-start mb-4">
                                                                <div
                                                                    class="bank-logo-box bg-white rounded shadow-sm d-flex align-items-center gap-3 px-4 py-3">
                                                                    <img id="preview_bank_logo"
                                                                        src="/admin/img/banks/bsi.png" alt="Bank Logo"
                                                                        class="bank-logo-img"
                                                                        onerror="this.style.display='none'; this.nextElementSibling.style.display='block';">
                                                                    <div class="bank-logo-fallback"
                                                                        style="display: none;">
                                                                        <strong class="text-primary fs-4">BANK</strong>
                                                                    </div>
                                                                    <div class="vr"
                                                                        style="height: 40px; opacity: 0.3;"></div>
                                                                    <span id="preview_bank_name"
                                                                        class="fw-semibold text-dark small">Bank Syariah
                                                                        Indonesia</span>
                                                                </div>
                                                            </div>

                                                            <!-- Account Number -->
                                                            <div class="mb-4">
                                                                <div class="card-label-small">Nomor Rekening Tujuan</div>
                                                                <div class="card-number" id="preview_account_number">####
                                                                    #### ####</div>
                                                            </div>

                                                            <!-- Account Holder -->
                                                            <div>
                                                                <div class="card-label-small">Atas Nama</div>
                                                                <div class="card-holder" id="preview_holder_name">HOLDER
                                                                    NAME</div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- Background Customization -->
                                                    <div class="w-100 px-3">
                                                        <label class="form-label fw-semibold mb-2">Pilih Background
                                                            Kartu</label>

                                                        <!-- Hidden inputs for storing values -->
                                                        <input type="hidden" name="card_background_type"
                                                            id="card_background_type"
                                                            value="{{ old('card_background_type', $setting->card_background_type ?? 'gradient') }}">
                                                        <input type="hidden" name="card_gradient_style"
                                                            id="card_gradient_style"
                                                            value="{{ old('card_gradient_style', $setting->card_gradient_style ?? 'blue') }}">

                                                        <!-- Gradient Options -->
                                                        <div class="mb-3">
                                                            <small class="text-muted d-block mb-2">Warna Background:</small>
                                                            <div class="d-flex gap-2 justify-content-center flex-wrap">
                                                                <button type="button"
                                                                    class="btn btn-outline-secondary p-1 border-2 rounded-circle card-style-btn"
                                                                    onclick="setCardStyle('white')"
                                                                    data-style="white" title="White">
                                                                    <div class="rounded-circle gradient-preview"
                                                                        style="width: 35px; height: 35px; background: linear-gradient(135deg, #ffffff 0%, #f0f0f0 100%); border: 1px solid #ddd;">
                                                                    </div>
                                                                </button>
                                                                <button type="button"
                                                                    class="btn btn-outline-secondary p-1 border-2 rounded-circle card-style-btn"
                                                                    onclick="setCardStyle('silver')"
                                                                    data-style="silver" title="Silver">
                                                                    <div class="rounded-circle gradient-preview"
                                                                        style="width: 35px; height: 35px; background: linear-gradient(135deg, #e0e0e0 0%, #c0c0c0 100%);">
                                                                    </div>
                                                                </button>
                                                                <button type="button"
                                                                    class="btn btn-outline-secondary p-1 border-2 rounded-circle card-style-btn"
                                                                    onclick="setCardStyle('gold')" data-style="gold"
                                                                    title="Gold">
                                                                    <div class="rounded-circle gradient-preview"
                                                                        style="width: 35px; height: 35px; background: linear-gradient(135deg, #ffd700 0%, #fdb931 100%);">
                                                                    </div>
                                                                </button>
                                                                <button type="button"
                                                                    class="btn btn-outline-secondary p-1 border-2 rounded-circle card-style-btn"
                                                                    onclick="setCardStyle('transparent')"
                                                                    data-style="transparent" title="Transparent">
                                                                    <div class="rounded-circle gradient-preview"
                                                                        style="width: 35px; height: 35px; background: rgba(59, 130, 246, 0.3);">
                                                                    </div>
                                                                </button>
                                                                <button type="button"
                                                                    class="btn btn-outline-secondary p-1 border-2 rounded-circle card-style-btn active"
                                                                    onclick="setCardStyle('blue')" data-style="blue"
                                                                    title="Blue Ocean">
                                                                    <div class="rounded-circle gradient-preview"
                                                                        style="width: 35px; height: 35px; background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);">
                                                                    </div>
                                                                </button>
                                                                <button type="button"
                                                                    class="btn btn-outline-secondary p-1 border-2 rounded-circle card-style-btn"
                                                                    onclick="setCardStyle('green')" data-style="green"
                                                                    title="Emerald">
                                                                    <div class="rounded-circle gradient-preview"
                                                                        style="width: 35px; height: 35px; background: linear-gradient(135deg, #00a884 0%, #005c4b 100%);">
                                                                    </div>
                                                                </button>
                                                                <button type="button"
                                                                    class="btn btn-outline-secondary p-1 border-2 rounded-circle card-style-btn"
                                                                    onclick="setCardStyle('purple')" data-style="purple"
                                                                    title="Royal Purple">
                                                                    <div class="rounded-circle gradient-preview"
                                                                        style="width: 35px; height: 35px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                                                                    </div>
                                                                </button>
                                                                <button type="button"
                                                                    class="btn btn-outline-secondary p-1 border-2 rounded-circle card-style-btn"
                                                                    onclick="setCardStyle('dark')" data-style="dark"
                                                                    title="Carbon Black">
                                                                    <div class="rounded-circle gradient-preview"
                                                                        style="width: 35px; height: 35px; background: linear-gradient(135deg, #232526 0%, #414345 100%);">
                                                                    </div>
                                                                </button>
                                                                <button type="button"
                                                                    class="btn btn-outline-secondary p-1 border-2 rounded-circle card-style-btn"
                                                                    onclick="setCardStyle('red')" data-style="red"
                                                                    title="Ruby Red">
                                                                    <div class="rounded-circle gradient-preview"
                                                                        style="width: 35px; height: 35px; background: linear-gradient(135deg, #eb3349 0%, #f45c43 100%);">
                                                                    </div>
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <style>
                                            /* Bank Card Styles */
                                            .bank-card {
                                                position: relative;
                                                width: 100%;
                                                max-width: 450px;
                                                aspect-ratio: 1.586 / 1;
                                                border-radius: 1rem;
                                                overflow: hidden;
                                                box-shadow: 0 4px 15px rgba(0,0,0,0.1);
                                            }

                                            .bank-card-bg {
                                                position: absolute;
                                                inset: 0;
                                                background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
                                                background-size: cover;
                                                background-position: center;
                                            }

                                            .bank-card-overlay {
                                                position: absolute;
                                                inset: 0;
                                                background: linear-gradient(to bottom right, rgba(0, 0, 0, 0.05), transparent);
                                            }

                                            .bank-card-content {
                                                position: relative;
                                                height: 100%;
                                                padding: 1.5rem;
                                                display: flex;
                                                flex-direction: column;
                                                justify-content: space-between;
                                                color: white;
                                                text-shadow: 0 1px 2px rgba(0,0,0,0.1);
                                            }
                                            
                                            /* Adjust text color for light backgrounds */
                                            .bank-card.light-bg .bank-card-content {
                                                color: #333;
                                                text-shadow: none;
                                            }

                                            .bank-logo-box {
                                                max-width: fit-content;
                                            }

                                            .bank-logo-img {
                                                height: 40px;
                                                width: auto;
                                                object-fit: contain;
                                                max-width: 120px;
                                            }

                                            .card-label-small {
                                                font-size: 0.7rem;
                                                opacity: 0.8;
                                                margin-bottom: 0.25rem;
                                            }

                                            .card-number {
                                                font-size: 1.5rem;
                                                font-weight: bold;
                                                letter-spacing: 0.1em;
                                            }

                                            .card-holder {
                                                font-size: 1rem;
                                                font-weight: 600;
                                                text-transform: uppercase;
                                            }

                                            /* Dropdown with logo */
                                            .bank-select {
                                                background-repeat: no-repeat !important;
                                                background-position: 12px center !important;
                                                background-size: 32px 32px !important;
                                                padding-left: 52px !important;
                                            }

                                            /* Card style buttons */
                                            .card-style-btn {
                                                transition: all 0.3s ease;
                                            }

                                            .card-style-btn:hover {
                                                transform: scale(1.1);
                                            }

                                            .card-style-btn.active {
                                                border-color: #0d6efd !important;
                                                box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.25);
                                                transform: scale(1.1);
                                            }

                                            .gradient-preview {
                                                transition: all 0.2s ease;
                                            }
                                        </style>

                                        <script>
                                            // Gradient styles
                                            const gradientStyles = {
                                                white: 'linear-gradient(135deg, #ffffff 0%, #f0f0f0 100%)',
                                                silver: 'linear-gradient(135deg, #e0e0e0 0%, #c0c0c0 100%)',
                                                gold: 'linear-gradient(135deg, #ffd700 0%, #fdb931 100%)',
                                                transparent: 'rgba(59, 130, 246, 0.3)',
                                                blue: 'linear-gradient(135deg, #1e3c72 0%, #2a5298 100%)',
                                                green: 'linear-gradient(135deg, #00a884 0%, #005c4b 100%)',
                                                orange: 'linear-gradient(135deg, #f7971e 0%, #ffd200 100%)', // Keep for backward compatibility if needed, but UI uses Gold
                                                purple: 'linear-gradient(135deg, #667eea 0%, #764ba2 100%)',
                                                dark: 'linear-gradient(135deg, #232526 0%, #414345 100%)',
                                                red: 'linear-gradient(135deg, #eb3349 0%, #f45c43 100%)'
                                            };

                                            // Bank logos mapping
                                            const bankLogos = {
                                                'Bank Syariah Indonesia': '/admin/img/banks/bsi.png',
                                                'BRI': '/admin/img/banks/bri.png',
                                                'Mandiri': '/admin/img/banks/mandiri.png',
                                                'BNI': '/admin/img/banks/bni.png',
                                                'BCA': '/admin/img/banks/bca.png',
                                                'Bank Riau Kepri Syariah': '/admin/img/banks/brk.png',
                                                'Bank Mega': '/admin/img/banks/mega.png'
                                            };

                                            // Update card preview
                                            function updateCardPreview() {
                                                const bankName = document.getElementById('bank_name').value;
                                                const accountNumber = document.getElementById('bank_account_number').value;
                                                const accountHolder = document.getElementById('bank_account_holder').value;

                                                // Update bank logo and name
                                                const logoImg = document.getElementById('preview_bank_logo');
                                                const bankNameSpan = document.getElementById('preview_bank_name');

                                                if (bankName && bankLogos[bankName]) {
                                                    logoImg.src = bankLogos[bankName];
                                                    logoImg.style.display = 'block';
                                                    logoImg.nextElementSibling.style.display = 'none';
                                                }
                                                bankNameSpan.textContent = bankName || 'Nama Bank';

                                                // Update account number with formatting
                                                const formattedNumber = accountNumber.replace(/(\d{4})(?=\d)/g, '$1 ');
                                                document.getElementById('preview_account_number').textContent = formattedNumber || '#### #### ####';

                                                // Update account holder
                                                document.getElementById('preview_holder_name').textContent = accountHolder.toUpperCase() || 'HOLDER NAME';

                                                // Update dropdown background with logo
                                                const selectElement = document.getElementById('bank_name');
                                                if (bankName && bankLogos[bankName]) {
                                                    selectElement.style.backgroundImage = `url(${bankLogos[bankName]})`;
                                                    selectElement.style.paddingLeft = '52px';
                                                } else {
                                                    selectElement.style.backgroundImage = 'none';
                                                    selectElement.style.paddingLeft = '16px';
                                                }
                                            }

                                            // Set card gradient style
                                            function setCardStyle(style) {
                                                const cardBg = document.getElementById('card_bg_preview');
                                                const bankCard = document.querySelector('.bank-card');
                                                
                                                cardBg.style.background = gradientStyles[style];
                                                cardBg.style.backgroundSize = 'cover';

                                                // Update hidden inputs
                                                document.getElementById('card_background_type').value = 'gradient';
                                                document.getElementById('card_gradient_style').value = style;
                                                
                                                // Toggle light/dark text class
                                                if (['white', 'silver', 'gold', 'transparent'].includes(style)) {
                                                    bankCard.classList.add('light-bg');
                                                } else {
                                                    bankCard.classList.remove('light-bg');
                                                }

                                                // Update active button
                                                document.querySelectorAll('.card-style-btn').forEach(btn => {
                                                    btn.classList.remove('active');
                                                    if (btn.dataset.style === style) {
                                                        btn.classList.add('active');
                                                    }
                                                });
                                            }

                                            // Initialize preview on page load
                                            document.addEventListener('DOMContentLoaded', function() {
                                                updateCardPreview();

                                                // Set initial gradient style
                                                const savedStyle = document.getElementById('card_gradient_style').value || 'blue';
                                                setCardStyle(savedStyle);
                                            });
                                        </script>

                                        <!-- KONTAK TAB -->
                                        <div class="tab-pane fade" id="v-pills-contact" role="tabpanel">
                                            <h5 class="fw-bold mb-4 text-primary"><i class="bx bx-support me-2"></i>Kontak
                                                & Jam Layanan</h5>

                                            <div class="row g-4">
                                                <div class="col-md-6">
                                                    <div class="form-floating mb-3">
                                                        <input type="text" class="form-control" id="whatsapp_number"
                                                            name="whatsapp_number"
                                                            value="{{ old('whatsapp_number', $setting->whatsapp_number) }}"
                                                            placeholder="628..." required
                                                            oninput="updateContactPreview()">
                                                        <label for="whatsapp_number">Nomor WhatsApp (Format:
                                                            628...)</label>
                                                    </div>
                                                    <div class="form-floating mb-3">
                                                        <textarea class="form-control" id="office_address" name="office_address" style="height: 100px"
                                                            placeholder="Alamat Kantor" oninput="updateContactPreview()">{{ old('office_address', $setting->office_address) }}</textarea>
                                                        <label for="office_address">Alamat Kantor</label>
                                                    </div>
                                                    <div class="form-floating mb-3">
                                                        <input type="text" class="form-control" id="operating_hours"
                                                            name="operating_hours"
                                                            value="{{ old('operating_hours', $setting->operating_hours) }}"
                                                            placeholder="Jam Operasional"
                                                            oninput="updateContactPreview()">
                                                        <label for="operating_hours">Jam Operasional</label>
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <label class="form-label fw-semibold mb-3">Preview Kontak</label>
                                                    <div class="card border shadow-sm">
                                                        <div class="card-body">
                                                            <div class="d-flex align-items-center mb-3">
                                                                <div class="avatar avatar-md me-3">
                                                                    <span
                                                                        class="avatar-initial rounded-circle bg-success text-white">
                                                                        <i class='bx bxl-whatsapp fs-3'></i>
                                                                    </span>
                                                                </div>
                                                                <div>
                                                                    <h6 class="mb-0 fw-bold">WhatsApp Admin</h6>
                                                                    <a href="#"
                                                                        class="text-success text-decoration-none"
                                                                        id="preview_wa_link" target="_blank">
                                                                        <span id="preview_wa_number">+62
                                                                            8xx-xxxx-xxxx</span> <i
                                                                            class="bx bx-link-external small ms-1"></i>
                                                                    </a>
                                                                </div>
                                                            </div>
                                                            <hr class="my-3">
                                                            <div class="mb-2">
                                                                <i class="bx bx-map text-muted me-2"></i>
                                                                <span id="preview_address" class="text-dark">Alamat
                                                                    kantor...</span>
                                                            </div>
                                                            <div>
                                                                <i class="bx bx-time text-muted me-2"></i>
                                                                <span id="preview_hours" class="text-dark">Jam
                                                                    operasional...</span>
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

    <!-- Google Maps API -->
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBFw0Qbyq9zTFTd-tUY6dZWTgaQzuU17R8&libraries=places&callback=initMap" async defer></script>

    <style>
        /* Enhanced Card Styles */
        .card {
            transition: all 0.3s ease;
        }

        .card:hover {
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1) !important;
        }

        /* Form Floating Enhancements */
        .form-floating > .form-control:focus ~ label,
        .form-floating > .form-control:not(:placeholder-shown) ~ label,
        .form-floating > .form-select ~ label {
            opacity: 0.65;
            transform: scale(0.85) translateY(-0.5rem) translateX(0.15rem);
        }

        /* Nav Pills Enhancement */
        .nav-pills .nav-link {
            transition: all 0.3s ease;
            border-radius: 0.5rem;
            margin-bottom: 0.5rem;
        }

        .nav-pills .nav-link:hover {
            background-color: rgba(105, 108, 255, 0.1);
            transform: translateX(5px);
        }

        .nav-pills .nav-link.active {
            background: linear-gradient(135deg, #0099ff 0%, #0077cc 100%);
            box-shadow: 0 4px 15px rgba(0, 153, 255, 0.4);
        }

        /* Map Container */
        #map {
            border-radius: 1rem;
            overflow: hidden;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        }

        /* Alert Enhancement */
        .alert {
            border-radius: 0.75rem;
            border: none;
        }

        /* Button Enhancements */
        .btn {
            transition: all 0.3s ease;
            border-radius: 0.5rem;
        }

        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }

        .btn-primary {
            background: linear-gradient(135deg, #0099ff 0%, #0077cc 100%);
            border: none;
        }

        .btn-primary:hover {
            background: linear-gradient(135deg, #0088ee 0%, #0066bb 100%);
        }

        /* Tab Content Animation */
        .tab-pane {
            animation: fadeIn 0.5s ease;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

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
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.3);
        }

        .atm-card:hover {
            transform: translateY(-5px) scale(1.02);
            box-shadow: 0 15px 50px rgba(0, 0, 0, 0.4);
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
                radial-gradient(circle at 20% 50%, rgba(255, 255, 255, 0.1) 0%, transparent 50%),
                radial-gradient(circle at 80% 80%, rgba(255, 255, 255, 0.05) 0%, transparent 50%);
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

        .card-style-btn {
            transition: all 0.3s ease;
        }

        .card-style-btn:hover {
            transform: scale(1.1);
        }
    </style>

    <script>
        let map;
        let marker;
        let geocoder;
        let autocomplete;

        // Initialize Google Map
        function initMap() {
            const lat = {{ old('latitude', $setting->latitude) ?? -0.52000 }};
            const lng = {{ old('longitude', $setting->longitude) ?? 101.00000 }};

            // Create map with default view (not satellite)
            map = new google.maps.Map(document.getElementById('map'), {
                center: { lat: lat, lng: lng },
                zoom: 16,
                mapTypeId: 'roadmap', // Default map view
                mapTypeControl: true,
                mapTypeControlOptions: {
                    style: google.maps.MapTypeControlStyle.HORIZONTAL_BAR,
                    position: google.maps.ControlPosition.TOP_RIGHT,
                    mapTypeIds: ['roadmap', 'satellite']
                },
                streetViewControl: true,
                fullscreenControl: true,
                zoomControl: true
            });

            // Create draggable marker
            marker = new google.maps.Marker({
                position: { lat: lat, lng: lng },
                map: map,
                draggable: true,
                title: 'Lokasi BUMDes',
                animation: google.maps.Animation.DROP
            });

            // Initialize geocoder
            geocoder = new google.maps.Geocoder();

            // Update coordinates when marker is dragged
            marker.addListener('dragend', function(event) {
                const position = event.latLng;
                document.getElementById('latitude').value = position.lat().toFixed(7);
                document.getElementById('longitude').value = position.lng().toFixed(7);
                
                // Reverse geocode to get address
                geocoder.geocode({ location: position }, function(results, status) {
                    if (status === 'OK' && results[0]) {
                        document.getElementById('address').value = results[0].formatted_address;
                    }
                });
            });

            // Initialize autocomplete for search
            const searchInput = document.getElementById('map_search');
            autocomplete = new google.maps.places.Autocomplete(searchInput, {
                componentRestrictions: { country: 'id' } // Restrict to Indonesia
            });

            autocomplete.addListener('place_changed', function() {
                const place = autocomplete.getPlace();
                if (place.geometry) {
                    const location = place.geometry.location;
                    map.setCenter(location);
                    map.setZoom(16);
                    marker.setPosition(location);
                    
                    document.getElementById('latitude').value = location.lat().toFixed(7);
                    document.getElementById('longitude').value = location.lng().toFixed(7);
                    document.getElementById('address').value = place.formatted_address || place.name;
                }
            });

            // Handle tab shown event to resize map
            const tabEl = document.querySelector('button[data-bs-target="#v-pills-location"]');
            if (tabEl) {
                tabEl.addEventListener('shown.bs.tab', function() {
                    google.maps.event.trigger(map, 'resize');
                    map.setCenter(marker.getPosition());
                });
            }

            // Initialize other previews
            updateCardPreview();
            updateContactPreview();

            const currentStyle = document.getElementById('card_gradient_style').value;
            const btn = document.querySelector(`.card-style-btn[data-style="${currentStyle}"]`);
            if (btn) {
                btn.click();
            }

            @if ($setting->card_background_image)
                setCardBackgroundImage("{{ asset('storage/' . $setting->card_background_image) }}");
            @endif

            // Enable Enter key for search
            searchInput.addEventListener('keypress', function(e) {
                if (e.key === 'Enter') {
                    e.preventDefault();
                    searchLocation();
                }
            });
        }

        // Search Location Function
        function searchLocation() {
            const query = document.getElementById('map_search').value;
            if (!query) {
                alert('Silakan masukkan alamat atau nama lokasi yang ingin dicari');
                return;
            }

            geocoder.geocode({ address: query, componentRestrictions: { country: 'id' } }, function(results, status) {
                if (status === 'OK' && results[0]) {
                    const location = results[0].geometry.location;
                    map.setCenter(location);
                    map.setZoom(16);
                    marker.setPosition(location);
                    
                    document.getElementById('latitude').value = location.lat().toFixed(7);
                    document.getElementById('longitude').value = location.lng().toFixed(7);
                    document.getElementById('address').value = results[0].formatted_address;
                } else {
                    alert('Lokasi tidak ditemukan. Coba gunakan kata kunci yang lebih spesifik.');
                }
            });
        }

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
            'Bank Mega': `<svg width="180" height="40" viewBox="0 0 180 40" fill="none">
            <rect width="180" height="40" rx="4" fill="white" opacity="0.95"/>
            <text x="90" y="25" text-anchor="middle" fill="#0066CC" font-size="14" font-weight="bold" font-family="Arial">MEGA</text>
        </svg>`
        };

        function updateCardPreview() {
            var bankName = document.getElementById('bank_name').value || 'BANK NAME';
            var accNum = document.getElementById('bank_account_number').value || '#### #### #### ####';
            var holder = document.getElementById('bank_account_holder').value || 'HOLDER NAME';

            document.getElementById('preview_account_number').textContent = accNum;
            document.getElementById('preview_holder_name').textContent = holder;

            // Update bank logo
            var logoContainer = document.getElementById('bank_logo_container');
            if (logoContainer && bankLogos[bankName]) {
                logoContainer.innerHTML = bankLogos[bankName];
            } else if (logoContainer) {
                logoContainer.innerHTML =
                    `<div style="color: white; font-size: 1.2rem; font-weight: bold; text-shadow: 2px 2px 4px rgba(0,0,0,0.5);">${bankName}</div>`;
            }
        }

        function setCardStyle(style, gradient) {
            document.getElementById('card_background_type').value = 'gradient';
            document.getElementById('card_gradient_style').value = style;
            document.getElementById('card_bg_preview').style.background = gradient;
            document.getElementById('card_bg_preview').style.backgroundImage = '';

            document.querySelectorAll('.card-style-btn').forEach(b => b.classList.remove('active', 'border-primary'));
            var btn = document.querySelector(`.card-style-btn[data-style="${style}"]`);
            if (btn) {
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

            document.getElementById('card_background_type').value = 'image';

            document.querySelectorAll('.card-style-btn').forEach(b => b.classList.remove('active', 'border-primary'));
        }

        function clearCardImage() {
            document.getElementById('card_background_image').value = '';
            var currentStyle = document.getElementById('card_gradient_style').value || 'blue';
            var btn = document.querySelector(`.card-style-btn[data-style="${currentStyle}"]`);
            if (btn) {
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
            if (cleanWa.startsWith('0')) cleanWa = '62' + cleanWa.substring(1);
            document.getElementById('preview_wa_link').href = 'https://wa.me/' + cleanWa;
        }
    </script>
@endsection
