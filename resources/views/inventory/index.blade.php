<h1>Data Inventory</h1>

<a href="{{ route('inventory.create') }}">Tambah Barang</a>

<table border="1">
    <tr>
        <th>Nama</th>
        <th>Merk</th>
        <th>Jumlah</th>
        <th>Kondisi</th>
        <th>Lokasi</th>
    </tr>

    @foreach($items as $item)
        <tr>
            <td>{{ $item->nama_barang }}</td>
            <td>{{ $item->merk }}</td>
            <td>{{ $item->jumlah }}</td>
            <td>{{ $item->kondisi }}</td>
            <td>{{ $item->lokasi }}</td>
        </tr>
    @endforeach
</table>
