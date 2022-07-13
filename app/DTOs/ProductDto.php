<?php

namespace App\DTOs;

class ProductDto
{
    private $storeId;
    private $arName;
    private $enName;
    private $arDescription;
    private $enDescription;
    private $price;

    /**
     * @return string
     */
    public function getStoreId(): string
    {
        return $this->storeId;
    }

    /**
     * @param string $storeId
     */
    public function setStoreId(string $storeId): void
    {
        $this->storeId = $storeId;
    }

    /**
     * @return string
     */
    public function getArName(): string
    {
        return $this->arName;
    }

    /**
     * @param string $arName
     */
    public function setArName(string $arName): void
    {
        $this->arName = $arName;
    }

    /**
     * @return string
     */
    public function getEnName(): string
    {
        return $this->enName;
    }

    /**
     * @param string $enName
     */
    public function setEnName(string $enName): void
    {
        $this->enName = $enName;
    }

    /**
     * @return string
     */
    public function getArDescription(): string
    {
        return $this->arDescription;
    }

    /**
     * @param string $arDescription
     */
    public function setArDescription(string $arDescription): void
    {
        $this->arDescription = $arDescription;
    }

    /**
     * @return string
     */
    public function getEnDescription(): string
    {
        return $this->enDescription;
    }

    /**
     * @param string $enDescription
     */
    public function setEnDescription(string $enDescription): void
    {
        $this->enDescription = $enDescription;
    }

    /**
     * @return float
     */
    public function getPrice(): float
    {
        return $this->price;
    }

    /**
     * @param float $price
     */
    public function setPrice(float $price): void
    {
        $this->price = $price;
    }
}
