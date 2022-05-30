<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $clients = Client::all();
        return response()->json($clients);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $fields = $request->all();
        $fields['images']=json_encode($fields['images']);
        $clients = Client::create($fields);
        return response()->json($clients);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $client = Client::find($id);
        return $client? response()->json($client) : '';
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function edit(Client $client)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $client = DB::table("clients")->where("id", $id)->update($request->all());
        return $client ? 1 : 0;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $client = Client::find($id);
        $deleted = $client->delete();
        return $deleted? 1 : 0;
    }
    public function store_imgs(Request $request)
    {
        $files=[];
        if($request->TotalImages > 0)
        {

            for ($i=0;$i<$request->TotalImages;$i++){

                if($request->hasFile('images'.$i)){
                    $file = $request->file('images'.$i);
                    $prefix=$request['Prefix'.$i];
                    $file_name = $prefix.$file->getClientOriginalName();
                    $file->move(public_path('images/clients'), $file_name);
                    array_push($files, $file_name);
                }
            }
            return response()->json([
                'message' => 'files uploaded',
                'files'=>$files,
            ], 200);
        }
    }
}
