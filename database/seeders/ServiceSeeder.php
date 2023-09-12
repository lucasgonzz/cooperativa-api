<?php

namespace Database\Seeders;

use App\Models\Service;
use App\Models\User;
use Illuminate\Database\Seeder;

class ServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $models = [
            [
                'name'          => 'Pileta',
                'price'         => 2500,
                'description'   => 'Inscripciones cerradas',
            ],
            [
                'name'          => 'Tenis',
                'price'         => 3000,
                'description'   => '',
            ],
        ];

        $user = User::where('name', 'Diana')->first();
        
        foreach ($models as $model) {
            Service::create([
                'name'          => $model['name'],
                'price'         => $model['price'],
                'description'   => $model['description'],
                'user_id'       => $user->id,
            ]);
        }
    }
}
