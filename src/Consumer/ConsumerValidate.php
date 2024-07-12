<?php

namespace App\Consumer;

use PhpAmqpLib\Message\AMQPMessage;

class ConsumerValidate extends ConsumerAbstract
{
    public function callback($message)
    {
        //здесь должен быть функционал связанный с валидацией
        var_dump(json_decode($message->body));
        $msg = new AMQPMessage($message->body);
        $channel = $this->getChannel();
        $channel->queue_declare
        (
            'validate',
            false,
            true,
            false,
            false
        );
        $channel->basic_publish($msg, '', 'validate');
    }
}