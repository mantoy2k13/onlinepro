<?php

use App\Models\User;
use Illuminate\Database\Seeder;

class PurchaseLogTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach (range(1, 300) as $index) {
            $user = User::inRandomOrder()->first();
            $model = factory(\App\Models\PurchaseLog::class)->make();

            $model->user_id = $user->id;
            $model->point_amount = rand(1,100);
            $model->purchase_method_type = 'purchase';
            $model->purchase_info = '';
            factory(\App\Models\PurchaseLog::class)->create($model->toFillableArray());
        }
    }
}
