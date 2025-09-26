<?php

declare(strict_types=1);

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: "flights")]
class Flight
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: "integer")]
    private int $id;

    #[ORM\Column(type: "string", length: 100)]
    private string $flightNumber;

    #[ORM\Column(type: "string", length: 100)]
    private string $departure;

    #[ORM\Column(type: "string", length: 100)]
    private string $arrival;

    #[ORM\Column(type: "datetime")]
    private \DateTimeInterface $departureTime;

    #[ORM\Column(type: "datetime")]
    private \DateTimeInterface $arrivalTime;

    public function getId(): int
    {
        return $this->id;
    }

    public function getFlightNumber(): string
    {
        return $this->flightNumber;
    }

    public function setFlightNumber(string $flightNumber): self
    {
        $this->flightNumber = $flightNumber;
        return $this;
    }

    public function getDeparture(): string
    {
        return $this->departure;
    }

    public function setDeparture(string $departure): self
    {
        $this->departure = $departure;
        return $this;
    }

    public function getArrival(): string
    {
        return $this->arrival;
    }

    public function setArrival(string $arrival): self
    {
        $this->arrival = $arrival;
        return $this;
    }

    public function getDepartureTime(): \DateTimeInterface
    {
        return $this->departureTime;
    }

    public function setDepartureTime(\DateTimeInterface $departureTime): self
    {
        $this->departureTime = $departureTime;
        return $this;
    }

    public function getArrivalTime(): \DateTimeInterface
    {
        return $this->arrivalTime;
    }

    public function setArrivalTime(\DateTimeInterface $arrivalTime): self
    {
        $this->arrivalTime = $arrivalTime;
        return $this;
    }
}
