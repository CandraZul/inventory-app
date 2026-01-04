@extends('layouts.app')

@section('title', 'Riwayat Peminjaman')

@section('content')
    <div class="bg-white shadow rounded-lg p-4">

        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left border border-gray-200 rounded-lg">
                <thead class="bg-gray-100 text-gray-700">
                <tr>
                    <th class="px-4 py-2 border-b">ID Riwayat</th>
                    <th class="px-4 py-2 border-b">ID Peminjaman</th>
                    <th class="px-4 py-2 border-b">ID User</th>
                    <th class="px-4 py-2 border-b">Nama</th>
                    <th class="px-4 py-2 border-b">NIM/NIP</th>
                    <th class="px-4 py-2 border-b">Kontak</th>
                    <th class="px-4 py-2 border-b">Barang/Keperluan</th>
                    <th class="px-4 py-2 border-b">Status</th>
                    <th class="px-4 py-2 border-b">Tanggal Pinjam</th>
                    <th class="px-4 py-2 border-b">Tanggal Kembali</th>
                    <th class="px-4 py-2 border-b">Surat (PDF)</th> <!-- 🔥 INI kolom suratnya -->
                    <th class="px-4 py-2 border-b">Jenis</th>
                </tr>
                </thead>
                <tbody class="text-gray-600">

                @foreach($data as $row)
                    <tr class="hover:bg-gray-50 border-b">

                        <td class="px-4 py-2">{{ $row->riwayat_id }}</td>
                        <td class="px-4 py-2">{{ $row->peminjaman_id ?? '-' }}</td>
                        <td class="px-4 py-2">{{ $row->user_id }}</td>
                        <td class="px-4 py-2">{{ $row->nama_user }}</td>
                        <td class="px-4 py-2">{{ $row->identitas ?? '-' }}</td>
                        <td class="px-4 py-2">{{ $row->kontak ?? '-' }}</td>
                        <td class="px-4 py-2">{{ $row->nama_barang }}</td>

                        <td class="px-4 py-2">
      <span class="px-2 py-1 text-xs font-medium rounded
        {{ $row->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : '' }}
        {{ $row->status === 'dipinjam' ? 'bg-blue-100 text-blue-800' : '' }}
        {{ $row->status === 'kembali' ? 'bg-green-100 text-green-800' : '' }}
        {{ $row->status === 'approved' ? 'bg-purple-100 text-purple-800' : '' }}">
        {{ ucfirst($row->status) }}
      </span>
                        </td>

                        <td class="px-4 py-2">{{ $row->tanggal_pinjam }}</td>
                        <td class="px-4 py-2">{{ $row->tanggal_kembali ?? '-' }}</td>

                        <!-- BAGIAN SURAT -->
                        <td class="px-4 py-2">
                            @if($row->jenis === 'surat')
                                <a href="{{ asset($row->surat_path) }}" target="_blank"
                                   class="inline-flex items-center gap-2 bg-red-500 text-white px-3 py-1.5 rounded text-xs hover:bg-red-600">
                                    <i class="fas fa-file-pdf"></i> Lihat Surat
                                </a>
                            @else
                                -
                            @endif
                        </td>

                        <td class="px-4 py-2">{{ ucfirst($row->jenis) }}</td>

                    </tr>
                @endforeach

                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $data->links() }}
        </div>

    </div>
@endsection
