<?php
namespace App\Repository;

use App\Entity\Account3;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Psr\Log\LoggerInterface;

class Account3Repository extends ServiceEntityRepository
{
    private LoggerInterface $logger;

    public function __construct(
        ManagerRegistry $registry,
        LoggerInterface $logger
    )
    {
        parent::__construct($registry, Account3::class);
        $this->logger = $logger;
    }

    public function findWithLock($id)
    {
        $connection = $this->getEntityManager()->getConnection();

        $sql = 'SELECT * FROM account3 WHERE id = :id FOR UPDATE NOWAIT';

        try {
            $result = $connection->executeQuery(
                $sql,['id'=> $id]
            )->fetchAssociative();
        } catch (\Exception $e){
            $this->logger->error($e->getMessage());
            throw $e;
        }

        $account = new Account3();
        $account->setId($id);
        $account->setBalance($result['balance']);

        $this->getEntityManager()->getUnitOfWork()->registerManaged($account, ['id' => $id], $result);

        return $account;
    }
}
