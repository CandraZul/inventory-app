<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PeminjamanUserController extends Controller
{
    public function dashboard()
    {
        return view('borrowing.dashboard');
    }

    public function index()
    {
        return view('borrowing.pinjam');
    }
}