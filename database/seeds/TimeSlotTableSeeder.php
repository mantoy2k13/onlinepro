<?php

use App\Models\Teacher;
use Illuminate\Database\Seeder;

class TimeSlotTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        foreach (range(1, 500) as $index) {
            $faker = Faker\Factory::create();
            $time = config('timeslot.timeSlot')[rand(0,19)];
            $date = $faker->dateTimeThisYear('+1 month');
            $date = $date->format('Y-m-d');
            $datetime = $date . ' ' .$time;

            $startAt = \DateTimeHelper::convertToStorageDateTime($datetime);
            $endAt = \DateTimeHelper::convertToStorageDateTime($datetime);
            $endAt = $endAt->addMinutes(config('timeslot.start_end_config_in_minute'));

            $teacher = Teacher::inRandomOrder()->first();

            $model = factory(\App\Models\TimeSlot::class)->make();
            $model->start_at = $startAt;
            $model->end_at = $endAt;
            $model->teacher_id = $teacher->id;
            factory(\App\Models\TimeSlot::class)->create($model->toFillableArray());
        }
    }
}
