@extends('layouts.app')

@section('title', 'Approval Peminjaman')

@section('subtitle', 'Kelola status ajuan peminjaman barang laboratorium PTIK')

@section('content')

    <div class="bg-white p-5 rounded-2xl shadow border border-gray-200">

        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-gray-100 uppercase text-gray-700">
                <tr>
                    <th class="p-3 text-left">ID Ajuan</th>
                    <th class="p-3 text-left">Pemohon</th>
                    <th class="p-3 text-left">Role</th>
                    <th class="p-3 text-left">Barang</th>
                    <th class="p-3 text-center">Jumlah</th>
                    <th class="p-3 text-center">Status</th>
                    <th class="p-3 text-center">Tanggal Pinjam</th>
                    <th class="p-3 text-center">Surat (PDF)</th>
                    <th class="p-3 text-center">Aksi</th>
                </tr>
                </thead>
                <tbody>

                @foreach($ajuan as $item)
                    <tr class="border-b hover:bg-gray-50">

                        <td class="p-3 font-bold">{{ $item->peminjaman_id }}</td>

                        <td>{{ $item->peminjam }}</td>

                        <td class="capitalize">{{ $item->role }}</td>

                        <td>{{ $item->nama_barang }}</td>

                        <td class="text-center">{{ $item->jumlah }}</td>

                        <td class="text-center font-semibold">{{ $item->status }}</td>

                        <td class="text-center">{{ $item->tanggal_pinjam }}</td>

                        <!-- Link Download Surat -->
                        <td class="text-center">
                            @if($item->surat_url)
                                <a href="{{ $item->surat_url }}" target="_blank" class="text-blue-600 hover:underline text-xs font-semibold">
                                    Download PDF
                                </a>
                            @else
                                <span class="text-gray-400 text-xs italic">Tidak ada surat</span>
                            @endif
                        </td>

                        <!-- Tombol Approval -->
                        <td class="p-3 text-center">
                            @if($item->status === 'pending')
                                <form method="POST" action="{{ route('approval.peminjaman.approve', $item->peminjaman_id) }}" class="inline">
                                    @method('PUT')
                                    @csrf
                                    <button class="px-3 py-1 bg-green-600 hover:bg-green-700 text-white rounded text-xs font-bold">
                                        ACC
                                    </button>
                                </form>

                                <form method="POST" action="{{ route('approval.peminjaman.reject', $item->peminjaman_id) }}" class="inline">
                                    @method('PUT')
                                    @csrf
                                    <button class="px-3 py-1 bg-red-600 hover:bg-red-700 text-white rounded text-xs font-bold">
                                        Tolak
                                    </button>
                                </form>
                            @else
                                <span class="text-gray-400 text-xs italic">Sudah diproses</span>
                            @endif
                        </td>

                    </tr>
                @endforeach

                @if(count($ajuan) === 0)
                    <tr>
                        <td colspan="9" class="p-4 text-center text-gray-500 font-medium">
                            Tidak ada ajuan peminjaman yang menunggu approval.
                        </td>
                    </tr>
                @endif

                </tbody>
            </table>
        </div>

    </div>

@endsection
