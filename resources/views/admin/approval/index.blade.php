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
                    <th class="p-3 text-center">Barang</th>
                    <th class="p-3 text-center">Status</th>
                    <th class="p-3 text-center">Tanggal Pinjam</th>
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

                        {{-- Tombol Modal --}}
                        <td class="p-3 text-center">
                            <button onclick="openModal({{ $item->peminjaman_id }})"
                                    class="px-3 py-1 bg-blue-600 hover:bg-blue-700 text-white rounded text-xs font-bold">
                                Lihat Barang
                            </button>
                        </td>

                        <td class="p-3 text-center font-semibold">{{ $item->status }}</td>
                        <td class="p-3 text-center">{{ $item->tanggal_pinjam }}</td>

                        {{-- Tombol ACC/Tolak --}}
                        <td class="p-3 text-center">
                            <div class="flex justify-center gap-1">
                                <form method="POST" action="{{ route('approval.peminjaman.approve', $item->peminjaman_id) }}">
                                    @csrf @method('PUT')
                                    <button class="px-3 py-1 bg-green-600 hover:bg-green-700 text-white rounded text-xs font-bold">
                                        ACC
                                    </button>
                                </form>

                                <form method="POST" action="{{ route('approval.peminjaman.reject', $item->peminjaman_id) }}">
                                    @csrf @method('PUT')
                                    <button class="px-3 py-1 bg-red-600 hover:bg-red-700 text-white rounded text-xs font-bold">
                                        Tolak
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach

                @if($ajuan->count() === 0)
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

    {{-- MODAL DI LUAR TABEL --}}
    @foreach($ajuan as $item)
        @php $details = json_decode($item->detail_barang, true) ?? [] @endphp
        <div id="modal-{{ $item->peminjaman_id }}" class="fixed inset-0 bg-black bg-opacity-40 hidden flex justify-center items-center">
            <div class="bg-white w-[500px] rounded-xl shadow-lg p-4">
                <h3 class="font-bold mb-3 text-gray-800">Detail Barang Peminjaman #{{ $item->peminjaman_id }}</h3>

                <table class="w-full text-xs border border-gray-200">
                    <thead class="bg-gray-100 text-gray-700">
                    <tr>
                        <th class="p-2 border-b text-left">Barang</th>
                        <th class="p-2 border-b text-center">Jumlah</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($details as $d)
                        <tr class="border-b">
                            <td class="p-2">{{ $d['barang'] }}</td>
                            <td class="p-2 text-center">{{ $d['jumlah'] }}</td>
                        </tr>
                    @endforeach

                    @if(count($details) === 0)
                        <tr><td colspan="2" class="p-2 text-center text-gray-500">Tidak ada data barang</td></tr>
                    @endif
                    </tbody>
                </table>

                <div class="flex justify-end mt-4">
                    <button onclick="closeModal({{ $item->peminjaman_id }})"
                            class="px-3 py-1 bg-gray-600 hover:bg-gray-700 text-white rounded text-xs font-bold">
                        Tutup
                    </button>
                </div>
            </div>
        </div>
    @endforeach
@endsection

{{-- JS FIX --}}
@push('scripts')
    <script>
        function openModal(id){
            document.getElementById('modal-'+id)?.classList.remove('hidden');
        }
        function closeModal(id){
            document.getElementById('modal-'+id)?.classList.add('hidden');
        }
    </script>
@endpush
