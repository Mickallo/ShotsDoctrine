<?php
namespace App\Controller;

use App\Repository\Account1Repository;
use App\Repository\Account2Repository;
use App\Repository\Account3Repository;
use App\Repository\Account4Repository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class AccountController extends AbstractController
{
    public function __construct(
        private Account1Repository $account1Repository,
        private Account2Repository $account2Repository,
        private Account3Repository $account3Repository,
        private Account4Repository $account4Repository
    ) { }

    #[Route('/balances', name: 'get_balances', methods: ['GET'])]
    public function getBalances(): JsonResponse
    {
        $balances = [
            'account1' => $this->account1Repository->findAll(),
            'account2' => $this->account2Repository->findAll(),
            'account3' => $this->account3Repository->findAll(),
            'account4' => $this->account4Repository->findAll(),
        ];

        $result = [];
        foreach ($balances as $key => $accounts) {
            $result[$key] = array_map(function ($account) {
                return [
                    'id' => $account->getId(),
                    'balance' => $account->getBalance(),
                ];
            }, $accounts);
        }

        return new JsonResponse($result);
    }
}
