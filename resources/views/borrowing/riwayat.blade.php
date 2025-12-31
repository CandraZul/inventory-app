@extends('borrowing.layouts.app')

@section('title', 'Riwayat Peminjaman')
@section('page-title', 'Riwayat Peminjaman')

@section('content')

<div class="card">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
        <h3 style="margin: 0;">
            <i class="fas fa-history"></i> Riwayat Peminjaman Saya
        </h3>
        
        <!-- Filter Status -->
        <form method="GET" action="{{ route('borrowing.riwayat') }}" style="display: flex; gap: 10px;">
            <select name="status" onchange="this.form.submit()" 
                    style="padding: 8px 15px; border: 1px solid #d1d5db; border-radius: 8px; background: white;">
                <option value="">-- Semua Status --</option>
                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="dipinjam" {{ request('status') == 'dipinjam' ? 'selected' : '' }}>Dipinjam</option>
                <option value="kembali" {{ request('status') == 'kembali' ? 'selected' : '' }}>Kembali</option>
            </select>
        </form>
    </div>
    
    @if($riwayat->count() > 0)
    <div style="overflow-x: auto;">
        <table style="width: 100%; border-collapse: collapse;">
            <thead>
                <tr style="background: #f8fafc; border-bottom: 2px solid #e5e7eb;">
                    <th style="padding: 12px; text-align: left; color: #475569;">No</th>
                    <th style="padding: 12px; text-align: left; color: #475569;">Kode Peminjaman</th>
                    <th style="padding: 12px; text-align: left; color: #475569;">Tanggal Pinjam</th>
                    <th style="padding: 12px; text-align: left; color: #475569;">Barang</th>
                    <th style="padding: 12px; text-align: left; color: #475569;">Jumlah</th>
                    <th style="padding: 12px; text-align: left; color: #475569;">Status</th>
                    <th style="padding: 12px; text-align: left; color: #475569;">Tanggal Kembali</th>
                </tr>
            </thead>
            <tbody>
                @php $counter = ($riwayat->currentPage() - 1) * $riwayat->perPage() + 1; @endphp
                @foreach($riwayat as $peminjaman)
                    @foreach($peminjaman->details as $detail)
                    <tr style="border-bottom: 1px solid #e5e7eb;">
                        <td style="padding: 15px;">{{ $counter++ }}</td>
                        <td style="padding: 15px; font-family: monospace;">
                            PMJ-{{ str_pad($peminjaman->id, 4, '0', STR_PAD_LEFT) }}
                        </td>
                        <td style="padding: 15px;">
                            {{ \Carbon\Carbon::parse($peminjaman->tanggal_pinjam)->format('d/m/Y H:i') }}
                        </td>
                        <td style="padding: 15px; font-weight: 500;">
                            {{ $detail->inventory->nama_barang }}
                        </td>
                        <td style="padding: 15px;">
                            <span style="padding: 5px 10px; background: #f1f5f9; border-radius: 20px;">
                                {{ $detail->jumlah }}
                            </span>
                        </td>
                        <td style="padding: 15px;">
                            @if($peminjaman->status == 'pending')
                                <span style="padding: 5px 10px; background: #fef3c7; color: #92400e; border-radius: 20px; font-weight: 500;">
                                    <i class="fas fa-clock"></i> Menunggu
                                </span>
                            @elseif($peminjaman->status == 'dipinjam')
                                <span style="padding: 5px 10px; background: #dbeafe; color: #1e40af; border-radius: 20px; font-weight: 500;">
                                    <i class="fas fa-box-open"></i> Dipinjam
                                </span>
                            @elseif($peminjaman->status == 'kembali')
                                <span style="padding: 5px 10px; background: #d1fae5; color: #065f46; border-radius: 20px; font-weight: 500;">
                                    <i class="fas fa-check-circle"></i> Dikembalikan
                                </span>
                            @endif
                        </td>
                        <td style="padding: 15px;">
                            @if($peminjaman->status == 'pending')
                                <span style="color: #94a3b8;">-</span>
                            @elseif($peminjaman->status == 'dipinjam')
                                <span style="color: #94a3b8;">Belum dikembalikan</span>
                            @else
                                {{ $peminjaman->tanggal_kembali ? \Carbon\Carbon::parse($peminjaman->tanggal_kembali)->format('d/m/Y H:i') : '-' }}
                            @endif
                        </td>
                    </tr>
                    @endforeach
                @endforeach
            </tbody>
        </table>
        
        <!-- Pagination -->
        <div style="margin-top: 20px;">
            {{ $riwayat->links() }}
        </div>
    </div>
    @else
    <div style="text-align: center; padding: 40px;">
        <i class="fas fa-history" style="font-size: 60px; color: #cbd5e1;"></i>
        <h3 style="margin-top: 20px; color: #64748b;">Belum Ada Riwayat</h3>
        <p style="color: #94a3b8;">
            @if(request('status'))
                Tidak ada riwayat dengan status "{{ request('status') }}"
            @else
                Anda belum pernah meminjam barang
            @endif
        </p>
        
        <a href="{{ route('borrowing.pinjam') }}" class="btn btn-primary" style="margin-top: 20px;">
            <i class="fas fa-cart-plus"></i> Mulai Pinjam
        </a>
    </div>
    @endif
</div>

<!-- Statistik Card -->
<div class="card">
    <h3><i class="fas fa-chart-pie"></i> Statistik Peminjaman</h3>
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px; margin-top: 20px;">
        <div style="background: #fef3c7; padding: 20px; border-radius: 10px; text-align: center;">
            <div style="font-size: 32px; color: #92400e; font-weight: bold;">
                {{ $riwayat->where('status', 'pending')->count() }}
            </div>
            <div style="color: #92400e; margin-top: 5px;">
                <i class="fas fa-clock"></i> Menunggu
            </div>
        </div>
        
        <div style="background: #dbeafe; padding: 20px; border-radius: 10px; text-align: center;">
            <div style="font-size: 32px; color: #1e40af; font-weight: bold;">
                {{ $riwayat->where('status', 'dipinjam')->count() }}
            </div>
            <div style="color: #1e40af; margin-top: 5px;">
                <i class="fas fa-box-open"></i> Dipinjam
            </div>
        </div>
        
        <div style="background: #d1fae5; padding: 20px; border-radius: 10px; text-align: center;">
            <div style="font-size: 32px; color: #065f46; font-weight: bold;">
                {{ $riwayat->where('status', 'kembali')->count() }}
            </div>
            <div style="color: #065f46; margin-top: 5px;">
                <i class="fas fa-check-circle"></i> Dikembalikan
            </div>
        </div>
        
        <div style="background: #f1f5f9; padding: 20px; border-radius: 10px; text-align: center;">
            <div style="font-size: 32px; color: #475569; font-weight: bold;">
                {{ $riwayat->count() }}
            </div>
            <div style="color: #475569; margin-top: 5px;">
                <i class="fas fa-list"></i> Total
            </div>
        </div>
    </div>
</div>

@endsection