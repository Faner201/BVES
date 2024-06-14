<?php

namespace App\Entity;

class Information
{
    /**
     * @var string
     */
    private $number;

    /**
     * @return string
     */
    public function getNumber(): string
    {
        return $this->number;
    }

    /**
     * @param string $number
     */
    public function setNumber(string $number): void
    {
        $this->number = $number;
    }

    /**
     * @var string
     */
    private $email;

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    /**
     * @param string $number
     * @param string $email
     */
    public function __construct(string $number, string $email)
    {
        $this->number = $number;
        $this->email = $email;
    }
}