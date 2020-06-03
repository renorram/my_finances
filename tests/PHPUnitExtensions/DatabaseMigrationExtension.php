<?php declare(strict_types=1);

namespace App\Tests\PHPUnitExtensions;

use App\Kernel;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Tools\SchemaTool;
use PHPUnit\Runner\BeforeFirstTestHook;

class DatabaseMigrationExtension implements BeforeFirstTestHook
{

    public function executeBeforeFirstTest(): void
    {
        $kernel = new Kernel('test', true);
        $kernel->boot();

        // Get the entity manager from the service container
        /** @var EntityManagerInterface $entityManager */
        $entityManager = $kernel->getContainer()->get('doctrine')->getManager();

        // Run the schema update tool using our entity metadata
        $metadata = $entityManager->getMetadataFactory()->getAllMetadata();
        $schemaTool = new SchemaTool($entityManager);
        $schemaTool->updateSchema($metadata);
    }
}
