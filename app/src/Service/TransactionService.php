<?php
namespace App\Service;

use App\Repository\Account1Repository;
use App\Repository\Account2Repository;
use App\Repository\Account3Repository;
use App\Repository\Account4Repository;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\TransactionIsolationLevel;
use Doctrine\ORM\EntityManagerInterface;

class TransactionService
{
    public function __construct(
        private EntityManagerInterface $em,
        private Account1Repository $account1Repository,
        private Account2Repository $account2Repository,
        private Account3Repository $account3Repository,
        private Account4Repository $account4Repository
    ) { }

    private function transfer($from,$to, $amount){
        if ($from->getBalance() < $amount) {
            throw new \Exception('Insufficient balance');
        }
        $from->setBalance($from->getBalance() - $amount);
        $to->setBalance($to->getBalance() + $amount);
    }

    public function transferWithoutLock(int $fromId, int $toId, float $amount)
    {
        $this->em->beginTransaction();

        $from = $this->account1Repository->find($fromId);
        $to = $this->account1Repository->find($toId);

        $this->transfer($from,$to,$amount);

        $this->em->flush();
        $this->em->commit();
    }

//        $accounts = $this->account1Repository->findSeveral([$fromId, $toId]);
//        $from = $accounts[$fromId];
//        $to = $accounts[$toId];

    public function transferWithPessimisticWait(int $fromId, int $toId, float $amount)
    {
        $this->em->beginTransaction();
        $from = $this->account2Repository->findWithLock($fromId);
        $to = $this->account2Repository->findWithLock($toId);

        $this->transfer($from,$to,$amount);

        $this->em->flush();
        $this->em->commit();
    }

    public function transferWithPessimisticError(int $fromId, int $toId, float $amount)
    {
        $this->em->beginTransaction();
        $from = $this->account3Repository->findWithLock($fromId);
        $to = $this->account3Repository->findWithLock($toId);

        $this->transfer($from,$to,$amount);

        $this->em->flush();
        $this->em->commit();
    }

    public function transferWithOptimisticLock(int $fromId, int $toId, float $amount)
    {
        $this->em->beginTransaction();
        $from = $this->account4Repository->findWithLock($fromId);
        $to = $this->account4Repository->findWithLock($toId);

        $this->transfer($from,$to,$amount);

        $this->em->flush();
        $this->em->commit();
    }
}
