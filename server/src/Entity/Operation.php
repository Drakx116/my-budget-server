<?php

namespace App\Entity;

use App\Enum\OperationType;
use App\Enum\PaymentType;
use App\Repository\OperationRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: OperationRepository::class)]
class Operation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 64)]
    private $label;

    #[ORM\Column(type: 'datetime')]
    private $date;

    #[ORM\Column(type: 'float')]
    private $amount;

    #[ORM\Column(type: 'string', length: 32, enumType: PaymentType::class)]
    private $method;

    #[ORM\Column(type: 'string', length: 32, enumType: OperationType::class)]
    private $type;

    #[ORM\ManyToOne(targetEntity: OperationCategory::class, inversedBy: 'operations')]
    private $category;

    public function getId(): int
    {
        return $this->id;
    }

    public function getLabel(): string
    {
        return $this->label;
    }

    public function setLabel(string $label): self
    {
        $this->label = $label;

        return $this;
    }

    public function getDate(): \DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getAmount(): float
    {
        return $this->amount;
    }

    public function setAmount(float $amount): self
    {
        $this->amount = $amount;

        return $this;
    }

    public function getMethod(): string
    {
        return $this->method;
    }

    public function setMethod(string $method): self
    {
        $this->method = $method;

        return $this;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getCategory(): ?OperationCategory
    {
        return $this->category;
    }

    public function setCategory(?OperationCategory $category): self
    {
        $this->category = $category;

        return $this;
    }
}
