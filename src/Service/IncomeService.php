<?php declare(strict_types=1);

namespace App\Service;

use App\Entity\Income;
use App\Entity\ValueObjects\Recurrence;
use App\Exception\DomainValidationException;
use App\Repository\IncomeRepository;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

final class IncomeService
{
    private IncomeRepository $incomeRepository;
    private ValidatorInterface $validator;

    public function __construct(EntityManagerInterface $entityManager, ValidatorInterface $validator)
    {
        $this->incomeRepository = $entityManager->getRepository(Income::class);
        $this->validator = $validator;
    }

    /**
     * @param Income $income
     *
     * @return Income
     *
     * @throws DomainValidationException
     */
    public function createOrFail(Income $income): Income
    {
        $errors = $this->validator->validate($income);
        if (count($errors) > 0) {
            throw new DomainValidationException($errors);
        }

        $income->setReceived(self::isIncomeReceived($income));
        $this->incomeRepository->save($income);

        return $income;
    }

    /**
     * @param Income $income
     *
     * @return bool
     * @todo use transactions made instead of recurrence type
     */
    public static function isIncomeReceived(Income $income): bool
    {
        $recurrence = $income->getRecurrence();
        $now = new DateTime();

        if ($recurrence->getType() === Recurrence::TYPE_NONE) {
            return $recurrence->getDueDate() > $now;
        }

        return false;
    }
}
