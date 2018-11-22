<?php namespace Tests\Services;

use Tests\TestCase;

class PayPalServiceTest extends TestCase
{

    public function testGetInstance()
    {
        /** @var  \App\Services\PayPalServiceInterface $service */
        $service = \App::make(\App\Services\PayPalServiceInterface::class);
        $this->assertNotNull($service);
    }

}
