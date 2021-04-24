<?php

use App\User;
use Illuminate\Database\Seeder;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create(
            [
                "title" => "Mr",
                "initials" => "B. K",
                "initials_full" => "Batagoda Kankanamge",
                "first_name" => "Aruna",
                "last_name" => "Usitha",
                "gender" => "m",
                "mobile" => "0712514573",
                "address_no" => "225/1",
                "address_street" => "Deniyaya Road, Poramba, Akuressa",
                "address_city" => "Akuressa",
                "DOB" => "2019-12-10",
                "NIC" => "933603288V",
                "email" => "mediaaruna@gmail.com",
                "password" => Hash::make("12"),
                "status" => 1,
                "profile_img" => "users_data/933603288V/profile_img.jpeg",
                "email_verified_at" => null,
                "remember_token" => "2019-12-10 17:21:58",
                "created_at" => "2019-12-14 18:07:11",
                "updated_at" => null

            ]
    );

    }
}
