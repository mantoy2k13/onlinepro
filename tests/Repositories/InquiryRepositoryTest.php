<?php namespace Tests\Repositories;

use App\Models\Inquiry;
use Tests\TestCase;

class InquiryRepositoryTest extends TestCase
{
    protected $useDatabase = true;

    public function testGetInstance()
    {
        /** @var  \App\Repositories\InquiryRepositoryInterface $repository */
        $repository = \App::make(\App\Repositories\InquiryRepositoryInterface::class);
        $this->assertNotNull($repository);
    }

    public function testGetList()
    {
        $inquiries = factory(Inquiry::class, 3)->create();
        $inquiryIds = $inquiries->pluck('id')->toArray();

        /** @var  \App\Repositories\InquiryRepositoryInterface $repository */
        $repository = \App::make(\App\Repositories\InquiryRepositoryInterface::class);
        $this->assertNotNull($repository);

        $inquiriesCheck = $repository->get('id', 'asc', 0, 1);
        $this->assertInstanceOf(Inquiry::class, $inquiriesCheck[0]);

        $inquiriesCheck = $repository->getByIds($inquiryIds);
        $this->assertEquals(3, count($inquiriesCheck));
    }

    public function testFind()
    {
        $inquiries = factory(Inquiry::class, 3)->create();
        $inquiryIds = $inquiries->pluck('id')->toArray();

        /** @var  \App\Repositories\InquiryRepositoryInterface $repository */
        $repository = \App::make(\App\Repositories\InquiryRepositoryInterface::class);
        $this->assertNotNull($repository);

        $inquiryCheck = $repository->find($inquiryIds[0]);
        $this->assertEquals($inquiryIds[0], $inquiryCheck->id);
    }

    public function testCreate()
    {
        $inquiryData = factory(Inquiry::class)->make();

        /** @var  \App\Repositories\InquiryRepositoryInterface $repository */
        $repository = \App::make(\App\Repositories\InquiryRepositoryInterface::class);
        $this->assertNotNull($repository);

        $inquiryCheck = $repository->create($inquiryData->toArray());
        $this->assertNotNull($inquiryCheck);
    }

    public function testUpdate()
    {
        $inquiryData = factory(Inquiry::class)->create();

        /** @var  \App\Repositories\InquiryRepositoryInterface $repository */
        $repository = \App::make(\App\Repositories\InquiryRepositoryInterface::class);
        $this->assertNotNull($repository);

        $inquiryCheck = $repository->update($inquiryData, $inquiryData->toArray());
        $this->assertNotNull($inquiryCheck);
    }

    public function testDelete()
    {
        $inquiryData = factory(Inquiry::class)->create();

        /** @var  \App\Repositories\InquiryRepositoryInterface $repository */
        $repository = \App::make(\App\Repositories\InquiryRepositoryInterface::class);
        $this->assertNotNull($repository);

        $repository->delete($inquiryData);

        $inquiryCheck = $repository->find($inquiryData->id);
        $this->assertNull($inquiryCheck);
    }

}
