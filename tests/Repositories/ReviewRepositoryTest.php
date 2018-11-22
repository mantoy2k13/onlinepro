<?php namespace Tests\Repositories;

use App\Models\Review;
use Tests\TestCase;

class ReviewRepositoryTest extends TestCase
{
    protected $useDatabase = true;

    public function testGetInstance()
    {
        /** @var  \App\Repositories\ReviewRepositoryInterface $repository */
        $repository = \App::make(\App\Repositories\ReviewRepositoryInterface::class);
        $this->assertNotNull($repository);
    }

    public function testGetList()
    {
        $reviews = factory(Review::class, 3)->create();
        $reviewIds = $reviews->pluck('id')->toArray();

        /** @var  \App\Repositories\ReviewRepositoryInterface $repository */
        $repository = \App::make(\App\Repositories\ReviewRepositoryInterface::class);
        $this->assertNotNull($repository);

        $reviewsCheck = $repository->get('id', 'asc', 0, 1);
        $this->assertInstanceOf(Review::class, $reviewsCheck[0]);

        $reviewsCheck = $repository->getByIds($reviewIds);
        $this->assertEquals(3, count($reviewsCheck));
    }

    public function testFind()
    {
        $reviews = factory(Review::class, 3)->create();
        $reviewIds = $reviews->pluck('id')->toArray();

        /** @var  \App\Repositories\ReviewRepositoryInterface $repository */
        $repository = \App::make(\App\Repositories\ReviewRepositoryInterface::class);
        $this->assertNotNull($repository);

        $reviewCheck = $repository->find($reviewIds[0]);
        $this->assertEquals($reviewIds[0], $reviewCheck->id);
    }

    public function testCreate()
    {
        $reviewData = factory(Review::class)->make();

        /** @var  \App\Repositories\ReviewRepositoryInterface $repository */
        $repository = \App::make(\App\Repositories\ReviewRepositoryInterface::class);
        $this->assertNotNull($repository);

        $reviewCheck = $repository->create($reviewData->toArray());
        $this->assertNotNull($reviewCheck);
    }

    public function testUpdate()
    {
        $reviewData = factory(Review::class)->create();

        /** @var  \App\Repositories\ReviewRepositoryInterface $repository */
        $repository = \App::make(\App\Repositories\ReviewRepositoryInterface::class);
        $this->assertNotNull($repository);

        $reviewCheck = $repository->update($reviewData, $reviewData->toArray());
        $this->assertNotNull($reviewCheck);
    }

    public function testDelete()
    {
        $reviewData = factory(Review::class)->create();

        /** @var  \App\Repositories\ReviewRepositoryInterface $repository */
        $repository = \App::make(\App\Repositories\ReviewRepositoryInterface::class);
        $this->assertNotNull($repository);

        $repository->delete($reviewData);

        $reviewCheck = $repository->find($reviewData->id);
        $this->assertNull($reviewCheck);
    }

}
