<?php

namespace App\DataFixtures;

use App\Entity\Category;
use App\Entity\Product;
use App\Repository\ProductRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ProductFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $repo = $manager->getRepository(Category::class);
        foreach($this->payload() as $payload) {
            $category = $repo->findOneBy(['name' => $payload['category']]);
            $product = new Product();
            $product->setName($payload['name'])
                ->setSku($payload['sku'])
                ->setPrice($payload['price'])
                ->setCategory($category);
            $manager->persist($product);
        }

        $manager->flush();
    }

    private function payload():array
    {
        return [
            [
                "sku" => "000001",
                "name" => "BV Lean leather ankle boots",
                "category" => "boots",
                "price" => 89000

            ],
            [
                "sku" => "000002",
                "name" => "BV Lean leather ankle boots",
                "category" => "boots",
                "price" => 99000
            ],
            [
                "sku" => "000003",
                "name" => "Ashlington leather ankle boots",
                "category" => "boots",
                "price" => 71000
            ],
            [
                "sku" => "000004",
                "name" => "Naima embellished suede sandals",
                "category" => "sandals",
                "price" => 79500
            ],
            [
                "sku" => "000005",
                "name" => "Nathane leather sneakers",
                "category" => "sneakers",
                "price" => 59000
            ]
        ];
    }
}
