@extends('layouts.app')

@section('title', 'Tambah Inventory')
@section('subtitle', 'Tambah Barang Baru')

@section('content')
    <div class="grid grid-cols-1 gap-8">
        <!-- Header -->
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Tambah Inventory</h1>
                <p class="text-gray-600">Tambahkan barang baru ke sistem inventori TIK</p>
            </div>
            <a href="{{ route('inventory.index') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-800 px-4 py-3 rounded-lg font-medium flex items-center">
                <i class="fas fa-arrow-left mr-2"></i>
                Kembali
            </a>
        </div>

        <!-- Form -->
        <div class="bg-white rounded-xl shadow-md overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-lg font-semibold text-gray-800">Form Tambah Barang</h2>
            </div>

            <div class="p-6">
                <form method="POST" action="{{ route('inventory.store') }}" class="space-y-6">
                    @csrf

                    <!-- Nama Barang -->
                    <div>
                        <label for="nama_barang" class="block text-sm font-medium text-gray-700 mb-2">
                            Nama Barang
                        </label>
                        <input type="text"
                               name="nama_barang"
                               id="nama_barang"
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-colors duration-200"
                               placeholder="Masukkan nama barang">
                    </div>

                    <!-- Merk Barang -->
                    <div>
                        <label for="merk" class="block text-sm font-medium text-gray-700 mb-2">
                            Merk Barang
                        </label>
                        <input type="text"
                               name="merk"
                               id="merk"
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-colors duration-200"
                               placeholder="Masukkan merk barang">
                    </div>

                    <!-- Jumlah -->
                    <div>
                        <label for="jumlah" class="block text-sm font-medium text-gray-700 mb-2">
                            Jumlah
                        </label>
                        <input type="number"
                               name="jumlah"
                               id="jumlah"
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-colors duration-200"
                               placeholder="Masukkan jumlah barang">
                    </div>

                    <!-- Kondisi -->
                    <div>
                        <label for="kondisi" class="block text-sm font-medium text-gray-700 mb-2">
                            Kondisi
                        </label>
                        <input type="text"
                               name="kondisi"
                               id="kondisi"
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-colors duration-200"
                               placeholder="Contoh: Baik, Rusak Ringan, Rusak Berat">
                    </div>

                    <!-- Lokasi Barang -->
                    <div>
                        <label for="lokasi" class="block text-sm font-medium text-gray-700 mb-2">
                            Lokasi Barang
                        </label>
                        <input type="text"
                               name="lokasi"
                               id="lokasi"
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-colors duration-200"
                               placeholder="Masukkan lokasi penyimpanan">
                    </div>

                    <!-- Tombol Submit -->
                    <div class="pt-4">
                        <button type="submit"
                                class="bg-primary-600 hover:bg-primary-700 text-white px-6 py-3 rounded-lg font-medium flex items-center justify-center transition-colors duration-200">
                            <i class="fas fa-save mr-2"></i>
                            Simpan Barang
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
