<?php

use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        User::create(
            [
                "name" => "Shashank Jha",
                "email" => "shashank@account.local.com",
                "mobile" => "9807060707",
                "password" => Hash::make("shashank@123"),
            ]
        );
    }
}
