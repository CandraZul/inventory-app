<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SidebarController extends Controller
{
    public function toggle(Request $request)
    {
        $collapsed = $request->input('collapsed', false);
        session(['sidebar_collapsed' => $collapsed]);
        
        return response()->json(['success' => true]);
    }
}