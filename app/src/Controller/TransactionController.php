<?php

namespace App\Controller;

use App\Service\TransactionService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TransactionController extends AbstractController
{
    public function __construct(
        private TransactionService $transactionService)
    { }

    #[Route('/transfer/{type}/{fromId}/{toId}/{amount}', name: 'transfer')]
    public function transfer(string $type, int $fromId, int $toId, float $amount): Response
    {
        try {
            switch ($type) {
                case 'without_lock':
                    $this->transactionService->transferWithoutLock($fromId, $toId, $amount);
                    break;
                case 'pessimistic_wait':
                    $this->transactionService->transferWithPessimisticWait($fromId, $toId, $amount);
                    break;
                case 'pessimistic_error':
                    $this->transactionService->transferWithPessimisticError($fromId, $toId, $amount);
                    break;
                case 'optimistic':
                    $this->transactionService->transferWithOptimisticLock($fromId, $toId, $amount);
                    break;
                default:
                    throw new \InvalidArgumentException('Invalid lock type');
            }

            return new Response('Transfer successful');
        } catch (\Exception $e) {
            return new Response('Transfer failed: ' . $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
