<?php

use App\Models\Inquiry;
use App\Models\User;
use Illuminate\Database\Seeder;

class InquiryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $array = array("vn",  "th", "jp",  "id");

        foreach (range(1, 100) as $index) {
            $user = User::inRandomOrder()->first();
            $model = factory(\App\Models\Inquiry::class)->make();
            $model->user_id = $user->id;
            $model->living_country_code = $array[rand(0,3)];
            factory(\App\Models\Inquiry::class)->create($model->toFillableArray());
        }
    }
}
