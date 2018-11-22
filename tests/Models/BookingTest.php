<?php namespace Tests\Models;

use App\Models\Booking;
use Tests\TestCase;

class BookingTest extends TestCase
{

    protected $useDatabase = true;

    public function testGetInstance()
    {
        /** @var  \App\Models\Booking $booking */
        $booking = new Booking();
        $this->assertNotNull($booking);
    }

    public function testStoreNew()
    {
        /** @var  \App\Models\Booking $booking */
        $bookingModel = new Booking();

        $bookingData = factory(Booking::class)->make();
        foreach( $bookingData->toArray() as $key => $value ) {
            $bookingModel->$key = $value;
        }
        $bookingModel->save();

        $this->assertNotNull(Booking::find($bookingModel->id));
    }

}
