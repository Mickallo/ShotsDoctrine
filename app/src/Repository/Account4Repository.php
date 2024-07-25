<?php
namespace App\Repository;

use App\Entity\Account4;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\DBAL\LockMode;
use Doctrine\Persistence\ManagerRegistry;

class Account4Repository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Account4::class);
    }

    public function findWithLock($id)
    {
        return $this->find($id,LockMode::OPTIMISTIC);
    }
}
