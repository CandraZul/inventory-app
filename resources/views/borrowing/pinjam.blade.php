@extends('borrowing.layouts.app')

@section('title', 'Pinjam Barang')

@section('content')

<h2>Daftar Barang Lab</h2>

<form method="GET" action="{{ route('borrowing.pinjam') }}" style="margin-bottom:20px">
    <input type="text" name="search" placeholder="Cari barang..."
           value="{{ request('search') }}">
    <button type="submit">Cari</button>
</form>

<table border="1" cellpadding="10" cellspacing="0">
    <thead>
        <tr>
            <th>Nama Barang</th>
            <th>Stok</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        @foreach($inventories as $item)
        <tr>
            <td>{{ $item->nama_barang }}</td>
            <td>{{ $item->jumlah }}</td>
            <td>
                <form method="POST" action="{{ route('borrowing.store') }}">
                    @csrf
                    <input type="hidden" name="inventory_id" value="{{ $item->id }}">
                    <input type="number" name="jumlah" min="1" max="{{ $item->jumlah }}" required>
                    <button type="submit">Pinjam</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

@endsection
