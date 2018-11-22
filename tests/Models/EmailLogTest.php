<?php namespace Tests\Models;

use App\Models\EmailLog;
use Tests\TestCase;

class EmailLogTest extends TestCase
{

    protected $useDatabase = true;

    public function testGetInstance()
    {
        /** @var  \App\Models\EmailLog $emailLog */
        $emailLog = new EmailLog();
        $this->assertNotNull($emailLog);
    }

    public function testStoreNew()
    {
        /** @var  \App\Models\EmailLog $emailLog */
        $emailLogModel = new EmailLog();

        $emailLogData = factory(EmailLog::class)->make();
        foreach( $emailLogData->toFillableArray() as $key => $value ) {
            $emailLogModel->$key = $value;
        }
        $emailLogModel->save();

        $this->assertNotNull(EmailLog::find($emailLogModel->id));
    }

}
