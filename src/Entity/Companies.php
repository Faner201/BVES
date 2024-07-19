<?php

namespace App\Entity;

use App\Repository\CompaniesRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CompaniesRepository::class)
 * @ORM\Table(name="companies")
 */
class Companies
{
    /**
     * @var int
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;
    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    /**
     * @var string
     * @ORM\Column(type="string")
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
     * @param Location $location
     * @ORM\ManyToOne(targetEntity="Location", cascade={"persist"})
     */
    private Location $location;

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
     * @param Information $information
     * @ORM\ManyToOne(targetEntity="Information", cascade={"persist"})
     */
    private Information $information;

    /**
     * @return Information
     */
    public function getInformation(): Information
    {
        return $this->information;
    }

    /**
     * @param Information $information
     */
    public function setInformation(Information $information): void
    {
        $this->information = $information;
    }

    /**
     * @ORM\OneToOne(targetEntity="NamePerson", cascade={"persist"})
     */
    private NamePerson $founder;

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
     * @param Information $information
     * @param NamePerson $founder
     */
    public function __construct(string $name, Location $location, Information $information, NamePerson $founder)
    {
        $this->name = $name;
        $this->location = $location;
        $this->information = $information;
        $this->founder = $founder;
    }

}