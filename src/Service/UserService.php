<?php

namespace App\Service;

use App\ContextGroups\UserContextGroups;
use App\Entity\User;
use App\Entity\ValueObjects\Money;
use App\Exception\DomainValidationException;
use App\Repository\UserRepository;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Encoder\PasswordEncoderInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

final class UserService
{
    private UserRepository $userRepository;
    private ValidatorInterface $validator;
    private UserPasswordEncoderInterface $passwordEncoder;

    public function __construct(
        EntityManagerInterface $entityManager,
        ValidatorInterface $validator,
        UserPasswordEncoderInterface $passwordEncoder
    ) {
        $this->userRepository = $entityManager->getRepository(User::class);
        $this->validator = $validator;
        $this->passwordEncoder = $passwordEncoder;
    }

    /**
     * @param User $user
     *
     * @return User
     *
     * @throws DomainValidationException
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function registerUserOrFail(User $user): User
    {
        $errors = $this->validator->validate($user, null, [UserContextGroups::REGISTRATION]);
        if (count($errors) > 0) {
            throw new DomainValidationException($errors);
        }

        $user->setPassword($this->passwordEncoder->encodePassword($user, $user->getPassword()));
        $user->setBalance(Money::createForUser(0, $user));

        $this->userRepository->save($user);

        return $user;
    }
}
