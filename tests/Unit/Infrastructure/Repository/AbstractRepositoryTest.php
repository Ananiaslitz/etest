<?php

namespace Tests\Unit\Infrastructure\Repository;

use Core\Infrastructure\Repository\AbstractRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Mockery;
use Tests\TestCase;

class AbstractRepositoryTest extends TestCase
{
    private $modelMock;
    private $repository;

    protected function setUp(): void
    {
        parent::setUp();
        $this->modelMock = \Mockery::mock(Model::class);
        $this->repository = new class($this->modelMock) extends AbstractRepository {
            public function __construct(Model $model)
            {
                parent::__construct($model);
            }
        };
    }
    public function tearDown(): void
    {
        Mockery::close();
    }

    public function testAllReturnsCollectionOfModels()
    {
        $this->modelMock->shouldReceive('all')->once()->andReturn(new Collection(['fakeModel']));

        $result = $this->repository->all();

        $this->assertInstanceOf(Collection::class, $result);
        $this->assertCount(1, $result);
    }

    public function testFindReturnsModel()
    {
        $modelId = 1;
        $fakeModel = Mockery::mock(Model::class);
        $this->modelMock->shouldReceive('findOrFail')->with($modelId)->once()->andReturn($fakeModel);

        $result = $this->repository->find($modelId);

        $this->assertInstanceOf(Model::class, $result);
    }

    public function testCreateStoresModelAndReturnsIt()
    {
        $data = ['name' => 'Test Name'];
        $fakeModel = Mockery::mock(Model::class);
        $this->modelMock->shouldReceive('create')->with($data)->once()->andReturn($fakeModel);

        $result = $this->repository->create($data);

        $this->assertInstanceOf(Model::class, $result);
    }

    public function testDeleteRemovesModel()
    {
        $modelId = 1;
        $fakeModelInstance = Mockery::mock(Model::class);
        $fakeModelInstance->shouldReceive('delete')->withNoArgs()->once()->andReturn(true);

        $this->modelMock->shouldReceive('findOrFail')->with($modelId)->once()->andReturn($fakeModelInstance);

        $result = $this->repository->delete($modelId);

        $this->assertTrue($result);
    }
}
