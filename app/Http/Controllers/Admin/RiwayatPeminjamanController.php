<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class RiwayatPeminjamanController extends Controller
{
    public function index(Request $request)
    {
        // Riwayat peminjaman barang
        $riwayatBarang = DB::table('peminjaman_details as d')
            ->join('peminjamans as p', 'p.id', '=', 'd.peminjaman_id')
            ->join('users as u', 'u.id', '=', 'p.user_id')
            ->join('inventories as i', 'i.id', '=', 'd.inventory_id')
            ->leftJoin('profiles_mahasiswa as mhs', 'mhs.user_id', '=', 'u.id')
            ->leftJoin('profiles_dosen as dsn', 'dsn.user_id', '=', 'u.id')
            ->select([
                'd.id as riwayat_id',
                'p.id as peminjaman_id',
                'u.id as user_id',
                'i.id as barang_id',
                'u.name as nama_user',
                DB::raw('COALESCE(mhs.nim, dsn.nip) as identitas'),
                DB::raw('COALESCE(mhs.kontak, dsn.kontak) as kontak'),
                'i.nama_barang',
                'p.status',
                'p.tanggal_pinjam',
                'p.tanggal_kembali',
                DB::raw('"barang" as jenis')
            ]);

        // Riwayat surat yang sudah di acc
        $riwayatSurat = DB::table('surat_peminjamans as s')
            ->join('users as u', 'u.id', '=', 's.user_id')
            ->leftJoin('profiles_mahasiswa as mhs', 'mhs.user_id', '=', 'u.id')
            ->leftJoin('profiles_dosen as dsn', 'dsn.user_id', '=', 'u.id')
            ->select([
                's.id as riwayat_id',
                's.peminjaman_id as peminjaman_id',
                'u.id as user_id',
                DB::raw('NULL as barang_id'),
                'u.name as nama_user',
                DB::raw('COALESCE(mhs.nim, dsn.nip) as identitas'),
                'u.email as kontak',
                DB::raw('s.keperluan as nama_barang'),
                's.status',
                's.tanggal_mulai as tanggal_pinjam',
                's.tanggal_selesai as tanggal_kembali',
                DB::raw('"surat" as jenis')
            ])
            ->where('s.status', 'approved');

        // Gabungkan pakai UNION ALL lalu paginate
        $data = DB::query()
            ->fromSub($riwayatBarang->unionAll($riwayatSurat), 'x')
            ->orderByDesc('tanggal_pinjam')
            ->paginate(10);

        return view('admin.riwayat.index', compact('data'));
    }

}
