<?php

namespace App\Http\Controllers\Helpers;

use App\Models\Service;
use Carbon\Carbon;

class PartnerPaymentHelper {
	
	static function getAmount($request) {
		if (!is_null($request->amount)) {
			return $request->amount;
		}
		$service = Service::find($request->service_id);
		return $service->price;
	}

}