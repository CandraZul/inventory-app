<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class SuratAdminController extends Controller
{
    public function index(){
        $surat = DB::table('surat_peminjamans')->orderByDesc('created_at')->get();
        return view('admin.surat.index', compact('surat'));
    }
}

