<?php

namespace App\Http\Controllers;

use Auth;
use App\Data;
use Illuminate\Http\Request;

class DataController extends Controller
{

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(!empty($request->get('id'))){

            $long = $request->get('long');
            $lat = $request->get('lat');

            $data = Data::where('id', '=', $request->get('id'))->first();

            if($data->cep != $request->get('cep')){
                $endpoint = 'https://www.google.com/maps/search/' . $request->street . '+' .  $request->number . '+' .  $request->neighborhood . '+' .  $request->city . '+' .  $request->state;
                $endpoint = str_replace(' ', '%20', $endpoint);

                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $endpoint);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
                $response = curl_exec($ch);

                preg_match("/APP_INITIALIZATION_STATE=\[\[\[(-?\d+\.\d+),(-?\d+\.\d+),(-?\d+\.\d+)\]/m", $response, $group);

                $long = $group[2];
                $lat = $group[3];
            }

            Data::where('id', '=', $request->get('id'))->update(
                [
                    'status' => $request->get('status'),
                    'street' => $request->get('street'),
                    'number' => $request->get('number'),
                    'neighborhood' => $request->get('neighborhood'),
                    'city' => $request->get('city'),
                    'state' => $request->get('state'),
                    'cep' => $request->get('cep'),
                    'whatsapp' => $request->get('whatsapp'),
                    'lat' => $lat,
                    'long' => $long,
                ]
            );

            return redirect()->back()->with('success', 'Atualizado com sucesso ...'); 
        }

        $data = new Data();
        $data->user_id = Auth::user()->id;
        $data->fill($request->all());

        $endpoint = 'https://www.google.com/maps/place/' . $data->street . '+' .  $data->number . '+' .  $data->neighborhood . '+' .  $data->city . '+' .  $data->state;
        $endpoint = str_replace(' ', '+', $endpoint);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $endpoint);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
        $response = curl_exec($ch);

        preg_match("/APP_INITIALIZATION_STATE=\[\[\[(-?\d+\.\d+),(-?\d+\.\d+),(-?\d+\.\d+)\]/m", $response, $group);

        $data->long = $group[2];
        $data->lat = $group[3];

        $data->save();
        
        return redirect()->back()->with('success', 'Atualizado com sucesso'); 
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Data  $data
     * @return \Illuminate\Http\Response
     */
    public function show(Data $data)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Data  $data
     * @return \Illuminate\Http\Response
     */
    public function edit(Data $data)
    {
        $data = Data::where('id', $data->id)->first();
        return view('home', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Data  $data
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Data $data)
    {
        $data->fill($request->all());
        $data->update();

        return redirect()->back()->with('success', 'Atualizado com sucesso'); 
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Data  $data
     * @return \Illuminate\Http\Response
     */
    public function destroy(Data $data)
    {
        //
    }
}
