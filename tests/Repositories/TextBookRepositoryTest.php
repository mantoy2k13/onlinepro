<?php namespace Tests\Repositories;

use App\Models\TextBook;
use Tests\TestCase;

class TextBookRepositoryTest extends TestCase
{
    protected $useDatabase = true;

    public function testGetInstance()
    {
        /** @var  \App\Repositories\TextBookRepositoryInterface $repository */
        $repository = \App::make(\App\Repositories\TextBookRepositoryInterface::class);
        $this->assertNotNull($repository);
    }

    public function testGetList()
    {
        $textBooks = factory(TextBook::class, 3)->create();
        $textBookIds = $textBooks->pluck('id')->toArray();

        /** @var  \App\Repositories\TextBookRepositoryInterface $repository */
        $repository = \App::make(\App\Repositories\TextBookRepositoryInterface::class);
        $this->assertNotNull($repository);

        $textBooksCheck = $repository->get('id', 'asc', 0, 1);
        $this->assertInstanceOf(TextBook::class, $textBooksCheck[0]);

        $textBooksCheck = $repository->getByIds($textBookIds);
        $this->assertEquals(3, count($textBooksCheck));
    }

    public function testFind()
    {
        $textBooks = factory(TextBook::class, 3)->create();
        $textBookIds = $textBooks->pluck('id')->toArray();

        /** @var  \App\Repositories\TextBookRepositoryInterface $repository */
        $repository = \App::make(\App\Repositories\TextBookRepositoryInterface::class);
        $this->assertNotNull($repository);

        $textBookCheck = $repository->find($textBookIds[0]);
        $this->assertEquals($textBookIds[0], $textBookCheck->id);
    }

    public function testCreate()
    {
        $textBookData = factory(TextBook::class)->make();

        /** @var  \App\Repositories\TextBookRepositoryInterface $repository */
        $repository = \App::make(\App\Repositories\TextBookRepositoryInterface::class);
        $this->assertNotNull($repository);

        $textBookCheck = $repository->create($textBookData->toFillableArray());
        $this->assertNotNull($textBookCheck);
    }

    public function testUpdate()
    {
        $textBookData = factory(TextBook::class)->create();

        /** @var  \App\Repositories\TextBookRepositoryInterface $repository */
        $repository = \App::make(\App\Repositories\TextBookRepositoryInterface::class);
        $this->assertNotNull($repository);

        $textBookCheck = $repository->update($textBookData, $textBookData->toFillableArray());
        $this->assertNotNull($textBookCheck);
    }

    public function testDelete()
    {
        $textBookData = factory(TextBook::class)->create();

        /** @var  \App\Repositories\TextBookRepositoryInterface $repository */
        $repository = \App::make(\App\Repositories\TextBookRepositoryInterface::class);
        $this->assertNotNull($repository);

        $repository->delete($textBookData);

        $textBookCheck = $repository->find($textBookData->id);
        $this->assertNull($textBookCheck);
    }

}
