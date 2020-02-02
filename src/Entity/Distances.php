<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Form\FormTypeInterface;

/**
 * @ORM\Entity(repositoryClass="App\Repository\DistancesRepository")
 */
class Distances
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=36)
     */
    private $ipAddress;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $postalAddress;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $distance;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIpAddress(): ?string
    {
        return $this->ipAddress;
    }

    public function setIpAddress(string $ipAddress): self
    {
        $this->ipAddress = $ipAddress;

        return $this;
    }

    public function getPostalAddress(): ?string
    {
        return $this->postalAddress;
    }

    public function setPostalAddress(string $postalAddress): self
    {
        $this->postalAddress = $postalAddress;

        return $this;
    }

    public function getDistance(): ?float
    {
        return $this->distance;
    }

    public function setDistance(?float $distance): self
    {
        $this->distance = $distance;

        return $this;
    }
}
