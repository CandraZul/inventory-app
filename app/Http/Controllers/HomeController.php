<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Inventory;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login');
        }

        // Cek role
        if ($user->hasAnyRole(['admin', 'super admin'])) {
            // redirect ke admin dashboard
            return redirect()->route('dashboard.admin');
        } else {
            // redirect ke user dashboard
            return redirect()->route('borrowing.dashboard');
        }
    }

    // Opsional: halaman dashboard admin
    public function adminDashboard()
    {
        return view('dashboard'); // view admin
    }
}
