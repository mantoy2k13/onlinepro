<?php namespace Tests\Services;

use Tests\TestCase;

class BookingServiceTest extends TestCase
{

    public function testGetInstance()
    {
        /** @var  \App\Services\BookingServiceInterface $service */
        $service = \App::make(\App\Services\BookingServiceInterface::class);
        $this->assertNotNull($service);
    }

}
