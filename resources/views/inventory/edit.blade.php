@extends('layouts.app')

@section('title', 'Edit Inventory')
@section('subtitle', 'Edit Data Barang')

@section('content')
    <div class="max-w-3xl mx-auto bg-white p-6 rounded-lg shadow">

        <h2 class="text-xl font-semibold mb-4">Edit Data Inventory</h2>

        <form action="{{ route('inventory.update', $item->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label class="block mb-1 font-medium">Nama Barang</label>
                <input type="text" name="nama_barang" value="{{ $item->nama_barang }}"
                       class="w-full border rounded px-3 py-2" required>
            </div>

            <div class="mb-4">
                <label class="block mb-1 font-medium">Merk</label>
                <input type="text" name="merk" value="{{ $item->merk }}"
                       class="w-full border rounded px-3 py-2">
            </div>

            <div class="mb-4">
                <label class="block mb-1 font-medium">Jumlah</label>
                <input type="number" name="jumlah" value="{{ $item->jumlah }}"
                       class="w-full border rounded px-3 py-2" required>
            </div>

            <div class="mb-4">
                <label class="block mb-1 font-medium">Kondisi</label>
                <select name="kondisi" class="w-full border rounded px-3 py-2">
                    <option value="Baik" {{ $item->kondisi == 'Baik' ? 'selected' : '' }}>Baik</option>
                    <option value="Rusak Ringan" {{ $item->kondisi == 'Rusak Ringan' ? 'selected' : '' }}>Rusak Ringan</option>
                    <option value="Rusak Berat" {{ $item->kondisi == 'Rusak Berat' ? 'selected' : '' }}>Rusak Berat</option>
                </select>
            </div>

            <div class="mb-6">
                <label class="block mb-1 font-medium">Lokasi</label>
                <input type="text" name="lokasi" value="{{ $item->lokasi }}"
                       class="w-full border rounded px-3 py-2">
            </div>

            <div class="flex justify-end gap-3">
                <a href="{{ route('inventory.index') }}"
                   class="px-4 py-2 bg-gray-300 rounded">
                    Batal
                </a>
                <button type="submit"
                        class="px-4 py-2 bg-blue-600 text-white rounded">
                    Update
                </button>
            </div>
        </form>
    </div>
@endsection
