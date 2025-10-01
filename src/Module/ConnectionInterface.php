<?php

namespace App\Module;

use PhpAmqpLib\Connection\AMQPStreamConnection;

interface ConnectionInterface
{
    public function getConnection(): AMQPStreamConnection;
}