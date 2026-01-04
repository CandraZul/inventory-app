<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RiwayatPeminjamanController extends Controller
{
    public function index(Request $request)
    {
        $data = DB::table('peminjamans as p')
            ->join('peminjaman_details as d', 'd.peminjaman_id', '=', 'p.id')
            ->join('inventories as i', 'i.id', '=', 'd.inventory_id')
            ->join('users as u', 'u.id', '=', 'p.user_id')
            ->leftJoin('profiles_mahasiswa as mhs', 'mhs.user_id', '=', 'u.id')
            ->leftJoin('profiles_dosen as dsn', 'dsn.user_id', '=', 'u.id')
            ->select([
                'p.id as peminjaman_id',
                'u.id as user_id',
                'u.name as nama_user',
                DB::raw('COALESCE(mhs.nim, dsn.nip) as identitas'),
                'u.email as kontak',
                'p.status',
                'p.tanggal_pinjam',
                'p.tanggal_kembali',
                DB::raw('GROUP_CONCAT(
                    JSON_OBJECT(
                        "nama", i.nama_barang,
                        "jumlah", d.jumlah
                    )
                ) as items')
            ])
            ->groupBy('p.id', 'u.id', 'u.name', 'identitas', 'u.email', 'p.status', 'p.tanggal_pinjam', 'p.tanggal_kembali')
            ->orderByDesc('p.tanggal_pinjam')
            ->paginate(10);

        $data->through(function ($item) {
            $item->role = User::find($item->user_id)?->getRoleNames()->first() ?? '-';
            return $item;
        });

        return view('admin.riwayat.index', compact('data'));
    }
}
