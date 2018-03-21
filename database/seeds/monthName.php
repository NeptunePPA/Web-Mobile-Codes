<?php

use Illuminate\Database\Seeder;
use App\Month;

class monthName extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $month = new Month();
        $month->month = "January";
        $month->save();

        $month = new Month();
        $month->month = "February";
        $month->save();

        $month = new Month();
        $month->month = "March";
        $month->save();

        $month = new Month();
        $month->month = "April";
        $month->save();

        $month = new Month();
        $month->month = "May";
        $month->save();

        $month = new Month();
        $month->month = "June";
        $month->save();

        $month = new Month();
        $month->month = "July";
        $month->save();

        $month = new Month();
        $month->month = "August";
        $month->save();

        $month = new Month();
        $month->month = "September";
        $month->save();

        $month = new Month();
        $month->month = "October";
        $month->save();

        $month = new Month();
        $month->month = "November";
        $month->save();

        $month = new Month();
        $month->month = "December";
        $month->save();
    }
}
