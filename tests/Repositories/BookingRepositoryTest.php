<?php namespace Tests\Repositories;

use App\Models\Booking;
use Tests\TestCase;

class BookingRepositoryTest extends TestCase
{
    protected $useDatabase = true;

    public function testGetInstance()
    {
        /** @var  \App\Repositories\BookingRepositoryInterface $repository */
        $repository = \App::make(\App\Repositories\BookingRepositoryInterface::class);
        $this->assertNotNull($repository);
    }

    public function testGetList()
    {
        $bookings = factory(Booking::class, 3)->create();
        $bookingIds = $bookings->pluck('id')->toArray();

        /** @var  \App\Repositories\BookingRepositoryInterface $repository */
        $repository = \App::make(\App\Repositories\BookingRepositoryInterface::class);
        $this->assertNotNull($repository);

        $bookingsCheck = $repository->get('id', 'asc', 0, 1);
        $this->assertInstanceOf(Booking::class, $bookingsCheck[0]);

        $bookingsCheck = $repository->getByIds($bookingIds);
        $this->assertEquals(3, count($bookingsCheck));
    }

    public function testFind()
    {
        $bookings = factory(Booking::class, 3)->create();
        $bookingIds = $bookings->pluck('id')->toArray();

        /** @var  \App\Repositories\BookingRepositoryInterface $repository */
        $repository = \App::make(\App\Repositories\BookingRepositoryInterface::class);
        $this->assertNotNull($repository);

        $bookingCheck = $repository->find($bookingIds[0]);
        $this->assertEquals($bookingIds[0], $bookingCheck->id);
    }

    public function testCreate()
    {
        $bookingData = factory(Booking::class)->make();

        /** @var  \App\Repositories\BookingRepositoryInterface $repository */
        $repository = \App::make(\App\Repositories\BookingRepositoryInterface::class);
        $this->assertNotNull($repository);

        $bookingCheck = $repository->create($bookingData->toArray());
        $this->assertNotNull($bookingCheck);
    }

    public function testUpdate()
    {
        $bookingData = factory(Booking::class)->create();

        /** @var  \App\Repositories\BookingRepositoryInterface $repository */
        $repository = \App::make(\App\Repositories\BookingRepositoryInterface::class);
        $this->assertNotNull($repository);

        $bookingCheck = $repository->update($bookingData, $bookingData->toArray());
        $this->assertNotNull($bookingCheck);
    }

    public function testDelete()
    {
        $bookingData = factory(Booking::class)->create();

        /** @var  \App\Repositories\BookingRepositoryInterface $repository */
        $repository = \App::make(\App\Repositories\BookingRepositoryInterface::class);
        $this->assertNotNull($repository);

        $repository->delete($bookingData);

        $bookingCheck = $repository->find($bookingData->id);
        $this->assertNull($bookingCheck);
    }

}
