@extends('layouts.app')

@section('title','Surat Peminjaman')

@section('content')
    <div class="bg-white rounded-xl shadow p-6">
        <div class="overflow-x-auto">
            <table class="w-full text-lg text-center border border-gray-200 rounded-lg">
                <thead class="bg-gray-100 text-gray-700 font-semibold">
                <tr>
                    <th class="px-4 py-3 border-b">ID</th>
                    <th class="px-4 py-3 border-b">User ID</th>
                    <th class="px-4 py-3 border-b">Nama</th>
                    <th class="px-4 py-3 border-b">Nomor HP</th>
                    <th class="px-4 py-3 border-b">Tanggal Pinjam</th>
                    <th class="px-4 py-3 border-b">Tanggal Kembali</th>
                    <th class="px-4 py-3 border-b">File Surat</th>
                </tr>
                </thead>
                <tbody>
                @foreach($surat as $s)
                    <tr class="hover:bg-gray-50 transition">
{{--                        {{dd($s)}}--}}
                        <td class="px-4 py-3 border-b">{{ $s->id }}</td>
                        <td class="px-4 py-3 border-b">{{ $s->user_id }}</td>
                        <td class="px-4 py-3 border-b">{{ $s->nama_pemohon }}</td>
                        <td class="px-4 py-3 border-b">{{ $s->no_hp }}</td>
                        <td class="px-4 py-3 border-b">{{ $s->tanggal_mulai }}</td>
                        <td class="px-4 py-3 border-b">{{ $s->tanggal_selesai }}</td>

                        <td class="px-4 py-3 border-b">
                            <a class="text-blue-600 underline font-medium hover:text-blue-800 transition"
                               href="{{ Storage::url($s->surat_path) }}"
                               target="_blank">
                                Lihat Surat
                            </a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
