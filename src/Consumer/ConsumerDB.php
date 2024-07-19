<?php

namespace App\Consumer;

use App\Entity\Companies;
use App\Entity\Ports;
use App\Entity\Vessels;
use Doctrine\ORM\EntityManagerInterface;
use stdClass;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\SerializerInterface;

class ConsumerDB extends ConsumerAbstract
{
    private SerializerInterface $serializer;

    private EntityManagerInterface $manager;

    /**
     * @param SerializerInterface $serializer
     * @param EntityManagerInterface $manager
     */
    public function __construct(SerializerInterface $serializer, EntityManagerInterface $manager)
    {
        $this->serializer = $serializer;
        $this->manager = $manager;
        parent::__construct();
    }

    public function callback($message)
    {
        $jsonData = json_decode($message->body, true);
        $class = stdClass::class;

        foreach ($jsonData as $jsonArrayData) {
            foreach ($jsonArrayData as $name => $dataArray) {
                foreach ($dataArray as $data) {
                    $json = $this->serializer->serialize
                    (
                        $data,
                        JsonEncoder::FORMAT,
                        ['json_encode_options' => JSON_UNESCAPED_UNICODE]
                    );

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
                    $this->manager->persist($dto);
                }
            }
            $this->manager->flush();
        }
    }
}