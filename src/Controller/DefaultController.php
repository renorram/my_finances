<?php

declare(strict_types=1);

namespace App\Controller;

use App\Service\ExpenseService;
use App\Service\IncomeService;
use App\Service\TransactionService;
use App\Service\UserService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends AbstractController
{
    public function __invoke(
        UserService $userService,
        ExpenseService $expenseService,
        TransactionService $transactionService,
        IncomeService $incomeService
    ) {
        return Response::create('test');
    }
}
