@extends('layouts.app')

@section('content')
<div class="container">
    <h3 class="mb-4">📦 Daftar Barang Lab</h3>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Barang</th>
                <th>Stok</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($inventories as $item)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $item->nama_barang }}</td>
                    <td>{{ $item->jumlah }}</td>
                    <td>
                        <a href="#" class="btn btn-sm btn-primary">
                            Pinjam
                        </a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="text-center">
                        Tidak ada barang tersedia
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
