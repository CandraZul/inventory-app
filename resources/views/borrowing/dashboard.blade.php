@extends('borrowing.layouts.app')

@section('title', 'Dashboard')

@section('content')

<h2>Halo, {{ auth()->user()->name }} 👋</h2>

<p>Selamat datang di sistem peminjaman alat Lab PTIK.</p>

<div style="margin-top:30px">

    <a href="{{ route('borrowing.pinjam') }}"
       style="padding:12px 20px; background:#2563eb; color:white; text-decoration:none; border-radius:6px;">
        Mulai Pinjam
    </a>

    <a href="{{ route('borrowing.riwayat') }}"
       style="padding:12px 20px; background:#16a34a; color:white; text-decoration:none; border-radius:6px; margin-left:10px;">
        Riwayat Peminjaman
    </a>

</div>

@endsection