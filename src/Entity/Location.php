<?php

namespace App\Entity;

class Location
{
    /**
     * @var string
     */
    private $county;

    /**
     * @return string
     */
    public function getCounty(): string
    {
        return $this->county;
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
     * @param string $county
     * @param string $city
     */
    public function __construct(string $county, string $city)
    {
        $this->county = $county;
        $this->city = $city;
    }
}