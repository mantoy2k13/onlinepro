<?php

use App\Models\Booking;
use App\Models\User;
use Illuminate\Database\Seeder;

class PointLogTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $type = array("booking", "refund", "purchase");
        foreach (range(1, 300) as $index) {
            $booking = Booking::inRandomOrder()->first();
            $user = User::inRandomOrder()->first();
            $model = factory(\App\Models\PointLog::class)->make();
            $model->user_id = $user->id;
            $model->related_id = rand(1,300);
            $model->point_amount = -1;
            $model->type = $type[rand(0, 2)];
            $model->description = '';
            $model->related_id = $booking->id;
            factory(\App\Models\PointLog::class)->create($model->toFillableArray());
        }
    }
}
