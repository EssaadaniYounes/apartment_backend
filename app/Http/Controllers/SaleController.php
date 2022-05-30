<?php

namespace App\Http\Controllers;

use App\Models\Property;
use App\Models\Sale;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SaleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sales = DB::table('sales')
            ->join('clients','clients.id','=','sales.client_id')
            ->join('properties','properties.id','=','sales.property_id')
            ->selectRaw('sales.*, clients.name,properties.city,properties.status')
            ->get();
        return response()->json($sales);
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
        $sale = Sale::create($request->all());
        $apartment = Property::find($request->property_id);

        if($apartment) {
            $apartment->status = 'soldé';
            $apartment->save();
        }
        return $sale;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Sale  $sale
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $sale = Sale::find($id);
        return response()->json($sale);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Sale  $sale
     * @return \Illuminate\Http\Response
     */
    public function edit(Sale $sale)
    {

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Sale  $sale
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {
        $sale = DB::table('sales')->where('id','=',$id)
            ->update($request->all());
        return response()->json($sale);
    }
    public function updateRest(Request $request,$id){
        $sale = Sale::find($id);

        if($sale) {
            $sale->rest = $request->rest;
            $sale->save();
        }
        return response()->json($sale) || 0;
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Sale  $sale
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $sale = Sale::find($id);
        $deleted = $sale->delete();
        return response()->json($deleted);
    }
}
