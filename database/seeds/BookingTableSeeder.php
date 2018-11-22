<?php

use App\Models\Booking;
use App\Models\Category;
use App\Models\PaymentLog;
use App\Models\Teacher;
use App\Models\TimeSlot;
use App\Models\User;
use Illuminate\Database\Seeder;

class BookingTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $status = array("pending", "canceled", "finished");
        foreach (range(1, 300) as $index) {
            $category = Category::inRandomOrder()->first();
            $teacher = Teacher::inRandomOrder()->first();
            $user = User::inRandomOrder()->first();
            $timeSlot = TimeSlot::inRandomOrder()->first();
            $paymentLog = PaymentLog::inRandomOrder()->first();
            $model = factory(\App\Models\Booking::class)->make();
            $model->user_id = $user->id;
            $model->teacher_id = $teacher->id;
            $model->status = $status[rand(0, 2)];
            $model->time_slot_id = $timeSlot->id;
            $model->payment_log_id = $paymentLog->id;
            $model->message = '';
            $model->category_id = $category->id;
            factory(\App\Models\Booking::class)->create($model->toFillableArray());
        }
    }
}
