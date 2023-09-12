<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Helpers\PartnerPaymentHelper;
use App\Http\Controllers\Pdf\PartnerPaymentHistoryPdf;
use App\Http\Controllers\Pdf\PartnerPaymentPdf;
use App\Models\PartnerPayment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PartnerPaymentController extends Controller
{
    
    function index($model_id, $from_date, $until_date = null) {
        $models = PartnerPayment::withAll()
                                ->orderBy('created_at', 'DESC');

        if (!is_null($until_date)) {
            $models = $models->whereDate('issued_at', '>=', $from_date)
                            ->whereDate('issued_at', '<=', $until_date);
        } else {
            $models = $models->whereDate('issued_at', $from_date);
            Log::info('issued_at = '.$from_date);
        }

        if ($model_id != 0) {
            $models = $models->where('partner_id', $model_id);
        }
        $models = $models->get();
        return response()->json(['models' => $models], 200);
    }

    function store(Request $request) {
        $model = PartnerPayment::create([
            'num'           => $this->num('partner_payments'),
            'amount'        => PartnerPaymentHelper::getAmount($request),
            'issued_at'     => $request->issued_at,
            'observations'  => $request->observations,
            'partner_id'    => $request->model_id,
            'service_id'    => $request->service_id,
            'user_id'       => $this->userId(),
        ]);
        return response()->json(['model' => $this->fullModel('partner_payment', $model->id)], 201);
    }

    function update(Request $request, $id) {
        $model = PartnerPayment::find($id);
        $model->amount          = PartnerPaymentHelper::getAmount($request);
        $model->issued_at       = $request->issued_at;
        $model->observations    = $request->observations;
        $model->service_id      = $request->service_id;
        $model->save();
        return response()->json(['model' => $this->fullModel('partner_payment', $model->id)], 201);
    }

    function destroy($id) {
        $model = PartnerPayment::find($id);
        $model->delete();
        return response(null, 200);
    }

    function pdf($id) {
        $model = PartnerPayment::find($id);
        new PartnerPaymentPdf($model);
    }
    
    function pdfHistory($from_date, $until_date, $model_id = null) {
        $models = PartnerPayment::whereDate('created_at', '>=', $from_date)
                            ->whereDate('created_at', '<=', $until_date)
                            ->withAll()
                            ->orderBy('created_at', 'DESC');
        if (!is_null($model_id)) {
            $models = $models->where('partner_id', $model_id);
        }
        $models = $models->get();
        new PartnerPaymentHistoryPdf($models, $model_id, $from_date, $until_date);
    }
}
