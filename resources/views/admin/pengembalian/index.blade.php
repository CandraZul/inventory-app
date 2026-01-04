@extends('layouts.app')

@section('title', 'Kelola Pengembalian')
@section('subtitle', 'Konfirmasi & edit tanggal pengembalian barang peminjaman')

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
                        <td class="p-3">{{ $item->identitas ?? '-' }}</td>
                        <td class="p-3">{{ $item->role ?? '-' }}</td>

                        {{-- Tombol lihat barang --}}
                        <td class="p-3 text-center">
                            <button onclick="openModal({{ $item->peminjaman_id }})"
                                    class="px-3 py-1 bg-blue-600 text-white rounded text-xs font-bold">
                                Lihat Barang
                            </button>
                        </td>

                        {{-- Jumlah --}}
                        <td class="p-3 text-center">{{ $item->total_jumlah ?? '-' }}</td>

                        {{-- Status --}}
                        <td class="p-3 text-center">{{ $item->status }}</td>

                        {{-- Tanggal pinjam --}}
                        <td class="p-3 text-center">{{ $item->tanggal_pinjam }}</td>

                        {{-- Kolom tanggal kembali + form --}}
                        <td class="p-3 text-center">
                            @if($item->status === 'dipinjam')
                                <form id="form-{{ $item->peminjaman_id }}" method="POST"
                                      action="{{ route('admin.pengembalian.update', $item->peminjaman_id) }}"
                                      onsubmit="syncTanggal({{ $item->peminjaman_id }})"
                                      class="inline">
                                    @csrf
                                    @method('PUT')
                                    <input type="date" name="tanggal_kembali"
                                           id="date-{{ $item->peminjaman_id }}"
                                           class="text-xs border rounded px-2 py-1 w-28">
                                </form>
                            @else
                                <span class="text-xs text-gray-500">{{ $item->tanggal_kembali ?? '-' }}</span>
                            @endif
                        </td>

                        {{-- Tombol simpan di kolom aksi --}}
                        <td class="p-3 text-center">
                            @if($item->status === 'dipinjam')
                                <button onclick="document.getElementById('form-{{ $item->peminjaman_id }}').submit()"
                                        type="button"
                                        class="px-3 py-1 bg-green-600 text-white rounded text-xs font-bold">
                                    Simpan
                                </button>
                            @else
                                <span class="text-gray-400 text-xs">-</span>
                            @endif
                        </td>
                    </tr>
                @endforeach

                @if($ajuan->count() === 0)
                    <tr><td colspan="10" class="p-4 text-center">Tidak ada data</td></tr>
                @endif
                </tbody>
            </table>

            <div class="mt-4">{{ $ajuan->links() }}</div>
        </div>

    </div>

    {{-- Modal detail barang --}}
    @foreach($ajuan as $item)
        @php $details = json_decode($item->detail_barang, true) ?? [] @endphp
        <div id="modal-{{ $item->peminjaman_id }}" class="fixed inset-0 bg-black bg-opacity-40 hidden flex justify-center items-center">
            <div class="bg-white w-[500px] rounded-xl shadow-lg p-4">
                <h3 class="font-bold mb-3">Detail Barang #{{ $item->peminjaman_id }}</h3>
                <table class="w-full text-xs border">
                    <thead class="bg-gray-100"><tr><th class="p-2 text-left">Barang</th><th class="p-2">Jumlah</th></tr></thead>
                    <tbody>
                    @foreach($details as $d)
                        <tr class="border-b"><td class="p-2">{{ $d['barang'] }}</td><td class="p-2 text-center">{{ $d['jumlah'] }}</td></tr>
                    @endforeach
                    @if(!count($details))
                        <tr><td colspan="2" class="p-2 text-center text-gray-500">Tidak ada data</td></tr>
                    @endif
                    </tbody>
                </table>
                <div class="text-right mt-4">
                    <button onclick="closeModal({{ $item->peminjaman_id }})"
                            class="px-3 py-1 bg-gray-600 text-white rounded text-xs font-bold">
                        Tutup
                    </button>
                </div>
            </div>
        </div>
    @endforeach

@endsection

@push('scripts')
    <script>
        function openModal(id){
            document.getElementById('modal-'+id)?.classList.remove('hidden');
        }
        function closeModal(id){
            document.getElementById('modal-'+id)?.classList.add('hidden');
        }
        function syncTanggal(id){
            const val = document.getElementById('date-'+id)?.value;
            document.getElementById('sync-'+id).value = val;
        }
    </script>
@endpush
