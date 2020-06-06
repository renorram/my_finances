<?php declare(strict_types=1);

namespace App\Tests\Controller;

use App\ContextGroups\UserContextGroups;
use App\Entity\User;
use App\Factory\UserFactory;
use App\Service\UserService;
use Faker\Factory;
use Faker\Generator;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\SerializerInterface;

class GetControllerTest extends WebTestCase
{
    private UserService $userService;
    private KernelBrowser $client;
    private Generator $faker;
    private SerializerInterface $serializer;

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->userService = self::$container->get(UserService::class);
        $this->serializer = self::$container->get(SerializerInterface::class);
        $this->faker = Factory::create();
    }

    public function testCanCreateUser()
    {
        $user = UserFactory::create(
            $this->faker->firstName,
            $this->faker->lastName,
            $this->faker->email,
            $this->faker->password,
            $this->faker->currencyCode
        );
        $requestJson = $this->serializer->serialize($user, 'json', ['groups' => UserContextGroups::REGISTRATION]);

        $this->client->request(
            'POST',
            '/user',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            $requestJson
        );

        $this->assertEquals(Response::HTTP_CREATED, $this->client->getResponse()->getStatusCode());
        $this->assertResponseHeaderSame('Content-Type', 'application/json');
        $this->assertJson($this->client->getResponse()->getContent());
    }

    public function testCanGetUser()
    {
        $user = UserFactory::create(
            $this->faker->firstName,
            $this->faker->lastName,
            $this->faker->email,
            $this->faker->password,
            $this->faker->currencyCode
        );
        $this->userService->registerUserOrFail($user);
        $userSerialized = $this->serializer->serialize($user, 'json', ['groups' => UserContextGroups::DETAILS]);

        $this->client->request('GET', '/user/1');

        $this->assertEquals(Response::HTTP_OK, $this->client->getResponse()->getStatusCode());
        $this->assertResponseHeaderSame('Content-Type', 'application/json');
        $this->assertJsonStringEqualsJsonString($userSerialized, $this->client->getResponse()->getContent());
    }
}
