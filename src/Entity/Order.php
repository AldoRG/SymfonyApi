<?php

namespace App\Entity;

use App\Repository\OrderRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=OrderRepository::class)
 * @ORM\Table(name="`order`")
 */
class Order
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
    private $order_number;

    /**
     * @ORM\Column(type="float")
     */
    private $total;

    /**
     * @ORM\Column(type="float")
     */
    private $subtotal;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $notes;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Pizza", inversedBy="orders")
     */
    private $pizzas;

    /**
     * @return Collection
     */
    public function getPizzas(): Collection
    {
        return $this->pizzas;
    }

    /**
     * @param Pizza $pizza
     * @return Collection|Pizza[]
     */
    public function addPizza(Pizza $pizza): self
    {
        if (!$this->pizzas->contains($pizza)) {
            $this->pizzas[] = $pizza;
        }
        return $this;
    }

    /**
     * @param Pizza $pizza
     * @return Collection|Pizza[]
     */
    public function removePizza(Pizza $pizza): self
    {
        if ($this->pizzas->contains($pizza)) {
            $this->pizzas-removeElement($pizza);
        }

        return $this;
    }

    public function __construct()
    {
        $this->pizzas = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getOrderNumber(): ?string
    {
        return $this->order_number;
    }

    public function setOrderNumber(string $order_number): self
    {
        $this->order_number = $order_number;

        return $this;
    }

    public function getTotal(): ?float
    {
        return $this->total;
    }

    public function setTotal(float $total): self
    {
        $this->total = $total;

        return $this;
    }

    public function getSubtotal(): ?float
    {
        return $this->subtotal;
    }

    public function setSubtotal(float $subtotal): self
    {
        $this->subtotal = $subtotal;

        return $this;
    }

    public function getNotes(): ?string
    {
        return $this->notes;
    }

    public function setNotes(?string $notes): self
    {
        $this->notes = $notes;

        return $this;
    }
}
