<?php namespace Tests\Models;

use App\Models\PurchaseLog;
use Tests\TestCase;

class PurchaseLogTest extends TestCase
{

    protected $useDatabase = true;

    public function testGetInstance()
    {
        /** @var  \App\Models\PurchaseLog $purchaseLog */
        $purchaseLog = new PurchaseLog();
        $this->assertNotNull($purchaseLog);
    }

    public function testStoreNew()
    {
        /** @var  \App\Models\PurchaseLog $purchaseLog */
        $purchaseLogModel = new PurchaseLog();

        $purchaseLogData = factory(PurchaseLog::class)->make();
        foreach( $purchaseLogData->toArray() as $key => $value ) {
            $purchaseLogModel->$key = $value;
        }
        $purchaseLogModel->save();

        $this->assertNotNull(PurchaseLog::find($purchaseLogModel->id));
    }

}
