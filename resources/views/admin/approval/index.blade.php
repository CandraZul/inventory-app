@extends('layouts.app')

@section('title', 'Kelola Peminjaman')
@section('subtitle', 'Kelola status ajuan peminjaman barang laboratorium PTIK')

@section('content')
    <div class="bg-white p-5 rounded-2xl shadow border border-gray-200">

        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-gray-100 uppercase text-gray-700">
                <tr>
                    <th class="p-3 text-left">ID Ajuan</th>
                    <th class="p-3 text-left">Pemohon</th>
                    <th class="p-3 text-center">NIM/NIP</th>
                    <th class="p-3 text-center">Role</th>
                    <th class="p-3 text-left">Barang</th>
                    <th class="p-3 text-center">Jumlah</th>
                    <th class="p-3 text-center">Status</th>
                    <th class="p-3 text-center">Tanggal Pinjam</th>
                    <th class="p-3 text-center">Tanggal Kembali</th>
                    <th class="p-3 text-center">Aksi</th>
                </tr>
                </thead>

                <tbody>
                @foreach($ajuan as $item)
                    <tr class="border-b hover:bg-gray-50">
                        <td class="p-3 font-bold">{{ $item->peminjaman_id }}</td>
                        <td class="p-3">{{ $item->peminjam }}</td>
                        <td class="p-3 text-center">{{ $item->identitas ?? '-' }}</td>
                        <td class="p-3 text-center capitalize">{{ $item->role ?? '-' }}</td>
                        <td class="p-3">{{ $item->nama_barang }}</td>
                        <td class="p-3 text-center">{{ $item->jumlah }}</td>
                        <td class="p-3 text-center font-semibold">{{ $item->status }}</td>
                        <td class="p-3 text-center">{{ $item->tanggal_pinjam }}</td>
                        <td class="p-3 text-center">{{ $item->tanggal_kembali ?? '-' }}</td>

                        <td class="p-3 text-center">
                            @if($item->status === 'dipinjam')
                                <span class="text-gray-500 text-xs italic">Sedang dipinjam</span>
                            @elseif($item->status === 'pending')
                                <div class="flex justify-center gap-1">
                                    <form method="POST" action="{{ route('approval.peminjaman.approve', $item->peminjaman_id) }}">
                                        @csrf
                                        @method('PUT')
                                        <button type="submit"
                                                class="px-3 py-1 bg-green-600 hover:bg-green-700 text-white rounded text-xs font-bold">
                                            ACC
                                        </button>
                                    </form>

                                    <form method="POST" action="{{ route('approval.peminjaman.reject', $item->peminjaman_id) }}">
                                        @csrf
                                        @method('PUT')
                                        <button type="submit"
                                                class="px-3 py-1 bg-red-600 hover:bg-red-700 text-white rounded text-xs font-bold">
                                            Tolak
                                        </button>
                                    </form>
                                </div>
                            @else
                                <span class="text-gray-400 text-xs italic">Sudah diproses</span>
                            @endif
                        </td>
                    </tr>
                @endforeach

                @if(count($ajuan) === 0)
                    <tr>
                        <td colspan="10" class="p-4 text-center text-gray-500">Tidak ada ajuan peminjaman</td>
                    </tr>
                @endif
                </tbody>
            </table>
            <div class="mt-4">
                {{ $ajuan->links() }}
            </div>

        </div>

    </div>
@endsection
