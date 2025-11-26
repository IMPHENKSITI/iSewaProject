@extends('layouts.app')

@section('content')
    {{-- USER NAVBAR --}}
    @include('partials.navbar')

    <main class="flex-grow relative w-full">
        @yield('page')
    </main>

    {{-- USER FOOTER --}}
    @include('partials.footer')
@endsection
