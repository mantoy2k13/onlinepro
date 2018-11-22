<?php namespace Tests\Services;

use Tests\TestCase;

class TimeSlotServiceTest extends TestCase
{

    public function testGetInstance()
    {
        /** @var  \App\Services\TimeSlotServiceInterface $service */
        $service = \App::make(\App\Services\TimeSlotServiceInterface::class);
        $this->assertNotNull($service);
    }

}
