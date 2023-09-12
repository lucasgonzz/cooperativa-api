<?php

namespace App\Http\Controllers;

use App\Models\Provider;
use Illuminate\Http\Request;

class ProviderController extends Controller
{

    public function index() {
        $models = Provider::where('user_id', $this->userId())
                        ->orderBy('created_at', 'DESC')
                        ->withAll()
                        ->get();
        return response()->json(['models' => $models], 200);
    }

    public function store(Request $request) {
        $model = Provider::create([
            'num'           => $this->num('providers'),
            'name'          => $request->name,
            'cuit'          => $request->cuit,
            'address'       => $request->address,
            'observations'  => $request->observations,
            'user_id'       => $this->userId(),
        ]);
        return response()->json(['model' => $this->fullModel('provider', $model->id)], 201);
    }

    public function update(Request $request, $id) {
        $model = Provider::find($id);
        $model->name          = $request->name;
        $model->cuit          = $request->cuit;
        $model->address       = $request->address;
        $model->observations  = $request->observations;
        $model->user_id       = $this->userId();
        $model->save();
        return response()->json(['model' => $this->fullModel('provider', $model->id)], 201);
    }

    public function destroy($id) {
        $model = Provider::find($id);
        $model->delete();
        return response(null, 200);
    }
}
