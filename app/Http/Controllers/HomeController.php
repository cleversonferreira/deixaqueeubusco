<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Data;

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
        $data = Data::where('user_id', Auth::user()->id)->first();

        if(empty($data)){
            $data = json_decode(json_encode([
                'id' => '',
                'status' => '',
                'street' => '',
                'number' => '',
                'neighborhood' => '',
                'city' => '',
                'state' => '',
                'cep' => '',
                'whatsapp' => '',
                'lat' => '',
                'long' => '',
            ]));
        }

        return view('home', compact('data'));
    }
}
