<?php

namespace App\Tests\Unit;


use App\Entity\Product;
use App\Tests\Utils\DatabaseTestCase;

class ProductRepositoryTest extends DatabaseTestCase
{
    private $repository;

    protected function setUp(): void
    {
        parent::setUp();

    }

    protected function tearDown(): void
    {
        parent::tearDown();

        $this->entityManager->close();
    }

    public function testGetAll():void
    {
        $this->repository = $this->entityManager->getRepository(Product::class);
        $data = $this->repository->getAll($this->request->query->all());
        $this->assertCount(5,$data);
        $this->assertNotEmpty($data);
        $this->assertIsArray($data);
    }


}