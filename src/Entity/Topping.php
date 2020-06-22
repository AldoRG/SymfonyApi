<?php

namespace App\Entity;

use App\Repository\ToppingRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ToppingRepository::class)
 */
class Topping
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $extra_price;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getExtraPrice(): ?float
    {
        return $this->extra_price;
    }

    public function setExtraPrice(?float $extra_price): self
    {
        $this->extra_price = $extra_price;

        return $this;
    }
}
