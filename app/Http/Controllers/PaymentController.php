<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $payments = DB::table('payments')
            ->join('sales','sales.id','=','payments.sale_id')
            ->join('clients','clients.id','=','sales.client_id')
            ->join('properties','properties.id','=','sales.property_id')
            ->join('lodgings','lodgings.id','=','properties.lodging_id')
            ->selectRaw('payments.*, lodgings.name as lodging , clients.name, clients.id as client_id , sales.agreed_amount, sales.rest , properties.price, properties.address,properties.city')
            ->get();
        return response()->json($payments);
    }

    public function getNotifications(){
        $notifications = DB::table('payments')
            ->join('sales','sales.id','=','payments.sale_id')
            ->join('clients','clients.id','=','sales.client_id')
            ->join('properties','properties.id','=','sales.property_id')
            ->join('lodgings','lodgings.id','=','properties.lodging_id')
            ->selectRaw('payments.id, payments.next_payment, lodgings.name as lodging , clients.name, clients.id as client_id , sales.monthly_amount, sales.rest , properties.address, properties.type ,properties.city')
            ->whereRaw("DATEDIFF(payments.next_payment,NOW())<=7 AND  DATEDIFF(payments.next_payment,NOW())>0  AND sales.rest > 0 AND sales.payment_nature='partial'")
            ->get();

        return $notifications;
    }


    public function getPayments($id){
        $payments = DB::table('payments')
            ->join('sales','sales.id','=','payments.sale_id')
            ->join('clients','clients.id','=','sales.client_id')
            ->join('properties','properties.id','=','sales.property_id')
            ->join('lodgings','lodgings.id','=','properties.lodging_id')
            ->selectRaw('payments.*, lodgings.name as lodging , clients.name , sales.agreed_amount, sales.rest , properties.price, properties.address,properties.city')
            ->where('payments.sale_id','=',$id)
            ->get();

        return response()->json($payments);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $payment = Payment::create($request->all());
        return $payment;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $payment = Payment::find($id);
        return response()->json($payment);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function edit(Payment $payment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $edited = DB::table('payments')->where('id','=',$id)->update($request->all());
        return  $edited;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $payment = Payment::find($id);
        $payment->delete();
    }

    public function getPrintDetails($id)

    {
        $printDetails= DB::table('payments')
            ->join('sales','sales.id','=','payments.sale_id')
            ->join('clients','clients.id','=','sales.client_id')
            ->join('properties','properties.id','=','sales.property_id')
            ->join('lodgings','lodgings.id','=','properties.lodging_id')
            ->selectRaw('lodgings.city, lodgings.name,
                            lodgings.address, payments.amount,
                            properties.num_apartment, properties.type,
                            sales.rest,
                             payments.payment_date,  clients.name as client_name,
                             clients.cin')
            ->where('payments.id','=',$id)
            ->get();
        return response()->json($printDetails);

    }

}
