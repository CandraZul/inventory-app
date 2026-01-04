@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-800 flex items-center gap-2">
                <i class="fas fa-history text-blue-500"></i>
                Riwayat Peminjaman
            </h1>
            <p class="text-gray-600 mt-1">Riwayat peminjaman barang Anda</p>
        </div>
        
        <!-- Filter Status -->
        <form method="GET" action="{{ route('borrowing.riwayat') }}">
            <select name="status" onchange="this.form.submit()" 
                    class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                <option value="">-- Semua Status --</option>
                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="dipinjam" {{ request('status') == 'dipinjam' ? 'selected' : '' }}>Dipinjam</option>
                <option value="kembali" {{ request('status') == 'kembali' ? 'selected' : '' }}>Kembali</option>
            </select>
        </form>
    </div>

    @if($riwayat->count() > 0)
    <!-- Table -->
    <div class="bg-white rounded-xl shadow overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kode Peminjaman</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal Pinjam</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Barang</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jumlah</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal Kembali</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @php $counter = ($riwayat->currentPage() - 1) * $riwayat->perPage() + 1; @endphp
                    @foreach($riwayat as $peminjaman)
                        @foreach($peminjaman->details as $detail)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ $counter++ }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-mono text-gray-900">
                                PMJ-{{ str_pad($peminjaman->id, 4, '0', STR_PAD_LEFT) }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ \Carbon\Carbon::parse($peminjaman->tanggal_pinjam)->format('d/m/Y H:i') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                {{ $detail->inventory->nama_barang }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-gray-100 text-gray-800">
                                    {{ $detail->jumlah }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($peminjaman->status == 'pending')
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-yellow-100 text-yellow-800">
                                        <i class="fas fa-clock mr-1"></i>
                                        Pending
                                    </span>
                                @elseif($peminjaman->status == 'dipinjam')
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                                        <i class="fas fa-box-open mr-1"></i>
                                        Dipinjam
                                    </span>
                                @elseif($peminjaman->status == 'kembali')
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                                        <i class="fas fa-check-circle mr-1"></i>
                                        Dikembalikan
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                @if($peminjaman->status == 'pending')
                                    <span class="text-gray-400">-</span>
                                @elseif($peminjaman->status == 'dipinjam')
                                    <span class="text-gray-400">Belum dikembalikan</span>
                                @else
                                    {{ $peminjaman->tanggal_kembali ? \Carbon\Carbon::parse($peminjaman->tanggal_kembali)->format('d/m/Y H:i') : '-' }}
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    @endforeach
                </tbody>
            </table>
        </div>
        
        <!-- Pagination -->
        @if($riwayat->hasPages())
        <div class="px-6 py-4 border-t border-gray-200">
            {{ $riwayat->links() }}
        </div>
        @endif
    </div>
    
    @else
    <!-- Empty State -->
    <div class="bg-white rounded-xl shadow p-8 text-center">
        <div class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
            <i class="fas fa-history text-3xl text-gray-400"></i>
        </div>
        <h3 class="text-xl font-semibold text-gray-700 mb-2">Belum Ada Riwayat</h3>
        <p class="text-gray-500 mb-6">
            @if(request('status'))
                Tidak ada riwayat dengan status "{{ request('status') }}"
            @else
                Anda belum pernah meminjam barang
            @endif
        </p>
        
        <a href="{{ route('borrowing.pinjam') }}" 
           class="inline-flex items-center gap-2 bg-blue-500 hover:bg-blue-600 text-white px-6 py-3 rounded-lg font-medium">
            <i class="fas fa-cart-plus"></i>
            Mulai Pinjam
        </a>
    </div>
    @endif

    <!-- Statistik Card -->
    <div class="bg-white rounded-xl shadow p-6">
        <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center gap-2">
            <i class="fas fa-chart-pie text-blue-500"></i>
            Statistik Peminjaman
        </h3>
        
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            <div class="bg-yellow-50 p-4 rounded-lg text-center">
                <div class="text-3xl font-bold text-yellow-700">
                    {{ $riwayat->where('status', 'pending')->count() }}
                </div>
                <div class="text-yellow-600 mt-1">
                    <i class="fas fa-clock mr-1"></i>Menunggu
                </div>
            </div>
            
            <div class="bg-blue-50 p-4 rounded-lg text-center">
                <div class="text-3xl font-bold text-blue-700">
                    {{ $riwayat->where('status', 'dipinjam')->count() }}
                </div>
                <div class="text-blue-600 mt-1">
                    <i class="fas fa-box-open mr-1"></i>Dipinjam
                </div>
            </div>
            
            <div class="bg-green-50 p-4 rounded-lg text-center">
                <div class="text-3xl font-bold text-green-700">
                    {{ $riwayat->where('status', 'kembali')->count() }}
                </div>
                <div class="text-green-600 mt-1">
                    <i class="fas fa-check-circle mr-1"></i>Dikembalikan
                </div>
            </div>
            
            <div class="bg-gray-50 p-4 rounded-lg text-center">
                <div class="text-3xl font-bold text-gray-700">
                    {{ $riwayat->count() }}
                </div>
                <div class="text-gray-600 mt-1">
                    <i class="fas fa-list mr-1"></i>Total
                </div>
            </div>
        </div>
    </div>
</div>
@endsection