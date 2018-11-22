<?php namespace Tests\Models;

use App\Models\Inquiry;
use Tests\TestCase;

class InquiryTest extends TestCase
{

    protected $useDatabase = true;

    public function testGetInstance()
    {
        /** @var  \App\Models\Inquiry $inquiry */
        $inquiry = new Inquiry();
        $this->assertNotNull($inquiry);
    }

    public function testStoreNew()
    {
        /** @var  \App\Models\Inquiry $inquiry */
        $inquiryModel = new Inquiry();

        $inquiryData = factory(Inquiry::class)->make();
        foreach( $inquiryData->toArray() as $key => $value ) {
            $inquiryModel->$key = $value;
        }
        $inquiryModel->save();

        $this->assertNotNull(Inquiry::find($inquiryModel->id));
    }

}
