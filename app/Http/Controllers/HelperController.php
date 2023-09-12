<?php

namespace App\Http\Controllers;

use App\Models\Partner;
use App\Models\Provider;
use App\Models\Service;
use App\Models\User;
use Illuminate\Http\Request;

class HelperController extends Controller
{
    function setNums($company_name) {
        $user = User::where('company_name', $company_name)
                        ->first();
                        
        $models = Partner::where('user_id', $user->id)
                            ->orderBy('created_at', 'ASC')
                            ->get();
        foreach ($models as $model) {
            $model->num = null;
            $model->timestamps = false;
            $model->save();
        }
        foreach ($models as $model) {
            $model->num = $this->num('partners');
            $model->timestamps = false;
            $model->save();
            echo $model->name.' num: '.$model->num.' </br>';
        }
        echo 'Socios actualizados </br>';
        echo '----------------------------------------------- </br>';

        $models = Provider::where('user_id', $user->id)
                            ->orderBy('created_at', 'ASC')
                            ->get();
        foreach ($models as $model) {
            $model->num = null;
            $model->timestamps = false;
            $model->save();
        }
        foreach ($models as $model) {
            $model->num = $this->num('providers');
            $model->timestamps = false;
            $model->save();
            echo $model->name.' num: '.$model->num.' </br>';
        }
        echo 'Proveedres actualizados </br>';
        echo '----------------------------------------------- </br>';
                        
        $models = Service::where('user_id', $user->id)
                            ->orderBy('created_at', 'ASC')
                            ->get();
        foreach ($models as $model) {
            $model->num = null;
            $model->timestamps = false;
            $model->save();
        }
        foreach ($models as $model) {
            $model->num = $this->num('services');
            $model->timestamps = false;
            $model->save();
            echo $model->name.' num: '.$model->num.' </br>';
        }
        echo 'Servicios actualizados </br>';
        echo '----------------------------------------------- </br>';

        echo "Termiando";
    }
}
