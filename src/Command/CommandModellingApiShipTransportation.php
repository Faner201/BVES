<?php

namespace App\Command;

use App\Entity\Companies;
use App\Entity\Information;
use App\Entity\Location;
use App\Entity\NamePerson;
use App\Entity\Ports;
use App\Entity\Vessels;
use Faker\Factory;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class CommandModellingApiShipTransportation extends Command
{
    private HttpClientInterface $client;
    private SerializerInterface $serializer;
    protected static $defaultName = 'app:call-api';
    protected static $defaultDescription = 'Modeling an external Api call.';

    public function __construct(HttpClientInterface $client, SerializerInterface $serializer)
    {
        $this->client = $client;
        $this->serializer = $serializer;

        parent::__construct();
    }

    /**
     * @throws TransportExceptionInterface
     * @throws \Exception
     */
    public function execute(InputInterface $input, OutputInterface $output): int
    {
        $data = $this->serializer->serialize
        (
            $this->generateDate(),
            JsonEncoder::FORMAT,
            ['json_encode_options' => JSON_UNESCAPED_UNICODE]
        );


        $response = $this->client->request(
            'POST',
            'http://127.0.0.1:8000/processing',
            [
                'headers' => [
                    'Accept' => 'application/json',
                    'Content-Type' => 'application/json; charset=utf-8',
                ],
                'json' => $data
            ]
        );

        if (200 !== $response->getStatusCode()) {
            throw new \Exception('Не удалось подключится с API');
        }

        $output->write('Данные успешно отправленны.');



        return Command::SUCCESS;
    }

    private function generateDate(): array
    {
        $faker = Factory::create();
        $dataArray = array();

        for ($i = 0; $i < 5; $i++) {
            $vessels = array();
            $companies = array();
            $ports = array();
            for ($j = 0; $j < 15; $j++) {

                $vessel = new Vessels(
                    $faker->numberBetween(0, 5000),
                    $faker->numberBetween(0, 1000),
                    Vessels::$typeArray[$faker->numberBetween(0, 3)],
                    Vessels::$productTypeArray[$faker->numberBetween(0, 5)],
                    $faker->numberBetween(1980, 2023)
                );

                $port = new Ports
                (
                    $faker->domainName(),
                    new Location
                    (
                        $faker->country(),
                        $faker->city()
                    )
                );

                $companie = new Companies
                (
                    $faker->company(),
                    new Location
                    (
                        $faker->country(),
                        $faker->city()
                    ),
                    new Information
                    (
                        $faker->phoneNumber(),
                        $faker->companyEmail(),
                    ),
                    new NamePerson
                    (
                        $faker->firstName(),
                        $faker->lastName(),
                        $faker->domainName(),
                    )
                );

                if ($j % 4 == 0) {
                    $vessel->setLength(-3000);
                    $vessel->setWeight(-5000);
                    $companie->setInformation
                    (
                        new Information
                        (
                            '+32434', 'fsdfs32@@fsd,ru'
                        )
                    );
                } elseif ($j % 3 == 0) {
                    $companie->setInformation
                    (
                        new Information
                        (
                            '+324324', 'fsdfs32@@fsd,ru'
                        )
                    );
                }

                $vessels[] = $vessel;
                $companies[] = $companie;
                $ports[] = $port;
            }

            $dataArray[] = array(
                "Vessels" => $vessels,
                "Ports" => $ports,
                "Companies" => $companies
            );
        }

        return $dataArray;
    }
}