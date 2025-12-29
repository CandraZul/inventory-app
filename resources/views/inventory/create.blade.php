<h1>Tambah Inventory</h1>

<form method="POST" action="{{ route('inventory.store') }}">
    @csrf

    <label>Nama Barang</label><br>
    <input type="text" name="nama_barang"><br>

    <label>Merk Barang</label><br>
    <input type="text" name="merk"><br>

    <label>Jumlah</label><br>
    <input type="number" name="jumlah"><br>

    <label>Kondisi</label><br>
    <input type="text" name="kondisi"><br><br>

    <label>Lokasi Barang</label><br>
    <input type="text" name="lokasi"><br>

    <button type="submit">Simpan</button>
</form>
