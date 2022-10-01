<?php

namespace App\DataFixtures;

use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CategoryFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
         $category = new Category();
         $category->setName('boots');
         $manager->persist($category);

        $category1 = new Category();
        $category1->setName('sandals');
        $manager->persist($category1);

        $category2 = new Category();
        $category2->setName('sneakers');
        $manager->persist($category2);

        $manager->flush();
    }
}
