<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Helpers\PartnerHelper;
use App\Models\Partner;
use Illuminate\Http\Request;

class PartnerController extends Controller
{

    public function index() {
        $models = Partner::where('user_id', $this->userId())
                        ->orderBy('created_at', 'ASC')
                        ->withAll()
                        ->get();
        return response()->json(['models' => $models], 200);
    }

    public function store(Request $request) {
        $model = Partner::create([
            'num'           => $this->num('partners'),
            'name'          => $request->name,
            'doc_number'    => $request->doc_number,
            'address'       => $request->address,
            'observations'  => $request->observations,
            'user_id'       => $this->userId(),
        ]);
        PartnerHelper::attachServices($model, $request->services);
        return response()->json(['model' => $this->fullModel('partner', $model->id)], 201);
    }

    public function update(Request $request, $id) {
        $model = Partner::find($id);
        $model->name          = $request->name;
        $model->doc_number    = $request->doc_number;
        $model->address       = $request->address;
        $model->observations  = $request->observations;
        $model->user_id       = $this->userId();
        $model->save();
        PartnerHelper::attachServices($model, $request->services);
        return response()->json(['model' => $this->fullModel('partner', $model->id)], 201);
    }

    public function destroy($id) {
        $model = Partner::find($id);
        $model->delete();
        return response(null, 200);
    }

}
