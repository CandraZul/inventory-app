@extends('layouts.app')

@section('title', 'Riwayat Peminjaman')

@section('content')
    <div class="bg-white shadow rounded-xl p-5">

        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left border border-gray-200 rounded-lg">
                <thead class="bg-gray-100 text-gray-700">
                <tr>
                    <th class="px-4 py-2 border-b">ID Peminjaman</th>
                    <th class="px-4 py-2 border-b">ID User</th>
                    <th class="px-4 py-2 border-b">Nama</th>
                    <th class="px-4 py-2 border-b">NIM/NIP</th>
                    <th class="px-4 py-2 border-b">Kontak</th>
                    <th class="px-4 py-2 border-b text-center">Barang</th>
                    <th class="px-4 py-2 border-b">Status</th>
                    <th class="px-4 py-2 border-b">Tanggal Pinjam</th>
                    <th class="px-4 py-2 border-b">Tanggal Kembali</th>
                    <th class="px-4 py-2 border-b">Role</th>
                </tr>
                </thead>

                <tbody class="text-gray-600">
                @foreach($data as $row)
                    <tr class="hover:bg-gray-50 border-b">
                        <td class="px-4 py-2">{{ $row->peminjaman_id }}</td>
                        <td class="px-4 py-2">{{ $row->user_id }}</td>
                        <td class="px-4 py-2">{{ $row->nama_user }}</td>
                        <td class="px-4 py-2">{{ $row->identitas ?? '-' }}</td>
                        <td class="px-4 py-2">{{ $row->kontak ?? '-' }}</td>

                        <td class="px-4 py-2 text-center">
                            <button onclick="openModal({{ $row->peminjaman_id }})"
                                    class="bg-indigo-600 text-white px-3 py-1.5 rounded text-xs">
                                Lihat
                            </button>

                            @php
                                $items = collect(json_decode("[$row->items]"));
                            @endphp
                            <input type="hidden" id="items-{{ $row->peminjaman_id }}" value='@json($items)'>
                        </td>

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
                        <td class="px-4 py-2">
                            {{ $row->tanggal_kembali ? \Carbon\Carbon::parse($row->tanggal_kembali)->toDateString() : '-' }}
                        </td>
                        <td class="px-4 py-2">{{ $row->role }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $data->links() }}
        </div>
    </div>

    <!-- MODAL TABEL -->
    <div id="modal" class="fixed inset-0 bg-black bg-opacity-40 hidden items-center justify-center">
        <div class="bg-white w-[95%] max-w-lg rounded-xl shadow-lg p-5">
            <h3 class="font-semibold text-gray-800 mb-3">Rincian Barang</h3>

            <div class="overflow-x-auto">
                <table class="w-full text-sm border border-gray-200 rounded-lg">
                    <thead class="bg-gray-100 text-gray-700">
                    <tr>
                        <th class="px-4 py-2 border-b text-left">Nama Barang</th>
                        <th class="px-4 py-2 border-b text-center">Jumlah</th>
                    </tr>
                    </thead>
                    <tbody id="modal-body" class="text-gray-600"></tbody>
                </table>
            </div>

            <button onclick="closeModal()" class="mt-4 bg-red-500 text-white px-4 py-2 rounded text-xs">
                Tutup
            </button>
        </div>
    </div>

    <!-- SCRIPT MODAL -->
    <script>
        function openModal(id) {
            const raw = document.getElementById(`items-${id}`).value;
            const items = JSON.parse(raw);

            const body = document.getElementById("modal-body");
            body.innerHTML = "";

            items.forEach(item => {
                body.innerHTML += `
      <tr class="border-b">
        <td class="px-4 py-2 text-left">${item.nama}</td>
        <td class="px-4 py-2 text-center">${item.jumlah}</td>
      </tr>
    `;
            });

            document.getElementById("modal").classList.remove("hidden");
            document.getElementById("modal").classList.add("flex");
        }

        function closeModal() {
            document.getElementById("modal").classList.add("hidden");
            document.getElementById("modal").classList.remove("flex");
        }
    </script>

@endsection
