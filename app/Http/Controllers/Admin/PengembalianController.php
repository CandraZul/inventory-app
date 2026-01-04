<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use App\Models\User;

class PengembalianController extends Controller
{
    public function index()
    {
        $data = DB::table('peminjamans as p')
            ->join('users as u', 'u.id', '=', 'p.user_id')
            ->leftJoin('profiles_mahasiswa as m', 'm.user_id', '=', 'u.id')
            ->leftJoin('profiles_dosen as ds', 'ds.user_id', '=', 'u.id')
            ->select(
                'p.id as peminjaman_id',
                'p.user_id as user_id',
                'u.name as peminjam',
                DB::raw("CASE WHEN m.nim IS NOT NULL THEN m.nim ELSE ds.nip END as identitas"),
                DB::raw("(SELECT JSON_ARRAYAGG(JSON_OBJECT('barang', i.nama_barang, 'jumlah', d.jumlah))
                          FROM peminjaman_details as d
                          JOIN inventories as i ON i.id = d.inventory_id
                          WHERE d.peminjaman_id = p.id) as detail_barang"),
                'p.status',
                'p.tanggal_pinjam',
                'p.tanggal_kembali'
            )
            ->where('p.status', 'dipinjam')
            ->orderBy('p.tanggal_pinjam', 'asc')
            ->groupBy('p.id','p.user_id','u.name','m.nim','ds.nip','p.status','p.tanggal_pinjam','p.tanggal_kembali')
            ->get();

        // Mapping role per user
        $data = $data->map(function($item){
            $item->role = User::find($item->user_id)?->getRoleNames()->first() ?? '-';
            return $item;
        });

        // Manual Pagination
        $page = request()->get('page', 1);
        $perPage = 10;

        $paginator = new LengthAwarePaginator(
            $data->forPage($page, $perPage),
            $data->count(),
            $perPage,
            $page,
            ['path' => request()->url(), 'query' => request()->query()]
        );

        return view('admin.pengembalian.index', ['ajuan' => $paginator]);
    }

    public function updateTanggalKembali(Request $request, $id)
    {
        $tanggal = $request->tanggal_kembali;

        if (empty($tanggal)) {
            $tanggal = now()->toDateString(); // hasil: 2026-01-04 (tanpa waktu)
        }


        DB::table('peminjamans')
            ->where('id', $id)
            ->update([
                'tanggal_kembali' => $tanggal,
                'status' => 'kembali' // ← ini sudah valid dan memang status final kamu
            ]);

        return back()->with('success', 'Tanggal kembali berhasil disimpan');
    }



}
