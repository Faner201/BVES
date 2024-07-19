<?php

namespace App\Producer;

use App\RabbitConnection;
use PhpAmqpLib\Channel\AMQPChannel;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

class Producer extends RabbitConnection
{
    private AMQPStreamConnection $connection;
    private AMQPChannel $channel;
    public function __construct()
    {
        $this->connection = $this->getConnection();
        $this->channel = $this->connection->channel();
    }

    public function sending(string $massage, string $queue)
    {
        $msg = new AMQPMessage($massage);
        $this->channel->queue_declare
        (
            $queue,
            false,
            true,
            false,
            false
        );
        $this->channel->basic_publish($msg, '', $queue);
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
}