<?php

namespace AppBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

use AppBundle\Entity\User;

class InitbddCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('initbdd')
            ->setDescription('...')
            ->addArgument('argument', InputArgument::OPTIONAL, 'Argument description')
            ->addOption('option', null, InputOption::VALUE_NONE, 'Option description')
        ;
    }

    function addAdmin(){
        $em = $this->getContainer()->get('doctrine')->getEntityManager();
        $user = new User();
        $user->username = 'imkael';
        $user->email = 'email@domain.com';

        $encoder = $this->getContainer()->get('security.password_encoder');
        $encoded = $encoder->encodePassword($user, 'FLCTMASTER02');
        $user->password = $encoded;
        //$user->setPassword('3NCRYPT3D-V3R51ON');
        $user->enabled = true;
        $em->persist($user);
        $em->flush();
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $argument = $input->getArgument('argument');

        if ($input->getOption('option')) {
            // ...
        }

        $this->addAdmin();
        $output->writeln('Command result hehe.');
    }

}
