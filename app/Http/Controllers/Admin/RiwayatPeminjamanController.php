<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Pagination\LengthAwarePaginator;

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
                'p.user_id as user_id',
                'u.name as peminjam',
                DB::raw('COALESCE(mhs.nim, dsn.nip) as identitas'),
                'u.email as kontak',
                'p.status',
                'p.tanggal_pinjam',
                'p.tanggal_kembali',
                DB::raw('(SELECT JSON_ARRAYAGG(JSON_OBJECT("nama", iv.nama_barang, "jumlah", det.jumlah))
                          FROM peminjaman_details as det
                          JOIN inventories as iv ON iv.id = det.inventory_id
                          WHERE det.peminjaman_id = p.id) as items')
            ])
            ->orderByDesc('p.tanggal_pinjam')
            ->groupBy('p.id','p.user_id','u.name','mhs.nim','dsn.nip','u.email','p.status','p.tanggal_pinjam','p.tanggal_kembali')
            ->get();

        $data = $data->map(function($item){
            $item->role = User::find($item->user_id)?->getRoleNames()->first() ?? '-';
            return $item;
        });

        $page = $request->get('page', 1);
        $perPage = 10;

        $paginator = new LengthAwarePaginator(
            $data->forPage($page, $perPage),
            $data->count(),
            $perPage,
            $page,
            ['path' => $request->url(), 'query' => $request->query()]
        );

        return view('admin.riwayat.index', ['data' => $paginator]);
    }
}
