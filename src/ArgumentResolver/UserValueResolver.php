<?php declare(strict_types=1);

namespace App\ArgumentResolver;

use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use InvalidArgumentException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Controller\ArgumentValueResolverInterface;
use Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class UserValueResolver implements ArgumentValueResolverInterface
{
    private UserRepository $repository;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->repository = $entityManager->getRepository(User::class);
    }

    /**
     *  Whether this resolver can resolve the value for the given ArgumentMetadata.
     *
     * @param Request $request
     * @param ArgumentMetadata $argument
     *
     * @return bool
     */
    public function supports(Request $request, ArgumentMetadata $argument)
    {
        return User::class === $argument->getType();
    }

    /**
     * Returns the possible value(s).
     *
     * @param Request $request
     * @param ArgumentMetadata $argument
     *
     * @return iterable
     */
    public function resolve(Request $request, ArgumentMetadata $argument)
    {
        $user = $this->repository->findOneBy(['id' => $request->get('id')]);
        if (!($user instanceof User)) {
            throw new NotFoundHttpException("User not found!");
        }

        yield $user;
    }
}
