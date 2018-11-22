<?php

use Illuminate\Database\Seeder;

class ImageTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach (range(1, 100) as $index) {
            $model = factory(\App\Models\Image::class)->make();
            factory(\App\Models\Image::class)->create($model->toFillableArray());
        }
    }
}
