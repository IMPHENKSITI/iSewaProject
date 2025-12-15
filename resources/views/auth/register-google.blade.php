@extends('layouts.app')

@section('content')

{{-- Container that mimics the modal overlay look --}}
<div class="min-h-screen flex items-center justify-center bg-gray-50/50 backdrop-blur-sm py-12 px-4 sm:px-6 lg:px-8">
    
    {{-- Main Card (Styled like the Register Modal) --}}
    <div class="max-w-2xl w-full bg-white p-8 rounded-3xl shadow-2xl relative">
        
        {{-- Header --}}
        <div class="text-center mb-8">
            <h2 class="text-3xl font-bold text-gray-900 mb-2">Lengkapi Profil</h2>
            <div class="flex items-center justify-center gap-2 text-sm text-gray-600 mb-4">
                <img src="https://www.google.com/favicon.ico" class="w-4 h-4" alt="Google">
                <span>Melanjutkan pendaftaran dengan Google</span>
            </div>
            
            {{-- Avatar Preview --}}
            <div class="relative inline-block mb-4 group">
                <img id="avatar-preview" 
                     src="{{ isset($googleData['avatar']) ? $googleData['avatar'] : asset('assets/Logo iSewa.png') }}" 
                     class="w-24 h-24 rounded-full object-cover border-4 border-blue-50 shadow-md mx-auto" 
                     alt="Avatar">
                <label for="avatar" 
                       class="absolute bottom-0 right-0 bg-blue-600 text-white rounded-full p-2 cursor-pointer hover:bg-blue-700 transition shadow-sm transform group-hover:scale-110"
                       title="Ubah Foto">
                    <svg class="w-4 h-4 ml-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                </label>
            </div>
            <p class="text-sm text-gray-600">
                Halo, <span class="font-semibold text-blue-600">{{ $googleData['name'] }}</span>! Silakan lengkapi data diri Anda.
            </p>
        </div>

        <form class="space-y-5" action="{{ route('register.google.complete') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <input type="file" id="avatar" name="avatar" class="hidden" accept="image/*" onchange="previewAvatar(this)">

            {{-- Row 1: Username & Email --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label for="username" class="block text-xs font-semibold text-gray-500 mb-1 ml-1">Username</label>
                    <input id="username" name="username" type="text" required 
                           value="{{ old('username') }}"
                           class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-100 outline-none transition text-sm" 
                           placeholder="Username Unik">
                    @error('username')
                        <p class="mt-1 text-xs text-red-500 ml-1">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                     <label class="block text-xs font-semibold text-gray-500 mb-1 ml-1">Email (Terverifikasi)</label>
                     <div class="w-full px-4 py-3 rounded-xl border border-gray-200 bg-gray-50 text-gray-500 text-sm flex items-center justify-between cursor-not-allowed">
                        <span>{{ $googleData['email'] }}</span>
                        <svg class="w-4 h-4 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                     </div>
                </div>
            </div>

            {{-- Row 2: Name --}}
            <div>
                <label for="name" class="block text-xs font-semibold text-gray-500 mb-1 ml-1">Nama Lengkap</label>
                <input id="name" name="name" type="text" required 
                       value="{{ old('name', $googleData['name']) }}"
                       class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-100 outline-none transition text-sm" 
                       placeholder="Nama Lengkap">
                @error('name')
                    <p class="mt-1 text-xs text-red-500 ml-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Row 3: Phone & Gender --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label for="phone" class="block text-xs font-semibold text-gray-500 mb-1 ml-1">No. Handphone</label>
                    <input id="phone" name="phone" type="number" required 
                           value="{{ old('phone') }}"
                           class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-100 outline-none transition text-sm" 
                           placeholder="08xxxxxxxxxx">
                    @error('phone')
                        <p class="mt-1 text-xs text-red-500 ml-1">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-500 mb-1 ml-1">Jenis Kelamin</label>
                    <select name="gender" required
                        class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-100 outline-none transition text-sm bg-white">
                        <option value="">Pilih...</option>
                        <option value="laki-laki" {{ old('gender') == 'laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                        <option value="perempuan" {{ old('gender') == 'perempuan' ? 'selected' : '' }}>Perempuan</option>
                    </select>
                    @error('gender')
                        <p class="mt-1 text-xs text-red-500 ml-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            {{-- Row 4: Address --}}
            <div>
                <label for="address" class="block text-xs font-semibold text-gray-500 mb-1 ml-1">Alamat Lengkap</label>
                <textarea id="address" name="address" rows="3" required 
                          class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-100 outline-none transition text-sm resize-none" 
                          placeholder="Alamat lengkap domisili">{{ old('address') }}</textarea>
                @error('address')
                    <p class="mt-1 text-xs text-red-500 ml-1">{{ $message }}</p>
                @enderror
            </div>
            
            {{-- Password Info --}}
            <div class="bg-blue-50 p-4 rounded-xl border border-blue-100 flex items-start gap-3">
                <svg class="h-5 w-5 text-blue-500 mt-0.5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <div class="text-sm text-blue-800">
                    <span class="font-semibold block mb-1">Opsional: Buat Kata Sandi</span>
                    Anda tetap bisa login dengan Google, tapi password ini berguna jika ingin login manual nanti.
                </div>
            </div>

            {{-- Row 5: Password --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="relative">
                    <input id="password" name="password" type="password" 
                           class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-100 outline-none transition text-sm" 
                           placeholder="Password Baru">
                    <button type="button" class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600" onclick="togglePassword('password')">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg>
                    </button>
                </div>
                <div class="relative">
                    <input id="password_confirmation" name="password_confirmation" type="password" 
                           class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-100 outline-none transition text-sm" 
                           placeholder="Konfirmasi Password">
                     <button type="button" class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600" onclick="togglePassword('password_confirmation')">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg>
                    </button>
                </div>
            </div>

            <div class="pt-4 flex items-center gap-4">
                <a href="{{ route('beranda') }}" class="w-1/3 py-3 text-center rounded-full border-2 border-gray-200 text-gray-600 font-semibold hover:bg-gray-50 hover:border-gray-300 transition">
                    Batal
                </a>
                <button type="submit" class="w-2/3 py-3 bg-blue-600 text-white rounded-full font-bold hover:bg-blue-700 hover:shadow-lg transform hover:-translate-y-0.5 transition duration-200 flex items-center justify-center gap-2">
                    <span>Selesaikan Pendaftaran</span>
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" /></svg>
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    function togglePassword(id) {
        const input = document.getElementById(id);
        if (input.type === 'password') input.type = 'text';
        else input.type = 'password';
    }

    function previewAvatar(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('avatar-preview').src = e.target.result;
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
@endpush
@endsection
