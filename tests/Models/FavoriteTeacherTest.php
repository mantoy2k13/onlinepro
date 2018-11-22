<?php namespace Tests\Models;

use App\Models\FavoriteTeacher;
use Tests\TestCase;

class FavoriteTeacherTest extends TestCase
{

    protected $useDatabase = true;

    public function testGetInstance()
    {
        /** @var  \App\Models\FavoriteTeacher $favoriteTeacher */
        $favoriteTeacher = new FavoriteTeacher();
        $this->assertNotNull($favoriteTeacher);
    }

    public function testStoreNew()
    {
        /** @var  \App\Models\FavoriteTeacher $favoriteTeacher */
        $favoriteTeacherModel = new FavoriteTeacher();

        $favoriteTeacherData = factory(FavoriteTeacher::class)->make();
        foreach( $favoriteTeacherData->toArray() as $key => $value ) {
            $favoriteTeacherModel->$key = $value;
        }
        $favoriteTeacherModel->save();

        $this->assertNotNull(FavoriteTeacher::find($favoriteTeacherModel->id));
    }

}
