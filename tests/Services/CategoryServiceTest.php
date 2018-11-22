<?php namespace Tests\Services;

use Tests\TestCase;

class CategoryServiceTest extends TestCase
{

    public function testGetInstance()
    {
        /** @var  \App\Services\CategoryServiceInterface $service */
        $service = \App::make(\App\Services\CategoryServiceInterface::class);
        $this->assertNotNull($service);
    }

}
