@extends('layouts.app')

@section('content')
    {{-- USER NAVBAR --}}
    @include('partials.navbar')

    <main class="flex-grow relative w-full">
        @yield('page')
    </main>

    {{-- USER FOOTER --}}
    @include('partials.footer')

    {{-- AUTH MODALS --}}
    @include('auth.modals')

@endsection

@push('scripts')
    @include('auth.scripts')
@endpush