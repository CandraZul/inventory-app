@extends('borrowing.layouts.app')

@section('title', 'Surat Saya')
@section('page-title', 'Surat Saya')

@section('content')

<div class="card">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px;">
        <div>
            <h3 style="margin: 0; display: flex; align-items: center; gap: 10px;">
                <i class="fas fa-file-contract" style="color: #3b82f6;"></i>
                Daftar Surat Peminjaman
            </h3>
            <p style="margin: 5px 0 0 0; color: #64748b; font-size: 14px;">
                Riwayat surat yang sudah Anda upload
            </p>
        </div>
        <a href="{{ route('borrowing.surat.upload') }}" class="btn btn-primary">
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
                    <th style="padding: 12px; text-align: left;">Status</th>
                    <th style="padding: 12px; text-align: left;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($suratList as $surat)
                <tr style="border-bottom: 1px solid #e5e7eb; transition: background 0.2s;">
                    <td style="padding: 15px; vertical-align: top;">
                        {{ ($suratList->currentPage() - 1) * $suratList->perPage() + $loop->iteration }}
                    </td>
                    <td style="padding: 15px; vertical-align: top;">
                        <div style="font-weight: 500;">
                            {{ \Carbon\Carbon::parse($surat->created_at)->format('d/m/Y') }}
                        </div>
                        <div style="font-size: 13px; color: #64748b;">
                            {{ \Carbon\Carbon::parse($surat->created_at)->format('H:i') }}
                        </div>
                    </td>
                    <td style="padding: 15px; vertical-align: top;">
                        <div style="font-weight: 500;">{{ $surat->nama_pemohon }}</div>
                        <div style="font-size: 13px; color: #64748b;">
                            <i class="fas fa-phone"></i> {{ $surat->no_hp }}
                        </div>
                    </td>
                    <td style="padding: 15px; vertical-align: top;">
                        <div style="font-weight: 500;">
                            {{ \Carbon\Carbon::parse($surat->tanggal_mulai)->format('d/m/Y') }}
                        </div>
                        <div style="font-size: 13px; color: #64748b;">
                            s/d {{ \Carbon\Carbon::parse($surat->tanggal_selesai)->format('d/m/Y') }}
                        </div>
                    </td>
                    <td style="padding: 15px; vertical-align: top;">
                        @if($surat->status == 'pending')
                            <span style="padding: 6px 12px; background: #fef3c7; color: #92400e; border-radius: 20px; display: inline-flex; align-items: center; gap: 5px;">
                                <i class="fas fa-clock"></i> Menunggu
                            </span>
                        @elseif($surat->status == 'approved')
                            <span style="padding: 6px 12px; background: #d1fae5; color: #065f46; border-radius: 20px; display: inline-flex; align-items: center; gap: 5px;">
                                <i class="fas fa-check"></i> Disetujui
                            </span>
                        @else
                            <span style="padding: 6px 12px; background: #fee2e2; color: #991b1b; border-radius: 20px; display: inline-flex; align-items: center; gap: 5px;">
                                <i class="fas fa-times"></i> Ditolak
                            </span>
                        @endif
                        
                        @if($surat->catatan_admin)
                            <div style="margin-top: 5px; font-size: 13px; color: #64748b;">
                                <i class="fas fa-comment"></i> {{ Str::limit($surat->catatan_admin, 50) }}
                            </div>
                        @endif
                    </td>
                    <td style="padding: 15px; vertical-align: top;">
                        <div style="display: flex; gap: 8px;">
                            <a href="{{ Storage::url($surat->surat_path) }}" target="_blank" 
                               class="btn btn-sm" style="background: #3b82f6; color: white; text-decoration: none; padding: 6px 12px; border-radius: 6px; font-size: 13px;">
                                <i class="fas fa-eye"></i> Lihat
                            </a>
                            
                            @if($surat->status == 'pending')
                            <form action="{{ route('borrowing.surat.cancel', $surat->id) }}" method="POST" style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm" 
                                        style="background: #f1f5f9; color: #64748b; padding: 6px 12px; border-radius: 6px; font-size: 13px; border: none; cursor: pointer;"
                                        onclick="return confirm('Batalkan surat ini?')">
                                    <i class="fas fa-times"></i> Batalkan
                                </button>
                            </form>
                            @endif
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        
        <!-- Pagination -->
        <div style="margin-top: 20px; display: flex; justify-content: center;">
            {{ $suratList->links() }}
        </div>
    </div>
    @else
    <div style="text-align: center; padding: 50px 20px;">
        <div style="width: 80px; height: 80px; background: #f1f5f9; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 20px;">
            <i class="fas fa-file-alt" style="font-size: 40px; color: #94a3b8;"></i>
        </div>
        <h3 style="margin: 0 0 10px 0; color: #64748b;">Belum Ada Surat</h3>
        <p style="color: #94a3b8; max-width: 400px; margin: 0 auto 25px;">
            Anda belum pernah mengupload surat peminjaman. Upload surat untuk peminjaman jangka panjang atau membawa barang keluar kampus.
        </p>
        <div style="display: flex; gap: 10px; justify-content: center;">
            <a href="{{ route('borrowing.surat.upload') }}" class="btn btn-primary">
                <i class="fas fa-upload"></i> Upload Surat
            </a>
            <a href="{{ route('borrowing.surat.template') }}" class="btn" style="background: #f1f5f9; color: #475569;">
                <i class="fas fa-download"></i> Download Template
            </a>
        </div>
    </div>
    @endif
</div>

<!-- Statistik Card -->
<div class="card" style="margin-top: 25px;">
    <h3 style="margin-bottom: 20px;">
        <i class="fas fa-chart-bar"></i> Statistik Surat
    </h3>
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(150px, 1fr)); gap: 15px;">
        <div style="text-align: center; padding: 20px; background: #fef3c7; border-radius: 10px;">
            <div style="font-size: 32px; font-weight: bold; color: #92400e;">
                {{ $suratList->where('status', 'pending')->count() }}
            </div>
            <div style="color: #92400e; margin-top: 5px;">
                <i class="fas fa-clock"></i> Menunggu
            </div>
        </div>
        
        <div style="text-align: center; padding: 20px; background: #d1fae5; border-radius: 10px;">
            <div style="font-size: 32px; font-weight: bold; color: #065f46;">
                {{ $suratList->where('status', 'approved')->count() }}
            </div>
            <div style="color: #065f46; margin-top: 5px;">
                <i class="fas fa-check"></i> Disetujui
            </div>
        </div>
        
        <div style="text-align: center; padding: 20px; background: #fee2e2; border-radius: 10px;">
            <div style="font-size: 32px; font-weight: bold; color: #991b1b;">
                {{ $suratList->where('status', 'rejected')->count() }}
            </div>
            <div style="color: #991b1b; margin-top: 5px;">
                <i class="fas fa-times"></i> Ditolak
            </div>
        </div>
        
        <div style="text-align: center; padding: 20px; background: #dbeafe; border-radius: 10px;">
            <div style="font-size: 32px; font-weight: bold; color: #1e40af;">
                {{ $suratList->total() }}
            </div>
            <div style="color: #1e40af; margin-top: 5px;">
                <i class="fas fa-file-alt"></i> Total Surat
            </div>
        </div>
    </div>
</div>

@endsection