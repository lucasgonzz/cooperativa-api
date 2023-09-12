<?php

namespace Database\Seeders;

use App\Models\Provider;
use App\Models\User;
use Illuminate\Database\Seeder;

class ProviderSeeder extends Seeder
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
                'name'          => 'Buenos Aires',
                'observations'  => 'Este es medio caro',
            ],
            [
                'name'          => 'Rosario',
                'observations'  => '',
            ],
        ];

        $user = User::where('name', 'Diana')->first();
        foreach ($models as $model) {
            Provider::create([
                'name'          => $model['name'],
                'observations'  => $model['observations'],
                'user_id'       => $user->id,
            ]);
        }
    }
}
