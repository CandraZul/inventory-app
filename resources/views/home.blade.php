@include('dashboard')
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard Mahasiswa</div>

                <div class="card-body">

                    <h4>Hallo, {{ Auth::user()->name }}</h4>

                    <p>Selamat datang di Sistem Peminjaman Alat Lab PTIK</p>

                    <hr>

                    <a href="/peminjaman" class="btn btn-primary">
                        Mulai Pinjam
                    </a>

                    <hr>

                    <ul>
                        <li><a href="/peminjaman/pending">Pending</a></li>
                        <li><a href="/peminjaman/aktif">Peminjaman</a></li>
                        <li><a href="/peminjaman/riwayat">Riwayat</a></li>
                    </ul>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
