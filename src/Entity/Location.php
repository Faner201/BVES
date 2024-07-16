<?php

namespace App\Entity;

class Location
{
    /**
     * @var string
     */
    private $country;

    /**
     * @return string
     */
    public function getCountry(): string
    {
        return $this->country;
    }


    /**
     * @var string
     */
    private $city;

    /**
     * @return string
     */
    public function getCity(): string
    {
        return $this->city;
    }

    /**
     * @param string $country
     * @param string $city
     */
    public function __construct(string $country, string $city)
    {
        $this->country = $country;
        $this->city = $city;
    }
}