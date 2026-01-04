@extends('layouts.app')

@section('title', 'Riwayat Peminjaman')
@section('subtitle', 'Daftar riwayat peminjaman barang laboratorium')

@section('content')
    <div class="bg-white shadow rounded-2xl p-5 border border-gray-200">
        @php
            $today = \Carbon\Carbon::today()->format('Y-m-d');
        @endphp
        {{-- FILTER --}}
        <form method="GET" class="mb-5 grid grid-cols-1 md:grid-cols-3 gap-4 items-end">

            @php
                $today = \Carbon\Carbon::today()->format('Y-m-d');
            @endphp

            {{-- Filter Tanggal --}}
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Tanggal Pinjam</label>
                <input type="date" name="tanggal" value="{{ request('tanggal', $today) }}"
                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring focus:border-blue-500">
            </div>

            {{-- Filter Barang / Alat --}}
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Barang / Alat</label>
                <input type="text" name="alat" placeholder="Contoh: Laptop, Proyektor..."
                       value="{{ request('alat') }}"
                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring focus:border-blue-500">
            </div>

            {{-- Filter Role --}}
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Role Peminjam</label>
                <select name="role"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring focus:border-blue-500">
                    <option value="">Semua</option>
                    <option value="mahasiswa" {{ request('role') == 'mahasiswa' ? 'selected' : '' }}>Mahasiswa</option>
                    <option value="dosen" {{ request('role') == 'dosen' ? 'selected' : '' }}>Dosen</option>
                </select>
            </div>

            {{-- Tombol Submit --}}
            <div class="md:col-span-3 flex justify-end">
                <button class="px-4 py-2 bg-blue-600 text-white text-sm font-bold rounded-lg hover:bg-blue-700">
                    Terapkan Filter
                </button>
            </div>

        </form>


        {{-- TABEL --}}
        <div class="overflow-x-auto">
            <table class="w-full text-sm border border-gray-200 rounded-lg">
                <thead class="bg-gray-100 uppercase text-gray-700">
                <tr>
                    <th class="p-3 text-left">ID Peminjaman</th>
                    <th class="p-3 text-left">Pemohon</th>
                    <th class="p-3 text-center">NIM/NIP</th>
                    <th class="p-3 text-left">Kontak</th>
                    <th class="p-3 text-center">Role</th>
                    <th class="p-3 text-center">Barang</th>
                    <th class="p-3 text-center">Status</th>
                    <th class="p-3 text-center">Tanggal Pinjam</th>
                    <th class="p-3 text-center">Tanggal Kembali</th>
                </tr>
                </thead>

                <tbody class="text-gray-600">

                @php
                    $filtered = collect($data->items())->filter(function($row){
                        $items = json_decode($row->items, true) ?? [];
                        $roleFilter = request('role');
                        $alatFilter = strtolower(request('alat'));
                        $tanggalFilter = request('tanggal');
                        $rowRole = strtolower($row->role);

                        $matchRole = !$roleFilter || $roleFilter == $rowRole;
                        $matchTanggal = !$tanggalFilter || substr($row->tanggal_pinjam, 0, 10) == $tanggalFilter;
                        $matchAlat = !$alatFilter || collect($items)->contains(fn($it) =>
                            str_contains(strtolower($it['nama']), $alatFilter)
                        );

                        return $matchRole && $matchTanggal && $matchAlat;
                    });
                @endphp

                @if($filtered->count() > 0)
                    @foreach($filtered as $row)
                        <tr class="border-b hover:bg-gray-50">
                            <td class="p-3 font-bold">{{ $row->peminjaman_id }}</td>
                            <td class="p-3">{{ $row->peminjam }}</td>
                            <td class="p-3 text-center">{{ $row->identitas ?? '-' }}</td>
                            <td class="p-3">{{ $row->kontak ?? '-' }}</td>
                            <td class="p-3 text-center capitalize">{{ $row->role }}</td>

                            <td class="p-3 text-center">
                                <button onclick="openModal({{ $row->peminjaman_id }})"
                                        class="px-3 py-1 bg-blue-600 hover:bg-blue-700 text-white rounded text-xs font-bold">
                                    Lihat Barang
                                </button>
                                <input type="hidden" id="items-{{ $row->peminjaman_id }}" value='{{ $row->items }}'>
                            </td>

                            <td class="p-3 text-center capitalize">
                                @if($row->status == 'kembali')
                                    Dikembalikan
                                @elseif($row->status == 'pending')
                                    Pending
                                @elseif($row->status == 'dipinjam')
                                    Dipinjam
                                @elseif($row->status == 'ditolak')
                                    Ditolak
                                @else
                                    {{ $row->status }}
                                @endif
                            </td>

                            <td class="p-3 text-center">
                                {{ $row->tanggal_pinjam ? \Carbon\Carbon::parse($row->tanggal_pinjam)->translatedFormat('d F Y') : '-' }}
                            </td>

                            <td class="p-3 text-center">
                                {{ $row->tanggal_kembali ? \Carbon\Carbon::parse($row->tanggal_kembali)->translatedFormat('d F Y') : '-' }}
                            </td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="9" class="p-4 text-center text-red-500 font-semibold">
                            Data Tidak Ditemukan
                        </td>
                    </tr>
                @endif

                </tbody>
            </table>

            <div class="mt-4">
                {{ $data->appends(request()->query())->links() }}
            </div>
        </div>

    </div>

    {{-- MODAL --}}
    <div id="modal" class="fixed inset-0 bg-black bg-opacity-40 hidden flex justify-center items-center">
        <div class="bg-white w-[500px] rounded-xl shadow-lg p-5">
            <h3 class="font-bold mb-3 text-gray-800">Rincian Barang</h3>
            <table class="w-full text-xs border border-gray-200 rounded-lg">
                <thead class="bg-gray-100">
                <tr>
                    <th class="p-2 text-left border-b">Nama Barang</th>
                    <th class="p-2 text-center border-b">Jumlah</th>
                </tr>
                </thead>
                <tbody id="modal-body"></tbody>
            </table>

            <div class="flex justify-end mt-4">
                <button onclick="closeModal()" class="px-3 py-1 bg-gray-600 text-white rounded text-xs font-bold">
                    Tutup
                </button>
            </div>
        </div>
    </div>

    {{-- SCRIPT --}}
    @push('scripts')
        <script>
            function openModal(id) {
                const raw = document.getElementById('items-' + id).value;
                const items = JSON.parse(raw || "[]");

                const body = document.getElementById("modal-body");
                body.innerHTML = "";

                items.forEach(it => {
                    body.innerHTML += `
            <tr class="border-b">
                <td class="p-2 text-left">${it.nama}</td>
                <td class="p-2 text-center">${it.jumlah}</td>
            </tr>`;
                });

                document.getElementById("modal").classList.remove("hidden");
            }

            function closeModal() {
                document.getElementById("modal").classList.add("hidden");
            }
        </script>
    @endpush

@endsection
