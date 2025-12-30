@extends('layouts.app')

@section('title', 'Dashboard')

@section('subtitle', 'Overview Sistem Inventory TIK')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <!-- Statistik Card 1 -->
    <div class="bg-white rounded-xl shadow-md p-6 border-l-4 border-primary-500">
        <div class="flex justify-between items-start">
            <div>
                <p class="text-sm text-gray-500">Total Inventori</p>
                <p class="text-3xl font-bold text-gray-800 mt-2">
                    @if(isset($stats['total_items']))
                        {{ $stats['total_items'] }}
                    @else
                        0
                    @endif
                </p>
                <p class="text-sm text-gray-600 mt-2">Item tersedia</p>
            </div>
            <div class="bg-primary-100 p-3 rounded-lg">
                <i class="fas fa-boxes text-2xl text-primary-600"></i>
            </div>
        </div>
    </div>

    <!-- Statistik Card 2 -->
    <div class="bg-white rounded-xl shadow-md p-6 border-l-4 border-green-500">
        <div class="flex justify-between items-start">
            <div>
                <p class="text-sm text-gray-500">Dipinjam</p>
                <p class="text-3xl font-bold text-gray-800 mt-2">@if(isset($stats['borrowed_items'])){{ $stats['borrowed_items'] }}@else 0 @endif</p>
                <p class="text-sm text-gray-600 mt-2">Item sedang dipinjam</p>
            </div>
            <div class="bg-green-100 p-3 rounded-lg">
                <i class="fas fa-handshake text-2xl text-green-600"></i>
            </div>
        </div>
    </div>
    <!-- Statistik Card 3 -->
    <div class="bg-white rounded-xl shadow-md p-6 border-l-4 border-yellow-500">
        <div class="flex justify-between items-start">
            <div>
                <p class="text-sm text-gray-500">Harus Dikembalikan</p>
                <p class="text-3xl font-bold text-gray-800 mt-2">@if(isset($stats['overdue_items'])){{ $stats['overdue_items'] }}@else 0 @endif</p>
                <p class="text-sm text-gray-600 mt-2">Lewat batas waktu</p>
            </div>
            <div class="bg-yellow-100 p-3 rounded-lg">
                <i class="fas fa-exclamation-triangle text-2xl text-yellow-600"></i>
            </div>
        </div>
    </div>

    <!-- Statistik Card 4 -->
    <div class="bg-white rounded-xl shadow-md p-6 border-l-4 border-purple-500">
        <div class="flex justify-between items-start">
            <div>
                <p class="text-sm text-gray-500">Total Pengguna</p>
                <p class="text-3xl font-bold text-gray-800 mt-2">@if(isset($stats['total_users'])){{ $stats['total_users'] }}@else 0 @endif</p>
                <p class="text-sm text-gray-600 mt-2">User terdaftar</p>
            </div>
            <div class="bg-purple-100 p-3 rounded-lg">
                <i class="fas fa-users text-2xl text-purple-600"></i>
            </div>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
    <!-- Chart atau Aktivitas Terbaru -->
    <div class="bg-white rounded-xl shadow-md p-6">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-xl font-bold text-gray-800">Aktivitas Peminjaman Terbaru</h2>
           </div>

        <div class="space-y-4">
            @if(isset($recent_activities) && count($recent_activities) > 0)
                @foreach($recent_activities as $activity)
                <div class="flex items-start border-b pb-4 last:border-0 last:pb-0">
                    <div class="flex-shrink-0 mt-1">
                        <div class="w-8 h-8 rounded-full flex items-center justify-center
                            @if($activity->status == 'dipinjam') bg-blue-100 text-blue-600
                            @elseif($activity->status == 'dikembalikan') bg-green-100 text-green-600
                            @else bg-gray-100 text-gray-600 @endif">
                            <i class="fas
                                @if($activity->status == 'dipinjam') fa-handshake
                                @elseif($activity->status == 'dikembalikan') fa-undo-alt
                                @else fa-clock @endif text-sm"></i>
                        </div>
                    </div>
                    <div class="ml-4 flex-1">
                        <p class="text-sm font-medium text-gray-900">{{ $activity->user_name }} - {{ $activity->item_name }}</p>
                        <p class="text-sm text-gray-600">{{ $activity->description }}</p>
                        <p class="text-xs text-gray-500 mt-1">{{ $activity->created_at->format('d M Y, H:i') }}</p>
                    </div>
                    <span class="px-2 py-1 text-xs font-semibold rounded-full
                        @if($activity->status == 'dipinjam') bg-blue-100 text-blue-800
                        @elseif($activity->status == 'dikembalikan') bg-green-100 text-green-800
                        @else bg-gray-100 text-gray-800 @endif">
                        {{ $activity->status }}
                    </span>
                </div>
                @endforeach
            @else
                <div class="text-center py-8 text-gray-500">
                    <i class="fas fa-history text-3xl mb-3"></i>
                    <p>Tidak ada aktivitas terbaru</p>
                </div>
            @endif
        </div>
    </div>

    <!-- Inventori dengan Stok Sedikit -->
    <div class="bg-white rounded-xl shadow-md p-6">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-xl font-bold text-gray-800">Stok Hampir Habis</h2>
             </div>

        <div class="space-y-4">
            @if(isset($low_stock_items) && count($low_stock_items) > 0)
                @foreach($low_stock_items as $item)
                <div class="flex items-center justify-between p-4 bg-yellow-50 rounded-lg border border-yellow-200">
                    <div class="flex items-center">
                        <div class="w-10 h-10 rounded-lg bg-yellow-100 flex items-center justify-center mr-4">
                            <i class="fas fa-microchip text-yellow-600"></i>
                        </div>
                        <div>
                            <p class="font-medium text-gray-900">{{ $item->name }}</p>
                            <p class="text-sm text-gray-600">{{ $item->category }}</p>
                        </div>
                    </div>
                    <div class="text-right">
                        <p class="text-lg font-bold text-red-600">{{ $item->stock }}</p>
                        <p class="text-xs text-gray-500">stok tersisa</p>
                    </div>
                </div>
                @endforeach
            @else
                <div class="text-center py-8 text-gray-500">
                    <i class="fas fa-check-circle text-3xl mb-3 text-green-500"></i>
                    <p>Semua stok dalam kondisi baik</p>
                </div>
            @endif
        </div>

        <!-- Quick Actions -->
        <div class="mt-8 pt-6 border-t border-gray-200">
            <h3 class="text-lg font-medium text-gray-800 mb-4">Aksi Cepat</h3>
            <div class="grid grid-cols-2 gap-4">

            </div>
        </div>
    </div>
</div>
@endsection
