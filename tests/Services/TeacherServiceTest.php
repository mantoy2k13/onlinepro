<?php namespace Tests\Services;

use Tests\TestCase;

class TeacherServiceTest extends TestCase
{

    public function testGetInstance()
    {
        /** @var  \App\Services\TeacherServiceInterface $service */
        $service = \App::make(\App\Services\TeacherServiceInterface::class);
        $this->assertNotNull($service);
    }

}
