<?php namespace Tests\Repositories;

use App\Models\Personality;
use Tests\TestCase;

class PersonalityRepositoryTest extends TestCase
{
    protected $useDatabase = true;

    public function testGetInstance()
    {
        /** @var  \App\Repositories\PersonalityRepositoryInterface $repository */
        $repository = \App::make(\App\Repositories\PersonalityRepositoryInterface::class);
        $this->assertNotNull($repository);
    }

    public function testGetList()
    {
        $personalities = factory(Personality::class, 3)->create();
        $personalityIds = $personalities->pluck('id')->toArray();

        /** @var  \App\Repositories\PersonalityRepositoryInterface $repository */
        $repository = \App::make(\App\Repositories\PersonalityRepositoryInterface::class);
        $this->assertNotNull($repository);

        $personalitiesCheck = $repository->get('id', 'asc', 0, 1);
        $this->assertInstanceOf(Personality::class, $personalitiesCheck[0]);

        $personalitiesCheck = $repository->getByIds($personalityIds);
        $this->assertEquals(3, count($personalitiesCheck));
    }

    public function testFind()
    {
        $personalities = factory(Personality::class, 3)->create();
        $personalityIds = $personalities->pluck('id')->toArray();

        /** @var  \App\Repositories\PersonalityRepositoryInterface $repository */
        $repository = \App::make(\App\Repositories\PersonalityRepositoryInterface::class);
        $this->assertNotNull($repository);

        $personalityCheck = $repository->find($personalityIds[0]);
        $this->assertEquals($personalityIds[0], $personalityCheck->id);
    }

    public function testCreate()
    {
        $personalityData = factory(Personality::class)->make();

        /** @var  \App\Repositories\PersonalityRepositoryInterface $repository */
        $repository = \App::make(\App\Repositories\PersonalityRepositoryInterface::class);
        $this->assertNotNull($repository);

        $personalityCheck = $repository->create($personalityData->toArray());
        $this->assertNotNull($personalityCheck);
    }

    public function testUpdate()
    {
        $personalityData = factory(Personality::class)->create();

        /** @var  \App\Repositories\PersonalityRepositoryInterface $repository */
        $repository = \App::make(\App\Repositories\PersonalityRepositoryInterface::class);
        $this->assertNotNull($repository);

        $personalityCheck = $repository->update($personalityData, $personalityData->toArray());
        $this->assertNotNull($personalityCheck);
    }

    public function testDelete()
    {
        $personalityData = factory(Personality::class)->create();

        /** @var  \App\Repositories\PersonalityRepositoryInterface $repository */
        $repository = \App::make(\App\Repositories\PersonalityRepositoryInterface::class);
        $this->assertNotNull($repository);

        $repository->delete($personalityData);

        $personalityCheck = $repository->find($personalityData->id);
        $this->assertNull($personalityCheck);
    }

}
