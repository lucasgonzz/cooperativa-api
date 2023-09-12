<?php

namespace Database\Seeders;

use App\Models\Partner;
use App\Models\User;
use Illuminate\Database\Seeder;

class PartnerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::where('name', 'Diana')->first();
        $models = [
            [
                'num'           => 1,
                'name'          => 'Lucas Gonzalez',
                'doc_number'    => '42354898',
                'address'       => 'Carmen gadea 787',
                'observations'  => 'Tiene muchas cosas',
                'user_id'       => $user->id,
            ],
        ];

        foreach ($models as $model) {
            $partner = Partner::create($model); 
            $partner->services()->attach(1);
        }
    }
}
