<?php

namespace App\Tests\Service;

use App\Entity\User;
use App\Exception\DomainValidationException;
use App\Factory\UserFactory;
use App\Service\UserService;
use App\Tests\AbstractKernelTestCase;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class UserServiceTest extends AbstractKernelTestCase
{
    private UserService $userService;

    protected function setUp(): void
    {
        parent::setUp();

        $this->userService = self::$container->get(UserService::class);
    }

    public function testItShouldThrowExceptionToEmptyEntity()
    {
        $this->expectException(DomainValidationException::class);

        $user = new User();
        $this->userService->registerUserOrFail($user);
    }

    public function testItShouldRegisterUser()
    {
        $user = UserFactory::create(
            $this->faker->firstName,
            $this->faker->lastName,
            $this->faker->email,
            $this->faker->password,
            $this->faker->currencyCode
        );

        $this->userService->registerUserOrFail($user);

        $this->assertNotNull($user->getId());
    }
}
