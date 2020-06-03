<?php declare(strict_types=1);

namespace App\Tests;

use Faker\Factory;
use Faker\Generator;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

abstract class AbstractKernelTestCase extends KernelTestCase
{
    protected Generator $faker;

    protected function setUp(): void
    {
        parent::bootKernel();

        $this->faker = Factory::create();
    }
}
