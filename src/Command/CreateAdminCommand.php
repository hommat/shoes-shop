<?php

namespace App\Command;

use App\Entity\User;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class CreateAdminCommand extends Command
{
    protected static $defaultName = 'app:create-admin';

    private $passwordEncoder;
    private $managerRegistry;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder, ManagerRegistry $managerRegistry)
    {
        $this->passwordEncoder = $passwordEncoder;
        $this->managerRegistry = $managerRegistry;

        parent::__construct();
    }

    protected function configure()
    {
        $this
            ->setDescription('Creates new admin user')
            ->addArgument('email', InputArgument::REQUIRED, 'Enter email')
            ->addArgument('password', InputArgument::REQUIRED, 'Enter password');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $email = $input->getArgument('email');
        $password = $input->getArgument('password');

        $user = new User();
        $user->setEmail($email);
        $user->setRoles(["ROLE_ADMIN"]);
        $user->setTermsAccepted(true);
        $user->setPassword($this->passwordEncoder->encodePassword($user, $password));

        $entityManager = $this->managerRegistry->getManager();
        $entityManager->persist($user);
        $entityManager->flush();

        $io->success('You successfully created new admin user.');

        return Command::SUCCESS;
    }
}
