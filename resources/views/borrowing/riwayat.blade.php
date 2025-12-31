@extends('borrowing.layouts.app')

@section('title', 'Riwayat Peminjaman')

@section('content')

<h2>Riwayat Peminjaman</h2>

<!-- filter status -->
<form method="GET" style="margin-bottom: 20px;">
    <select name="status" onchange="this.form.submit()">
        <option value="">-- Semua Status --</option>
        <option value="pending" {{ request('status')=='pending'?'selected':'' }}>Pending</option>
        <option value="dipinjam" {{ request('status')=='dipinjam'?'selected':'' }}>Dipinjam</option>
        <option value="kembali" {{ request('status')=='kembali'?'selected':'' }}>Kembali</option>
    </select>
</form>

<table border="1" cellpadding="10" cellspacing="0">
    <thead>
        <tr>
            <th>Nama Barang</th>
            <th>Jumlah</th>
            <th>Tanggal Pinjam</th>
            <th>Tanggal Kembali</th>
            <th>Status</th>
        </tr>
    </thead>
    <tbody>
        @forelse($riwayat as $p)
            @foreach($p->details as $detail)
                <tr>
                    <td>{{ $detail->inventory->nama_barang }}</td>
                    <td>{{ $detail->jumlah }}</td>
                    <td>{{ $p->tanggal_pinjam }}</td>
                    <td>
                        @if($p->status == 'pending')
                            -
                        @elseif($p->status == 'dipinjam')
                            {{ now()->toDateString() }}
                        @else
                            {{ $p->tanggal_kembali ?? '-' }}
                        @endif
                    </td>
                    <td>{{ ucfirst($p->status) }}</td>
                </tr>
            @endforeach
        @empty
            <tr>
                <td colspan="5">Belum ada riwayat peminjaman</td>
            </tr>
        @endforelse
    </tbody>
</table>

@endsection
