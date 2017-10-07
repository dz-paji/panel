<?php
/**
 * Pterodactyl - Panel
 * Copyright (c) 2015 - 2017 Dane Everitt <dane@daneeveritt.com>.
 *
 * This software is licensed under the terms of the MIT license.
 * https://opensource.org/licenses/MIT
 */

namespace Tests\Unit\Services\Services;

use Mockery as m;
use Tests\TestCase;
use Ramsey\Uuid\Uuid;
use Pterodactyl\Models\Nest;
use Illuminate\Contracts\Config\Repository;
use Pterodactyl\Traits\Services\CreatesServiceIndex;
use Pterodactyl\Services\Services\NestCreationService;
use Pterodactyl\Contracts\Repository\NestRepositoryInterface;

class ServiceCreationServiceTest extends TestCase
{
    use CreatesServiceIndex;

    /**
     * @var \Illuminate\Contracts\Config\Repository|\Mockery\Mock
     */
    protected $config;

    /**
     * @var \Pterodactyl\Contracts\Repository\NestRepositoryInterface|\Mockery\Mock
     */
    protected $repository;

    /**
     * @var \Pterodactyl\Services\Services\NestCreationService
     */
    protected $service;

    /**
     * @var \Ramsey\Uuid\Uuid|\Mockery\Mock
     */
    protected $uuid;

    /**
     * Setup tests.
     */
    public function setUp()
    {
        parent::setUp();

        $this->config = m::mock(Repository::class);
        $this->repository = m::mock(NestRepositoryInterface::class);
        $this->uuid = m::mock('overload:' . Uuid::class);

        $this->service = new NestCreationService($this->config, $this->repository);
    }

    /**
     * Test that a new service can be created using the correct data.
     */
    public function testCreateNewService()
    {
        $model = factory(Nest::class)->make();
        $data = [
            'name' => $model->name,
            'description' => $model->description,
            'folder' => $model->folder,
            'startup' => $model->startup,
        ];

        $this->uuid->shouldReceive('uuid4->toString')->withNoArgs()->once()->andReturn('uuid-0000');
        $this->config->shouldReceive('get')->with('pterodactyl.service.author')->once()->andReturn('0000-author');
        $this->repository->shouldReceive('create')->with([
            'uuid' => 'uuid-0000',
            'author' => '0000-author',
            'name' => $data['name'],
            'description' => $data['description'],
            'startup' => $data['startup'],
            'index_file' => $this->getIndexScript(),
        ], true, true)->once()->andReturn($model);

        $response = $this->service->handle($data);
        $this->assertInstanceOf(Nest::class, $response);
        $this->assertEquals($model, $response);
    }
}
