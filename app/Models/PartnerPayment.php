<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PartnerPayment extends Model
{
    protected $guarded = [];

    protected $dates = ['issued_at'];

    function scopeWithAll($query) {
        $query->with('service', 'partner');
    }

    function service() {
        return $this->belongsTo('App\Models\Service');
    }

    function partner() {
        return $this->belongsTo('App\Models\Partner');
    }
}
