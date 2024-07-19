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
    private SerializerInterface $serializer;

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
        $jsonData = json_decode(json_decode($message->body), true);

        $validData = array();

        $validErrors = array();

        $class = stdClass::class;

        foreach ($jsonData as $jsonArrayData) {
            $vesselsValid = array();
            $portsValid = array();
            $companiesValid = array();
            foreach ($jsonArrayData as $name => $dataArray) {
                foreach ($dataArray as $data) {
                    $qualityData = true;
                    $json = $this->serialize($data);

                    switch ($name) {
                        case 'Vessels':
                            $class = Vessels::class;
                            break;
                        case 'Ports':
                            $class = Ports::class;
                            break;
                        case 'Companies':
                            $class = Companies::class;
                            break;
                    }

                    $dto = $this->serializer->deserialize($json, $class, 'json');
                    $errors = $this->validator->validate($dto);

                    if (count($errors) > 0) {
                        $validErrors[] = (string)$errors;
                        $qualityData = false;
                    }
                    if ($qualityData) {
                        switch ($name) {
                            case 'Vessels':
                                $vesselsValid[] = $data;
                                break;
                            case 'Ports':
                                $portsValid[] = $data;
                                break;
                            case 'Companies':
                                $data['information']['number'] = preg_replace
                                (
                                    '/[^0-9]/',
                                    '',
                                    $data['information']['number']
                                );
                                $companiesValid[] = $data;
                                break;
                        }
                    }
                }
            }
            $validData[] = array(
                'Vessels' => $vesselsValid,
                'Ports' => $portsValid,
                'Companies' => $companiesValid
            );
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