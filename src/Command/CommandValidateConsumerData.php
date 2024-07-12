<?php

namespace App\Command;

use App\Consumer\ConsumerAbstract;
use App\Consumer\ConsumerValidate;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class CommandValidateConsumerData extends Command
{
    protected static $defaultName = 'rabbitMQ:consumer-validate-data';
    protected static $defaultDescription = 'Validation of data in runtime received from the queue.';

    protected function configure()
    {
        $this->addArgument('name-queue', InputArgument::REQUIRED, 'The main queue for taking data');
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        $consumer = new ConsumerValidate();
        try {
            $consumer->receiving($input->getArgument('name-queue'));
        } catch (\Exception $ex) {
            $output->writeln('Операция получила ошибку:'. $ex);
            $consumer->closure();
            return Command::FAILURE;
        }
        $consumer->closure();

        $output->writeln('Операция прошла успешна');

        return Command::SUCCESS;
    }
}