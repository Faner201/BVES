<?php

namespace App\Consumer;

use App\RabbitConnection;
use PhpAmqpLib\Channel\AMQPChannel;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

/**
 * @method externalCallback($message)
 */
abstract class ConsumerAbstract extends RabbitConnection
{
    private AMQPStreamConnection $connection;
    private AMQPChannel $channel;

    public function __construct()
    {
        $this->connection = $this->getConnection();
        $this->channel = $this->connection->channel();
    }

    public function receiving(string $queue)
    {
        $this->channel->queue_declare
        (
            $queue,
            false,
            true,
            false,
            false
        );

        $this->channel->basic_consume
        (
            $queue,
            '',
            false,
            true,
            false,
            false,
            array($this, 'callback')
        );

        while(count($this->channel->callbacks)) {
            $this->channel->wait();
        }

        try {
            $this->channel->consume();
        } catch (\Throwable $ex) {
            return $ex->getMessage();
        }
    }

    public function closure()
    {
        $this->channel->close();
        try {
            $this->connection->close();
        } catch (\Exception $e) {
            echo $e->getMessage();
        }
    }

    public function getChannel()
    {
        return $this->channel;
    }

    abstract protected function callback($message);
}