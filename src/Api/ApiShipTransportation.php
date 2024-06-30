<?php

namespace App\Api;

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
use Symfony\Component\Serializer\Encoder\JsonEncode;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;




class ApiShipTransportation extends Command
{
    private HttpClientInterface $client;
    protected static $defaultName = 'app:call-api';
    protected static $defaultDescription = 'Modeling an external Api call.';

    public function __construct(HttpClientInterface $client)
    {
        $this->client = $client;

        parent::__construct();
    }

    /**
     * @throws TransportExceptionInterface
     * @throws \Exception
     */
    public function execute(InputInterface $input, OutputInterface $output): int
    {
        $data = $this->serialize($this->generateDate());

        $response = $this->client->request(
            'GET',
            'http://127.0.0.1:8000/processing',
            [
                'json' => $data,
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
        for($i = 0; $i < 5; $i++)
        {
            $vessels = array();
            $ports = array();
            $companies = array();

            for($i = 0; $i < 10; $i++)
            {

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

                if($i / 4 == 0)
                {
                    $vessel->setLength(-3000);
                    $vessel->setWeight(-5000);
                    $companie->setInfomation
                    (
                        new Information
                        (
                        "+897845324", "fwerw@@mail.fwf"
                        )
                    );
                } elseif ($i / 3 == 0)
                {
                    $companie->setInfomation
                    (
                        new Information
                        (
                        "+7-(924)-565-45-34", "fwerw@@mail.fwf"
                        )
                    );
                }

                $vessels[] = $vessel;
                $ports[] = $port;
                $companies[] = $companie;
            }
            array_push($dataArray, $vessels, $ports, $companies);
        }

        return $dataArray;
    }

    private function serialize(array $data): string {
        $encoders = [new JsonEncode()];
        $normalizer = [new ObjectNormalizer()];

        $serializer = new Serializer($normalizer, $encoders);

        return $serializer->serialize
        (
            $data,
            JsonEncoder::FORMAT,
            ['json_encode_options' => JSON_UNESCAPED_UNICODE]
        );
    }
}