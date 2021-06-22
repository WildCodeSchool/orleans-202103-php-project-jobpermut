<?php

namespace App\Entity;

use App\Repository\VisitorTripRepository;

class VisitorTrip
{

    private string $homeCity;

    private string $workCity;

    private ?array $homeCityCoordonates;

    private ?array $workCityCoordonates;

    public function getHomeCity(): ?string
    {
        return $this->homeCity;
    }

    public function setHomeCity(string $homeCity): self
    {
        $this->homeCity = $homeCity;

        return $this;
    }

    public function getWorkCity(): ?string
    {
        return $this->workCity;
    }

    public function setWorkCity(string $workCity): self
    {
        $this->workCity = $workCity;

        return $this;
    }

    /**
     * Get the value of homeCityCoordonates
     */
    public function getHomeCityCoordonates(): ?array
    {
        return $this->homeCityCoordonates;
    }

    /**
     * Set the value of homeCityCoordonates
     *
     * @return  self
     */
    public function setHomeCityCoordonates(?array $homeCityCoordonates): self
    {
        $this->homeCityCoordonates = $homeCityCoordonates;

        return $this;
    }

    /**
     * Get the value of workCityCoordonates
     */
    public function getWorkCityCoordonates(): ?array
    {
        return $this->workCityCoordonates;
    }

    /**
     * Set the value of workCityCoordonates
     *
     * @return  self
     */
    public function setWorkCityCoordonates(?array $workCityCoordonates): self
    {
        $this->workCityCoordonates = $workCityCoordonates;

        return $this;
    }
}
