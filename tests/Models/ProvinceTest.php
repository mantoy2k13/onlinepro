<?php namespace Tests\Models;

use App\Models\Province;
use Tests\TestCase;

class ProvinceTest extends TestCase
{

    protected $useDatabase = true;

    public function testGetInstance()
    {
        /** @var  \App\Models\Province $province */
        $province = new Province();
        $this->assertNotNull($province);
    }

    public function testStoreNew()
    {
        /** @var  \App\Models\Province $province */
        $provinceModel = new Province();

        $provinceData = factory(Province::class)->make();
        foreach( $provinceData->toArray() as $key => $value ) {
            $provinceModel->$key = $value;
        }
        $provinceModel->save();

        $this->assertNotNull(Province::find($provinceModel->id));
    }

}
