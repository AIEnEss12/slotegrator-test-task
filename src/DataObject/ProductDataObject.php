<?php

namespace App\DataObject;

class ProductDataObject
{
    private string $name;

    private float $price;

    private string $photo;

    private string $description;

    public function __construct(string $name, string $price, string $photo, string $description)
    {
        $this->name = $name;
        $this->price = $price;
        $this->photo = $photo;
        $this->description = $description;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getPrice(): string
    {
        return $this->price;
    }

    public function setPrice(string $price): void
    {
        $this->price = $price;
    }

    public function getPhoto(): string
    {
        return $this->photo;
    }

    public function setPhoto(string $photo): void
    {
        $this->photo = $photo;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description): void
    {
        $this->description = $description;
    }
}