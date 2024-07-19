<?php

namespace App\Command;

use App\Consumer\ConsumerDB;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class CommandDBConsumer extends Command
{
    protected static $defaultName = 'rabbitMQ:consumer-db';
    protected static $defaultDescription = 'Saving data to a database in runtime';
    private ConsumerDB $consumer;

    /**
     * @param ConsumerDB $consumer
     */
    public function __construct(ConsumerDB $consumer)
    {
        $this->consumer = $consumer;
        parent::__construct();
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        try {
            $this->consumer->receiving('validate');
        } catch (\Exception $ex) {
            $output->writeln('Операция получила ошибку:'. $ex);
            $this->consumer->closure();
            return Command::FAILURE;
        }

        $this->consumer->closure();

        $output->writeln('Операция прошла успеша');

        return  Command::SUCCESS;
    }
}