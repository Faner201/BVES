<?php

namespace App\Consumer;

use App\Entity\Companies;
use App\Entity\Ports;
use App\Entity\Vessels;
use PhpAmqpLib\Message\AMQPMessage;
use stdClass;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class ConsumerValidate extends ConsumerAbstract
{

    private ValidatorInterface $validator;

    /**
     * @param ValidatorInterface $validator
     * @param SerializerInterface $serializer
     */
    public function __construct(ValidatorInterface $validator, SerializerInterface $serializer)
    {
        $this->validator = $validator;
        $this->serializer = $serializer;
        parent::__construct();
    }

    public function callback($message)
    {
        $jsonArray = json_decode(json_decode($message->body), true);

        $validData = array();

        $validErrors = array();

        $class = stdClass::class;

        foreach ($jsonArray as $jsonData) {

            $qualityData = true;

            $jsonData['Companie']['information']['number'] = preg_replace
            (
                '/[^0-9]/',
                '',
                $jsonData['Companie']['information']['number']
            );

            foreach ($jsonData as $name =>  $data) {
                $json = $this->serialize($data);

                switch ($name) {
                    case 'Vessel':
                        $class = Vessels::class;
                        break;
                    case 'Port':
                        $class = Ports::class;
                        break;
                    case 'Companie':
                        $class = Companies::class;
                        break;
                }

                $dto = $this->serializer->deserialize($json, $class, 'json');
                $errors = $this->validator->validate($dto);

                if (count($errors) > 0) {
                    $validErrors[] = (string) $errors;
                    $qualityData = false;
                }

            }

            if ($qualityData) {
                $validData[] = $jsonData;
            }
        }

        $msg = new AMQPMessage($this->serialize($validData));
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

    private function serialize($data): string
    {
        return $this->serializer->serialize
        (
            $data,
            JsonEncoder::FORMAT,
            ['json_encode_options' => JSON_UNESCAPED_UNICODE]
        );
    }
}