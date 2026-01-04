@extends('layouts.app')

@section('title', 'Surat Peminjaman - Admin')

@section('content')
<div class="space-y-6">
    <!-- Title Section -->
    <div class="mb-2">
        <p class="text-gray-600 text-lg">Daftar semua surat peminjaman dari pengguna</p>
    </div>
    
    <!-- Search Bar dengan Button Cari -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <!-- Search Form di kiri -->
        <form method="GET" action="{{ route('admin.surat.index') }}" class="flex-1 max-w-xl">
            <div class="flex gap-2">
                <div class="relative flex-1">
                    <input type="text" 
                           name="search" 
                           placeholder="Cari nama pemohon, no HP, atau user..." 
                           value="{{ request('search') }}"
                           class="w-full px-4 py-2 pl-10 pr-10 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    <div class="absolute left-3 top-1/2 transform -translate-y-1/2">
                        <i class="fas fa-search text-gray-400"></i>
                    </div>
                    @if(request('search'))
                    <a href="{{ route('admin.surat.index') }}" 
                       class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-gray-600">
                        <i class="fas fa-times"></i>
                    </a>
                    @endif
                </div>
                <button type="submit" 
                        class="inline-flex items-center justify-center gap-2 bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg font-medium whitespace-nowrap">
                    <i class="fas fa-search"></i>
                    <span class="hidden sm:inline">Cari</span>
                </button>
            </div>
        </form>
        
        <!-- Kosongkan bagian kanan jika tidak ada -->
        <div class="hidden md:block"></div>
    </div>

    @if(session('success'))
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
        {{ session('success') }}
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
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">User</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Pemohon</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No. HP</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Periode</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
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
                            <div class="font-medium">{{ $surat->user->name ?? '-' }}</div>
                            <div class="text-gray-500 text-xs">{{ $surat->user->email ?? '-' }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            <div class="font-medium">{{ $surat->nama_pemohon }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            {{ $surat->no_hp }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            <div class="font-medium">{{ \Carbon\Carbon::parse($surat->tanggal_mulai)->format('d/m/Y') }}</div>
                            <div class="text-gray-500 text-xs">
                                s/d {{ \Carbon\Carbon::parse($surat->tanggal_selesai)->format('d/m/Y') }}
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            <a href="{{ route('admin.surat.download', $surat->id) }}" 
                               class="inline-flex items-center gap-1 bg-blue-500 hover:bg-blue-600 text-white px-3 py-2 rounded text-sm font-medium"
                               title="Download Surat">
                                <i class="fas fa-download"></i>
                                Download
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
        <h3 class="text-xl font-semibold text-gray-700 mb-2">
            @if(request('search'))
                Hasil pencarian "{{ request('search') }}" tidak ditemukan
            @else
                Belum Ada Surat
            @endif
        </h3>
        <p class="text-gray-500 mb-6 max-w-md mx-auto">
            @if(request('search'))
                Coba dengan kata kunci yang berbeda
            @else
                Belum ada surat peminjaman yang diupload oleh pengguna.
            @endif
        </p>
        @if(request('search'))
        <a href="{{ route('admin.surat.index') }}" 
           class="inline-flex items-center gap-2 bg-gray-100 hover:bg-gray-200 text-gray-700 px-6 py-3 rounded-lg font-medium">
            <i class="fas fa-times"></i>
            Reset Pencarian
        </a>
        @endif
    </div>
    @endif
</div>
@endsection