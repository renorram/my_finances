<?php declare(strict_types=1);

namespace App\Controller\User;

use App\ContextGroups\UserContextGroups;
use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;

class GetUserController extends AbstractController
{
    public function __invoke(User $user): JsonResponse
    {
        return $this->json($user, JsonResponse::HTTP_OK, [], ['groups' => UserContextGroups::DETAILS]);
    }
}
