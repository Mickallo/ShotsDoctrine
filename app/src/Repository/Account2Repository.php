<?php
namespace App\Repository;

use App\Entity\Account2;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\DBAL\LockMode;
use Doctrine\Persistence\ManagerRegistry;

class Account2Repository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Account2::class);
    }

    public function findWithLock($id): Account2
    {
        return $this->find($id,LockMode::PESSIMISTIC_WRITE);
    }
}
