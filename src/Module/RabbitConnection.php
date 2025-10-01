<?php

namespace App\Module;

use PhpAmqpLib\Connection\AMQPStreamConnection;

class RabbitConnection implements ConnectionInterface
{
    private AMQPStreamConnection $connection;

    /**
     * @throws \Exception
     */
    private function init()
    {
        $this->connection = new AMQPStreamConnection
        (
            $_ENV["RABBIT_MQ_HOST"],
            $_ENV["RABBIT_MQ_PORT"],
            $_ENV["RABBIT_MQ_USER"],
            $_ENV["RABBIT_MQ_PASSWORD"],
        );
    }

    public final function getConnection(): AMQPStreamConnection
    {
        try {
            $this->init();
        } catch (\Exception $e) {
            echo "Не удалось подключиться, более подробно:". $e->getMessage();
        }
        return $this->connection;
    }
}