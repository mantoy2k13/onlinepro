<?php namespace Tests\Repositories;

use App\Models\Province;
use Tests\TestCase;

class ProvinceRepositoryTest extends TestCase
{
    protected $useDatabase = true;

    public function testGetInstance()
    {
        /** @var  \App\Repositories\ProvinceRepositoryInterface $repository */
        $repository = \App::make(\App\Repositories\ProvinceRepositoryInterface::class);
        $this->assertNotNull($repository);
    }

    public function testGetList()
    {
        $provinces = factory(Province::class, 3)->create();
        $provinceIds = $provinces->pluck('id')->toArray();

        /** @var  \App\Repositories\ProvinceRepositoryInterface $repository */
        $repository = \App::make(\App\Repositories\ProvinceRepositoryInterface::class);
        $this->assertNotNull($repository);

        $provincesCheck = $repository->get('id', 'asc', 0, 1);
        $this->assertInstanceOf(Province::class, $provincesCheck[0]);

        $provincesCheck = $repository->getByIds($provinceIds);
        $this->assertEquals(3, count($provincesCheck));
    }

    public function testFind()
    {
        $provinces = factory(Province::class, 3)->create();
        $provinceIds = $provinces->pluck('id')->toArray();

        /** @var  \App\Repositories\ProvinceRepositoryInterface $repository */
        $repository = \App::make(\App\Repositories\ProvinceRepositoryInterface::class);
        $this->assertNotNull($repository);

        $provinceCheck = $repository->find($provinceIds[0]);
        $this->assertEquals($provinceIds[0], $provinceCheck->id);
    }

    public function testCreate()
    {
        $provinceData = factory(Province::class)->make();

        /** @var  \App\Repositories\ProvinceRepositoryInterface $repository */
        $repository = \App::make(\App\Repositories\ProvinceRepositoryInterface::class);
        $this->assertNotNull($repository);

        $provinceCheck = $repository->create($provinceData->toArray());
        $this->assertNotNull($provinceCheck);
    }

    public function testUpdate()
    {
        $provinceData = factory(Province::class)->create();

        /** @var  \App\Repositories\ProvinceRepositoryInterface $repository */
        $repository = \App::make(\App\Repositories\ProvinceRepositoryInterface::class);
        $this->assertNotNull($repository);

        $provinceCheck = $repository->update($provinceData, $provinceData->toArray());
        $this->assertNotNull($provinceCheck);
    }

    public function testDelete()
    {
        $provinceData = factory(Province::class)->create();

        /** @var  \App\Repositories\ProvinceRepositoryInterface $repository */
        $repository = \App::make(\App\Repositories\ProvinceRepositoryInterface::class);
        $this->assertNotNull($repository);

        $repository->delete($provinceData);

        $provinceCheck = $repository->find($provinceData->id);
        $this->assertNull($provinceCheck);
    }

}
