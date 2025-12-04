@extends('layouts.user')

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

        <div class="max-w-5xl mx-auto px-6 relative z-10">
            <!-- Header with Gradient Text -->
            <div class="text-center mb-12 mt-8">
                <h1 class="text-3xl md:text-4xl font-bold mb-2">
                    <span class="text-gray-800">Metode </span>
                    <span class="bg-gradient-to-r from-[#115789] to-[#60a5fa] bg-clip-text text-transparent">Antar Jemput Alat Sewa</span>
                </h1>
            </div>

            <form id="booking-form" action="{{ route('rental.booking.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="barang_id" value="{{ $item->id }}">
                <input type="hidden" name="quantity" id="hidden-quantity" value="{{ $quantity }}">
                <input type="hidden" name="delivery_method" id="delivery-method-input" value="antar">
                <input type="hidden" name="latitude" id="latitude-input">
                <input type="hidden" name="longitude" id="longitude-input">

                <!-- Delivery Method Selection -->
                <div class="flex justify-center gap-6 mb-10">
                    <!-- Antar Card -->
                    <div class="delivery-method-card active cursor-pointer" data-method="antar">
                        <div class="bg-white rounded-2xl p-8 shadow-lg hover:shadow-xl transition-all duration-300 w-48 text-center border-4 border-transparent">
                            <!-- Placeholder for Truck Icon -->
                            <div class="mb-4 flex justify-center">
                                <img src="{{ asset('admin/img/elements/antar.png') }}" alt="Antar" class="w-20 h-20 object-contain">
                            </div>
                            <p class="font-bold text-lg text-gray-800">Antar</p>
                        </div>
                    </div>

                    <!-- Jemput Card -->
                    <div class="delivery-method-card cursor-pointer" data-method="jemput">
                        <div class="bg-white rounded-2xl p-8 shadow-lg hover:shadow-xl transition-all duration-300 w-48 text-center border-4 border-transparent">
                            <!-- Placeholder for Warehouse Icon -->
                            <div class="mb-4 flex justify-center">
                                <img src="{{ asset('admin/img/elements/jemput.png') }}" alt="Jemput" class="w-20 h-20 object-contain">
                            </div>
                            <p class="font-bold text-lg text-gray-800">Jemput</p>
                        </div>
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
                            <button type="button" 
                                    class="payment-method-btn active flex-1 px-6 py-3 bg-blue-500 text-white rounded-lg font-semibold hover:bg-blue-600 transition-colors"
                                    data-method="transfer">
                                Transfer
                            </button>
                            <button type="button" 
                                    class="payment-method-btn flex-1 px-6 py-3 bg-gray-200 text-gray-700 rounded-lg font-semibold hover:bg-gray-300 transition-colors"
                                    data-method="tunai">
                                Tunai
                            </button>
                        </div>
                        <input type="hidden" name="payment_method" id="payment-method-hidden" value="transfer">

                        <!-- Transfer Payment Card -->
                        <div id="transfer-payment" class="payment-content">
                            <div class="bg-gradient-to-br from-blue-50 to-blue-100 rounded-2xl shadow-lg p-8">
                                <h4 class="text-2xl font-bold text-center text-gray-800 mb-6">{{ $setting->bank_name ?? 'Bank Syariah Indonesia' }}</h4>
                                
                                <div class="flex items-start gap-6 mb-6">
                                    <!-- Bank Logo Placeholder -->
                                    <div class="flex-shrink-0">
                                        <div class="w-24 h-24 bg-white rounded-lg flex items-center justify-center shadow-md">
                                            <span class="text-3xl font-bold text-blue-600">BSI</span>
                                        </div>
                                    </div>
                                    
                                    <div class="flex-1">
                                        <p class="text-sm text-gray-600 mb-1">Atas Nama</p>
                                        <p class="text-lg font-bold text-gray-800 mb-4">{{ $setting->account_name ?? 'BUMDes Desa Pematang Duku Timur' }}</p>
                                        
                                        <p class="text-sm text-gray-600 mb-1">Nomor Rekening Tujuan</p>
                                        <p class="text-3xl font-bold text-gray-800 mb-2">{{ $setting->account_number ?? '1234 5678 989' }}</p>
                                    </div>
                                    
                                    <div class="text-right">
                                        <p class="text-sm text-gray-600 mb-1">Jumlah Yang Harus Dibayar</p>
                                        <p class="text-3xl font-bold text-red-600" id="total-amount-transfer">Rp. {{ number_format($item->harga_sewa * $quantity, 0, ',', '.') }}</p>
                                    </div>
                                </div>
                                
                                <div class="border-t border-blue-200 pt-6">
                                    <div class="flex items-center justify-between mb-4">
                                        <label class="text-sm font-semibold text-gray-700">Upload Bukti Pembayaran</label>
                                        <button type="button" 
                                                onclick="document.getElementById('payment-proof').click()"
                                                class="px-4 py-2 bg-white border border-blue-300 text-blue-600 rounded-lg hover:bg-blue-50 transition-colors">
                                            Pilih File
                                        </button>
                                    </div>
                                    <input type="file" 
                                           name="payment_proof" 
                                           id="payment-proof" 
                                           accept="image/*,application/pdf"
                                           class="hidden">
                                    <p id="file-name" class="text-sm text-gray-600 italic">Belum ada file dipilih</p>
                                    <a href="#" class="text-sm text-blue-600 hover:underline mt-2 inline-block">Kirim</a>
                                </div>
                            </div>
                        </div>

                        <!-- Cash Payment Card -->
                        <div id="cash-payment" class="payment-content hidden">
                            <div class="bg-gradient-to-br from-gray-50 to-gray-100 rounded-2xl shadow-lg p-8">
                                <h4 class="text-2xl font-bold text-center text-gray-800 mb-6">Silahkan Lakukan Pembayaran Ditempat</h4>
                                
                                <div class="flex items-center justify-between">
                                    <div>
                                        <p class="text-lg text-gray-700">Yani - Bendahara BUMDes</p>
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
                        <button type="submit" 
                                class="px-8 py-3 bg-blue-500 hover:bg-blue-600 text-white font-bold rounded-full shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-0.5">
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
                            <button type="button" 
                                    class="payment-method-btn-jemput flex-1 px-6 py-3 bg-gray-200 text-gray-700 rounded-lg font-semibold hover:bg-gray-300 transition-colors"
                                    data-method="transfer">
                                Transfer
                            </button>
                            <button type="button" 
                                    class="payment-method-btn-jemput active flex-1 px-6 py-3 bg-blue-500 text-white rounded-lg font-semibold hover:bg-blue-600 transition-colors"
                                    data-method="tunai">
                                Tunai
                            </button>
                        </div>

                        <!-- Transfer Payment Card for Jemput -->
                        <div id="transfer-payment-jemput" class="payment-content-jemput hidden">
                            <div class="bg-gradient-to-br from-blue-50 to-blue-100 rounded-2xl shadow-lg p-8">
                                <h4 class="text-2xl font-bold text-center text-gray-800 mb-6">{{ $setting->bank_name ?? 'Bank Syariah Indonesia' }}</h4>
                                
                                <div class="flex items-start gap-6 mb-6">
                                    <div class="flex-shrink-0">
                                        <div class="w-24 h-24 bg-white rounded-lg flex items-center justify-center shadow-md">
                                            <span class="text-3xl font-bold text-blue-600">BSI</span>
                                        </div>
                                    </div>
                                    
                                    <div class="flex-1">
                                        <p class="text-sm text-gray-600 mb-1">Atas Nama</p>
                                        <p class="text-lg font-bold text-gray-800 mb-4">{{ $setting->account_name ?? 'BUMDes Desa Pematang Duku Timur' }}</p>
                                        
                                        <p class="text-sm text-gray-600 mb-1">Nomor Rekening Tujuan</p>
                                        <p class="text-3xl font-bold text-gray-800 mb-2">{{ $setting->account_number ?? '1234 5678 989' }}</p>
                                    </div>
                                    
                                    <div class="text-right">
                                        <p class="text-sm text-gray-600 mb-1">Jumlah Yang Harus Dibayar</p>
                                        <p class="text-3xl font-bold text-red-600" id="total-amount-transfer-jemput">Rp. {{ number_format($item->harga_sewa * $quantity, 0, ',', '.') }}</p>
                                    </div>
                                </div>
                                
                                <div class="border-t border-blue-200 pt-6">
                                    <div class="flex items-center justify-between mb-4">
                                        <label class="text-sm font-semibold text-gray-700">Upload Bukti Pembayaran</label>
                                        <button type="button" 
                                                onclick="document.getElementById('payment-proof-jemput').click()"
                                                class="px-4 py-2 bg-white border border-blue-300 text-blue-600 rounded-lg hover:bg-blue-50 transition-colors">
                                            Pilih File
                                        </button>
                                    </div>
                                    <input type="file" 
                                           id="payment-proof-jemput" 
                                           accept="image/*,application/pdf"
                                           class="hidden">
                                    <p id="file-name-jemput" class="text-sm text-gray-600 italic">Belum ada file dipilih</p>
                                    <a href="#" class="text-sm text-blue-600 hover:underline mt-2 inline-block">Kirim</a>
                                </div>
                            </div>
                        </div>

                        <!-- Cash Payment Card for Jemput -->
                        <div id="cash-payment-jemput" class="payment-content-jemput">
                            <div class="bg-gradient-to-br from-gray-50 to-gray-100 rounded-2xl shadow-lg p-8">
                                <h4 class="text-2xl font-bold text-center text-gray-800 mb-6">Silahkan Lakukan Pembayaran Ditempat</h4>
                                
                                <div class="flex items-center justify-between">
                                    <div>
                                        <p class="text-lg text-gray-700">Yani - Bendahara BUMDes</p>
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
                        <button type="submit" 
                                class="px-8 py-3 bg-blue-500 hover:bg-blue-600 text-white font-bold rounded-full shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-0.5">
                            Konfirmasi
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </section>
</main>
@endsection

@push('styles')
<style>
    * {
        font-family: 'Inter', sans-serif;
    }

    /* Delivery Method Cards */
    .delivery-method-card.active > div {
        border-color: #3b82f6;
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
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
</style>
@endpush

@push('scripts')
<script>
    (function() {
        'use strict';

        const pricePerUnit = {{ $item->harga_sewa }};
        const maxStock = {{ $item->stok }};
        
        // Delivery Method Toggle
        const deliveryCards = document.querySelectorAll('.delivery-method-card');
        const deliveryMethodInput = document.getElementById('delivery-method-input');
        const antarForm = document.getElementById('antar-form');
        const jemputForm = document.getElementById('jemput-form');

        deliveryCards.forEach(card => {
            card.addEventListener('click', function() {
                const method = this.dataset.method;
                
                // Update active state
                deliveryCards.forEach(c => c.classList.remove('active'));
                this.classList.add('active');
                
                // Update hidden input
                deliveryMethodInput.value = method;
                
                // Show/hide forms
                if (method === 'antar') {
                    antarForm.classList.remove('hidden');
                    jemputForm.classList.add('hidden');
                } else {
                    antarForm.classList.add('hidden');
                    jemputForm.classList.remove('hidden');
                }
            });
        });

        // Quantity Controls for Antar
        const qtyDisplay = document.getElementById('quantity-display');
        const hiddenQty = document.getElementById('hidden-quantity');
        const decreaseBtn = document.getElementById('decrease-qty');
        const increaseBtn = document.getElementById('increase-qty');

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

        // Quantity Controls for Jemput
        const qtyDisplayJemput = document.getElementById('quantity-display-jemput');
        const decreaseBtnJemput = document.getElementById('decrease-qty-jemput');
        const increaseBtnJemput = document.getElementById('increase-qty-jemput');

        decreaseBtnJemput.addEventListener('click', () => {
            let val = parseInt(qtyDisplayJemput.value);
            if (val > 1) {
                qtyDisplayJemput.value = val - 1;
                hiddenQty.value = val - 1;
                updateTotalsJemput();
            }
        });

        increaseBtnJemput.addEventListener('click', () => {
            let val = parseInt(qtyDisplayJemput.value);
            if (val < maxStock) {
                qtyDisplayJemput.value = val + 1;
                hiddenQty.value = val + 1;
                updateTotalsJemput();
            }
        });

        qtyDisplayJemput.addEventListener('change', () => {
            let val = parseInt(qtyDisplayJemput.value) || 1;
            if (val < 1) val = 1;
            if (val > maxStock) val = maxStock;
            qtyDisplayJemput.value = val;
            hiddenQty.value = val;
            updateTotalsJemput();
        });

        // Date Calculation for Antar
        const startDate = document.getElementById('start-date');
        const endDate = document.getElementById('end-date');
        const daysCount = document.getElementById('days-count');

        function calculateDays() {
            if (startDate.value && endDate.value) {
                const start = new Date(startDate.value);
                const end = new Date(endDate.value);
                const diffTime = Math.abs(end - start);
                const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24)) + 1;
                daysCount.textContent = diffDays;
                updateTotals();
            }
        }

        startDate.addEventListener('change', calculateDays);
        endDate.addEventListener('change', calculateDays);

        // Date Calculation for Jemput
        const startDateJemput = document.getElementById('start-date-jemput');
        const endDateJemput = document.getElementById('end-date-jemput');
        const daysCountJemput = document.getElementById('days-count-jemput');

        function calculateDaysJemput() {
            if (startDateJemput.value && endDateJemput.value) {
                const start = new Date(startDateJemput.value);
                const end = new Date(endDateJemput.value);
                const diffTime = Math.abs(end - start);
                const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24)) + 1;
                daysCountJemput.textContent = diffDays;
                updateTotalsJemput();
            }
        }

        startDateJemput.addEventListener('change', calculateDaysJemput);
        endDateJemput.addEventListener('change', calculateDaysJemput);

        // Update Totals for Antar
        function updateTotals() {
            const qty = parseInt(qtyDisplay.value) || 1;
            const days = parseInt(daysCount.textContent) || 1;
            const subtotal = pricePerUnit * qty;
            const total = subtotal * days;
            
            document.getElementById('subtotal').textContent = 'Rp. ' + subtotal.toLocaleString('id-ID');
            document.getElementById('total-amount-transfer').textContent = 'Rp. ' + total.toLocaleString('id-ID');
            document.getElementById('total-amount-cash').textContent = 'Rp. ' + total.toLocaleString('id-ID');
        }

        // Update Totals for Jemput
        function updateTotalsJemput() {
            const qty = parseInt(qtyDisplayJemput.value) || 1;
            const days = parseInt(daysCountJemput.textContent) || 1;
            const subtotal = pricePerUnit * qty;
            const total = subtotal * days;
            
            document.getElementById('subtotal-jemput').textContent = 'Rp. ' + subtotal.toLocaleString('id-ID');
            document.getElementById('total-amount-transfer-jemput').textContent = 'Rp. ' + total.toLocaleString('id-ID');
            document.getElementById('total-amount-cash-jemput').textContent = 'Rp. ' + total.toLocaleString('id-ID');
        }

        // Payment Method Toggle for Antar
        const paymentBtns = document.querySelectorAll('.payment-method-btn');
        const paymentMethodHidden = document.getElementById('payment-method-hidden');
        const transferPayment = document.getElementById('transfer-payment');
        const cashPayment = document.getElementById('cash-payment');

        paymentBtns.forEach(btn => {
            btn.addEventListener('click', function() {
                const method = this.dataset.method;
                
                paymentBtns.forEach(b => b.classList.remove('active'));
                this.classList.add('active');
                
                paymentMethodHidden.value = method;
                
                if (method === 'transfer') {
                    transferPayment.classList.remove('hidden');
                    cashPayment.classList.add('hidden');
                } else {
                    transferPayment.classList.add('hidden');
                    cashPayment.classList.remove('hidden');
                }
            });
        });

        // Payment Method Toggle for Jemput
        const paymentBtnsJemput = document.querySelectorAll('.payment-method-btn-jemput');
        const transferPaymentJemput = document.getElementById('transfer-payment-jemput');
        const cashPaymentJemput = document.getElementById('cash-payment-jemput');

        paymentBtnsJemput.forEach(btn => {
            btn.addEventListener('click', function() {
                const method = this.dataset.method;
                
                paymentBtnsJemput.forEach(b => b.classList.remove('active'));
                this.classList.add('active');
                
                paymentMethodHidden.value = method;
                
                if (method === 'transfer') {
                    transferPaymentJemput.classList.remove('hidden');
                    cashPaymentJemput.classList.add('hidden');
                } else {
                    transferPaymentJemput.classList.add('hidden');
                    cashPaymentJemput.classList.remove('hidden');
                }
            });
        });

        // File Upload Preview
        const paymentProof = document.getElementById('payment-proof');
        const fileName = document.getElementById('file-name');

        paymentProof.addEventListener('change', function() {
            if (this.files && this.files[0]) {
                fileName.textContent = this.files[0].name;
                fileName.classList.remove('italic');
            }
        });

        const paymentProofJemput = document.getElementById('payment-proof-jemput');
        const fileNameJemput = document.getElementById('file-name-jemput');

        paymentProofJemput.addEventListener('change', function() {
            if (this.files && this.files[0]) {
                fileNameJemput.textContent = this.files[0].name;
                fileNameJemput.classList.remove('italic');
            }
        });

        // Google Maps Location Sharing
        const shareLocationBtn = document.getElementById('share-location-btn');
        const latitudeInput = document.getElementById('latitude-input');
        const longitudeInput = document.getElementById('longitude-input');

        shareLocationBtn.addEventListener('click', function() {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(
                    (position) => {
                        latitudeInput.value = position.coords.latitude;
                        longitudeInput.value = position.coords.longitude;
                        alert('Lokasi berhasil dibagikan!');
                    },
                    (error) => {
                        alert('Gagal mendapatkan lokasi. Pastikan GPS aktif.');
                    }
                );
            } else {
                alert('Browser tidak mendukung geolocation.');
            }
        });

        // Form Validation
        const bookingForm = document.getElementById('booking-form');
        bookingForm.addEventListener('submit', function(e) {
            const method = deliveryMethodInput.value;
            
            if (method === 'antar') {
                const recipientName = document.getElementById('recipient-name').value;
                const deliveryAddress = document.getElementById('delivery-address').value;
                const startDateVal = startDate.value;
                const endDateVal = endDate.value;
                
                if (!recipientName || !deliveryAddress || !startDateVal || !endDateVal) {
                    e.preventDefault();
                    alert('Mohon lengkapi semua data pengiriman!');
                    return false;
                }
            } else {
                const startDateVal = startDateJemput.value;
                const endDateVal = endDateJemput.value;
                
                if (!startDateVal || !endDateVal) {
                    e.preventDefault();
                    alert('Mohon pilih tanggal sewa!');
                    return false;
                }
                
                // Copy jemput dates to main form
                startDate.value = startDateVal;
                endDate.value = endDateVal;
            }
            
            const paymentMethod = paymentMethodHidden.value;
            if (paymentMethod === 'transfer') {
                const proofFile = method === 'antar' ? paymentProof.files[0] : paymentProofJemput.files[0];
                if (!proofFile) {
                    e.preventDefault();
                    alert('Mohon upload bukti pembayaran!');
                    return false;
                }
                
                // Copy file to main input if from jemput
                if (method === 'jemput' && paymentProofJemput.files[0]) {
                    const dataTransfer = new DataTransfer();
                    dataTransfer.items.add(paymentProofJemput.files[0]);
                    paymentProof.files = dataTransfer.files;
                }
            }
        });

        // Smooth scroll to top
        window.scrollTo({ top: 0, behavior: 'smooth' });

        // Initialize totals on load
        updateTotals();
        updateTotalsJemput();

        // Update totals when switching tabs
        deliveryCards.forEach(card => {
            card.addEventListener('click', function() {
                const method = this.dataset.method;
                setTimeout(() => {
                    if (method === 'jemput') {
                        updateTotalsJemput();
                    } else {
                        updateTotals();
                    }
                }, 50);
            });
        });
    })();
</script>
@endpush
