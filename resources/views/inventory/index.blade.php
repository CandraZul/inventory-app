<h1>Data Inventory</h1>

<a href="{{ route('inventory.create') }}">Tambah Barang</a>

<table border="1">
    <tr>
        <th>Nama</th>
        <th>Jumlah</th>
        <th>Kondisi</th>
    </tr>

    @foreach($items as $item)
        <tr>
            <td>{{ $item->nama_barang }}</td>
            <td>{{ $item->jumlah }}</td>
            <td>{{ $item->kondisi }}</td>
        </tr>
    @endforeach
</table>
