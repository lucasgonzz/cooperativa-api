<?php

namespace App\Http\Controllers\Helpers;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class UserHelper {

	static function userId($from_admin = true) {
        $user = Auth()->user();
        if ($from_admin) {
            if (is_null($user->admin_id)) {
                return $user->id;
            } else {
    	        return $user->admin_id;
            }
        } else {
            return $user->id;
        }
    }

    static function user() {
        return User::find(Self::userId());
    }

    static function getFullModel($id = null) {
        if (is_null($id)) {
            $id = Self::userId();
        }
        $user = User::where('id', $id)
                    ->withAll()
                    ->first();
        return $user;
    }

    static function checkUserTrial($user = null) {
        if (is_null($user)) {
            $user = Self::getFullModel();
        }
    	$expired_at = $user->expired_at;
    	if (!is_null($expired_at) && $expired_at->lte(Carbon::now())) {
    		$user->trial_expired = true;
    	} else {
    		$user->trial_expired = false;
    	}
    	return $user;
    }

    static function setEmployeeExtencionsAndConfigurations($employee) {
        $user_owner = Self::getFullModel(); 
        $employee->owner_extencions = $user_owner->extencions;
        $employee->owner_configuration = $user_owner->configuration;
        $employee->owner_addresses = $user_owner->addresses;
        $employee->from_cloudinary = $user_owner->from_cloudinary;
        $employee->default_article_image_url = $user_owner->default_article_image_url;
        return $employee;
    }
}