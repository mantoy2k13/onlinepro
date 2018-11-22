<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        Model::unguard();

        $this->call('AdminUserTableSeeder');
        $this->call('CountryTableSeeder');
        $this->call('ProvinceTableSeeder');
        $this->call('CategoryTableSeeder');


        if (App::environment() === 'testing') {
            // Add More Seed For Testing
        }elseif(App::environment() === 'local'){
            $this->call('ImageTableSeeder');
            $this->call('UserTableSeeder');
            $this->call('InquiryTableSeeder');
            $this->call('TeacherTableSeeder');
            $this->call('TeacherCategoryTableSeeder');
            $this->call('TimeSlotTableSeeder');
            $this->call('PaymentLogTableSeeder');
            $this->call('BookingTableSeeder');
            $this->call('PointLogTableSeeder');
            $this->call('PurchaseLogTableSeeder');
            $this->call('ReviewTableSeeder');

        }

        Model::reguard();
    }
}
