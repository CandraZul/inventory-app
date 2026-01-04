@extends('layouts.app')

@section('title','Surat Peminjaman')

@section('content')
    <div class="bg-white rounded-xl shadow p-6">
        <table class="w-full text-sm border">
            <thead class="bg-gray-100">
            <tr>
                <th class="p-2 border">User</th>
                <th class="p-2 border">Peminjaman ID</th>
                <th class="p-2 border">Status</th>
                <th class="p-2 border">File Surat</th>
            </tr>
            </thead>
            <tbody>
            @foreach($surat as $s)
                <tr>
                    <td class="p-2 border">{{ $s->user_id }}</td>
                    <td class="p-2 border">{{ $s->peminjaman_id }}</td>
                    <td class="p-2 border">{{ $s->status }}</td>
                    <td class="p-2 border">
                        <a class="text-blue-600 underline" href="{{ asset($s->surat_path) }}">Lihat</a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection
