<?php

namespace App\Entity;

class Data
{
    /**
     * @var Vessels[]
     */
    private $vessels;

    /**
     * @return Vessels[]
     */
    public function getVessels(): array
    {
        return $this->vessels;
    }

    /**
     * @param Vessels[] $vessels
     */
    public function setVessels(array $vessels): void
    {
        $this->vessels = $vessels;
    }

    /**
     * @var Ports[]
     */
    private $ports;

    /**
     * @return Ports[]
     */
    public function getPorts(): array
    {
        return $this->ports;
    }

    /**
     * @param Ports[] $ports
     */
    public function setPorts(array $ports): void
    {
        $this->ports = $ports;
    }

    /**
     * @var Companies[]
     */
    private $companies;

    /**
     * @return Companies[]
     */
    public function getCompanies(): array
    {
        return $this->companies;
    }

    /**
     * @param Companies[] $companies
     */
    public function setCompanies(array $companies): void
    {
        $this->companies = $companies;
    }

    /**
     * @param Vessels[] $vessels
     * @param Ports[] $ports
     * @param Companies[] $companies
     */
    public function __construct(array $vessels, array $ports, array $companies)
    {
        $this->vessels = $vessels;
        $this->ports = $ports;
        $this->companies = $companies;
    }

}