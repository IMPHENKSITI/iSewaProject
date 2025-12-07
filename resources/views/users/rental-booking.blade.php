@extends('layouts.user')

@php
    // Determine card background style based on admin settings
    $cardStyle = 'background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);'; // default blue
    $amountColor = 'text-yellow-300'; // Default amount color
    $cardTextColor = 'text-white'; // Default card text color
    $buttonClass = 'bg-white/20 backdrop-blur-sm border border-white/40 text-white hover:bg-white/30'; // Default button style
    $borderClass = 'border-white/30'; // Default border style
    
    if ($setting && $setting->card_gradient_style) {
        $gradients = [
            'white' => 'linear-gradient(135deg, #ffffff 0%, #f0f0f0 100%)',
            'silver' => 'linear-gradient(135deg, #e0e0e0 0%, #c0c0c0 100%)',
            'gold' => 'linear-gradient(135deg, #ffd700 0%, #fdb931 100%)',
            'transparent' => 'rgba(59, 130, 246, 0.3)',
            'blue' => 'linear-gradient(135deg, #1e3c72 0%, #2a5298 100%)',
            'green' => 'linear-gradient(135deg, #00a884 0%, #005c4b 100%)',
            'purple' => 'linear-gradient(135deg, #667eea 0%, #764ba2 100%)',
            'dark' => 'linear-gradient(135deg, #232526 0%, #414345 100%)',
            'orange' => 'linear-gradient(135deg, #f7971e 0%, #ffd200 100%)',
            'red' => 'linear-gradient(135deg, #eb3349 0%, #f45c43 100%)',
        ];
        
        $style = $setting->card_gradient_style;
        $cardStyle = 'background: ' . ($gradients[$style] ?? $gradients['blue']) . ';';
        
        // Determine colors based on background
        if (in_array($style, ['white', 'silver', 'gold', 'transparent'])) {
            $amountColor = 'text-red-600';
            $cardTextColor = 'text-gray-800';
            $buttonClass = 'bg-gray-200 hover:bg-gray-300 text-gray-800 border border-gray-400';
            $borderClass = 'border-gray-300';
        } elseif ($style == 'red') {
            $amountColor = 'text-white';
            $cardTextColor = 'text-white';
        } else {
            $amountColor = 'text-yellow-300'; // Blue, Green, Purple, Dark
            $cardTextColor = 'text-white';
        }
    }
    
    // Legacy support for image (if re-enabled or existing)
    if ($setting && $setting->card_background_type === 'image' && $setting->card_background_image) {
        $cardStyle = "background-image: url('" . asset('storage/' . $setting->card_background_image) . "'); background-size: cover; background-position: center;";
        $amountColor = 'text-yellow-300';
        $cardTextColor = 'text-white';
    }
    
    // Get cash payment description
    $cashDescription = $setting->cash_payment_description ?? 'Yani - Bendahara BUMDes';

    // Bank Logo Mapping
    $bankLogos = [
        'Bank Syariah Indonesia' => 'admin/img/banks/bsi.png',
        'BRI' => 'admin/img/banks/bri.png',
        'Mandiri' => 'admin/img/banks/mandiri.png',
        'BNI' => 'admin/img/banks/bni.png',
        'BCA' => 'admin/img/banks/bca.png',
        'Bank Riau Kepri Syariah' => 'admin/img/banks/brk.png',
        'Bank Mega' => 'admin/img/banks/mega.png',
    ];
    $bankLogoPath = $bankLogos[$setting->bank_name ?? ''] ?? 'admin/img/banks/bsi.png';
    
    // Determine available payment methods with better fallback
    $methods = $setting?->payment_methods ?? ['transfer', 'tunai'];
    if (!is_array($methods) || empty($methods)) {
        $methods = ['transfer', 'tunai'];
    }
    $hasTransfer = in_array('transfer', $methods);
    $hasTunai = in_array('tunai', $methods);
    
    // Ensure at least one method is available
    if (!$hasTransfer && !$hasTunai) {
        $hasTransfer = true;
        $hasTunai = true;
    }
    
    // Determine default active method
    $defaultMethod = $hasTransfer ? 'transfer' : 'tunai';
@endphp

@section('page')
<main class="flex-grow relative w-full">
    <section class="relative z-10 min-h-screen pt-32 pb-16 bg-cover bg-center bg-no-repeat bg-fixed" 
             style="background-image: url('{{ asset('admin/img/elements/background1.png') }}');">
        
        <!-- White Overlay (25% opacity / 75% transparent) to make background visible -->
        <div class="absolute inset-0 bg-white/25 pointer-events-none"></div>

        <!-- Decorative Background Elements (Commented Out) -->
        {{-- 
        <div class="absolute inset-0 pointer-events-none overflow-hidden">
            <!-- Top Left Blue Wave -->
            <svg class="absolute top-0 left-0 w-[500px] h-[400px] opacity-30" style="transform: translate(-20%, -10%);">
                <defs>
                    <linearGradient id="blueWave1" x1="0%" y1="0%" x2="100%" y2="100%">
                        <stop offset="0%" style="stop-color:#60a5fa;stop-opacity:0.6" />
                        <stop offset="100%" style="stop-color:#93c5fd;stop-opacity:0.3" />
                    </linearGradient>
                </defs>
                <path d="M0,100 Q150,50 300,100 T600,100 L600,0 L0,0 Z" fill="url(#blueWave1)" />
            </svg>

            <!-- Top Right Geometric Shape -->
            <div class="absolute top-20 right-0" style="transform: translateX(30%) rotate(15deg);">
                <svg width="300" height="300" viewBox="0 0 300 300" class="opacity-20">
                    <rect x="50" y="50" width="80" height="80" fill="#60a5fa" transform="rotate(45 90 90)" opacity="0.4"/>
                    <rect x="150" y="80" width="60" height="60" fill="#93c5fd" transform="rotate(30 180 110)" opacity="0.3"/>
                </svg>
            </div>

            <!-- Bottom Left Yellow Wave -->
            <svg class="absolute bottom-0 left-0 w-[600px] h-[400px] opacity-40" style="transform: translate(-15%, 20%);">
                <defs>
                    <linearGradient id="yellowWave" x1="0%" y1="0%" x2="100%" y2="100%">
                        <stop offset="0%" style="stop-color:#fbbf24;stop-opacity:0.5" />
                        <stop offset="100%" style="stop-color:#fde68a;stop-opacity:0.2" />
                    </linearGradient>
                </defs>
                <path d="M0,200 Q200,150 400,200 T800,200 L800,400 L0,400 Z" fill="url(#yellowWave)" />
            </svg>

            <!-- Bottom Right Blue Wave -->
            <svg class="absolute bottom-0 right-0 w-[500px] h-[350px] opacity-35" style="transform: translate(20%, 15%);">
                <defs>
                    <linearGradient id="blueWave2" x1="0%" y1="0%" x2="100%" y2="100%">
                        <stop offset="0%" style="stop-color:#3b82f6;stop-opacity:0.4" />
                        <stop offset="100%" style="stop-color:#60a5fa;stop-opacity:0.2" />
                    </linearGradient>
                </defs>
                <path d="M0,150 Q150,100 300,150 T600,150 L600,400 L0,400 Z" fill="url(#blueWave2)" />
            </svg>
        </div>
        --}}

        <div class="max-w-5xl mx-auto px-6 relative z-20">
            <!-- Header with Gradient Text -->
            <div class="text-center mb-12 mt-8">
                <h1 class="text-3xl md:text-4xl font-bold mb-2">
                    <span class="text-gray-800">Metode </span>
                    <span class="bg-gradient-to-r from-[#115789] to-[#60a5fa] bg-clip-text text-transparent">Antar Jemput Alat Sewa</span>
                </h1>
            </div>

            <form id="booking-form" action="#" method="POST" enctype="multipart/form-data" onsubmit="return false;">
                @csrf
                <input type="hidden" name="barang_id" value="{{ $item->id }}">
                <input type="hidden" name="quantity" id="hidden-quantity" value="{{ $quantity }}">
                <input type="hidden" name="delivery_method" id="delivery-method-input" value="antar">
                <input type="hidden" name="latitude" id="latitude-input">
                <input type="hidden" name="longitude" id="longitude-input">

                <!-- Delivery Method Selection -->
                <div class="flex justify-center gap-6 mb-10">
                    <!-- Antar Card -->
                    <div class="delivery-method-card active cursor-pointer bg-white rounded-2xl p-8 shadow-lg hover:shadow-xl transition-all duration-300 w-48 text-center border-4 border-transparent" data-method="antar">
                        <!-- Placeholder for Truck Icon -->
                        <div class="mb-4 flex justify-center">
                            <img src="{{ asset('admin/img/elements/antar.png') }}" alt="Antar" class="w-20 h-20 object-contain">
                        </div>
                        <p class="font-bold text-lg text-gray-800">Antar</p>
                    </div>

                    <!-- Jemput Card -->
                    <div class="delivery-method-card cursor-pointer bg-white rounded-2xl p-8 shadow-lg hover:shadow-xl transition-all duration-300 w-48 text-center border-4 border-transparent" data-method="jemput">
                        <!-- Placeholder for Warehouse Icon -->
                        <div class="mb-4 flex justify-center">
                            <img src="{{ asset('admin/img/elements/jemput.png') }}" alt="Jemput" class="w-20 h-20 object-contain">
                        </div>
                        <p class="font-bold text-lg text-gray-800">Jemput</p>
                    </div>
                </div>

                <!-- Antar Method Form -->
                <div id="antar-form" class="delivery-form-content">
                    <!-- Alamat Pengiriman Card -->
                    <div class="bg-white rounded-2xl shadow-lg p-6 mb-6">
                        <div class="flex items-center gap-3 mb-4">
                            <svg class="w-6 h-6 text-red-600" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"/>
                            </svg>
                            <h3 class="text-lg font-bold text-gray-800">Alamat Pengiriman</h3>
                        </div>
                        
                        <div class="space-y-4">
                            <input type="text" 
                                   name="recipient_name" 
                                   id="recipient-name"
                                   placeholder="Nama Lengkap" 
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                            
                            <textarea name="delivery_address" 
                                      id="delivery-address"
                                      rows="3" 
                                      placeholder="Alamat Lengkap" 
                                      class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>
                            
                            <p class="text-sm text-gray-600">Bagikan juga lokasi anda menggunakan Maps agar lebih akurat</p>
                            
                            <button type="button" 
                                    id="share-location-btn"
                                    class="flex items-center gap-2 px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors">
                                <svg class="w-5 h-5" viewBox="0 0 48 48">
                                    <path fill="#1976D2" d="M24 9.5c-5.8 0-10.5 4.7-10.5 10.5s4.7 10.5 10.5 10.5 10.5-4.7 10.5-10.5S29.8 9.5 24 9.5z"/>
                                    <path fill="#FFC107" d="M24 4C15.2 4 8 11.2 8 20c0 8.8 16 24 16 24s16-15.2 16-24c0-8.8-7.2-16-16-16zm0 21.5c-3 0-5.5-2.5-5.5-5.5s2.5-5.5 5.5-5.5 5.5 2.5 5.5 5.5-2.5 5.5-5.5 5.5z"/>
                                </svg>
                                <span class="text-sm font-medium">Google Maps</span>
                            </button>
                        </div>
                    </div>

                    <!-- Waktu Penyewaan Card -->
                    <div class="bg-white rounded-2xl shadow-lg p-6 mb-6">
                        <div class="flex items-center gap-3 mb-4">
                            <svg class="w-6 h-6 text-red-600" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/>
                            </svg>
                            <h3 class="text-lg font-bold text-gray-800">Waktu Penyewaan</h3>
                            <div class="ml-auto text-right">
                                <p class="text-sm text-gray-600">Lama Hari Sewa</p>
                                <p class="text-2xl font-bold text-gray-800"><span id="days-count">0</span> Hari</p>
                            </div>
                        </div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-3">
                            <div>
                                <label class="block text-sm text-gray-600 mb-2">Tanggal Mulai Sewa / Acara</label>
                                <input type="date" 
                                       name="start_date" 
                                       id="start-date"
                                       min="{{ date('Y-m-d') }}"
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                            </div>
                            <div>
                                <label class="block text-sm text-gray-600 mb-2">Tanggal Selesai Sewa / Acara</label>
                                <input type="date" 
                                       name="end_date" 
                                       id="end-date"
                                       min="{{ date('Y-m-d') }}"
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                            </div>
                        </div>
                        
                        <div class="flex items-center gap-2 text-sm text-gray-600">
                            <svg class="w-4 h-4 text-red-600" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                            </svg>
                            <p>Pembayaran sewa bisa dilakukan hingga selesai acara</p>
                        </div>
                    </div>

                    <!-- Product Card -->
                    <div class="bg-white rounded-2xl shadow-lg p-6 mb-6">
                        <div class="flex items-center gap-3 mb-4">
                            <svg class="w-6 h-6 text-red-600" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M3 1a1 1 0 000 2h1.22l.305 1.222a.997.997 0 00.01.042l1.358 5.43-.893.892C3.74 11.846 4.632 14 6.414 14H15a1 1 0 000-2H6.414l1-1H14a1 1 0 00.894-.553l3-6A1 1 0 0017 3H6.28l-.31-1.243A1 1 0 005 1H3zM16 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM6.5 18a1.5 1.5 0 100-3 1.5 1.5 0 000 3z"/>
                            </svg>
                            <h3 class="text-lg font-bold text-gray-800">{{ $item->nama_barang }}</h3>
                            <span class="ml-auto text-sm text-gray-600">{{ $item->kategori }}</span>
                        </div>
                        
                        <div class="flex gap-6">
                            <img src="{{ asset('storage/' . $item->foto) }}" 
                                 alt="{{ $item->nama_barang }}" 
                                 class="w-32 h-32 object-cover rounded-lg">
                            
                            <div class="flex-1">
                                <p class="text-sm text-gray-600 mb-1">Harga Satuan</p>
                                <p class="text-xl font-bold text-gray-800 mb-4">Rp. {{ number_format($item->harga_sewa, 0, ',', '.') }}</p>
                                
                                <div class="flex items-center gap-3">
                                    <label class="text-sm text-gray-600">Jumlah</label>
                                    <div class="flex items-center gap-2 border border-gray-300 rounded-lg px-3 py-1">
                                        <button type="button" id="decrease-qty" class="text-gray-600 hover:text-gray-800">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"/>
                                            </svg>
                                        </button>
                                        <input type="number" 
                                               id="quantity-display" 
                                               value="{{ $quantity }}" 
                                               min="1" 
                                               max="{{ $item->stok }}"
                                               class="w-12 text-center border-0 focus:outline-none focus:ring-0">
                                        <button type="button" id="increase-qty" class="text-gray-600 hover:text-gray-800">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="text-right">
                                <p class="text-sm text-gray-600 mb-1">Subtotal</p>
                                <p class="text-xl font-bold text-gray-800" id="subtotal">Rp. {{ number_format($item->harga_sewa * $quantity, 0, ',', '.') }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Payment Method -->
                    <div class="mb-6">
                        <h3 class="text-xl font-bold text-gray-800 mb-4">Metode Pembayaran</h3>
                        <div class="flex gap-4 mb-6">
                            @if($hasTransfer)
                            <button type="button" 
                                    class="payment-method-btn {{ $defaultMethod == 'transfer' ? 'active' : '' }} flex-1 px-6 py-3 bg-blue-500 text-white rounded-lg font-semibold hover:bg-blue-600 transition-colors"
                                    data-method="transfer">
                                Transfer
                            </button>
                            @endif
                            
                            @if($hasTunai)
                            <button type="button" 
                                    class="payment-method-btn {{ $defaultMethod == 'tunai' ? 'active' : '' }} flex-1 px-6 py-3 bg-gray-200 text-gray-700 rounded-lg font-semibold hover:bg-gray-300 transition-colors"
                                    data-method="tunai">
                                Tunai
                            </button>
                            @endif
                        </div>
                        <input type="hidden" name="payment_method" id="payment-method-hidden" value="{{ $defaultMethod }}">

                        <!-- Transfer Payment Card -->
                        <div id="transfer-payment" class="payment-content {{ $defaultMethod == 'transfer' ? '' : 'hidden' }}">
                            <div class="rounded-2xl shadow-lg p-8 {{ $cardTextColor }}" style="{{ $cardStyle }}">
                                <h4 class="text-2xl font-bold text-center mb-6">{{ $setting->bank_name ?? 'Bank Syariah Indonesia' }}</h4>
                                
                                <div class="flex items-start gap-6 mb-6">
                                    <!-- Bank Logo -->
                                    <div class="flex-shrink-0">
                                        <div class="w-24 h-16 bg-white rounded-lg flex items-center justify-center shadow-md p-2">
                                            <img src="{{ asset($bankLogoPath) }}" alt="{{ $setting->bank_name }}" class="w-full h-full object-contain">
                                        </div>
                                    </div>
                                    
                                    <div class="flex-1">
                                        <p class="text-sm mb-1 opacity-90">Atas Nama</p>
                                        <p class="text-lg font-bold mb-4">{{ $setting->bank_account_holder ?? 'BUMDes Desa Pematang Duku Timur' }}</p>
                                        
                                        <p class="text-sm mb-1 opacity-90">Nomor Rekening Tujuan</p>
                                        <p class="text-3xl font-bold mb-2">{{ $setting->bank_account_number ?? '1234 5678 989' }}</p>
                                    </div>
                                    
                                    <div class="text-right">
                                        <p class="text-sm mb-1 opacity-90">Jumlah Yang Harus Dibayar</p>
                                        <p class="text-3xl font-bold {{ $amountColor }}" id="total-amount-transfer">Rp. {{ number_format($item->harga_sewa * $quantity, 0, ',', '.') }}</p>
                                    </div>
                                </div>
                                
                                <div class="border-t {{ $borderClass }} pt-6">
                                    <div class="flex items-center justify-between mb-4">
                                        <label class="text-sm font-semibold">Upload Bukti Pembayaran</label>
                                        <button type="button" 
                                                onclick="document.getElementById('payment-proof').click()"
                                                class="px-4 py-2 {{ $buttonClass }} rounded-lg transition-colors">
                                            Pilih File
                                        </button>
                                    </div>
                                    <input type="file" 
                                           name="payment_proof" 
                                           id="payment-proof" 
                                           accept="image/*,application/pdf"
                                           class="hidden">
                                    <p id="file-name" class="text-sm opacity-80 italic">Belum ada file dipilih</p>
                                    <a href="#" class="text-sm hover:underline mt-2 inline-block opacity-90">Kirim</a>
                                </div>
                            </div>
                        </div>

                        <!-- Cash Payment Card -->
                        <div id="cash-payment" class="payment-content {{ $defaultMethod == 'tunai' ? '' : 'hidden' }}">
                            <div class="bg-gradient-to-br from-gray-50 to-gray-100 rounded-2xl shadow-lg p-8">
                                <h4 class="text-2xl font-bold text-center text-gray-800 mb-6">Silahkan Lakukan Pembayaran Ditempat</h4>
                                
                                <div class="flex items-center justify-between">
                                    <div>
                                        <p class="text-lg text-gray-700">{{ $cashDescription }}</p>
                                    </div>
                                    
                                    <div class="text-right">
                                        <p class="text-sm text-gray-600 mb-1">Jumlah Yang Harus Dibayar</p>
                                        <p class="text-3xl font-bold text-red-600" id="total-amount-cash">Rp. {{ number_format($item->harga_sewa * $quantity, 0, ',', '.') }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="flex justify-end">
                        <button type="button" 
                                class="confirm-action-btn px-8 py-3 bg-blue-500 hover:bg-blue-600 text-white font-bold rounded-full shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-0.5">
                            Konfirmasi
                        </button>
                    </div>
                </div>

                <!-- Jemput Method Form -->
                <div id="jemput-form" class="delivery-form-content hidden">
                    <!-- Alamat BUMDes Card -->
                    <div class="bg-white rounded-2xl shadow-lg p-6 mb-6">
                        <div class="flex items-center gap-3 mb-4">
                            <svg class="w-6 h-6 text-red-600" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"/>
                            </svg>
                            <h3 class="text-lg font-bold text-gray-800">Alamat Bumdes</h3>
                        </div>
                        
                        <div class="flex items-center justify-between">
                            <p class="text-gray-600">Lihat dan dapatkan juga Lokasi BUMDes untuk mempermudah penjemputan Alat Sewa</p>
                            
                            @if($setting && $setting->latitude && $setting->longitude)
                            <a href="https://www.google.com/maps?q={{ $setting->latitude }},{{ $setting->longitude }}" 
                               target="_blank"
                               class="flex items-center gap-2 px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors flex-shrink-0 ml-4">
                                <svg class="w-5 h-5" viewBox="0 0 48 48">
                                    <path fill="#1976D2" d="M24 9.5c-5.8 0-10.5 4.7-10.5 10.5s4.7 10.5 10.5 10.5 10.5-4.7 10.5-10.5S29.8 9.5 24 9.5z"/>
                                    <path fill="#FFC107" d="M24 4C15.2 4 8 11.2 8 20c0 8.8 16 24 16 24s16-15.2 16-24c0-8.8-7.2-16-16-16zm0 21.5c-3 0-5.5-2.5-5.5-5.5s2.5-5.5 5.5-5.5 5.5 2.5 5.5 5.5-2.5 5.5-5.5 5.5z"/>
                                </svg>
                                <span class="text-sm font-medium">Google Maps</span>
                            </a>
                            @endif
                        </div>
                    </div>

                    <!-- Waktu Penyewaan Card (Same as Antar) -->
                    <div class="bg-white rounded-2xl shadow-lg p-6 mb-6">
                        <div class="flex items-center gap-3 mb-4">
                            <svg class="w-6 h-6 text-red-600" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/>
                            </svg>
                            <h3 class="text-lg font-bold text-gray-800">Waktu Penyewaan</h3>
                            <div class="ml-auto text-right">
                                <p class="text-sm text-gray-600">Lama Hari Sewa</p>
                                <p class="text-2xl font-bold text-gray-800"><span id="days-count-jemput">0</span> Hari</p>
                            </div>
                        </div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-3">
                            <div>
                                <label class="block text-sm text-gray-600 mb-2">Tanggal Mulai Sewa / Acara</label>
                                <input type="date" 
                                       id="start-date-jemput"
                                       min="{{ date('Y-m-d') }}"
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                            </div>
                            <div>
                                <label class="block text-sm text-gray-600 mb-2">Tanggal Selesai Sewa / Acara</label>
                                <input type="date" 
                                       id="end-date-jemput"
                                       min="{{ date('Y-m-d') }}"
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                            </div>
                        </div>
                        
                        <div class="flex items-center gap-2 text-sm text-gray-600">
                            <svg class="w-4 h-4 text-red-600" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                            </svg>
                            <p>Pembayaran sewa bisa dilakukan hingga selesai acara</p>
                        </div>
                    </div>

                    <!-- Product Card (Same as Antar) -->
                    <div class="bg-white rounded-2xl shadow-lg p-6 mb-6">
                        <div class="flex items-center gap-3 mb-4">
                            <svg class="w-6 h-6 text-red-600" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M3 1a1 1 0 000 2h1.22l.305 1.222a.997.997 0 00.01.042l1.358 5.43-.893.892C3.74 11.846 4.632 14 6.414 14H15a1 1 0 000-2H6.414l1-1H14a1 1 0 00.894-.553l3-6A1 1 0 0017 3H6.28l-.31-1.243A1 1 0 005 1H3zM16 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM6.5 18a1.5 1.5 0 100-3 1.5 1.5 0 000 3z"/>
                            </svg>
                            <h3 class="text-lg font-bold text-gray-800">{{ $item->nama_barang }}</h3>
                            <span class="ml-auto text-sm text-gray-600">{{ $item->kategori }}</span>
                        </div>
                        
                        <div class="flex gap-6">
                            <img src="{{ asset('storage/' . $item->foto) }}" 
                                 alt="{{ $item->nama_barang }}" 
                                 class="w-32 h-32 object-cover rounded-lg">
                            
                            <div class="flex-1">
                                <p class="text-sm text-gray-600 mb-1">Harga Satuan</p>
                                <p class="text-xl font-bold text-gray-800 mb-4">Rp. {{ number_format($item->harga_sewa, 0, ',', '.') }}</p>
                                
                                <div class="flex items-center gap-3">
                                    <label class="text-sm text-gray-600">Jumlah</label>
                                    <div class="flex items-center gap-2 border border-gray-300 rounded-lg px-3 py-1">
                                        <button type="button" id="decrease-qty-jemput" class="text-gray-600 hover:text-gray-800">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"/>
                                            </svg>
                                        </button>
                                        <input type="number" 
                                               id="quantity-display-jemput" 
                                               value="{{ $quantity }}" 
                                               min="1" 
                                               max="{{ $item->stok }}"
                                               class="w-12 text-center border-0 focus:outline-none focus:ring-0">
                                        <button type="button" id="increase-qty-jemput" class="text-gray-600 hover:text-gray-800">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="text-right">
                                <p class="text-sm text-gray-600 mb-1">Subtotal</p>
                                <p class="text-xl font-bold text-gray-800" id="subtotal-jemput">Rp. {{ number_format($item->harga_sewa * $quantity, 0, ',', '.') }}</p>
                            </div>
                        </div>
                    </div>
                    <!-- Payment Method for Jemput -->
                    <div class="mb-6">
                        <h3 class="text-xl font-bold text-gray-800 mb-4">Metode Pembayaran</h3>
                        <div class="flex gap-4 mb-6">
                            @if($hasTransfer)
                            <button type="button" 
                                    class="payment-method-btn-jemput {{ $defaultMethod == 'transfer' ? 'active' : '' }} flex-1 px-6 py-3 bg-blue-500 text-white rounded-lg font-semibold hover:bg-blue-600 transition-colors"
                                    data-method="transfer">
                                Transfer
                            </button>
                            @endif
                            
                            @if($hasTunai)
                            <button type="button" 
                                    class="payment-method-btn-jemput {{ $defaultMethod == 'tunai' ? 'active' : '' }} flex-1 px-6 py-3 bg-gray-200 text-gray-700 rounded-lg font-semibold hover:bg-gray-300 transition-colors"
                                    data-method="tunai">
                                Tunai
                            </button>
                            @endif
                        </div>
                        <input type="hidden" name="payment_method_jemput" id="payment-method-jemput-hidden" value="{{ $defaultMethod }}">

                        <!-- Transfer Payment Card for Jemput -->
                        <div id="transfer-payment-jemput" class="payment-content-jemput {{ $defaultMethod == 'transfer' ? '' : 'hidden' }}">
                            <div class="rounded-2xl shadow-lg p-8 {{ $cardTextColor }}" style="{{ $cardStyle }}">
                                <h4 class="text-2xl font-bold text-center mb-6">{{ $setting->bank_name ?? 'Bank Syariah Indonesia' }}</h4>
                                
                                <div class="flex items-start gap-6 mb-6">
                                    <div class="flex-shrink-0">
                                        <div class="w-24 h-16 bg-white rounded-lg flex items-center justify-center shadow-md p-2">
                                            <img src="{{ asset($bankLogoPath) }}" alt="{{ $setting->bank_name }}" class="w-full h-full object-contain">
                                        </div>
                                    </div>
                                    
                                    <div class="flex-1">
                                        <p class="text-sm mb-1 opacity-90">Atas Nama</p>
                                        <p class="text-lg font-bold mb-4">{{ $setting->bank_account_holder ?? 'BUMDes Desa Pematang Duku Timur' }}</p>
                                        
                                        <p class="text-sm mb-1 opacity-90">Nomor Rekening Tujuan</p>
                                        <p class="text-3xl font-bold mb-2">{{ $setting->bank_account_number ?? '1234 5678 989' }}</p>
                                    </div>
                                    
                                    <div class="text-right">
                                        <p class="text-sm mb-1 opacity-90">Jumlah Yang Harus Dibayar</p>
                                        <p class="text-3xl font-bold {{ $amountColor }}" id="total-amount-transfer-jemput">Rp. {{ number_format($item->harga_sewa * $quantity, 0, ',', '.') }}</p>
                                    </div>
                                </div>
                                
                                <div class="border-t {{ $borderClass }} pt-6">
                                    <div class="flex items-center justify-between mb-4">
                                        <label class="text-sm font-semibold">Upload Bukti Pembayaran</label>
                                        <button type="button" 
                                                onclick="document.getElementById('payment-proof-jemput').click()"
                                                class="px-4 py-2 {{ $buttonClass }} rounded-lg hover:bg-white/30 transition-colors">
                                            Pilih File
                                        </button>
                                    </div>
                                    <input type="file" 
                                           name="payment_proof_jemput"
                                           id="payment-proof-jemput" 
                                           accept="image/*,application/pdf"
                                           class="hidden">
                                    <p id="file-name-jemput" class="text-sm opacity-80 italic">Belum ada file dipilih</p>
                                    <a href="#" class="text-sm hover:underline mt-2 inline-block opacity-90">Kirim</a>
                                </div>
                            </div>
                        </div>

                        <!-- Cash Payment Card for Jemput -->
                        <div id="cash-payment-jemput" class="payment-content-jemput {{ $defaultMethod == 'tunai' ? '' : 'hidden' }}">
                            <div class="bg-gradient-to-br from-gray-50 to-gray-100 rounded-2xl shadow-lg p-8">
                                <h4 class="text-2xl font-bold text-center text-gray-800 mb-6">Silahkan Lakukan Pembayaran Ditempat</h4>
                                
                                <div class="flex items-center justify-between">
                                    <div>
                                        <p class="text-lg text-gray-700">{{ $cashDescription }}</p>
                                    </div>
                                    
                                    <div class="text-right">
                                        <p class="text-sm text-gray-600 mb-1">Jumlah Yang Harus Dibayar</p>
                                        <p class="text-3xl font-bold text-red-600" id="total-amount-cash-jemput">Rp. {{ number_format($item->harga_sewa * $quantity, 0, ',', '.') }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="flex justify-end">
                        <button type="button" 
                                class="confirm-action-btn px-8 py-3 bg-blue-500 hover:bg-blue-600 text-white font-bold rounded-full shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-0.5">
                            Konfirmasi
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </section>

    <!-- Confirmation Modal -->
    <div id="confirmation-modal" class="fixed inset-0 bg-black/50 hidden items-center justify-center z-50" style="display: none;">
        <div class="bg-white rounded-3xl p-8 max-w-md w-full mx-4 shadow-2xl transform transition-all">
            <div class="text-center">
                <img src="{{ asset('admin/img/illustrations/isewalogo.png') }}" alt="iSewa Logo" class="w-40 mx-auto mb-6">
                <h2 class="text-2xl font-bold text-gray-800 mb-2">Anda akan Melakukan Penyewaan</h2>
                <p class="text-gray-600 mb-2">Pesanan Anda Akan Diproses</p>
                <p class="text-gray-500 text-sm mb-6">Apakah anda yakin?</p>
                
                <div class="flex gap-4">
                    <button type="button" 
                            id="cancel-confirmation"
                            class="flex-1 px-6 py-3 bg-gray-200 hover:bg-gray-300 text-gray-800 font-semibold rounded-full transition-colors">
                        Tidak
                    </button>
                    <button type="button" 
                            id="proceed-confirmation"
                            class="flex-1 px-6 py-3 bg-blue-500 hover:bg-blue-600 text-white font-semibold rounded-full transition-colors">
                        Ya
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Success Modal -->
    <div id="success-modal" class="fixed inset-0 bg-black/50 hidden items-center justify-center z-50" style="display: none;">
        <div class="bg-white rounded-3xl p-8 max-w-md w-full mx-4 shadow-2xl transform transition-all">
            <button type="button" id="close-success-modal" class="absolute top-4 right-4 text-gray-400 hover:text-gray-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
            
            <div class="text-center">
                <div class="mb-6">
                    <!-- Animated Checkmark -->
                    <div class="checkmark-circle mx-auto">
                        <svg class="checkmark" viewBox="0 0 52 52">
                            <circle class="checkmark-circle-path" cx="26" cy="26" r="25" fill="none"/>
                            <path class="checkmark-check" fill="none" d="M14.1 27.2l7.1 7.2 16.7-16.8"/>
                        </svg>
                    </div>
                </div>
                
                <h2 class="text-2xl font-bold text-gray-800 mb-3">Pesanan Berhasil Dibuat</h2>
                <p class="text-gray-700 font-medium mb-2">Pesanan Anda sedang Diproses</p>
                <p class="text-gray-500 text-sm mb-8">Silahkan klik untuk menuju halaman selanjutnya</p>
                
                <div class="space-y-4">
                    <div class="flex gap-4">
                        <button type="button" 
                                id="view-receipt-btn"
                                class="flex-1 px-5 py-3 border-2 border-blue-500 text-blue-500 font-semibold rounded-xl hover:bg-blue-50 transition-all">
                            Lihat Bukti Transaksi
                        </button>
                        <button type="button" 
                                id="download-receipt-btn"
                                class="flex-1 px-5 py-3 border-2 border-blue-500 text-blue-500 font-semibold rounded-xl hover:bg-blue-50 transition-all">
                            Unduh Bukti Transaksi
                        </button>
                    </div>
                    <button type="button" 
                            id="view-activity-btn"
                            class="w-full px-6 py-3.5 bg-blue-500 hover:bg-blue-600 text-white font-bold rounded-full shadow-lg hover:shadow-xl transition-all">
                        Lihat Aktivitas
                    </button>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection

@push('styles')
<style>
    * {
        font-family: 'Inter', sans-serif;
    }

    /* Delivery Method Cards */
    .delivery-method-card {
        cursor: pointer !important;
        user-select: none;
    }
    
    .delivery-method-card.active {
        border-color: #3b82f6 !important;
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
    }
    
    .delivery-method-card:hover {
        transform: translateY(-2px);
    }

    /* Payment Method Buttons */
    .payment-method-btn.active,
    .payment-method-btn-jemput.active {
        background-color: #3b82f6;
        color: white;
    }

    .payment-method-btn:not(.active),
    .payment-method-btn-jemput:not(.active) {
        background-color: #e5e7eb;
        color: #374151;
    }

    /* Remove spinner from number input */
    input[type="number"]::-webkit-inner-spin-button,
    input[type="number"]::-webkit-outer-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }

    input[type="number"] {
        -moz-appearance: textfield;
    }

    /* Checkmark Animation */
    .checkmark-circle {
        width: 150px;
        height: 150px;
        position: relative;
        display: inline-block;
    }

    .checkmark {
        width: 150px;
        height: 150px;
        border-radius: 50%;
        display: block;
        stroke-width: 3;
        stroke: #4ade80;
        stroke-miterlimit: 10;
        box-shadow: inset 0px 0px 0px #4ade80;
        animation: fill .4s ease-in-out .4s forwards, scale .3s ease-in-out .9s both;
    }

    .checkmark-circle-path {
        stroke-dasharray: 166;
        stroke-dashoffset: 166;
        stroke-width: 3;
        stroke-miterlimit: 10;
        stroke: #4ade80;
        animation: stroke 0.6s cubic-bezier(0.65, 0, 0.45, 1) forwards;
    }

    .checkmark-check {
        transform-origin: 50% 50%;
        stroke-dasharray: 48;
        stroke-dashoffset: 48;
        stroke: #fff;
        animation: stroke 0.3s cubic-bezier(0.65, 0, 0.45, 1) 0.8s forwards;
    }

    @keyframes stroke {
        100% {
            stroke-dashoffset: 0;
        }
    }

    @keyframes scale {
        0%, 100% {
            transform: none;
        }
        50% {
            transform: scale3d(1.1, 1.1, 1);
        }
    }

    @keyframes fill {
        100% {
            box-shadow: inset 0px 0px 0px 75px #4ade80;
        }
    }
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        'use strict';

        const pricePerUnit = {{ number_format($item->harga_sewa, 0, '.', '') }};
        const maxStock = {{ $item->stok }};
        
        // Helper to safely get element
        const getEl = (id) => document.getElementById(id);

        // Get all element references first
        const deliveryCards = document.querySelectorAll('.delivery-method-card');
        const deliveryMethodInput = getEl('delivery-method-input');
        const antarForm = getEl('antar-form');
        const jemputForm = getEl('jemput-form');
        const qtyDisplay = getEl('quantity-display');
        const hiddenQty = getEl('hidden-quantity');
        const decreaseBtn = getEl('decrease-qty');
        const increaseBtn = getEl('increase-qty');
        const qtyDisplayJemput = getEl('quantity-display-jemput');
        const decreaseBtnJemput = getEl('decrease-qty-jemput');
        const increaseBtnJemput = getEl('increase-qty-jemput');
        const startDate = getEl('start-date');
        const endDate = getEl('end-date');
        const daysCount = getEl('days-count');
        const startDateJemput = getEl('start-date-jemput');
        const endDateJemput = getEl('end-date-jemput');
        const daysCountJemput = getEl('days-count-jemput');

        // Define update functions FIRST before using them
        function updateTotals() {
            if (!qtyDisplay) return;
            const qty = parseInt(qtyDisplay.value) || 1;
            const subtotal = pricePerUnit * qty;
            const total = subtotal;
            
            const subtotalEl = getEl('subtotal');
            const totalTransferEl = getEl('total-amount-transfer');
            const totalCashEl = getEl('total-amount-cash');

            if (subtotalEl) subtotalEl.textContent = 'Rp. ' + subtotal.toLocaleString('id-ID');
            if (totalTransferEl) totalTransferEl.textContent = 'Rp. ' + total.toLocaleString('id-ID');
            if (totalCashEl) totalCashEl.textContent = 'Rp. ' + total.toLocaleString('id-ID');
        }

        function updateTotalsJemput() {
            if (!qtyDisplayJemput) return;
            const qty = parseInt(qtyDisplayJemput.value) || 1;
            const subtotal = pricePerUnit * qty;
            const total = subtotal;
            
            const subtotalEl = getEl('subtotal-jemput');
            const totalTransferEl = getEl('total-amount-transfer-jemput');
            const totalCashEl = getEl('total-amount-cash-jemput');

            if (subtotalEl) subtotalEl.textContent = 'Rp. ' + subtotal.toLocaleString('id-ID');
            if (totalTransferEl) totalTransferEl.textContent = 'Rp. ' + total.toLocaleString('id-ID');
            if (totalCashEl) totalCashEl.textContent = 'Rp. ' + total.toLocaleString('id-ID');
        }

        function calculateDays() {
            if (startDate && endDate && daysCount && startDate.value && endDate.value) {
                const start = new Date(startDate.value);
                const end = new Date(endDate.value);
                const diffTime = Math.abs(end - start);
                const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24)) + 1;
                daysCount.textContent = diffDays;
                updateTotals();
            }
        }

        function calculateDaysJemput() {
            if (startDateJemput && endDateJemput && daysCountJemput && startDateJemput.value && endDateJemput.value) {
                const start = new Date(startDateJemput.value);
                const end = new Date(endDateJemput.value);
                const diffTime = Math.abs(end - start);
                const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24)) + 1;
                daysCountJemput.textContent = diffDays;
                updateTotalsJemput();
            }
        }

        // NOW set up event listeners using the functions defined above
        // Delivery Method Toggle
        deliveryCards.forEach(card => {
            card.addEventListener('click', function() {
                const method = this.dataset.method;
                
                deliveryCards.forEach(c => c.classList.remove('active'));
                this.classList.add('active');
                
                deliveryMethodInput.value = method;
                
                if (method === 'antar') {
                    antarForm.classList.remove('hidden');
                    jemputForm.classList.add('hidden');
                    updateTotals();
                } else {
                    antarForm.classList.add('hidden');
                    jemputForm.classList.remove('hidden');
                    updateTotalsJemput();
                }
            });
        });

        // Quantity Controls for Antar
        if (qtyDisplay && hiddenQty && decreaseBtn && increaseBtn) {
            decreaseBtn.addEventListener('click', () => {
                let val = parseInt(qtyDisplay.value);
                if (val > 1) {
                    qtyDisplay.value = val - 1;
                    hiddenQty.value = val - 1;
                    updateTotals();
                }
            });

            increaseBtn.addEventListener('click', () => {
                let val = parseInt(qtyDisplay.value);
                if (val < maxStock) {
                    qtyDisplay.value = val + 1;
                    hiddenQty.value = val + 1;
                    updateTotals();
                }
            });

            qtyDisplay.addEventListener('change', () => {
                let val = parseInt(qtyDisplay.value) || 1;
                if (val < 1) val = 1;
                if (val > maxStock) val = maxStock;
                qtyDisplay.value = val;
                hiddenQty.value = val;
                updateTotals();
            });
        }

        // Quantity Controls for Jemput
        if (qtyDisplayJemput && decreaseBtnJemput && increaseBtnJemput) {
            decreaseBtnJemput.addEventListener('click', () => {
                let val = parseInt(qtyDisplayJemput.value);
                if (val > 1) {
                    qtyDisplayJemput.value = val - 1;
                    if (hiddenQty) hiddenQty.value = val - 1;
                    updateTotalsJemput();
                }
            });

            increaseBtnJemput.addEventListener('click', () => {
                let val = parseInt(qtyDisplayJemput.value);
                if (val < maxStock) {
                    qtyDisplayJemput.value = val + 1;
                    if (hiddenQty) hiddenQty.value = val + 1;
                    updateTotalsJemput();
                }
            });

            qtyDisplayJemput.addEventListener('change', () => {
                let val = parseInt(qtyDisplayJemput.value) || 1;
                if (val < 1) val = 1;
                if (val > maxStock) val = maxStock;
                qtyDisplayJemput.value = val;
                if (hiddenQty) hiddenQty.value = val;
                updateTotalsJemput();
            });
        }

        // Date Calculation for Antar
        if (startDate && endDate) {
            startDate.addEventListener('change', calculateDays);
            endDate.addEventListener('change', calculateDays);
        }

        // Date Calculation for Jemput
        if (startDateJemput && endDateJemput) {
            startDateJemput.addEventListener('change', calculateDaysJemput);
            endDateJemput.addEventListener('change', calculateDaysJemput);
        }

        // Payment Method Toggle for Antar
        const paymentBtns = document.querySelectorAll('.payment-method-btn');
        const paymentMethodHidden = getEl('payment-method-hidden');
        const transferPayment = getEl('transfer-payment');
        const cashPayment = getEl('cash-payment');

        paymentBtns.forEach(btn => {
            btn.addEventListener('click', function() {
                const method = this.dataset.method;
                
                paymentBtns.forEach(b => b.classList.remove('active'));
                this.classList.add('active');
                
                paymentMethodHidden.value = method;
                
                if (method === 'transfer') {
                    if (transferPayment) transferPayment.classList.remove('hidden');
                    if (cashPayment) cashPayment.classList.add('hidden');
                } else {
                    if (transferPayment) transferPayment.classList.add('hidden');
                    if (cashPayment) cashPayment.classList.remove('hidden');
                }
            });
        });

        // Payment Method Toggle for Jemput
        const paymentBtnsJemput = document.querySelectorAll('.payment-method-btn-jemput');
        const paymentMethodHiddenJemput = getEl('payment-method-jemput-hidden');
        const transferPaymentJemput = getEl('transfer-payment-jemput');
        const cashPaymentJemput = getEl('cash-payment-jemput');

        paymentBtnsJemput.forEach(btn => {
            btn.addEventListener('click', function() {
                const method = this.dataset.method;
                
                paymentBtnsJemput.forEach(b => b.classList.remove('active'));
                this.classList.add('active');
                
                paymentMethodHiddenJemput.value = method;
                
                if (method === 'transfer') {
                    if (transferPaymentJemput) transferPaymentJemput.classList.remove('hidden');
                    if (cashPaymentJemput) cashPaymentJemput.classList.add('hidden');
                } else {
                    if (transferPaymentJemput) transferPaymentJemput.classList.add('hidden');
                    if (cashPaymentJemput) cashPaymentJemput.classList.remove('hidden');
                }
            });
        });

        // File Upload Preview
        const paymentProof = getEl('payment-proof');
        const fileName = getEl('file-name');

        if (paymentProof && fileName) {
            paymentProof.addEventListener('change', function() {
                if (this.files && this.files[0]) {
                    fileName.textContent = this.files[0].name;
                    fileName.classList.remove('italic');
                }
            });
        }

        const paymentProofJemput = getEl('payment-proof-jemput');
        const fileNameJemput = getEl('file-name-jemput');

        if (paymentProofJemput && fileNameJemput) {
            paymentProofJemput.addEventListener('change', function() {
                if (this.files && this.files[0]) {
                    fileNameJemput.textContent = this.files[0].name;
                    fileNameJemput.classList.remove('italic');
                }
            });
        }


        // Google Maps Location Sharing
        const shareLocationBtn = getEl('share-location-btn');
        const latitudeInput = getEl('latitude-input');
        const longitudeInput = getEl('longitude-input');

        if (shareLocationBtn && latitudeInput && longitudeInput) {
            shareLocationBtn.addEventListener('click', function() {
                if (navigator.geolocation) {
                    navigator.geolocation.getCurrentPosition(
                        (position) => {
                            latitudeInput.value = position.coords.latitude;
                            longitudeInput.value = position.coords.longitude;
                            Swal.fire({
                                icon: 'success',
                                title: 'Lokasi Terkirim',
                                text: 'Lokasi berhasil dibagikan!',
                                confirmButtonColor: '#3085d6',
                            });
                        },
                        (error) => {
                            Swal.fire({
                                icon: 'error',
                                title: 'Gagal',
                                text: 'Gagal mendapatkan lokasi. Pastikan GPS aktif.',
                                confirmButtonColor: '#3085d6',
                            });
                        }
                    );
                } else {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Tidak Didukung',
                        text: 'Browser tidak mendukung geolocation.',
                        confirmButtonColor: '#3085d6',
                    });
                }
            });
        }

        // Smooth scroll to top
        window.scrollTo({ top: 0, behavior: 'smooth' });

        // Initialize totals on load
        updateTotals();
        updateTotalsJemput();

        // ============================================
        // BOOKING CONFIRMATION SYSTEM
        // ============================================
        
        const confirmationModal = document.getElementById('confirmation-modal');
        const successModal = document.getElementById('success-modal');
        const confirmBookingBtns = document.querySelectorAll('.confirm-action-btn');
        const cancelConfirmation = document.getElementById('cancel-confirmation');
        const proceedConfirmation = document.getElementById('proceed-confirmation');
        const closeSuccessModal = document.getElementById('close-success-modal');
        const viewReceiptBtn = document.getElementById('view-receipt-btn');
        const downloadReceiptBtn = document.getElementById('download-receipt-btn');
        const viewActivityBtn = document.getElementById('view-activity-btn');
        const bookingForm = getEl('booking-form');

        let receiptId = null;

        // Show confirmation modal on button click
        if (confirmBookingBtns.length > 0) {
            confirmBookingBtns.forEach(btn => {
                btn.addEventListener('click', function(e) {
                    e.preventDefault();
                    // Validate required fields
                    const deliveryMethod = deliveryMethodInput ? deliveryMethodInput.value : 'antar';
                    let isValid = true;
                    let errorMessage = '';

                    if (deliveryMethod === 'antar') {
                        const recipientName = getEl('recipient-name')?.value;
                        const deliveryAddress = getEl('delivery-address')?.value;
                        const startDateVal = startDate?.value;
                        const endDateVal = endDate?.value;

                        if (!recipientName || !deliveryAddress || !startDateVal || !endDateVal) {
                            isValid = false;
                            errorMessage = 'Mohon lengkapi semua field yang wajib diisi (Nama Penerima, Alamat Pengiriman, Tanggal Mulai, Tanggal Selesai)';
                        }
                    } else {
                        const startDateVal = startDateJemput?.value;
                        const endDateVal = endDateJemput?.value;

                        if (!startDateVal || !endDateVal) {
                            isValid = false;
                            errorMessage = 'Mohon lengkapi Tanggal Mulai dan Tanggal Selesai';
                        }
                    }

                    if (!isValid) {
                        Swal.fire({
                            icon: 'warning',
                            title: 'Data Belum Lengkap',
                            text: errorMessage,
                            confirmButtonColor: '#3085d6',
                        });
                        return;
                    }

                    // Show confirmation modal
                    confirmationModal.style.display = 'flex';
                    confirmationModal.classList.remove('hidden');
                });
            });
        }

        // Cancel confirmation
        if (cancelConfirmation) {
            cancelConfirmation.addEventListener('click', function() {
                confirmationModal.style.display = 'none';
                confirmationModal.classList.add('hidden');
            });
        }

        // Proceed with booking
        if (proceedConfirmation) {
            proceedConfirmation.addEventListener('click', function() {
                // Hide confirmation modal
                confirmationModal.style.display = 'none';
                confirmationModal.classList.add('hidden');

                // Copy jemput data to main form if jemput method is selected
                const deliveryMethod = deliveryMethodInput ? deliveryMethodInput.value : 'antar';
                if (deliveryMethod === 'jemput') {
                    // Copy dates
                    if (startDateJemput && startDate) startDate.value = startDateJemput.value;
                    if (endDateJemput && endDate) endDate.value = endDateJemput.value;
                    
                    // Copy payment proof file if exists
                    const paymentProofJemput = getEl('payment-proof-jemput');
                    if (paymentProofJemput?.files[0] && paymentProof) {
                        const dataTransfer = new DataTransfer();
                        dataTransfer.items.add(paymentProofJemput.files[0]);
                        paymentProof.files = dataTransfer.files;
                    }
                }

                // Submit form via AJAX
                const formData = new FormData(bookingForm);

                fetch('{{ route("rental.booking.store") }}', {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json'
                    }
                })
                .then(response => {
                    // Handle 401 Unauthorized - trigger login modal
                    if (response.status === 401) {
                        return response.json().then(data => {
                            // Open login modal using the existing modal system
                            const overlay = document.getElementById('auth-modal-overlay');
                            const modalLogin = document.getElementById('modal-login');
                            
                            if (overlay && modalLogin) {
                                document.querySelectorAll('.modal-content').forEach(m => {
                                    m.classList.add('hidden');
                                    m.classList.remove('scale-100', 'opacity-100');
                                });

                                overlay.classList.remove('hidden');
                                setTimeout(() => {
                                    overlay.classList.add('show');
                                    modalLogin.classList.remove('hidden');
                                    setTimeout(() => {
                                        modalLogin.classList.add('scale-100', 'opacity-100');
                                    }, 50);
                                }, 10);
                            }
                            
                            throw new Error(data.message || 'Anda harus login terlebih dahulu');
                        });
                    }
                    return response.json();
                })
                .then(data => {
                    if (data.success) {
                        receiptId = data.receipt_id;
                        
                        successModal.style.display = 'flex';
                        successModal.classList.remove('hidden');
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal',
                            text: data.message || 'Terjadi kesalahan saat memproses pesanan',
                            confirmButtonColor: '#d33',
                        });
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    Swal.fire({
                        icon: 'error',
                        title: 'Terjadi Kesalahan',
                        text: 'Terjadi kesalahan sistem saat memproses pesanan',
                        confirmButtonColor: '#d33',
                    });
                });
            });
        }


        // View receipt
        if (viewReceiptBtn) {
            viewReceiptBtn.addEventListener('click', function() {
                if (receiptId) {
                    window.open(`/receipt/rental/${receiptId}/view`, '_blank');
                }
            });
        }

        // Download receipt
        if (downloadReceiptBtn) {
            downloadReceiptBtn.addEventListener('click', function() {
                if (receiptId) {
                    window.location.href = `/receipt/rental/${receiptId}/download`;
                }
            });
        }

        // View activity
        if (viewActivityBtn) {
            viewActivityBtn.addEventListener('click', function() {
                window.location.href = '{{ route("user.activity") }}';
            });
        }

    });
</script>

@endpush
