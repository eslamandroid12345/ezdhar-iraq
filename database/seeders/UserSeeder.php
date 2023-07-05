<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{

    public function run()
    {
        $data['phone'] = '01026638997';
        $data['phone_code'] = '+20';
        $data['first_name'] = 'mohamed';
        $data['last_name'] = 'gamal';
        $data['user_type'] = 'client';
        $data['city_id'] = 1;
        $data['birthdate'] = '2001-06-03';

        User::create($data);
    }
}
