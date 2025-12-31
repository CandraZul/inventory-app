@extends('borrowing.layouts.app')

@section('title', 'Surat Saya')
@section('page-title', 'Surat Saya')

@section('content')

<div class="card">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
        <div>
            <h3 style="margin: 0; display: flex; align-items: center; gap: 10px; font-size: 1.3rem;">
                <i class="fas fa-file-contract" style="color: #3b82f6;"></i>
                Daftar Surat Peminjaman
            </h3>
            <p style="margin: 5px 0 0 0; color: #64748b; font-size: 13px;">
                Riwayat surat yang sudah Anda upload
            </p>
        </div>
        <a href="{{ route('borrowing.surat.upload') }}" class="btn btn-primary" style="padding: 10px 20px; font-size: 14px;">
            <i class="fas fa-plus"></i> Upload Surat Baru
        </a>
    </div>
    
    @if(session('success'))
    <div class="alert alert-success">
        <i class="fas fa-check-circle"></i> {{ session('success') }}
    </div>
    @endif
    
    @if(session('error'))
    <div class="alert alert-error">
        <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
    </div>
    @endif
    
    @if($suratList->count() > 0)
    <div style="overflow-x: auto;">
        <table style="width: 100%; border-collapse: collapse;">
            <thead>
                <tr style="background: #f8fafc; border-bottom: 2px solid #e5e7eb;">
                    <th style="padding: 12px; text-align: left;">No</th>
                    <th style="padding: 12px; text-align: left;">Tanggal Upload</th>
                    <th style="padding: 12px; text-align: left;">Nama Pemohon</th>
                    <th style="padding: 12px; text-align: left;">Periode</th>
                    <th style="padding: 12px; text-align: left;">Keperluan</th>
                    <th style="padding: 12px; text-align: left;">File Surat</th>
                </tr>
            </thead>
            <tbody>
                @foreach($suratList as $surat)
                <tr style="border-bottom: 1px solid #e5e7eb; transition: background 0.2s;">
                    <td style="padding: 15px; vertical-align: top;">
                        {{ ($suratList->currentPage() - 1) * $suratList->perPage() + $loop->iteration }}
                    </td>
                    <td style="padding: 15px; vertical-align: top;">
                        <div style="font-weight: 500; font-size: 14px;">
                            {{ \Carbon\Carbon::parse($surat->created_at)->format('d/m/Y') }}
                        </div>
                        <div style="font-size: 13px; color: #64748b;">
                            {{ \Carbon\Carbon::parse($surat->created_at)->format('H:i') }}
                        </div>
                    </td>
                    <td style="padding: 15px; vertical-align: top;">
                        <div style="font-weight: 500; font-size: 14px;">{{ $surat->nama_pemohon }}</div>
                        <div style="font-size: 13px; color: #64748b;">
                            <i class="fas fa-phone" style="margin-right: 4px;"></i> {{ $surat->no_hp }}
                        </div>
                    </td>
                    <td style="padding: 15px; vertical-align: top;">
                        <div style="font-weight: 500; font-size: 14px;">
                            {{ \Carbon\Carbon::parse($surat->tanggal_mulai)->format('d/m/Y') }}
                        </div>
                        <div style="font-size: 13px; color: #64748b;">
                            s/d {{ \Carbon\Carbon::parse($surat->tanggal_selesai)->format('d/m/Y') }}
                        </div>
                    </td>
                    <td style="padding: 15px; vertical-align: top;">
                        <div style="font-weight: 500; font-size: 14px;">
                            {{ $surat->keperluan ?? '-' }}
                        </div>
                    </td>
                    <td style="padding: 15px; vertical-align: top;">
                        <a href="{{ Storage::url($surat->surat_path) }}" target="_blank" 
                           class="btn btn-sm" style="background: #3b82f6; color: white; text-decoration: none; padding: 6px 12px; border-radius: 6px; font-size: 13px;">
                            <i class="fas fa-eye"></i> Lihat Surat
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        
        <!-- Pagination -->
        @if($suratList->hasPages())
        <div style="margin-top: 20px; display: flex; justify-content: center;">
            {{ $suratList->links() }}
        </div>
        @endif
    </div>
    @else
    <div style="text-align: center; padding: 40px 20px;">
        <div style="width: 70px; height: 70px; background: #f1f5f9; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 20px;">
            <i class="fas fa-file-alt" style="font-size: 35px; color: #94a3b8;"></i>
        </div>
        <h3 style="margin: 0 0 10px 0; color: #64748b; font-size: 1.2rem;">Belum Ada Surat</h3>
        <p style="color: #94a3b8; max-width: 400px; margin: 0 auto 25px; font-size: 14px;">
            Anda belum pernah mengupload surat peminjaman. Upload surat untuk peminjaman jangka panjang atau membawa barang keluar kampus.
        </p>
        <div style="display: flex; gap: 10px; justify-content: center;">
            <a href="{{ route('borrowing.surat.upload') }}" class="btn btn-primary" style="padding: 10px 20px;">
                <i class="fas fa-upload"></i> Upload Surat
            </a>
            <a href="{{ route('borrowing.surat.template') }}" class="btn" style="background: #f1f5f9; color: #475569; padding: 10px 20px;">
                <i class="fas fa-download"></i> Download Template
            </a>
        </div>
    </div>
    @endif
</div>

@endsection