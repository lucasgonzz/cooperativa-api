<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Provider extends Model
{
    protected $guarded = [];

    function scopeWithAll($query) {
        $query->with('provider_payments');
    }

    function provider_payments() {
        return $this->hasMany('App\Models\ProviderPayment');
    }
}
