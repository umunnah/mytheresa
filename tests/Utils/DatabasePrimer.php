<?php

namespace App\Tests\Utils;

use App\DataFixtures\CategoryFixtures;
use App\DataFixtures\ProductFixtures;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Tools\SchemaTool;
use LogicException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\KernelInterface;

class DatabasePrimer
{
    public static function prime(KernelInterface $kernel)
    {
        if ('test' !== $kernel->getEnvironment()) {
            throw new LogicException('Execution only in Test environment possible!');
        }
        $entityManager = $kernel->getContainer()->get('doctrine.orm.entity_manager');
        $metaData = $entityManager->getMetadataFactory()->getAllMetadata();
        $schemaTool = new SchemaTool($entityManager);
        $schemaTool->updateSchema($metaData);

        $entityManager = $kernel->getContainer()
            ->get('doctrine')
            ->getManager();
        $categoryFixture = new CategoryFixtures();
        $productFixture = new ProductFixtures();
        $categoryFixture->load($entityManager);
        $productFixture->load($entityManager);
    }

}