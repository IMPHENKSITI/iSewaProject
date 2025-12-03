@extends('layouts.user')

@section('page')
<section class="relative z-10 min-h-screen pt-32 pb-16">
    {{-- Background Decorations --}}
    <div class="absolute top-0 right-0 w-96 h-96 pointer-events-none overflow-hidden">
        <div class="absolute top-0 right-0 w-full h-full bg-gradient-to-bl from-blue-200/40 via-blue-300/30 to-transparent"
            style="clip-path: polygon(100% 0, 100% 100%, 40% 100%, 0 0);"></div>
    </div>

    <div class="absolute bottom-0 left-0 w-96 h-64 pointer-events-none">
        <div class="absolute bottom-0 left-0 w-full h-full bg-gradient-to-tr from-blue-300/30 via-yellow-200/20 to-transparent rounded-tr-full"></div>
    </div>

    <div class="max-w-7xl mx-auto px-6">
        {{-- Header --}}
        <div class="text-center mb-12">
            <h1 class="text-4xl font-bold bg-gradient-to-r from-[#115789] to-blue-300 bg-clip-text text-transparent relative inline-block drop-shadow-[0_0_15px_rgba(59,130,246,0.5)]">
                Profil Saya
            </h1>
        </div>

        {{-- Success Alert --}}
        @if(session('success'))
        <div id="success-alert" class="max-w-4xl mx-auto mb-6 bg-green-50 border border-green-200 text-green-800 px-6 py-4 rounded-xl transition-opacity duration-300">
            <div class="flex items-center gap-3">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                </svg>
                <span class="font-medium">{{ session('success') }}</span>
            </div>
        </div>
        @endif

        {{-- Profile Card --}}
        <div class="max-w-4xl mx-auto">
            <div class="backdrop-blur-sm bg-white/80 rounded-3xl p-8 md:p-12 border border-white/70 shadow-xl">
                <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                        {{-- LEFT: Avatar Section --}}
                        <div class="flex flex-col items-center">
                            <div class="relative group">
                                <div class="w-48 h-48 rounded-full overflow-hidden border-4 border-white shadow-lg bg-gradient-to-br from-blue-400 to-blue-600">
                                    @if($user->file)
                                        <img id="avatar-preview" src="{{ $user->file->file_stream }}" alt="Avatar" class="w-full h-full object-cover">
                                    @else
                                        <img id="avatar-preview" src="" alt="Avatar" class="w-full h-full object-cover hidden">
                                        <div id="avatar-placeholder" class="w-full h-full flex items-center justify-center text-white text-6xl font-bold">
                                            {{ strtoupper(substr($user->name, 0, 1)) }}
                                        </div>
                                    @endif
                                </div>

                                {{-- Upload Overlay --}}
                                <div class="absolute inset-0 bg-black/50 rounded-full opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-center justify-center cursor-pointer">
                                    <svg class="w-12 h-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    </svg>
                                </div>

                                <input type="file" id="profile-input" name="profile" accept="image/jpeg,image/jpg,image/png" class="hidden">
                            </div>

                            <button type="button" onclick="document.getElementById('profile-input').click()" class="mt-6 px-6 py-2.5 bg-blue-500 text-white rounded-full font-medium hover:bg-blue-600 transition">
                                Unggah Foto
                            </button>

                            <p class="mt-3 text-sm text-gray-500 text-center">
                                JPG, PNG (Max 2MB)
                            </p>

                            @error('profile')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- RIGHT: Form Fields --}}
                        <div class="md:col-span-2 space-y-6">
                            {{-- Username (disabled) --}}
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Username</label>
                                <input type="text" value="{{ $user->username }}" disabled class="w-full px-4 py-3 bg-gray-100 border border-gray-300 rounded-lg text-gray-600 cursor-not-allowed">
                            </div>

                            {{-- Nama Lengkap --}}
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Nama Lengkap</label>
                                <input type="text" name="name" value="{{ old('name', $user->name) }}" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:border-blue-500 focus:ring-2 focus:ring-blue-200 outline-none transition">
                                @error('name')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Email (disabled) --}}
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Email</label>
                                <input type="email" value="{{ $user->email }}" disabled class="w-full px-4 py-3 bg-gray-100 border border-gray-300 rounded-lg text-gray-600 cursor-not-allowed">
                            </div>

                            {{-- No Telepon --}}
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">No Telepon</label>
                                <input type="tel" name="phone" value="{{ old('phone', $user->phone) }}" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:border-blue-500 focus:ring-2 focus:ring-blue-200 outline-none transition">
                                @error('phone')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Jenis Kelamin --}}
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Jenis Kelamin</label>
                                <select name="gender" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:border-blue-500 focus:ring-2 focus:ring-blue-200 outline-none transition">
                                    <option value="">Pilih Jenis Kelamin</option>
                                    <option value="laki-laki" {{ old('gender', $user->gender) == 'laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                                    <option value="perempuan" {{ old('gender', $user->gender) == 'perempuan' ? 'selected' : '' }}>Perempuan</option>
                                </select>
                            </div>

                            {{-- Alamat --}}
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Alamat</label>
                                <textarea name="address" rows="3" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:border-blue-500 focus:ring-2 focus:ring-blue-200 outline-none transition resize-none">{{ old('address', $user->address) }}</textarea>
                                @error('address')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Kata Sandi --}}
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Kata Sandi</label>
                                <div class="flex items-center gap-3">
                                    <input type="password" value="••••••••" disabled class="flex-1 px-4 py-3 bg-gray-100 border border-gray-300 rounded-lg text-gray-600 cursor-not-allowed">
                                    <button type="button" id="btn-open-change-password" class="px-6 py-3 bg-blue-500 text-white rounded-lg font-medium hover:bg-blue-600 transition whitespace-nowrap">
                                        Ubah Sandi
                                    </button>
                                </div>
                            </div>

                            {{-- Action Buttons --}}
                            <div class="flex flex-col sm:flex-row gap-3 pt-4">
                                <button type="submit" class="flex-1 py-3 bg-blue-500 text-white rounded-full font-semibold hover:bg-blue-600 transition">
                                    Simpan
                                </button>
                                <form action="{{ route('auth.logout') }}" method="POST" class="flex-1">
                                    @csrf
                                    <button type="submit" class="w-full py-3 bg-red-500 text-white rounded-full font-semibold hover:bg-red-600 transition">
                                        Keluar
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

{{-- ✅ INCLUDE MODALS & SCRIPTS DARI AUTH --}}
@include('auth.profile-modals')
@endsection

@push('scripts')
@include('auth.profile-scripts')
@endpush

@push('styles')
<style>
    * {
        font-family: 'Inter', sans-serif;
    }
</style>
@endpush