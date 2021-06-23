<?php

namespace App\Entity;

class VisitorTrip
{

    private string $homeCity;

    private string $workCity;

    private ?array $homeCityCoordinates;

    private ?array $workCityCoordinates;

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
     * Get the value of homeCityCoordinates
     */
    public function gethomeCityCoordinates(): ?array
    {
        return $this->homeCityCoordinates;
    }

    /**
     * Set the value of homeCityCoordinates
     *
     * @return  self
     */
    public function sethomeCityCoordinates(?array $homeCityCoordinates): self
    {
        $this->homeCityCoordinates = $homeCityCoordinates;

        return $this;
    }

    /**
     * Get the value of workCityCoordinates
     */
    public function getworkCityCoordinates(): ?array
    {
        return $this->workCityCoordinates;
    }

    /**
     * Set the value of workCityCoordinates
     *
     * @return  self
     */
    public function setworkCityCoordinates(?array $workCityCoordinates): self
    {
        $this->workCityCoordinates = $workCityCoordinates;

        return $this;
    }
}
