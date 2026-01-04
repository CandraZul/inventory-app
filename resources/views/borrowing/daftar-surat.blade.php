@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-800 flex items-center gap-2">
                <i class="fas fa-file-contract text-blue-500"></i>
                Surat Saya
            </h1>
            <p class="text-gray-600 mt-1">Riwayat surat yang sudah Anda upload</p>
        </div>
        
        <a href="{{ route('borrowing.surat.upload') }}" 
           class="inline-flex items-center gap-2 bg-blue-500 hover:bg-blue-600 text-white px-4 py-3 rounded-lg font-medium">
            <i class="fas fa-plus"></i>
            Upload Surat Baru
        </a>
    </div>

    @if(session('success'))
    <div class="bg-green-50 border border-green-200 rounded-lg p-4">
        <div class="flex items-center">
            <i class="fas fa-check-circle text-green-500 mr-3"></i>
            <p class="text-green-800 font-medium">{{ session('success') }}</p>
        </div>
    </div>
    @endif
    
    @if(session('error'))
    <div class="bg-red-50 border border-red-200 rounded-lg p-4">
        <div class="flex items-center">
            <i class="fas fa-exclamation-circle text-red-500 mr-3"></i>
            <p class="text-red-800 font-medium">{{ session('error') }}</p>
        </div>
    </div>
    @endif
    
    @if($suratList->count() > 0)
    <!-- Table -->
    <div class="bg-white rounded-xl shadow overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal Upload</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Pemohon</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Periode</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Keperluan</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">File Surat</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($suratList as $surat)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            {{ ($suratList->currentPage() - 1) * $suratList->perPage() + $loop->iteration }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            <div class="font-medium">{{ \Carbon\Carbon::parse($surat->created_at)->format('d/m/Y') }}</div>
                            <div class="text-gray-500 text-xs">{{ \Carbon\Carbon::parse($surat->created_at)->format('H:i') }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            <div class="font-medium">{{ $surat->nama_pemohon }}</div>
                            <div class="text-gray-500 text-xs">
                                <i class="fas fa-phone mr-1"></i> {{ $surat->no_hp }}
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            <div class="font-medium">{{ \Carbon\Carbon::parse($surat->tanggal_mulai)->format('d/m/Y') }}</div>
                            <div class="text-gray-500 text-xs">
                                s/d {{ \Carbon\Carbon::parse($surat->tanggal_selesai)->format('d/m/Y') }}
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            {{ $surat->keperluan ?? '-' }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            <a href="{{ Storage::url($surat->surat_path) }}" target="_blank" 
                               class="inline-flex items-center gap-1 bg-blue-50 hover:bg-blue-100 text-blue-600 px-3 py-1 rounded text-sm font-medium">
                                <i class="fas fa-eye"></i>
                                Lihat
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        
        <!-- Pagination -->
        @if($suratList->hasPages())
        <div class="px-6 py-4 border-t border-gray-200">
            {{ $suratList->links() }}
        </div>
        @endif
    </div>
    
    @else
    <!-- Empty State -->
    <div class="bg-white rounded-xl shadow p-8 text-center">
        <div class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
            <i class="fas fa-file-alt text-3xl text-gray-400"></i>
        </div>
        <h3 class="text-xl font-semibold text-gray-700 mb-2">Belum Ada Surat</h3>
        <p class="text-gray-500 mb-6 max-w-md mx-auto">
            Anda belum pernah mengupload surat peminjaman. Upload surat untuk peminjaman jangka panjang atau membawa barang keluar kampus.
        </p>
        
        <div class="flex flex-col sm:flex-row gap-3 justify-center">
            <a href="{{ route('borrowing.surat.upload') }}" 
               class="inline-flex items-center justify-center gap-2 bg-blue-500 hover:bg-blue-600 text-white px-6 py-3 rounded-lg font-medium">
                <i class="fas fa-upload"></i>
                Upload Surat
            </a>
            
            <a href="{{ route('borrowing.surat.template') }}" 
               class="inline-flex items-center justify-center gap-2 bg-gray-100 hover:bg-gray-200 text-gray-700 px-6 py-3 rounded-lg font-medium">
                <i class="fas fa-download"></i>
                Download Template
            </a>
        </div>
    </div>
    @endif
</div>
@endsection