<?php

namespace App\Http\Controllers;

use App\Models\Lodging;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LodgingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $lodings= Lodging::all();
        return response()->json($lodings);
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
        $lodging = Lodging::create($request->all());
        return $lodging;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Lodging  $lodging
     * @return \Illuminate\Http\Response
     */
    public function show(Lodging $lodging)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Lodging  $lodging
     * @return \Illuminate\Http\Response
     */
    public function edit(Lodging $lodging)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Lodging  $lodging
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $lodging = DB::table('lodgings')->where('id','=',$id)->update($request->all());
        return $lodging;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Lodging  $lodging
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $lodging = Lodging::find($id);
        $lodging->delete();
        return response()->make('deleted',200);
    }

    public function store_img(Request $request)
    {
        if($request->hasFile('image')){
            $file = $request->file('image');
            $file_name = $file->getClientOriginalName();
            $file->move(public_path('images/lodgings'), $file_name);
            return response()->json([
                'message' => 'file uploaded',
                'file' => $file_name
            ], 200);
        }if($request->hasFile('pdf')){
            $file = $request->file('pdf');
            $file_name = $file->getClientOriginalName();
            $file->move(public_path('images/lodgings/plan'), $file_name);
            return response()->json([
                'message' => 'file uploaded',
                'file' => $file_name
            ], 200);
        }
    }

    public function getLodgingInfos($id)
    {
        $lodging = DB::table('lodgings')->where('id','=',$id)->get();
        $details= DB::table('sales')
            ->join('properties','properties.id','=','sales.property_id')
            ->join('clients','clients.id','=','sales.client_id')
            ->join('lodgings','lodgings.id','=','properties.lodging_id')
            ->selectRaw('properties.type, properties.num_apartment, clients.name as client_name,
            clients.id as client_id, sales.agreed_amount, sales.advanced_amount, sales.rest')
            ->where('lodgings.id','=',$id)
            ->get();
        $nextPayments=DB::table('sales')
            ->join('properties','properties.id','=','sales.property_id')
            ->join('clients','clients.id','=','sales.client_id')
            ->join('lodgings','lodgings.id','=','properties.lodging_id')
            ->join('payments','payments.sale_id','=','sales.id')
            ->selectRaw('payments.next_payment,clients.id as client_id')
            ->where('lodgings.id','=',$id)
            ->get();
        $numberFree= DB::table('properties')
                    ->selectRaw('COUNT(id) as free')
                    ->whereRaw("properties.status='disponible'")
                    ->get();
        return response()->json([
            'lodging'=>$lodging,
            'details'=>$details,
            'free'=>$numberFree,
            'nextPayments'=>$nextPayments
        ]);
    }

}
