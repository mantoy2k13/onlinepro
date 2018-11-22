<?php

use App\Models\Image;
use Illuminate\Database\Seeder;

class TeacherTableSeeder extends Seeder
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
            $model = factory(\App\Models\Teacher::class)->make();

            $model->profile_image_id = $image->id;
            $model->last_notification_id = 0;
            $model->living_city_id = 0;
            $model->home_province_id = rand(1,4);
            $model->living_country_code = $array[rand(0,3)];
            $model->nationality_country_code = $array[rand(0,3)];
            factory(\App\Models\Teacher::class)->create($model->toFillableArray());
        }
    }
}
