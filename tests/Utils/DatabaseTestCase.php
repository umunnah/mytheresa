<?php

declare(strict_types = 1);

namespace App\Tests\Utils;

use App\DataFixtures\CategoryFixtures;
use App\DataFixtures\ProductFixtures;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Tools\SchemaTool;
use LogicException;
use PDO;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\KernelInterface;

class DatabaseTestCase extends KernelTestCase
{
    protected EntityManagerInterface $entityManager;
    protected Request $request;

    protected function setUp(): void
    {
        $kernel = self::bootKernel();

        DatabasePrimer::prime($kernel);

        $this->request =  new Request();
        $this->entityManager = $kernel->getContainer()
            ->get('doctrine')
            ->getManager();
    }

}