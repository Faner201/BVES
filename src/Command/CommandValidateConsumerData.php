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

    private ConsumerValidate $consumer;

    /**
     * @param ConsumerValidate $consumer
     */
    public function __construct(ConsumerValidate $consumer)
    {
        $this->consumer = $consumer;
        parent::__construct();
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        try {
            $this->consumer->receiving('task');
        } catch (\Exception $ex) {
            $output->writeln('Операция получила ошибку:'. $ex);
            $this->consumer->closure();
            return Command::FAILURE;
        }
        $this->consumer->closure();

        $output->writeln('Операция прошла успешна');

        return Command::SUCCESS;
    }
}