<?php

use App\Models\Category;
use App\Models\Teacher;
use Illuminate\Database\Seeder;

class TeacherCategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach (range(1, 150) as $index) {
            $teacher = Teacher::inRandomOrder()->first();
            $category = Category::inRandomOrder()->first();
            $model = factory(\App\Models\TeacherCategory::class)->make();

            $model->teacher_id = $teacher->id;
            $model->category_id = $category->id;
            factory(\App\Models\TeacherCategory::class)->create($model->toFillableArray());
        }
    }
}
