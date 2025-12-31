@extends('borrowing.layouts.app')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('content')

<style>
    /* Responsive grid untuk card statistik */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
        gap: 20px;
        margin-bottom: 30px;
    }
    
    /* Responsive dua kolom */
    .two-columns {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 30px;
        margin-bottom: 30px;
    }
    
    @media (max-width: 1024px) {
        .two-columns {
            grid-template-columns: 1fr;
        }
    }
    
    @media (max-width: 768px) {
        .stats-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }
    
    @media (max-width: 576px) {
        .stats-grid {
            grid-template-columns: 1fr;
        }
    }
</style>

<!-- Sapaan User -->
<div class="card" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white;">
    <h2 style="margin-bottom: 10px;">Halo, {{ auth()->user()->name }}! 👋</h2>
    <p style="opacity: 0.9;">Selamat datang di sistem peminjaman alat Lab PTIK</p>
</div>

<!-- Statistik Cards (2 kolom saja) -->
<div class="stats-grid">
    <div class="card" style="text-align: center;">
        <div style="font-size: 32px; font-weight: bold; color: #10b981; margin-bottom: 10px;">
            {{ $sedangDipinjam ?? 0 }}
        </div>
        <div style="color: #64748b;">
            <i class="fas fa-cart-arrow-down" style="color: #10b981; margin-right: 8px;"></i>
            Item Dipinjam
        </div>
        <div style="font-size: 14px; color: #94a3b8; margin-top: 5px;">
            Sedang digunakan
        </div>
    </div>
    
    <div class="card" style="text-align: center;">
        <div style="font-size: 32px; font-weight: bold; color: #f59e0b; margin-bottom: 10px;">
            {{ $pending ?? 0 }}
        </div>
        <div style="color: #64748b;">
            <i class="fas fa-clock" style="color: #f59e0b; margin-right: 8px;"></i>
            Menunggu
        </div>
        <div style="font-size: 14px; color: #94a3b8; margin-top: 5px;">
            Approval admin
        </div>
    </div>
</div>

<!-- Satu kolom penuh untuk Tutorial -->
<div class="card">
    <h3 style="margin-bottom: 20px; display: flex; align-items: center; gap: 10px;">
        <i class="fas fa-graduation-cap" style="color: #3b82f6;"></i>
        Cara Meminjam Barang
    </h3>
    
    <div style="display: flex; align-items: center; gap: 30px;">
        <div style="flex: 2;">
            <ol style="margin-left: 20px; line-height: 2.2; color: #475569; font-size: 15px;">
                <li><strong>Pilih menu "Pinjam Barang"</strong> di sidebar sebelah kiri</li>
                <li><strong>Cari dan pilih barang</strong> yang ingin dipinjam dari daftar</li>
                <li>Klik tombol <strong>"Tambah ke Keranjang"</strong></li>
                <li>Atur jumlah dan tanggal peminjaman di popup yang muncul</li>
                <li>Klik <strong>ikon keranjang</strong> di pojok kanan atas untuk review pesanan</li>
                <li>Submit permintaan peminjaman dan tunggu approval admin</li>
                <li>Setelah disetujui, <strong>upload surat peminjaman</strong> melalui menu "Surat Saya"</li>
                <li>Ambil barang di Lab PTIK sesuai jadwal yang sudah ditentukan</li>
            </ol>
        </div>
        <div style="flex: 1; text-align: center;">
            <div style="background: #f1f5f9; padding: 25px; border-radius: 12px; height: 100%; display: flex; flex-direction: column; justify-content: center;">
                <i class="fas fa-laptop-code" style="font-size: 70px; color: #3b82f6; margin-bottom: 15px;"></i>
                <p style="font-weight: 600; color: #1e293b; margin-bottom: 5px;">
                    Lab Komputer PTIK
                </p>
                <p style="color: #64748b; font-size: 14px;">
                    Universitas Sebelas Maret
                </p>
                <div style="margin-top: 20px; padding: 10px; background: #dbeafe; border-radius: 8px;">
                    <p style="font-size: 13px; color: #1e40af; margin: 0;">
                        <i class="fas fa-info-circle"></i> Buka: Senin - Sabtu, 08:00 - 18:00
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Aksi Cepat -->
<div class="card">
    <h3 style="margin-bottom: 20px; display: flex; align-items: center; gap: 10px;">
        <i class="fas fa-bolt" style="color: #10b981;"></i>
        Aksi Cepat
    </h3>
    
    <div style="display: flex; gap: 15px; flex-wrap: wrap;">
        <a href="{{ route('borrowing.pinjam') }}" class="btn btn-primary" style="padding: 12px 25px;">
            <i class="fas fa-cart-plus"></i> Mulai Pinjam
        </a>
        
        <a href="{{ route('borrowing.surat.template') }}" class="btn btn-success" style="padding: 12px 25px;">
            <i class="fas fa-download"></i> Unduh Template Surat
        </a>
        
        <a href="{{ route('borrowing.surat.upload') }}" class="btn btn-secondary" style="padding: 12px 25px;">
            <i class="fas fa-upload"></i> Upload Surat Pinjam
        </a>
        
        <a href="{{ route('borrowing.riwayat') }}" class="btn" style="background: #f1f5f9; color: #475569; padding: 12px 25px;">
            <i class="fas fa-history"></i> Lihat Riwayat
        </a>
    </div>
</div>

<!-- Info Stok -->
<div class="card" style="background: #f0f9ff; border-left: 4px solid #0ea5e9;">
    <div style="display: flex; align-items: center; gap: 15px;">
        <div style="width: 50px; height: 50px; background: #0ea5e9; border-radius: 10px; display: flex; align-items: center; justify-content: center;">
            <i class="fas fa-check-circle" style="color: white; font-size: 24px;"></i>
        </div>
        <div style="flex: 1;">
            <h4 style="margin: 0; color: #0369a1;">Semua stok dalam kondisi baik</h4>
            <p style="margin: 5px 0 0 0; color: #0c4a6e;">
                Semua barang tersedia dan siap dipinjam. Lakukan peminjaman melalui menu "Pinjam Barang" di sidebar.
            </p>
        </div>
        <div style="text-align: right;">
            <a href="{{ route('borrowing.pinjam') }}" class="btn" style="background: #0ea5e9; color: white; padding: 8px 16px; font-size: 14px;">
                <i class="fas fa-arrow-right"></i> Pinjam Sekarang
            </a>
        </div>
    </div>
</div>


@endsection