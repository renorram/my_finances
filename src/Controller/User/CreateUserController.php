<?php declare(strict_types=1);

namespace App\Controller\User;

use App\ContextGroups\UserContextGroups;
use App\Entity\User;
use App\Exception\DomainValidationException;
use App\Service\UserService;
use Doctrine\ORM\ORMException;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\SerializerInterface;

class CreateUserController extends AbstractController
{
    public function __invoke(
        Request $request,
        SerializerInterface $serializer,
        UserService $userService,
        LoggerInterface $logger
    ): JsonResponse {
        try {
            $user = $serializer->deserialize(
                $request->getContent(),
                User::class,
                'json',
                ['groups' => UserContextGroups::REGISTRATION]
            );
            $user = $userService->registerUserOrFail($user);

            return $this->json($user, JsonResponse::HTTP_CREATED, [], ['groups' => UserContextGroups::DETAILS]);
        } catch (DomainValidationException $exception) {
            return $this->json($exception->getConstraintViolationList(), JsonResponse::HTTP_BAD_REQUEST);
        }
    }
}
