<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $payments = Payment::with('sess_id')->get();
        return $payments;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $payment = new Payment([
            'paymentDate' => $request->input('paymentDate'),
            'paidAmount' => $request->input('paidAmount'),
            'paymentStatus' => $request->input('paymentStatus'),
            'trainingcourse_id' => $request->input('trainingcourse_id'),
            'sess_id' => $request->input('sess_id'),
            'trainee_id' => $request->input('trainee_id'),
        ]);
        $payment->save();
        return response()->json($payment, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $payment = Payment::find($id);
        return response()->json($payment);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $payment = Payment::find($id);
        $payment->update($request->all());
        return response()->json($payment, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $payment = Payment::find($id);
        $payment->delete();
        return response()->json('Payment deleted !');
    }
}
