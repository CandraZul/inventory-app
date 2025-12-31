@extends('layouts.app')

@section('title', 'Dashboard User')
@section('subtitle', 'Sistem Peminjaman Alat Lab PTIK')

@section('content')
<div class="space-y-6">
    <!-- Sapaan User -->
    <div class="bg-gradient-to-r from-blue-600 to-purple-600 rounded-xl p-6 text-white shadow-lg">
        <h2 class="text-2xl font-bold mb-2">Halo, {{ auth()->user()->name }}! 👋</h2>
        <p class="opacity-90">Selamat datang di sistem peminjaman alat Lab PTIK</p>
    </div>

    <!-- Statistik Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <!-- Item Dipinjam -->
        <div class="bg-white rounded-xl shadow p-6 text-center">
            <div class="text-3xl font-bold text-green-500 mb-2">
                {{ $sedangDipinjam ?? 0 }}
            </div>
            <div class="text-gray-600 flex items-center justify-center">
                <i class="fas fa-cart-arrow-down text-green-500 mr-2"></i>
                Item Dipinjam
            </div>
            <div class="text-sm text-gray-400 mt-2">
                Sedang digunakan
            </div>
        </div>
        
        <!-- Menunggu Approval -->
        <div class="bg-white rounded-xl shadow p-6 text-center">
            <div class="text-3xl font-bold text-yellow-500 mb-2">
                {{ $pending ?? 0 }}
            </div>
            <div class="text-gray-600 flex items-center justify-center">
                <i class="fas fa-clock text-yellow-500 mr-2"></i>
                Menunggu
            </div>
            <div class="text-sm text-gray-400 mt-2">
                Approval admin
            </div>
        </div>
        
        <!-- Total Riwayat -->
        <div class="bg-white rounded-xl shadow p-6 text-center">
            <div class="text-3xl font-bold text-blue-500 mb-2">
                {{ $totalRiwayat ?? 0 }}
            </div>
            <div class="text-gray-600 flex items-center justify-center">
                <i class="fas fa-history text-blue-500 mr-2"></i>
                Total Pinjaman
            </div>
            <div class="text-sm text-gray-400 mt-2">
                Seluruh waktu
            </div>
        </div>
    </div>

    <!-- Tutorial Peminjaman -->
    <div class="bg-white rounded-xl shadow p-6">
        <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center gap-2">
            <i class="fas fa-graduation-cap text-blue-500"></i>
            Cara Meminjam Barang
        </h3>
        
        <div class="flex flex-col lg:flex-row gap-6">
            <!-- Langkah-langkah -->
            <div class="lg:w-2/3">
                <ol class="space-y-3 ml-4 text-gray-700">
                    <li class="flex items-start">
                        <span class="flex-shrink-0 w-6 h-6 bg-blue-100 text-blue-600 rounded-full flex items-center justify-center text-sm mr-3 mt-0.5">1</span>
                        <span><strong>Pilih menu "Pinjam Barang"</strong> di sidebar sebelah kiri</span>
                    </li>
                    <li class="flex items-start">
                        <span class="flex-shrink-0 w-6 h-6 bg-blue-100 text-blue-600 rounded-full flex items-center justify-center text-sm mr-3 mt-0.5">2</span>
                        <span><strong>Cari dan pilih barang</strong> yang ingin dipinjam dari daftar</span>
                    </li>
                    <li class="flex items-start">
                        <span class="flex-shrink-0 w-6 h-6 bg-blue-100 text-blue-600 rounded-full flex items-center justify-center text-sm mr-3 mt-0.5">3</span>
                        <span>Klik tombol <strong>"Tambah ke Keranjang"</strong></span>
                    </li>
                    <li class="flex items-start">
                        <span class="flex-shrink-0 w-6 h-6 bg-blue-100 text-blue-600 rounded-full flex items-center justify-center text-sm mr-3 mt-0.5">4</span>
                        <span>Atur jumlah dan tanggal peminjaman di popup yang muncul</span>
                    </li>
                    <li class="flex items-start">
                        <span class="flex-shrink-0 w-6 h-6 bg-blue-100 text-blue-600 rounded-full flex items-center justify-center text-sm mr-3 mt-0.5">5</span>
                        <span>Klik <strong>ikon keranjang</strong> di pojok kanan atas untuk review pesanan</span>
                    </li>
                </ol>
            </div>
            
            <!-- Info Lab -->
            <div class="lg:w-1/3">
                <div class="bg-gray-50 rounded-xl p-6 border border-gray-200">
                    <div class="text-center mb-4">
                        <i class="fas fa-laptop-code text-5xl text-blue-500 mb-3"></i>
                        <h4 class="font-semibold text-gray-800 mb-1">Lab Komputer PTIK</h4>
                        <p class="text-sm text-gray-600">Universitas Sebelas Maret</p>
                    </div>
                    <div class="bg-blue-50 rounded-lg p-4">
                        <p class="text-sm text-blue-700 flex items-center gap-2">
                            <i class="fas fa-info-circle"></i>
                            Buka: Senin - Sabtu, 08:00 - 18:00
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Aksi Cepat -->
    <div class="bg-white rounded-xl shadow p-6">
        <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center gap-2">
            <i class="fas fa-bolt text-green-500"></i>
            Aksi Cepat
        </h3>
        
        <div class="flex flex-wrap gap-3">
            <a href="{{ route('borrowing.pinjam') }}" class="inline-flex items-center gap-2 bg-blue-500 hover:bg-blue-600 text-white px-4 py-3 rounded-lg transition">
                <i class="fas fa-cart-plus"></i>
                Mulai Pinjam
            </a>
            
            <a href="{{ route('borrowing.surat.template') }}?v={{ time() }}" class="inline-flex items-center gap-2 bg-green-500 hover:bg-green-600 text-white px-4 py-3 rounded-lg transition">
                <i class="fas fa-download"></i>
                Unduh Template Surat
            </a>
            
            <a href="{{ route('borrowing.surat.upload') }}" class="inline-flex items-center gap-2 bg-gray-500 hover:bg-gray-600 text-white px-4 py-3 rounded-lg transition">
                <i class="fas fa-upload"></i>
                Upload Surat Pinjam
            </a>
            
            <a href="{{ route('borrowing.riwayat') }}" class="inline-flex items-center gap-2 bg-gray-100 hover:bg-gray-200 text-gray-700 px-4 py-3 rounded-lg transition">
                <i class="fas fa-history"></i>
                Lihat Riwayat
            </a>
        </div>
    </div>

    <!-- Info Stok -->
    <div class="bg-gradient-to-r from-sky-50 to-blue-50 border-l-4 border-blue-500 rounded-xl p-6">
        <div class="flex flex-col md:flex-row items-center gap-4">
            <div class="w-12 h-12 bg-blue-500 rounded-lg flex items-center justify-center">
                <i class="fas fa-check-circle text-white text-xl"></i>
            </div>
            <div class="flex-1">
                <h4 class="font-semibold text-blue-800">Semua stok dalam kondisi baik</h4>
                <p class="text-blue-700 mt-1">
                    Semua barang tersedia dan siap dipinjam. Lakukan peminjaman melalui menu "Pinjam Barang" di sidebar.
                </p>
            </div>
            <div>
                <a href="{{ route('borrowing.pinjam') }}" class="inline-flex items-center gap-2 bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg transition">
                    <i class="fas fa-arrow-right"></i>
                    Pinjam Sekarang
                </a>
            </div>
        </div>
    </div>
</div>

<style>
    .transition {
        transition: all 0.2s ease;
    }
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const templateLinks = document.querySelectorAll('a[href*="template"]');
    
    templateLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            let href = this.getAttribute('href');
            if (!href.includes('?v=')) {
                this.setAttribute('href', href + '?v=' + Date.now());
            }
        });
    });
});
</script>
@endsection