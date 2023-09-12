<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    
    public function index() {
        $models = Service::where('user_id', $this->userId())
                            ->get();
        return response()->json(['models' => $models], 200);
    }

    public function store(Request $request) {
        $model = Service::create([
            'num'           => $this->num('services'),
            'name'          => $request->name,
            'price'         => $request->price,
            'description'   => $request->description,
            'user_id'       => $this->userId(),
        ]);
        return response()->json(['model' => $model], 201);
    }

    public function update(Request $request, $id) {
        $model = Service::find($id);
        $model->name        = $request->name;
        $model->price       = $request->price;
        $model->description = $request->description;
        $model->save();
        return response()->json(['model' => $model], 201);
    }

    public function destroy($id) {
        $model = Service::find($id);
        $model->delete();
        return response(null, 200);
    }
}
