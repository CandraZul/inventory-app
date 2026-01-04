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

                        <!-- KOLOM TANGGAL KEMBALI -->
                        <td class="p-3 text-center">
                            <input type="date"
                                   name="tanggal_kembali"
                                   value="{{ $item->tanggal_kembali ?? '' }}"
                                   id="date-{{ $item->peminjaman_id }}"
                                   class="text-xs border rounded px-2 py-1 w-32">
                        </td>

                        <!-- KOLOM AKSI -->
                        <td class="p-3 text-center">
                            @if($item->status === 'dipinjam')
                                <form method="POST"
                                      action="{{ route('admin.pengembalian.update', $item->peminjaman_id) }}"
                                      class="flex justify-center gap-1 items-center"
                                      onsubmit="syncTanggal({{ $item->peminjaman_id }})">
                                    @csrf
                                    @method('PUT')

                                    <!-- Field hidden buat nampung tanggal dari input -->
                                    <input type="hidden" name="tanggal_kembali" id="sync-{{ $item->peminjaman_id }}">

                                    <button type="submit"
                                            class="px-3 py-1 bg-green-600 hover:bg-green-700 text-white rounded text-xs font-bold">
                                        Simpan
                                    </button>
                                </form>

                                <script>
                                    function syncTanggal(id){
                                        const val = document.getElementById('date-'+id).value;
                                        document.getElementById('sync-'+id).value = val;
                                    }
                                </script>

                            @else
                                <span class="text-gray-400 text-xs italic">Sudah kembali</span>
                            @endif
                        </td>
                    </tr>
                @endforeach

                @if($ajuan->count() === 0)
                    <tr>
                        <td colspan="10" class="p-4 text-center text-gray-500">Tidak ada data pengembalian</td>
                    </tr>
                @endif
                </tbody>
            </table>

            <!-- PAGINATION -->
            <div class="mt-4">
                {{ $ajuan->links() }}
            </div>
        </div>

    </div>
@endsection

@push('scripts')
    <script>
        // sinkronisasi tanggal saat klik simpan
        function syncTanggal(id){
            const val = document.getElementById('date-'+id).value;
            document.getElementById('sync-'+id).value = val;
        }
    </script>
@endpush
