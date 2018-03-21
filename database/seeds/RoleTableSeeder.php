<?php

use Illuminate\Database\Seeder;
use App\roll;

class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role = new roll();
        $role->roll_name = "Master Admin";
        $role->save();

        $role = new roll();
        $role->roll_name = "Administrator";
        $role->save();

        $role = new roll();
        $role->roll_name = "Physician";
        $role->save();

        $role = new roll();
        $role->roll_name = "Orders";
        $role->save();

        $role = new roll();
        $role->roll_name = "Rep";
        $role->save();
    }
}
