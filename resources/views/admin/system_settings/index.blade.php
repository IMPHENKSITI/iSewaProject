@extends('admin.layouts.admin')

@section('title', 'Pengaturan Sistem')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="card-title mb-0">Pengaturan Sistem</h4>
                    <div>
                        <form action="{{ route('admin.system-settings.reset') }}" method="POST" style="display:inline;" onsubmit="return confirm('Yakin ingin mereset semua pengaturan?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-outline-danger">Reset Pengaturan</button>
                        </form>
                    </div>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.system-settings.update') }}" method="POST">
                        @csrf
                        @method('PUT')

                        <!-- Tab Navigation -->
                        <ul class="nav nav-tabs" id="systemSettingsTab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="location-tab" data-bs-toggle="tab" data-bs-target="#location" type="button" role="tab" aria-controls="location" aria-selected="true">Lokasi BUMDes</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="bank-tab" data-bs-toggle="tab" data-bs-target="#bank" type="button" role="tab" aria-controls="bank" aria-selected="false">Nomor Rekening</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="contact-tab" data-bs-toggle="tab" data-bs-target="#contact" type="button" role="tab" aria-controls="contact" aria-selected="false">Kontak & Jam Layanan</button>
                            </li>
                        </ul>

                        <!-- Tab Content -->
                        <div class="tab-content mt-3" id="systemSettingsTabContent">

                            <!-- Lokasi BUMDes -->
                            <div class="tab-pane fade show active" id="location" role="tabpanel" aria-labelledby="location-tab">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="location_name" class="form-label">Nama Lokasi (Opsional)</label>
                                            <input type="text" class="form-control" id="location_name" name="location_name" value="{{ old('location_name', $setting->location_name) }}">
                                        </div>
                                        <div class="mb-3">
                                            <label for="address" class="form-label">Alamat Lengkap (Opsional)</label>
                                            <textarea class="form-control" id="address" name="address" rows="3">{{ old('address', $setting->address) }}</textarea>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="map" class="form-label">Preview Lokasi (Satellite View)</label>
                                            <div id="map" style="height: 400px; width: 100%; border: 1px solid #ddd; border-radius: 5px;"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Nomor Rekening -->
                            <div class="tab-pane fade" id="bank" role="tabpanel" aria-labelledby="bank-tab">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="bank_name" class="form-label">Nama Bank</label>
                                            <select class="form-select" id="bank_name" name="bank_name" required>
                                                <option value="">Pilih Bank</option>
                                                <option value="Bank Syariah Indonesia" {{ old('bank_name', $setting->bank_name) == 'Bank Syariah Indonesia' ? 'selected' : '' }}>Bank Syariah Indonesia (BSI)</option>
                                                <option value="BRI" {{ old('bank_name', $setting->bank_name) == 'BRI' ? 'selected' : '' }}>Bank Rakyat Indonesia (BRI)</option>
                                                <option value="BNI" {{ old('bank_name', $setting->bank_name) == 'BNI' ? 'selected' : '' }}>Bank Negara Indonesia (BNI)</option>
                                                <option value="Bank Riau Kepri Syariah" {{ old('bank_name', $setting->bank_name) == 'Bank Riau Kepri Syariah' ? 'selected' : '' }}>Bank Riau Kepri Syariah</option>
                                                <option value="Mandiri" {{ old('bank_name', $setting->bank_name) == 'Mandiri' ? 'selected' : '' }}>Bank Mandiri</option>
                                                <option value="BCA" {{ old('bank_name', $setting->bank_name) == 'BCA' ? 'selected' : '' }}>Bank Central Asia (BCA)</option>
                                                <option value="CIMB Niaga" {{ old('bank_name', $setting->bank_name) == 'CIMB Niaga' ? 'selected' : '' }}>CIMB Niaga</option>
                                                <option value="Danamon" {{ old('bank_name', $setting->bank_name) == 'Danamon' ? 'selected' : '' }}>Bank Danamon</option>
                                                <option value="PermataBank" {{ old('bank_name', $setting->bank_name) == 'PermataBank' ? 'selected' : '' }}>PermataBank</option>
                                                <option value="OCBC NISP" {{ old('bank_name', $setting->bank_name) == 'OCBC NISP' ? 'selected' : '' }}>OCBC NISP</option>
                                                <option value="Maybank" {{ old('bank_name', $setting->bank_name) == 'Maybank' ? 'selected' : '' }}>Maybank</option>
                                                <option value="Panin Bank" {{ old('bank_name', $setting->bank_name) == 'Panin Bank' ? 'selected' : '' }}>Panin Bank</option>
                                                <option value="UOB Indonesia" {{ old('bank_name', $setting->bank_name) == 'UOB Indonesia' ? 'selected' : '' }}>UOB Indonesia</option>
                                                <option value="Standard Chartered" {{ old('bank_name', $setting->bank_name) == 'Standard Chartered' ? 'selected' : '' }}>Standard Chartered</option>
                                                <option value="Citibank" {{ old('bank_name', $setting->bank_name) == 'Citibank' ? 'selected' : '' }}>Citibank</option>
                                                <option value="HSBC" {{ old('bank_name', $setting->bank_name) == 'HSBC' ? 'selected' : '' }}>HSBC</option>
                                                <option value="DBS Indonesia" {{ old('bank_name', $setting->bank_name) == 'DBS Indonesia' ? 'selected' : '' }}>DBS Indonesia</option>
                                                <option value="BNP Paribas" {{ old('bank_name', $setting->bank_name) == 'BNP Paribas' ? 'selected' : '' }}>BNP Paribas</option>
                                                <option value="ABN AMRO" {{ old('bank_name', $setting->bank_name) == 'ABN AMRO' ? 'selected' : '' }}>ABN AMRO</option>
                                                <option value="ING Bank" {{ old('bank_name', $setting->bank_name) == 'ING Bank' ? 'selected' : '' }}>ING Bank</option>
                                                <option value="Alliance Bank" {{ old('bank_name', $setting->bank_name) == 'Alliance Bank' ? 'selected' : '' }}>Alliance Bank</option>
                                                <option value="Maybank Syariah" {{ old('bank_name', $setting->bank_name) == 'Maybank Syariah' ? 'selected' : '' }}>Maybank Syariah</option>
                                                <option value="BNI Syariah" {{ old('bank_name', $setting->bank_name) == 'BNI Syariah' ? 'selected' : '' }}>BNI Syariah</option>
                                                <option value="BRI Syariah" {{ old('bank_name', $setting->bank_name) == 'BRI Syariah' ? 'selected' : '' }}>BRI Syariah</option>
                                                <option value="Mandiri Syariah" {{ old('bank_name', $setting->bank_name) == 'Mandiri Syariah' ? 'selected' : '' }}>Mandiri Syariah</option>
                                                <option value="CIMB Niaga Syariah" {{ old('bank_name', $setting->bank_name) == 'CIMB Niaga Syariah' ? 'selected' : '' }}>CIMB Niaga Syariah</option>
                                                <option value="BCA Syariah" {{ old('bank_name', $setting->bank_name) == 'BCA Syariah' ? 'selected' : '' }}>BCA Syariah</option>
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label for="bank_account_number" class="form-label">Nomor Rekening Tujuan</label>
                                            <input type="text" class="form-control" id="bank_account_number" name="bank_account_number" value="{{ old('bank_account_number', $setting->bank_account_number) }}" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="bank_account_holder" class="form-label">Atas Nama Rekening</label>
                                            <input type="text" class="form-control" id="bank_account_holder" name="bank_account_holder" value="{{ old('bank_account_holder', $setting->bank_account_holder) }}" required>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Metode Pembayaran Aktif</label>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" value="transfer" id="payment_transfer" name="payment_methods[]" {{ in_array('transfer', old('payment_methods', $setting->payment_methods ?? [])) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="payment_transfer">
                                                    Transfer Bank
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" value="tunai" id="payment_tunai" name="payment_methods[]" {{ in_array('tunai', old('payment_methods', $setting->payment_methods ?? [])) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="payment_tunai">
                                                    Tunai (kepada: <input type="text" class="form-control form-control-sm d-inline-block w-auto" name="tunai_to" placeholder="misal: Pak Ahmad" value="{{ old('tunai_to', $setting->payment_methods['tunai_to'] ?? '') }}")
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="bank_preview" class="form-label">Preview untuk User</label>
                                            <div class="card bg-light">
                                                <div class="card-body">
                                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                                        <div>
                                                            <img src="{{ asset('admin/img/banks/' . strtolower(str_replace(' ', '-', $setting->bank_name)) . '.png') }}" alt="{{ $setting->bank_name }}" style="height: 40px; margin-right: 10px;">
                                                            <strong>{{ $setting->bank_name }}</strong>
                                                        </div>
                                                        <div>
                                                            <span>Jumlah Yang Harus Dibayar</span><br>
                                                            <strong style="color: red; font-size: 1.2em;">Rp. 700.000</strong>
                                                        </div>
                                                    </div>
                                                    <div class="mb-3">
                                                        <span>Atas Nama</span><br>
                                                        <strong>{{ $setting->bank_account_holder }}</strong>
                                                    </div>
                                                    <div>
                                                        <span>Nomor Rekening Tujuan</span><br>
                                                        <strong style="font-size: 1.5em;">{{ $setting->bank_account_number }}</strong>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Kontak & Jam Layanan -->
                            <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="whatsapp_number" class="form-label">Nomor WhatsApp BUMDes</label>
                                            <input type="text" class="form-control" id="whatsapp_number" name="whatsapp_number" value="{{ old('whatsapp_number', $setting->whatsapp_number) }}" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="office_address" class="form-label">Alamat Kantor</label>
                                            <textarea class="form-control" id="office_address" name="office_address" rows="3">{{ old('office_address', $setting->office_address) }}</textarea>
                                        </div>
                                        <div class="mb-3">
                                            <label for="operating_hours" class="form-label">Jam Operasional</label>
                                            <input type="text" class="form-control" id="operating_hours" name="operating_hours" value="{{ old('operating_hours', $setting->operating_hours) }}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="contact_preview" class="form-label">Preview Kontak</label>
                                            <div class="card bg-light">
                                                <div class="card-body">
                                                    <div class="mb-3">
                                                        <i class="bx bxl-whatsapp"></i> <strong>WhatsApp:</strong> {{ $setting->whatsapp_number }}
                                                    </div>
                                                    <div class="mb-3">
                                                        <i class="bx bx-map"></i> <strong>Alamat:</strong> {{ $setting->office_address }}
                                                    </div>
                                                    <div>
                                                        <i class="bx bx-clock"></i> <strong>Jam Operasional:</strong> {{ $setting->operating_hours }}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="mt-4">
                            <a href="{{ route('admin.system-settings.index') }}" class="btn btn-secondary">Batal</a>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Google Maps Script -->
<script async defer src="https://maps.googleapis.com/maps/api/js?key=YOUR_GOOGLE_MAPS_API_KEY&callback=initMap"></script>
<script>
function initMap() {
    const mapOptions = {
        zoom: 15,
        mapTypeId: google.maps.MapTypeId.SATELLITE, // Satellite view
        center: { lat: {{ old('latitude', $setting->latitude) }}, lng: {{ old('longitude', $setting->longitude) }} },
        streetViewControl: false,
        mapTypeControl: true,
        zoomControl: true,
        fullscreenControl: true,
        scaleControl: true,
        rotateControl: false
    };

    const map = new google.maps.Map(document.getElementById("map"), mapOptions);

    // Add marker
    const marker = new google.maps.Marker({
        position: { lat: {{ old('latitude', $setting->latitude) }}, lng: {{ old('longitude', $setting->longitude) }} },
        map: map,
        draggable: true,
        title: "{{ old('location_name', $setting->location_name) }}"
    });

    // Update input fields when marker is dragged
    google.maps.event.addListener(marker, 'dragend', function(event) {
        document.getElementById('latitude').value = event.latLng.lat().toFixed(7);
        document.getElementById('longitude').value = event.latLng.lng().toFixed(7);
    });

    // Update marker position when input fields change
    document.getElementById('latitude').addEventListener('change', function() {
        const lat = parseFloat(this.value);
        const lng = parseFloat(document.getElementById('longitude').value);
        if (!isNaN(lat) && !isNaN(lng)) {
            marker.setPosition({lat: lat, lng: lng});
            map.setCenter({lat: lat, lng: lng});
        }
    });

    document.getElementById('longitude').addEventListener('change', function() {
        const lng = parseFloat(this.value);
        const lat = parseFloat(document.getElementById('latitude').value);
        if (!isNaN(lat) && !isNaN(lng)) {
            marker.setPosition({lat: lat, lng: lng});
            map.setCenter({lat: lat, lng: lng});
        }
    });
}

// Initialize map after DOM is loaded
document.addEventListener('DOMContentLoaded', function() {
    initMap();
});
</script>

@endsection