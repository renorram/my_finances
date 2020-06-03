<?php

namespace App\Service;

use App\ContextGroups\UserContextGroups;
use App\Entity\User;
use App\Exception\DomainValidationException;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

final class UserService
{
    private UserRepository $userRepository;
    private ValidatorInterface $validator;

    public function __construct(EntityManagerInterface $entityManager, ValidatorInterface $validator)
    {
        $this->userRepository = $entityManager->getRepository(User::class);
        $this->validator = $validator;
    }

    /**
     * @param User $user
     *
     * @return User
     *
     * @throws DomainValidationException
     */
    public function registerUserOrFail(User $user): User
    {
        $errors = $this->validator->validate($user, null, [UserContextGroups::REGISTRATION]);
        if (count($errors) > 0) {
            throw new DomainValidationException($errors);
        }

        $this->userRepository->save($user);

        return $user;
    }
}
