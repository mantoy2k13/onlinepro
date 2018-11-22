<?php namespace Tests\Services;

use Tests\TestCase;

class LessonServiceTest extends TestCase
{

    public function testGetInstance()
    {
        /** @var  \App\Services\LessonServiceInterface $service */
        $service = \App::make(\App\Services\LessonServiceInterface::class);
        $this->assertNotNull($service);
    }

}
