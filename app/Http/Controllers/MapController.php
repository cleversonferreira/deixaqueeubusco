<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Data;

class MapController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $data = Data::with('user')
            ->where('status', "on")
            ->get();

        return view('welcome', compact('data'));
    }
}
