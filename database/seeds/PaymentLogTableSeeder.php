<?php

use App\Models\Teacher;
use Illuminate\Database\Seeder;

class PaymentLogTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        foreach (range(1, 300) as $index) {
            $teacher = Teacher::inRandomOrder()->first();
            $faker = Faker\Factory::create();
            $model = factory(\App\Models\PaymentLog::class)->make();
            $model->teacher_id = $teacher->id;
            $model->paid_amount = rand(500,10000);
            $model->paid_for_month = $faker->dateTimeThisYear->format('Y-m');
            $model->paid_at = $faker->dateTimeThisYear->format('Y-m-d H:i:s');
            $model->status = 'paid';
            $model->note = '';
            factory(\App\Models\PaymentLog::class)->create($model->toFillableArray());
        }
    }
}
