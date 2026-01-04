<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Models\User;

class PeminjamanApprovalController extends Controller
{
    public function index()
    {
        $ajuan = DB::table('peminjamans as p')
            ->join('users as u', 'u.id', '=', 'p.user_id')
            ->join('peminjaman_details as d', 'd.peminjaman_id', '=', 'p.id')
            ->join('inventories as i', 'i.id', '=', 'd.inventory_id')
            ->leftJoin('surat_peminjamans as s', 's.peminjaman_id', '=', 'p.id')
            ->select(
                'p.id as peminjaman_id',
                'u.id as user_id',
                'u.name as peminjam',
                'u.email',
                'i.nama_barang',
                'd.jumlah',
                'p.status',
                'p.tanggal_pinjam',

                // Surat dari user
                's.user_id as surat_user_id',
                's.surat_path as surat_user_path',
                's.status as surat_status',

                // Surat balasan admin
                's.signed_response_path' // ← WAJIB di-select karena akan dipakai di view
            )
            ->get()
            ->map(function ($item) {
                // Role dari user pemohon peminjaman
                $item->role = User::find($item->user_id)?->getRoleNames()->first() ?? '-';

                // URL download surat dari user
                $item->surat_url = $item->surat_user_path ? Storage::url($item->surat_user_path) : null;

                // URL download balasan admin
                $item->signed_response_url = $item->signed_response_path ? Storage::url($item->signed_response_path) : null;

                return $item;
            });



        return view('admin.approval.index', ['ajuan' => $ajuan]);
    }

    public function approve($id)
    {
        DB::table('peminjamans')->where('id', $id)->update(['status' => 'dipinjam']);
        return back()->with('success', 'Pengajuan peminjaman berhasil di-ACC');
    }

    public function reject($id)
    {

        DB::table('peminjamans')->where('id', $id)->update(['status' => 'ditolak']);

        return back()->with('info', 'Pengajuan peminjaman ditolak');
    }

    public function uploadSignedResponse(Request $request, $id)
    {
        $path = $request->file('signed_pdf')->store('signed-response-pdf');

        DB::table('surat_peminjamans')->updateOrInsert(
            ['peminjaman_id' => $id],
            ['signed_response_path' => $path]
        );

        return back()->with('success', 'Surat balasan berhasil dikirim admin');
    }

    public function downloadSignedResponse($id)
    {
        $file = DB::table('surat_peminjamans')->where('peminjaman_id', $id)->value('signed_response_path');
        if (!$file) return back()->with('info', 'Belum ada surat balasan');
        return response()->download(storage_path('app/' . $file));
    }

    public function process(Request $request, $id){
        $action = $request->action;

        if ($action === 'approve') {
            $request->validate([
                'signed_pdf' => 'required|mimes:pdf|max:2048'
            ]);

            $file = $request->file('signed_pdf');
            $path = $file->store('surat-balasan');

            // ⬇ Tambahkan ini
            DB::table('peminjamans')
                ->where('id', $id)
                ->update(['status' => 'dipinjam']);

            // simpan juga surat balasan kalau perlu
            DB::table('surat_peminjamans')->updateOrInsert(
                ['peminjaman_id' => $id],
                ['signed_response_path' => $path]
            );
        }


        return redirect()->back()->with('success', 'Status ajuan berhasil diperbarui');
    }


}

