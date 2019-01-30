<?php

namespace App\App\Command;

use App\App\Command\Interfaces\CreateAdminCommandInterface;
use App\Domain\Entity\User;
use App\Domain\Repository\UserRepository;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Security\Core\Encoder\EncoderFactoryInterface;

/**
 * Class CreateAdminCommand
 * @package App\App\Command
 *
 * https://symfony.com/doc/current/console.html#creating-a-command
 */
final class CreateAdminCommand extends Command implements CreateAdminCommandInterface
{

    /**
     * @var EncoderFactoryInterface
     */
    private $encoderFactory;

    /**
     * @var UserRepository
     */
    private $repository;

    /**
     * @var User
     */
    private $user;

    /**
     * @var bool
     */
    private $username;

    /**
     * @var bool
     */
    private $password;

    /**
     * @var bool
     */
    private $email;

    /**
     * CreateAdminCommand constructor.
     * @inheritdoc
     */
    public function __construct(
        EncoderFactoryInterface $encoderFactory,
        UserRepository $repository,
        $username = true,
        $password = true,
        $email = true
    ) {
        parent::__construct();
        $this->encoderFactory = $encoderFactory;
        $this->repository = $repository;
        $this->user = new User();
        $this->username = $username;
        $this->password = $password;
        $this->email = $email;
    }

    protected function configure()
    {
        $this
            ->setName('app:create:admin')
            ->setDescription('Create an admin account')
            ->setHelp('This command allows you to create a user with admin privilege...')
            ->addArgument('username', InputArgument::REQUIRED, 'Admin username')
            ->addArgument('password', InputArgument::REQUIRED, 'Admin password')
            ->addArgument('email', InputArgument::REQUIRED, 'Admin email')
        ;
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int|null|void
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln('Admin user creation in progress...');
        $output->writeln('Username: ' .$input->getArgument('username'));
        $output->writeln('Password: ' .$input->getArgument('password'));
        $output->writeln('Email: ' .$input->getArgument('email'));
        $output->writeln('Role: ROLE_ADMIN');
        $encodedPassword = $this->encoderFactory
            ->getEncoder(User::class)
            ->encodePassword($input->getArgument('password'), null);
        $this->user->setUsername($input->getArgument('username'));
        $this->user->setPassword($encodedPassword);
        $this->user->setEmail($input->getArgument('email'));
        $this->user->setRoles(['ROLE_ADMIN']);
        $this->user->setIsActive(true);
        $this->repository->save($this->user);
        $output->writeln('Admin successfully created!');
    }
}
