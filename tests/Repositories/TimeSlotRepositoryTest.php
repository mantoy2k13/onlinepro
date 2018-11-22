<?php namespace Tests\Repositories;

use App\Models\TimeSlot;
use Tests\TestCase;

class TimeSlotRepositoryTest extends TestCase
{
    protected $useDatabase = true;

    public function testGetInstance()
    {
        /** @var  \App\Repositories\TimeSlotRepositoryInterface $repository */
        $repository = \App::make(\App\Repositories\TimeSlotRepositoryInterface::class);
        $this->assertNotNull($repository);
    }

    public function testGetList()
    {
        $timeSlots = factory(TimeSlot::class, 3)->create();
        $timeSlotIds = $timeSlots->pluck('id')->toArray();

        /** @var  \App\Repositories\TimeSlotRepositoryInterface $repository */
        $repository = \App::make(\App\Repositories\TimeSlotRepositoryInterface::class);
        $this->assertNotNull($repository);

        $timeSlotsCheck = $repository->get('id', 'asc', 0, 1);
        $this->assertInstanceOf(TimeSlot::class, $timeSlotsCheck[0]);

        $timeSlotsCheck = $repository->getByIds($timeSlotIds);
        $this->assertEquals(3, count($timeSlotsCheck));
    }

    public function testFind()
    {
        $timeSlots = factory(TimeSlot::class, 3)->create();
        $timeSlotIds = $timeSlots->pluck('id')->toArray();

        /** @var  \App\Repositories\TimeSlotRepositoryInterface $repository */
        $repository = \App::make(\App\Repositories\TimeSlotRepositoryInterface::class);
        $this->assertNotNull($repository);

        $timeSlotCheck = $repository->find($timeSlotIds[0]);
        $this->assertEquals($timeSlotIds[0], $timeSlotCheck->id);
    }

    public function testCreate()
    {
        $timeSlotData = factory(TimeSlot::class)->make();

        /** @var  \App\Repositories\TimeSlotRepositoryInterface $repository */
        $repository = \App::make(\App\Repositories\TimeSlotRepositoryInterface::class);
        $this->assertNotNull($repository);

        $timeSlotCheck = $repository->create($timeSlotData->toArray());
        $this->assertNotNull($timeSlotCheck);
    }

    public function testUpdate()
    {
        $timeSlotData = factory(TimeSlot::class)->create();

        /** @var  \App\Repositories\TimeSlotRepositoryInterface $repository */
        $repository = \App::make(\App\Repositories\TimeSlotRepositoryInterface::class);
        $this->assertNotNull($repository);

        $timeSlotCheck = $repository->update($timeSlotData, $timeSlotData->toArray());
        $this->assertNotNull($timeSlotCheck);
    }

    public function testDelete()
    {
        $timeSlotData = factory(TimeSlot::class)->create();

        /** @var  \App\Repositories\TimeSlotRepositoryInterface $repository */
        $repository = \App::make(\App\Repositories\TimeSlotRepositoryInterface::class);
        $this->assertNotNull($repository);

        $repository->delete($timeSlotData);

        $timeSlotCheck = $repository->find($timeSlotData->id);
        $this->assertNull($timeSlotCheck);
    }

}
