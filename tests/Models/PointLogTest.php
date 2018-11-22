<?php namespace Tests\Models;

use App\Models\PointLog;
use Tests\TestCase;

class PointLogTest extends TestCase
{

    protected $useDatabase = true;

    public function testGetInstance()
    {
        /** @var  \App\Models\PointLog $pointLog */
        $pointLog = new PointLog();
        $this->assertNotNull($pointLog);
    }

    public function testStoreNew()
    {
        /** @var  \App\Models\PointLog $pointLog */
        $pointLogModel = new PointLog();

        $pointLogData = factory(PointLog::class)->make();
        foreach( $pointLogData->toArray() as $key => $value ) {
            $pointLogModel->$key = $value;
        }
        $pointLogModel->save();

        $this->assertNotNull(PointLog::find($pointLogModel->id));
    }

}
