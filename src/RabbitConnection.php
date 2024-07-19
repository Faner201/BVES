<?php

namespace App;

use PhpAmqpLib\Connection\AMQPStreamConnection;

class RabbitConnection
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

    final protected function getConnection(): AMQPStreamConnection
    {
        try {
            $this->init();
        } catch (\Exception $e) {
            echo "Не удалось подключиться, более подробно:". $e->getMessage();
        }
        return $this->connection;
    }


}