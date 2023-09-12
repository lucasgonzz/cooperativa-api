<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Partner extends Model
{
    protected $guarded = [];

    function scopeWithAll($query) {
        $query->with('services');
    }

    function services() {
        return $this->belongsToMany('App\Models\Service');
    }

    function partner_payments() {
        return $this->hasMany('App\Models\PartnerPayment');
    }
}
