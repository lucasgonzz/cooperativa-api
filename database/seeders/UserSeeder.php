<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
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
                'name'          => 'Diana',
                'doc_number'    => '123',
                'phone'         => '34447222112',
                'company_name'  => 'CEF',
                'address'       => 'Carmen gadea 787',
                'email'         => 'lucasgonzalez5500@gmail.com',
                'password'      => bcrypt('123'),
            ],
        ];
        foreach ($models as $model) {
            User::create($model);
        }
    }
}
