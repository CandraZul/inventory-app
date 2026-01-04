@extends('layouts.app')

@section('content')
    <div class="space-y-6">

        <!-- Header & Filter -->
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold text-gray-800 flex items-center gap-2">
                    <i class="fas fa-history text-blue-500"></i>
                    Riwayat Peminjaman
                </h1>
                <p class="text-gray-600 mt-1">Riwayat peminjaman barang Anda</p>
            </div>

            <form method="GET" action="{{ route('borrowing.riwayat') }}">
                <select name="status" onchange="this.form.submit()"
                        class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    <option value="">-- Semua Status --</option>
                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="dipinjam" {{ request('status') == 'dipinjam' ? 'selected' : '' }}>Dipinjam</option>
                    <option value="kembali" {{ request('status') == 'kembali' ? 'selected' : '' }}>Kembali</option>
                    <option value="ditolak" {{ request('status') == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                </select>
            </form>
        </div>

        <!-- Table Utama -->
        @if($riwayat->count() > 0)
            <div class="bg-white rounded-xl shadow overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50 text-center">
                        <tr>
                            <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase text-center">No</th>
                            <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase text-center">ID Peminjaman</th>
                            <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase text-center">Barang</th>
                            <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase text-center">Status</th>
                            <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase text-center">Tanggal Pinjam</th>
                            <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase text-center">Tanggal Kembali</th>
                        </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($riwayat as $peminjaman)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 text-sm text-center">{{ $loop->iteration }}</td>
                                <td class="px-6 py-4 text-sm font-mono text-center">
                                    PMJ-{{ str_pad($peminjaman->id, 4, '0', STR_PAD_LEFT) }}
                                </td>

                                <!-- Tombol Lihat Barang -->
                                <td class="px-6 py-4 text-center">
                                    <button onclick='openModal(@json($peminjaman->details))'
                                            class="bg-blue-500 text-white px-3 py-1 rounded-lg text-sm">
                                        Lihat Barang
                                    </button>
                                </td>

                                <!-- Status -->
                                <td class="px-6 py-4 text-sm text-center">
                                    @php
                                        $statusMap = [
                                            'kembali' => 'Dikembalikan',
                                            'pending' => 'Pending',
                                            'dipinjam' => 'Dipinjam',
                                            'ditolak' => 'Ditolak',
                                        ];
                                    @endphp

                                    <span class="px-3 py-1
                                    {{ $peminjaman->status == 'pending' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                    {{ $peminjaman->status == 'dipinjam' ? 'bg-blue-100 text-blue-800' : '' }}
                                    {{ $peminjaman->status == 'kembali' ? 'bg-green-100 text-green-800' : '' }}
                                    {{ $peminjaman->status == 'ditolak' ? 'bg-red-100 text-red-800' : '' }}
                                    rounded-full text-xs font-medium">
                                    {{ $statusMap[$peminjaman->status] ?? ucfirst($peminjaman->status) }}
                                </span>
                                </td>

                                <td class="px-6 py-4 text-sm text-center">
                                    {{ \Carbon\Carbon::parse($peminjaman->tanggal_pinjam)->format('d/m/Y') }}
                                </td>

                                <td class="px-6 py-4 text-sm text-center">
                                    {{ $peminjaman->tanggal_kembali ? \Carbon\Carbon::parse($peminjaman->tanggal_kembali)->format('d/m/Y') : '-' }}
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="px-6 py-4 border-t text-center">
                    {{ $riwayat->links() }}
                </div>
            </div>
        @else
            <!-- Empty State -->
            <div class="bg-white rounded-xl shadow p-8 text-center">
                <i class="fas fa-inbox text-4xl text-gray-300 mb-3"></i>
                <h3 class="font-semibold text-gray-700">Belum ada riwayat peminjaman</h3>
            </div>
        @endif

    </div>

    <!-- Modal Detail Barang -->
    <div id="barangModal" class="fixed inset-0 bg-black/50 hidden items-center justify-center z-50">
        <div class="bg-white w-96 p-5 rounded-2xl shadow-xl">
            <h2 class="text-lg font-bold text-gray-800 mb-4 text-center">Detail Barang Dipinjam</h2>

            <div class="overflow-x-auto">
                <table class="w-full text-sm border border-gray-200 rounded-lg">
                    <thead class="bg-gray-100 text-center">
                    <tr>
                        <th class="border px-3 py-2 text-gray-700 text-center">Nama Barang</th>
                        <th class="border px-3 py-2 text-gray-700 text-center">Jumlah</th>
                    </tr>
                    </thead>
                    <tbody id="modalBody"></tbody>
                </table>
            </div>

            <button onclick="closeModal()" class="mt-4 bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg text-sm w-full">
                Tutup
            </button>
        </div>
    </div>

    <!-- Script Modal -->
    <script>
        function openModal(details){
            const modal = document.getElementById("barangModal")
            const body = document.getElementById("modalBody")
            body.innerHTML = ""

            const statusMap = {
                kembali: "Dikembalikan",
                pending: "Pending",
                dipinjam: "Dipinjam",
                ditolak: "Ditolak"
            };

            details.forEach(item => {
                body.innerHTML += `
<tr>
    <td class="border px-3 py-2 text-center">${item.inventory.nama_barang}</td>
    <td class="border px-3 py-2 text-center">${item.jumlah}</td>
</tr>`
            })

            modal.classList.remove("hidden")
            modal.classList.add("flex")
        }

        function closeModal(){
            const modal = document.getElementById("barangModal")
            modal.classList.add("hidden")
            modal.classList.remove("flex")
        }
    </script>

@endsection
