<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;

class BannedController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        if (!Auth::user()->is_active) {
            return view('banned');
        } else {
            return redirect()->route('dashboard.index');
        }
        
    }
}
