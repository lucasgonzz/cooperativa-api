<?php

use Illuminate\Support\Facades\Route;

Route::post('login', 'AuthController@login');
Route::post('logout', 'AuthController@logout');

Route::get('partner-payment/pdf/{id}', 'PartnerPaymentController@pdf');
Route::get('partner-payment/pdf/{from_date}/{until_date}/{id?}', 'PartnerPaymentController@pdfHistory');


// Password Reset
Route::post('/password-reset/send-verification-code',
	'PasswordResetController@sendVerificationCode'
);
Route::post('/password-reset/check-verification-code',
	'PasswordResetController@checkVerificationCode'
);
Route::post('/password-reset/update-password',
	'PasswordResetController@updatePassword'
);

// Helpers
Route::get('/set-nums/{company_name}',
	'HelperController@setNums'
);