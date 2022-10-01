<?php

namespace App\Tests\Functions;

use App\DataFixtures\CategoryFixtures;
use App\DataFixtures\ProductFixtures;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Tools\SchemaTool;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Request;

class ProductControllerTest extends WebTestCase
{
    protected EntityManagerInterface $entityManager;
    protected Request $request;
    protected $client;

    protected function setUp(): void
    {
        parent::setUp();
        $this->client = static::createClient();
        $entityManager = $this->client->getContainer()->get('doctrine.orm.entity_manager');
        $metaData = $entityManager->getMetadataFactory()->getAllMetadata();
        $schemaTool = new SchemaTool($entityManager);
        $schemaTool->updateSchema($metaData);

        $entityManager = $this->client->getContainer()
            ->get('doctrine')
            ->getManager();
        $categoryFixture = new CategoryFixtures();
        $productFixture = new ProductFixtures();
        $categoryFixture->load($entityManager);
        $productFixture->load($entityManager);

        $this->request =  new Request();
        $this->entityManager = $this->client->getContainer()
            ->get('doctrine')
            ->getManager();
    }

    protected function tearDown(): void
    {
        parent::tearDown();

        $this->entityManager->close();
    }

    public function testProductGetAll(): void
    {

        $this->client->request('GET', '/api/v1/products');
        $response = json_decode($this->client->getResponse()->getContent(),true);
        $this->assertCount(5,$response);
        $first = $response[0];
        $this->assertArrayHasKey('name',$first);
        $this->assertArrayHasKey('price',$first);
        $this->assertArrayHasKey('category',$first);
        $this->assertArrayHasKey('sku',$first);
        $this->assertArrayHasKey('original',$first['price']);
        $this->assertArrayHasKey('final',$first['price']);
        $this->assertArrayHasKey('currency',$first['price']);
        $this->assertArrayHasKey('discount_percentage',$first['price']);
        $this->assertSame('EUR',$first['price']['currency']);
        $this->assertIsArray($response);
        $this->assertResponseIsSuccessful();
    }

    public function testProductGetAllWithCategoryParam(): void
    {
        $this->client->request('GET', '/api/v1/products?category=boots');
        $response = json_decode($this->client->getResponse()->getContent(),true);
        $first = $response[0];
        $this->assertSame('boots',$first['category']);
        $this->assertNotEquals('sandals',$first['category']);
        $this->assertNotEquals('sneakers',$first['category']);
        $this->assertIsArray($response);
        $this->assertResponseIsSuccessful();
    }

    public function testProductGetAllWithPriceLessThanParam(): void
    {
        $price = 79500;
        $this->client->request('GET', "/api/v1/products?priceLessThan=$price");
        $response = json_decode($this->client->getResponse()->getContent(),true);
        $first = $response[0];
        $this->assertLessThanOrEqual($price,$first['price']['original']);
        $this->assertIsArray($response);
        $this->assertResponseIsSuccessful();
    }

    public function testCheckDiscountApplied(): void
    {
        $this->client->request('GET', '/api/v1/products?category=boots');
        $response = json_decode($this->client->getResponse()->getContent(),true);
        $first = $response[0];
        $discountedPercentage = '30%';
        $price =  $first['price']['original'];
        $discountedPrice =  $price -  ((30/100) * $price);
        $this->assertSame($discountedPercentage,$first['price']['discount_percentage']);
        $this->assertEquals($discountedPrice,$first['price']['final']);
        $this->assertIsArray($response);
        $this->assertResponseIsSuccessful();
    }

    public function testEmptyProductArray(): void
    {
        $this->client->request('GET', '/api/v1/products?category=jacket');
        $response = json_decode($this->client->getResponse()->getContent(),true);
        $this->assertCount(0,$response);
        $this->assertIsArray($response);
        $this->assertResponseIsSuccessful();
    }
}