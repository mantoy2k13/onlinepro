<?php namespace Tests\Services;

use Tests\TestCase;

class ExcelServiceTest extends TestCase
{

    public function testGetInstance()
    {
        /** @var  \App\Services\ExcelServiceInterface $service */
        $service = \App::make(\App\Services\ExcelServiceInterface::class);
        $this->assertNotNull($service);
    }

}
