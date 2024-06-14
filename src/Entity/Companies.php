<?php

namespace App\Entity;

class Companies
{
    /**
     * @var string
     */
    private $name;

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @var Location
     */
    private $location;

    /**
     * @return Location
     */
    public function getLocation(): Location
    {
        return $this->location;
    }

    /**
     * @param Location $location
     */
    public function setLocation(Location $location): void
    {
        $this->location = $location;
    }

    /**
     * @var Information
     */
    private $infomation;

    /**
     * @return Information
     */
    public function getInfomation(): Information
    {
        return $this->infomation;
    }

    /**
     * @param Information $infomation
     */
    public function setInfomation(Information $infomation): void
    {
        $this->infomation = $infomation;
    }

    /**
     * @var NamePerson
     */
    private $founder;

    /**
     * @return NamePerson
     */
    public function getFounder(): NamePerson
    {
        return $this->founder;
    }

    /**
     * @param NamePerson $founder
     */
    public function setFounder(NamePerson $founder): void
    {
        $this->founder = $founder;
    }

    /**
     * @param string $name
     * @param Location $location
     * @param Information $infomation
     * @param NamePerson $founder
     */
    public function __construct(string $name, Location $location, Information $infomation, NamePerson $founder)
    {
        $this->name = $name;
        $this->location = $location;
        $this->infomation = $infomation;
        $this->founder = $founder;
    }

}