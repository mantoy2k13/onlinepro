<?php

use App\Models\Booking;
use App\Models\Teacher;
use App\Models\User;
use Illuminate\Database\Seeder;

class ReviewTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $array = array("user",
            "teacher");
        foreach (range(1, 300) as $index) {
            $user = User::inRandomOrder()->first();
            $teacher = Teacher::inRandomOrder()->first();
            $booking = Booking::inRandomOrder()->first();
            $model = factory(\App\Models\Review::class)->make();

            $model->target = $array[rand(0,1)];
            $model->user_id = $user->id;
            $model->booking_id = $booking->id;
            $model->teacher_id = $teacher->id;
            $model->rating = rand(1,5);
            $model->content = '';
            factory(\App\Models\Review::class)->create($model->toFillableArray());
        }
    }
}
