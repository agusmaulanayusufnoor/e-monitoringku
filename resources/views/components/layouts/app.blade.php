<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <style>[x-cloak] { display: none !important; }</style>

    {{-- Styles Filament --}}
    @filamentStyles

    {{-- Panggil Vite HANYA SEKALI di sini untuk CSS dan JS --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- Styles tambahan --}}
    @stack('styles')
</head>
<body class="font-sans antialiased">

    {{-- Slot utama (konten halaman) --}}
    {{ $slot }}

    {{-- Notifikasi bawaan Livewire + Filament --}}
    @livewire('notifications')

    {{-- Script Filament (sudah include Livewire & Alpine) --}}
    @filamentScripts

    {{-- Script tambahan --}}
    @stack('scripts')
</body>
</html>
