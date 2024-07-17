<?php

namespace App\Entity;

use App\Repository\VesselsRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=VesselsRepository::class)
 * @ORM\Table(name="vessels")
 */
class Vessels
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
     * @var int
     * @ORM\Column(type="integer")
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
     * @ORM\Column(type="integer")
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
     * @ORM\Column(type="string")
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
     * @var string[]
     */

    public static $typeArray = ['газовый танкер', 'контейнеровоз', 'нефтеналивной танкер', 'танкер продуктовоз'];

    /**
     * @var string
     * @ORM\Column(type="string")
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
     * @var string[]
     */

    public static $productTypeArray = ['дерево', 'руда', 'нефть', 'бензин', 'машины', 'контейнеры'];

    /**
     * @var string
     * @ORM\Column(type="string")
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