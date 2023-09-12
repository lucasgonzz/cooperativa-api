<?php

namespace App\Http\Controllers\Helpers;

use Carbon\Carbon;

class PartnerHelper {
	
	static function attachServices($model, $services) {
		$model->services()->detach();
		foreach ($services as $service) {
			$model->services()->attach($service['id']);
		}
	}

}