<?php

use App\Models\Image;
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
        $array = array("vn",  "th", "jp",  "id");

        foreach (range(1, 40) as $index) {
            $image = Image::inRandomOrder()->first();

            $user = factory(\App\Models\User::class)->make();
            $user->last_notification_id = 0;
            $user->profile_image_id = $image->id;
            $user->points = rand(1, 99);
            $user->living_city_id = 0;
            $user->living_country_code = $array[rand(0,3)];
            factory(\App\Models\User::class)->create($user->toFillableArray());
        }
    }
}
