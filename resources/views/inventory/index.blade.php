@extends('layouts.app')

@section('title', 'Inventory')
@section('subtitle', 'Data Inventory TIK')

@section('content')
    <div class="grid grid-cols-1 gap-8">
        <!-- Header dengan Tombol Tambah -->
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Data Inventory</h1>
                <p class="text-gray-600">Daftar lengkap barang inventori TIK</p>
            </div>
            <a href="{{ route('inventory.create') }}" class="bg-primary-600 hover:bg-primary-700 text-white px-4 py-3 rounded-lg font-medium flex items-center">
                <i class="fas fa-plus mr-2"></i>
                Tambah Barang
            </a>
        </div>

        <!-- Tabel Inventory -->
        <div class="bg-white rounded-xl shadow-md overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-lg font-semibold text-gray-800">Daftar Barang</h2>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Nama Barang
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Merk
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Jumlah
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Kondisi
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Lokasi
                        </th>
                    </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($items as $item)
                        <tr class="hover:bg-gray-50 transition-colors duration-150">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">{{ $item->nama_barang }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ $item->merk }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full
                                @if($item->jumlah > 10) bg-green-100 text-green-800
                                @elseif($item->jumlah > 5) bg-yellow-100 text-yellow-800
                                @else bg-red-100 text-red-800 @endif">
                                {{ $item->jumlah }}
                            </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full
                                @if($item->kondisi == 'Baik') bg-green-100 text-green-800
                                @elseif($item->kondisi == 'Rusak Ringan') bg-yellow-100 text-yellow-800
                                @else bg-red-100 text-red-800 @endif">
                                {{ $item->kondisi }}
                            </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ $item->lokasi }}
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>

            @if($items->isEmpty())
                <div class="text-center py-12">
                    <i class="fas fa-box-open text-4xl text-gray-300 mb-4"></i>
                    <p class="text-gray-500 text-lg">Belum ada data inventory</p>
                    <p class="text-gray-400 mt-2">Mulai dengan menambahkan barang baru</p>
                </div>
            @endif
        </div>
    </div>
@endsection
