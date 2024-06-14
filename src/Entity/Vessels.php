<?php

namespace App\Entity;

class Vessels
{
    /**
     * @var int
     */
    private $length;

    /**
     * @return int
     */
    public function getLength(): int
    {
        return $this->length;
    }

    /**
     * @param int $length
     */
    public function setLength(int $length): void
    {
        $this->length = $length;
    }

    /**
     * @var int
     */
    private $weight;

    /**
     * @return int
     */
    public function getWeight(): int
    {
        return $this->weight;
    }

    /**
     * @param int $weight
     */
    public function setWeight(int $weight): void
    {
        $this->weight = $weight;
    }

    /**
     * @var string
     */
    private $type;

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @param string $type
     */
    public function setType(string $type): void
    {
        $this->type = $type;
    }

    /**
     * @var string
     */
    private $productType;

    /**
     * @return string
     */
    public function getProductType(): string
    {
        return $this->productType;
    }

    /**
     * @param string $productType
     */
    public function setProductType(string $productType): void
    {
        $this->productType = $productType;
    }

    /**
     * @var string
     */
    private $yearRelease;

    /**
     * @return string
     */
    public function getYearRelease(): string
    {
        return $this->yearRelease;
    }

    /**
     * @param string $yearRelease
     */
    public function setYearRelease(string $yearRelease): void
    {
        $this->yearRelease = $yearRelease;
    }

    public function __construct(int $length, int $weight, string $type, string $productType, string $yearRelease)
    {
        $this->length = $length;
        $this->weight = $weight;
        $this->type = $type;
        $this->productType = $productType;
        $this->yearRelease = $yearRelease;
    }
}