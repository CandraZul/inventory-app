<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\User;

class PengembalianController extends Controller
{
    public function index()
    {
        $ajuan = DB::table('peminjamans as p')
            ->join('users as u', 'u.id', '=', 'p.user_id')
            ->join('peminjaman_details as d', 'd.peminjaman_id', '=', 'p.id')
            ->join('inventories as i', 'i.id', '=', 'd.inventory_id')
            ->leftJoin('profiles_mahasiswa as m', 'm.user_id', '=', 'u.id')
            ->leftJoin('profiles_dosen as ds', 'ds.user_id', '=', 'u.id')
            ->select(
                'p.id as peminjaman_id',
                'u.id as user_id',
                'u.name as peminjam',
                DB::raw("CASE WHEN m.nim IS NOT NULL THEN m.nim ELSE ds.nip END as identitas"),
                'i.nama_barang',
                'd.jumlah',
                'p.status',
                'p.tanggal_pinjam',
                'p.tanggal_kembali'
            )
            ->where('p.status', 'dipinjam')
            ->orderBy('p.tanggal_pinjam', 'asc')
            ->paginate(10)
            ->through(function ($item) {
                $item->role = User::find($item->user_id)?->getRoleNames()->first() ?? '-';
                return $item;
            });

        return view('admin.pengembalian.index', ['ajuan' => $ajuan]);
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
