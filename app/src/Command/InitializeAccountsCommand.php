<?php
namespace App\Command;

use App\Entity\Account1;
use App\Entity\Account2;
use App\Entity\Account3;
use App\Entity\Account4;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Console\Input\InputOption;

#[AsCommand(
    name: 'app:initialize-accounts',
    description: 'Initializes the accounts with predefined balances'
)]
class InitializeAccountsCommand extends Command
{
    private const INITIAL_BALANCE = 100;
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        parent::__construct();
        $this->entityManager = $entityManager;
    }

    protected function configure(): void
    {
        $this
            ->addOption('reset', null, InputOption::VALUE_NONE, 'Reset the accounts before initializing');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        if ($input->getOption('reset')) {
            $this->entityManager->createQuery('DELETE FROM App\Entity\Account1')->execute();
            $this->entityManager->createQuery('DELETE FROM App\Entity\Account2')->execute();
            $this->entityManager->createQuery('DELETE FROM App\Entity\Account3')->execute();
            $this->entityManager->createQuery('DELETE FROM App\Entity\Account4')->execute();
            $io->success('Accounts reset.');
        }

        // Initialize accounts
        $this->initializeAccount1();
        $this->initializeAccount2();
        $this->initializeAccount3();
        $this->initializeAccount4();

        $this->entityManager->flush();

        $io->success('Accounts have been initialized.');

        return Command::SUCCESS;
    }

    private function initializeAccount1(): void
    {
        $account1 = new Account1();
        $account1->setId(1);
        $account1->setBalance(self::INITIAL_BALANCE);
        $this->entityManager->persist($account1);

        $account2 = new Account1();
        $account2->setId( 2);
        $account2->setBalance(0);
        $this->entityManager->persist($account2);
    }

    private function initializeAccount2(): void
    {
        $account1 = new Account2();
        $account1->setId(1);
        $account1->setBalance(self::INITIAL_BALANCE);
        $this->entityManager->persist($account1);

        $account2 = new Account2();
        $account2->setId( 2);
        $account2->setBalance(0);
        $this->entityManager->persist($account2);
    }

    private function initializeAccount3(): void
    {
        $account1 = new Account3();
        $account1->setId(1);
        $account1->setBalance(self::INITIAL_BALANCE);
        $this->entityManager->persist($account1);

        $account2 = new Account3();
        $account2->setId( 2);
        $account2->setBalance(0);
        $this->entityManager->persist($account2);
    }

    private function initializeAccount4(): void
    {
        $account1 = new Account4();
        $account1->setId(1);
        $account1->setBalance(self::INITIAL_BALANCE);
        $this->entityManager->persist($account1);

        $account2 = new Account4();
        $account2->setId( 2);
        $account2->setBalance(0);
        $this->entityManager->persist($account2);
    }
}
