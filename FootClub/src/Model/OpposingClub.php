<?php

namespace Model;

Class OpposingClub
{
    private ?int $id;
    private string $address;
    private string $city;

    public function __construct(?int $id, string $address, string $city) 
    {
        $this->id = $id;
        $this->address = $address;
        $this->city = $city;
    }

    // GETTERS
    public function getId(): ?int 
    {
        return $this->id;
    }

    public function getAddress(): string 
    {
        return $this->address;
    }

    public function getCity(): string 
    {
        return $this->city;
    }

    // SETTERS
    public function setId(int $id) 
    {
        $this->id = $id;
    }

    public function setAddress(string $address) 
    {
        $this->address = $address;
    }

    public function setCity(string $city) 
    {
        $this->city = $city;
    }
}