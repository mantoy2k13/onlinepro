<?php namespace Tests\Services;

use Tests\TestCase;

class PointLogServiceTest extends TestCase
{

    public function testGetInstance()
    {
        /** @var  \App\Services\PointLogServiceInterface $service */
        $service = \App::make(\App\Services\PointLogServiceInterface::class);
        $this->assertNotNull($service);
    }

}
