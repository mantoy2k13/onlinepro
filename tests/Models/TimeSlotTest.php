<?php namespace Tests\Models;

use App\Models\TimeSlot;
use Tests\TestCase;

class TimeSlotTest extends TestCase
{

    protected $useDatabase = true;

    public function testGetInstance()
    {
        /** @var  \App\Models\TimeSlot $timeSlot */
        $timeSlot = new TimeSlot();
        $this->assertNotNull($timeSlot);
    }

    public function testStoreNew()
    {
        /** @var  \App\Models\TimeSlot $timeSlot */
        $timeSlotModel = new TimeSlot();

        $timeSlotData = factory(TimeSlot::class)->make();
        foreach( $timeSlotData->toArray() as $key => $value ) {
            $timeSlotModel->$key = $value;
        }
        $timeSlotModel->save();

        $this->assertNotNull(TimeSlot::find($timeSlotModel->id));
    }

}
