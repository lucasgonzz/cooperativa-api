<?php

namespace App\Http\Controllers;

use App\Models\ProviderPayment;
use Illuminate\Http\Request;

class ProviderPaymentController extends Controller
{
    
    function index($model_id, $from_date, $until_date) {
        $models = ProviderPayment::where('provider_id', $model_id)
                            ->whereDate('created_at', '>=', $from_date)
                            ->whereDate('created_at', '<=', $until_date)
                            ->withAll()
                            ->orderBy('created_at', 'DESC')
                            ->get();
        return response()->json(['models' => $models], 200);
    }

    function store(Request $request) {
        $model = ProviderPayment::create([
            'amount'        => $request->amount,
            'issued_at'     => $request->issued_at,
            'code'          => $request->code,
            'observations'  => $request->observations,
            'provider_id'   => $request->model_id,
        ]);
        return response()->json(['model' => $this->fullModel('provider_payment', $model->id)], 201);
    }

    function update(Request $request, $id) {
        $model = ProviderPayment::find($id);
        $model->amount        = $request->amount;
        $model->issued_at     = $request->issued_at;
        $model->code          = $request->code;
        $model->observations  = $request->observations;
        $model->save();
        return response()->json(['model' => $this->fullModel('provider_payment', $model->id)], 201);
    }

    function destroy($id) {
        $model = ProviderPayment::find($id);
        $model->delete();
        return response(null, 200);
    }
}
