<?php

namespace App\Http\Controllers;

use App\Models\Property;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PropertyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $properties= Property::all();
        return response()->json($properties);
    }
    public function getAvailable()
    {

        $properties = DB::table('properties')->where('status','=','disponible')->get();
        return response()->json($properties);
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
        $fields['images']= json_encode($fields['images']);
       $property = Property::create($fields);
       return $property? 1 : 0;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Property  $property
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $property= Property::find($id);
        return $property ? response()->json($property):null;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Property  $property
     * @return \Illuminate\Http\Response
     */
    public function edit(Property $property)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Property  $property
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {
        $request['images'] = json_encode($request['images']);
        $property = DB::table('properties')->where('id','=',$id)->update($request->all());
        return $property? 1 : 0;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Property  $property
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $property = Property::find($id);
        $property->delete();
        return $property || 0;
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
                    $file->move(public_path('images/apartments'), $file_name);
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
