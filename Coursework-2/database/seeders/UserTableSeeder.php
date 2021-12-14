<?php

namespace Database\Seeders;
use App\Models\User;
use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $u = new User;
        $u->name = "TestUserName";
        $u->email = "TestUserEmail@email.com";
        $u->password = "TestUserPassword";
        $u->save();

        $users = User::factory()->count(10)->create();
    }
}
