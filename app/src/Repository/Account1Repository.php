<?php
namespace App\Repository;

use App\Entity\Account1;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class Account1Repository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Account1::class);
    }

    public function findSeveral(array $ids): array
    {
        $qb = $this->createQueryBuilder('a')
            ->where('a.id IN (:ids)')
            ->setParameter('ids', $ids);

        $accounts = $qb->getQuery()->getResult();

        // Index accounts by id
        $indexedAccounts = [];
        foreach ($accounts as $account) {
            $indexedAccounts[$account->getId()] = $account;
        }

        return $indexedAccounts;
    }
}
