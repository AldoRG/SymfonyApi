<?php

namespace App\Entity;

use App\Repository\PizzaRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PizzaRepository::class)
 */
class Pizza
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
     * @ORM\Column(type="float")
     */
    private $price;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $notes;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Order", mappedBy="pizzas")
     */
    private $orders;

    /**
     * @ORM\ManyToMany(targetEntity=Topping::class, mappedBy="pizzas")
     */
    private $toppings;

    /**
     * Pizza constructor.
     */
    public function __construct()
    {
        $this->orders = new ArrayCollection();
        $this->toppings = new ArrayCollection();
    }

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

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(float $price): self
    {
        $this->price = $price;

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

    /**
     * @return Collection
     */
    public function getOrders(): Collection
    {
        return $this->orders;
    }

    /**
     * @param Order $order
     */
    public function addOrders(Order $order): self
    {
        if (!$this->orders->contains($order)) {
            $this->orders[] = $order;
            $order->addPizza($this);
        }

        return $this;
    }

    /**
     * @param Order $order
     * @return $this
     */
    public function removeOrder(Order $order): self
    {
        if ($this->orders->contains($order)) {
            $this->orders->removeElement($order);
            $order->removePizza($this);
        }

        return $this;
    }

    /**
     * @return Collection|Topping[]
     */
    public function getToppings(): Collection
    {
        return $this->toppings;
    }

    public function addTopping(Topping $topping): self
    {
        if (!$this->toppings->contains($topping)) {
            $this->toppings[] = $topping;
            $topping->addPizza($this);
        }

        return $this;
    }

    public function removeTopping(Topping $topping): self
    {
        if ($this->toppings->contains($topping)) {
            $this->toppings->removeElement($topping);
            $topping->removePizza($this);
        }

        return $this;
    }
}
