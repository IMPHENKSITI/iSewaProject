@extends('layouts.user')

@section('page')
<main class="flex-grow relative w-full">
    <section class="relative z-10 min-h-screen pt-32 pb-16 bg-cover bg-center bg-no-repeat bg-fixed" 
             style="background-image: url('{{ asset('admin/img/elements/background1.png') }}');">
        
        <!-- White Overlay -->
        <div class="absolute inset-0 bg-white/25 pointer-events-none"></div>

        <div class="max-w-5xl mx-auto px-6 relative z-20">
            <!-- Header with Gradient Text (Centered) -->
            <div class="text-center mb-12 mt-8">
                <h1 class="text-3xl md:text-4xl font-bold bg-gradient-to-r from-[#115789] to-[#60a5fa] bg-clip-text text-transparent">
                    Aktivitas
                </h1>
            </div>

            <!-- Toggle Menu -->
            <div class="flex justify-center gap-6 mb-10">
                <!-- Penyewaan Card -->
                <div class="activity-menu-card active cursor-pointer" data-type="rental">
                    <div class="bg-white rounded-2xl p-6 shadow-lg hover:shadow-xl transition-all duration-300 w-48 text-center border-4 border-transparent">
                        <div class="mb-3 flex justify-center">
                            <img src="{{ asset('User/img/elemen/F1.png') }}" alt="Penyewaan" class="w-16 h-16 object-contain">
                        </div>
                        <p class="font-bold text-lg text-gray-800">Penyewaan</p>
                    </div>
                </div>

                <!-- Pesanan Gas Card -->
                <div class="activity-menu-card cursor-pointer" data-type="gas">
                    <div class="bg-white rounded-2xl p-6 shadow-lg hover:shadow-xl transition-all duration-300 w-48 text-center border-4 border-transparent">
                        <div class="mb-3 flex justify-center">
                            <img src="{{ asset('User/img/elemen/F2.png') }}" alt="Pesanan Gas" class="w-16 h-16 object-contain">
                        </div>
                        <p class="font-bold text-lg text-gray-800">Pesanan Gas</p>
                    </div>
                </div>
            </div>

            <!-- Rental Bookings Section -->
            <div id="rental-section" class="activity-section space-y-6">
                @forelse($rentalBookings as $booking)
                <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
                    <!-- Main Card Content -->
                    <div class="p-6">
                        <div class="flex gap-6">
                            <!-- Product Image -->
                            @if($booking->barang && $booking->barang->foto)
                            <img src="{{ asset('storage/' . $booking->barang->foto) }}" 
                                 alt="{{ $booking->barang->nama_barang }}" 
                                 class="w-32 h-32 object-cover rounded-lg flex-shrink-0"
                                 onerror="this.src='{{ asset('User/img/elemen/F1.png') }}'">
                            @else
                            <div class="w-32 h-32 bg-gray-100 rounded-lg flex items-center justify-center flex-shrink-0">
                                <img src="{{ asset('User/img/elemen/F1.png') }}" alt="Rental" class="w-16 h-16 object-contain">
                            </div>
                            @endif
                            
                            <div class="flex-1">
                                <!-- Product Name -->
                                <h3 class="text-xl font-bold text-gray-800 mb-2">{{ $booking->barang->nama_barang }}</h3>
                                
                                <!-- Date and Time -->
                                <p class="text-sm text-gray-600 mb-2">
                                    {{ \Carbon\Carbon::parse($booking->created_at)->locale('id')->isoFormat('dddd, DD MMMM YYYY HH:mm') }} WIB
                                </p>
                                
                                <!-- Total Units -->
                                <p class="text-sm text-gray-600 mb-2">Total {{ $booking->quantity }} Unit</p>
                                
                                <!-- Location -->
                                @if($setting && $setting->location_name)
                                <div class="flex items-center gap-2 mb-3">
                                    <svg class="w-4 h-4 text-red-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"/>
                                    </svg>
                                    <a href="https://www.google.com/maps?q={{ $setting->latitude }},{{ $setting->longitude }}" 
                                       target="_blank" 
                                       class="text-sm text-red-600 hover:underline">
                                        {{ $setting->location_name }}
                                    </a>
                                </div>
                                @endif
                            </div>
                            
                            <!-- Right Side: Status and Payment -->
                            <div class="text-right">
                                <!-- Status Badge -->
                                <div class="flex items-center justify-end gap-2 mb-3">
                                    <span class="text-sm font-semibold">Status Penyewaan</span>
                                    @php
                                        $statusConfig = [
                                            'completed' => ['text' => 'Selesai', 'color' => 'text-green-600', 'dot' => 'bg-green-600'],
                                            'pending' => ['text' => 'Belum Bayar', 'color' => 'text-yellow-600', 'dot' => 'bg-yellow-600'],
                                            'confirmed' => ['text' => 'Dikonfirmasi', 'color' => 'text-blue-600', 'dot' => 'bg-blue-600'],
                                            'being_prepared' => ['text' => 'Dipersiapkan', 'color' => 'text-blue-600', 'dot' => 'bg-blue-600'],
                                            'in_delivery' => ['text' => 'Dalam Pengiriman', 'color' => 'text-blue-600', 'dot' => 'bg-blue-600'],
                                            'arrived' => ['text' => 'Tiba', 'color' => 'text-green-600', 'dot' => 'bg-green-600'],
                                            'cancelled' => ['text' => 'Dibatalkan', 'color' => 'text-red-600', 'dot' => 'bg-red-600'],
                                        ];
                                        $status = $statusConfig[$booking->status] ?? ['text' => ucfirst($booking->status), 'color' => 'text-gray-600', 'dot' => 'bg-gray-600'];
                                    @endphp
                                    <div class="flex items-center gap-2">
                                        <span class="w-2 h-2 rounded-full {{ $status['dot'] }}"></span>
                                        <span class="{{ $status['color'] }} font-semibold">{{ $status['text'] }}</span>
                                    </div>
                                </div>
                                
                                <!-- Payment Method -->
                                <p class="text-sm text-gray-600 mb-2">
                                    @if($booking->payment_method == 'tunai')
                                        Pembayaran Tunai
                                    @else
                                        Transfer - {{ $setting->bank_name ?? 'Bank' }}
                                    @endif
                                </p>
                                
                                <!-- Amount -->
                                <p class="text-2xl font-bold text-red-600 mb-4">{{ $booking->formatted_total }}</p>
                                
                                <!-- View Details Button -->
                                <button type="button" 
                                        class="toggle-detail-btn px-6 py-2 border-2 border-blue-500 text-blue-500 rounded-lg font-semibold hover:bg-blue-50 transition-colors"
                                        data-target="rental-detail-{{ $booking->id }}">
                                    Lihat Selengkapnya
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Expandable Detail Section -->
                    <div id="rental-detail-{{ $booking->id }}" class="detail-section hidden border-t border-gray-200">
                        <div class="p-6 bg-gray-50">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <!-- Left Column -->
                                <div class="space-y-4">
                                    <div>
                                        <p class="text-sm text-gray-500 mb-1">No. Pesanan</p>
                                        <p class="font-semibold text-gray-800">{{ $booking->order_number ?? '-' }}</p>
                                    </div>
                                    
                                    <div>
                                        <p class="text-sm text-gray-500 mb-1">Waktu Pemesanan</p>
                                        <p class="font-semibold text-gray-800">
                                            {{ \Carbon\Carbon::parse($booking->created_at)->locale('id')->isoFormat('dddd, DD MMMM YYYY HH:mm') }} WIB
                                        </p>
                                    </div>
                                    
                                    @if($booking->delivery_time)
                                    <div>
                                        <p class="text-sm text-gray-500 mb-1">Waktu Pengiriman</p>
                                        <p class="font-semibold text-gray-800">
                                            {{ \Carbon\Carbon::parse($booking->delivery_time)->locale('id')->isoFormat('dddd, DD MMMM YYYY HH:mm') }} WIB
                                        </p>
                                    </div>
                                    @endif
                                    
                                    <div>
                                        <p class="text-sm text-gray-500 mb-1">Waktu Penyewaan</p>
                                        <p class="font-semibold text-gray-800">
                                            {{ \Carbon\Carbon::parse($booking->start_date)->locale('id')->isoFormat('dddd, DD MMMM YYYY') }}
                                        </p>
                                    </div>
                                    
                                    @if($booking->return_time)
                                    <div>
                                        <p class="text-sm text-gray-500 mb-1">Waktu Pengembalian</p>
                                        <p class="font-semibold text-gray-800">
                                            {{ \Carbon\Carbon::parse($booking->return_time)->locale('id')->isoFormat('dddd, DD MMMM YYYY HH:mm') }} WIB
                                        </p>
                                    </div>
                                    @endif
                                    
                                    @if($booking->completion_time)
                                    <div>
                                        <p class="text-sm text-gray-500 mb-1">Waktu Pemesanan Selesai</p>
                                        <p class="font-semibold text-gray-800">
                                            {{ \Carbon\Carbon::parse($booking->completion_time)->locale('id')->isoFormat('dddd, DD MMMM YYYY HH:mm') }} WIB
                                        </p>
                                    </div>
                                    @endif
                                </div>

                                <!-- Right Column -->
                                <div class="space-y-4">
                                    <!-- Transaction Receipt -->
                                    <div>
                                        <p class="text-sm text-gray-500 mb-2">Bukti Transaksi</p>
                                        <div class="flex gap-2">
                                            @if($booking->payment_proof)
                                            <a href="{{ asset('storage/' . $booking->payment_proof) }}" 
                                               target="_blank"
                                               class="px-4 py-2 bg-white border border-gray-300 rounded-lg text-sm font-semibold hover:bg-gray-50 transition-colors">
                                                Lihat
                                            </a>
                                            <a href="{{ asset('storage/' . $booking->payment_proof) }}" 
                                               download
                                               class="px-4 py-2 bg-blue-500 text-white rounded-lg text-sm font-semibold hover:bg-blue-600 transition-colors">
                                                Unduh
                                            </a>
                                            @else
                                            <p class="text-gray-400 text-sm">Belum ada bukti transaksi</p>
                                            @endif
                                        </div>
                                    </div>

                                    <!-- Delivery Status Timeline -->
                                    @if($booking->status != 'pending' && $booking->status != 'cancelled')
                                    <div>
                                        <p class="text-sm text-gray-500 mb-3">Kondisi Pesanan Sewa Tiba</p>
                                        <div class="space-y-3">
                                            @php
                                                $timeline = [
                                                    ['status' => 'confirmed', 'label' => 'Pesanan dikonfirmasi', 'time' => $booking->confirmed_at],
                                                    ['status' => 'being_prepared', 'label' => 'Pesanan sedang dipersiapkan', 'time' => null],
                                                    ['status' => 'in_delivery', 'label' => 'Pesanan dalam proses pengantaran', 'time' => $booking->delivery_time],
                                                    ['status' => 'arrived', 'label' => 'Pesanan tiba di alamat tujuan', 'time' => $booking->arrival_time],
                                                ];
                                                
                                                $currentStatusIndex = array_search($booking->status, array_column($timeline, 'status'));
                                            @endphp
                                            
                                            @foreach($timeline as $index => $item)
                                            <div class="flex items-start gap-3">
                                                <div class="flex flex-col items-center">
                                                    @if($index <= $currentStatusIndex)
                                                    <div class="w-3 h-3 rounded-full bg-green-500"></div>
                                                    @else
                                                    <div class="w-3 h-3 rounded-full bg-gray-300"></div>
                                                    @endif
                                                    @if($index < count($timeline) - 1)
                                                    <div class="w-0.5 h-8 {{ $index < $currentStatusIndex ? 'bg-green-500' : 'bg-gray-300' }}"></div>
                                                    @endif
                                                </div>
                                                <div class="flex-1 {{ $index <= $currentStatusIndex ? 'text-gray-800' : 'text-gray-400' }}">
                                                    <p class="text-sm font-semibold">{{ $item['label'] }}</p>
                                                    @if($item['time'])
                                                    <p class="text-xs text-gray-500">
                                                        {{ \Carbon\Carbon::parse($item['time'])->locale('id')->isoFormat('DD MMM YYYY HH:mm') }} WIB
                                                    </p>
                                                    @endif
                                                </div>
                                            </div>
                                            @endforeach
                                        </div>
                                    </div>
                                    @endif

                                    <!-- Delivery Proof -->
                                    @if($booking->delivery_proof_image)
                                    <div>
                                        <p class="text-sm text-gray-500 mb-2">Bukti Pengiriman</p>
                                        <a href="{{ asset('storage/' . $booking->delivery_proof_image) }}" 
                                           target="_blank"
                                           class="inline-block px-4 py-2 bg-green-500 text-white rounded-lg text-sm font-semibold hover:bg-green-600 transition-colors">
                                            Lihat Bukti Pengiriman
                                        </a>
                                    </div>
                                    @endif

                                    <!-- Cancellation Request -->
                                    @if($booking->canBeCancelled())
                                    <div class="pt-4 border-t border-gray-200">
                                        <button type="button" 
                                                class="cancel-order-btn w-full px-4 py-2 bg-red-500 text-white rounded-lg text-sm font-semibold hover:bg-red-600 transition-colors"
                                                data-type="rental"
                                                data-id="{{ $booking->id }}">
                                            Batalkan Pesanan
                                        </button>
                                    </div>
                                    @elseif($booking->hasCancellationRequest())
                                    <div class="pt-4 border-t border-gray-200">
                                        <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-3">
                                            <p class="text-sm font-semibold text-yellow-800 mb-1">Permintaan Pembatalan Diajukan</p>
                                            <p class="text-xs text-yellow-700">Menunggu konfirmasi admin</p>
                                        </div>
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @empty
                <div class="bg-white rounded-2xl shadow-lg p-8 text-center">
                    <p class="text-gray-500">Belum ada riwayat penyewaan</p>
                </div>
                @endforelse
            </div>

            <!-- Gas Orders Section -->
            <div id="gas-section" class="activity-section space-y-6 hidden">
                @forelse($gasOrders as $order)
                <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
                    <!-- Main Card Content -->
                    <div class="p-6">
                        <div class="flex gap-6">
                            <!-- Product Image -->
                            @if($order->gas && $order->gas->foto)
                            <img src="{{ asset('storage/' . $order->gas->foto) }}" 
                                 alt="{{ $order->item_name }}" 
                                 class="w-32 h-32 object-cover rounded-lg flex-shrink-0"
                                 onerror="this.src='{{ asset('User/img/elemen/F2.png') }}'">
                            @else
                            <div class="w-32 h-32 bg-gray-100 rounded-lg flex items-center justify-center flex-shrink-0">
                                <img src="{{ asset('User/img/elemen/F2.png') }}" alt="Gas" class="w-16 h-16 object-contain">
                            </div>
                            @endif
                            
                            <div class="flex-1">
                                <!-- Product Name -->
                                <h3 class="text-xl font-bold text-gray-800 mb-2">{{ $order->item_name }}</h3>
                                
                                <!-- Date and Time -->
                                <p class="text-sm text-gray-600 mb-2">
                                    {{ \Carbon\Carbon::parse($order->created_at)->locale('id')->isoFormat('dddd, DD MMMM YYYY HH:mm') }} WIB
                                </p>
                                
                                <!-- Total Units -->
                                <p class="text-sm text-gray-600 mb-2">Total {{ $order->quantity }} Unit</p>
                                
                                <!-- Location -->
                                @if($setting && $setting->location_name)
                                <div class="flex items-center gap-2 mb-3">
                                    <svg class="w-4 h-4 text-red-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"/>
                                    </svg>
                                    <a href="https://www.google.com/maps?q={{ $setting->latitude }},{{ $setting->longitude }}" 
                                       target="_blank" 
                                       class="text-sm text-red-600 hover:underline">
                                        {{ $setting->location_name }}
                                    </a>
                                </div>
                                @endif
                            </div>
                            
                            <!-- Right Side: Status and Payment -->
                            <div class="text-right">
                                <!-- Status Badge -->
                                <div class="flex items-center justify-end gap-2 mb-3">
                                    <span class="text-sm font-semibold">Status Pembelian</span>
                                    @php
                                        $statusConfig = [
                                            'completed' => ['text' => 'Selesai', 'color' => 'text-green-600', 'dot' => 'bg-green-600'],
                                            'pending' => ['text' => 'Belum Bayar', 'color' => 'text-yellow-600', 'dot' => 'bg-yellow-600'],
                                            'confirmed' => ['text' => 'Dikonfirmasi', 'color' => 'text-blue-600', 'dot' => 'bg-blue-600'],
                                            'being_prepared' => ['text' => 'Dipersiapkan', 'color' => 'text-blue-600', 'dot' => 'bg-blue-600'],
                                            'in_delivery' => ['text' => 'Dalam Pengiriman', 'color' => 'text-blue-600', 'dot' => 'bg-blue-600'],
                                            'arrived' => ['text' => 'Tiba', 'color' => 'text-green-600', 'dot' => 'bg-green-600'],
                                            'cancelled' => ['text' => 'Dibatalkan', 'color' => 'text-red-600', 'dot' => 'bg-red-600'],
                                        ];
                                        $status = $statusConfig[$order->status] ?? ['text' => ucfirst($order->status), 'color' => 'text-gray-600', 'dot' => 'bg-gray-600'];
                                    @endphp
                                    <div class="flex items-center gap-2">
                                        <span class="w-2 h-2 rounded-full {{ $status['dot'] }}"></span>
                                        <span class="{{ $status['color'] }} font-semibold">{{ $status['text'] }}</span>
                                    </div>
                                </div>
                                
                                <!-- Payment Method -->
                                <p class="text-sm text-gray-600 mb-2">
                                    @if($order->payment_method == 'Tunai')
                                        Pembayaran Tunai
                                    @else
                                        Transfer - {{ $setting->bank_name ?? 'Bank' }}
                                    @endif
                                </p>
                                
                                <!-- Amount -->
                                <p class="text-2xl font-bold text-red-600 mb-4">{{ $order->formatted_total }}</p>
                                
                                <!-- View Details Button -->
                                <button type="button" 
                                        class="toggle-detail-btn px-6 py-2 border-2 border-blue-500 text-blue-500 rounded-lg font-semibold hover:bg-blue-50 transition-colors"
                                        data-target="gas-detail-{{ $order->id }}">
                                    Lihat Selengkapnya
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Expandable Detail Section -->
                    <div id="gas-detail-{{ $order->id }}" class="detail-section hidden border-t border-gray-200">
                        <div class="p-6 bg-gray-50">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <!-- Left Column -->
                                <div class="space-y-4">
                                    <div>
                                        <p class="text-sm text-gray-500 mb-1">No. Pesanan</p>
                                        <p class="font-semibold text-gray-800">{{ $order->order_number ?? '-' }}</p>
                                    </div>
                                    
                                    <div>
                                        <p class="text-sm text-gray-500 mb-1">Waktu Pemesanan</p>
                                        <p class="font-semibold text-gray-800">
                                            {{ \Carbon\Carbon::parse($order->created_at)->locale('id')->isoFormat('dddd, DD MMMM YYYY HH:mm') }} WIB
                                        </p>
                                    </div>
                                    
                                    @if($order->delivery_time)
                                    <div>
                                        <p class="text-sm text-gray-500 mb-1">Waktu Pengambilan</p>
                                        <p class="font-semibold text-gray-800">
                                            {{ \Carbon\Carbon::parse($order->delivery_time)->locale('id')->isoFormat('dddd, DD MMMM YYYY HH:mm') }} WIB
                                        </p>
                                    </div>
                                    @endif
                                    
                                    @if($order->arrival_time)
                                    <div>
                                        <p class="text-sm text-gray-500 mb-1">Waktu Pembayaran</p>
                                        <p class="font-semibold text-gray-800">
                                            {{ \Carbon\Carbon::parse($order->arrival_time)->locale('id')->isoFormat('dddd, DD MMMM YYYY HH:mm') }} WIB
                                        </p>
                                    </div>
                                    @endif
                                    
                                    @if($order->completion_time)
                                    <div>
                                        <p class="text-sm text-gray-500 mb-1">Waktu Pemesanan Selesai</p>
                                        <p class="font-semibold text-gray-800">
                                            {{ \Carbon\Carbon::parse($order->completion_time)->locale('id')->isoFormat('dddd, DD MMMM YYYY HH:mm') }} WIB
                                        </p>
                                    </div>
                                    @endif
                                </div>

                                <!-- Right Column -->
                                <div class="space-y-4">
                                    <!-- Transaction Receipt -->
                                    <div>
                                        <p class="text-sm text-gray-500 mb-2">Bukti Transaksi</p>
                                        <div class="flex gap-2">
                                            @if($order->proof_of_payment)
                                            <a href="{{ asset('storage/' . $order->proof_of_payment) }}" 
                                               target="_blank"
                                               class="px-4 py-2 bg-white border border-gray-300 rounded-lg text-sm font-semibold hover:bg-gray-50 transition-colors">
                                                Lihat
                                            </a>
                                            <a href="{{ asset('storage/' . $order->proof_of_payment) }}" 
                                               download
                                               class="px-4 py-2 bg-blue-500 text-white rounded-lg text-sm font-semibold hover:bg-blue-600 transition-colors">
                                                Unduh
                                            </a>
                                            @else
                                            <p class="text-gray-400 text-sm">Belum ada bukti transaksi</p>
                                            @endif
                                        </div>
                                    </div>

                                    <!-- Cancellation Request -->
                                    @if($order->canBeCancelled())
                                    <div class="pt-4 border-t border-gray-200">
                                        <button type="button" 
                                                class="cancel-order-btn w-full px-4 py-2 bg-red-500 text-white rounded-lg text-sm font-semibold hover:bg-red-600 transition-colors"
                                                data-type="gas"
                                                data-id="{{ $order->id }}">
                                            Batalkan Pesanan
                                        </button>
                                    </div>
                                    @elseif($order->hasCancellationRequest())
                                    <div class="pt-4 border-t border-gray-200">
                                        <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-3">
                                            <p class="text-sm font-semibold text-yellow-800 mb-1">Permintaan Pembatalan Diajukan</p>
                                            <p class="text-xs text-yellow-700">Menunggu konfirmasi admin</p>
                                        </div>
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @empty
                <div class="bg-white rounded-2xl shadow-lg p-8 text-center">
                    <p class="text-gray-500">Belum ada riwayat pembelian gas</p>
                </div>
                @endforelse
            </div>
        </div>
    </section>
</main>

<!-- Footer -->
@include('partials.footer')
@endsection

@push('styles')
<style>
    * {
        font-family: 'Inter', sans-serif;
    }

    /* Activity Menu Cards */
    .activity-menu-card.active > div {
        border-color: #3b82f6;
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
    }

    /* Detail Section Animation */
    .detail-section {
        max-height: 0;
        overflow: hidden;
        transition: max-height 0.3s ease-out;
    }

    .detail-section.show {
        max-height: 2000px;
        transition: max-height 0.5s ease-in;
    }
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    (function() {
        'use strict';

        // Activity Menu Toggle
        const menuCards = document.querySelectorAll('.activity-menu-card');
        const rentalSection = document.getElementById('rental-section');
        const gasSection = document.getElementById('gas-section');

        menuCards.forEach(card => {
            card.addEventListener('click', () => {
                const type = card.dataset.type;
                
                // Update active state
                menuCards.forEach(c => c.classList.remove('active'));
                card.classList.add('active');
                
                // Toggle sections
                if (type === 'rental') {
                    rentalSection.classList.remove('hidden');
                    gasSection.classList.add('hidden');
                } else {
                    rentalSection.classList.add('hidden');
                    gasSection.classList.remove('hidden');
                }
            });
        });

        // Toggle Detail Dropdown
        const toggleButtons = document.querySelectorAll('.toggle-detail-btn');
        
        toggleButtons.forEach(button => {
            button.addEventListener('click', () => {
                const targetId = button.dataset.target;
                const detailSection = document.getElementById(targetId);
                
                if (detailSection.classList.contains('hidden')) {
                    // Show detail
                    detailSection.classList.remove('hidden');
                    setTimeout(() => {
                        detailSection.classList.add('show');
                    }, 10);
                    button.textContent = 'Tutup';
                } else {
                    // Hide detail
                    detailSection.classList.remove('show');
                    setTimeout(() => {
                        detailSection.classList.add('hidden');
                    }, 300);
                    button.textContent = 'Lihat Selengkapnya';
                }
            });
        });

        // Cancel Order
        const cancelButtons = document.querySelectorAll('.cancel-order-btn');
        
        cancelButtons.forEach(button => {
            button.addEventListener('click', async () => {
                const type = button.dataset.type;
                const id = button.dataset.id;
                
                const { value: reason } = await Swal.fire({
                    title: 'Batalkan Pesanan',
                    html: '<p class="mb-3">Berikan alasan pembatalan pesanan:</p>',
                    input: 'textarea',
                    inputPlaceholder: 'Masukkan alasan pembatalan...',
                    inputAttributes: {
                        'aria-label': 'Alasan pembatalan',
                        'rows': 4
                    },
                    showCancelButton: true,
                    confirmButtonText: 'Kirim Permintaan',
                    cancelButtonText: 'Batal',
                    confirmButtonColor: '#ef4444',
                    cancelButtonColor: '#6b7280',
                    inputValidator: (value) => {
                        if (!value) {
                            return 'Alasan pembatalan harus diisi!';
                        }
                        if (value.length < 10) {
                            return 'Alasan minimal 10 karakter!';
                        }
                    }
                });

                if (reason) {
                    try {
                        const response = await fetch(`/aktivitas/${type}/${id}/cancel`, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                            },
                            body: JSON.stringify({ reason })
                        });

                        const data = await response.json();

                        if (data.success) {
                            await Swal.fire({
                                icon: 'success',
                                title: 'Berhasil!',
                                text: data.message,
                                confirmButtonColor: '#3b82f6'
                            });
                            location.reload();
                        } else {
                            await Swal.fire({
                                icon: 'error',
                                title: 'Gagal!',
                                text: data.message,
                                confirmButtonColor: '#ef4444'
                            });
                        }
                    } catch (error) {
                        await Swal.fire({
                            icon: 'error',
                            title: 'Error!',
                            text: 'Terjadi kesalahan. Silakan coba lagi.',
                            confirmButtonColor: '#ef4444'
                        });
                    }
                }
            });
        });
    })();
</script>
@endpush
