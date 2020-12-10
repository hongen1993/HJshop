<?php 
namespace App\Entity;

use Symfony\Component\Validator\Constraints as Assert;

class PropertySearch{
    /**
     * @var int|null
     */
    private $maxPrice;

    /**
     * @var int|null
     */
    private $minPrice;

    /**
     * @return int|null
     */

     public function getMaxPrice(): ?int
    {
        return $this->maxPrice;
    }

    /**
     *  @param int|null $maxPrice
     * @return PropertySearch
     */
     public function setMaxPrice(int $maxPrice): PropertySearch
     {
         $this->maxPrice = $maxPrice;
         return $this;
     }

    /**
     * @return int|null
     */

    public function getMinPrice(): ?int
    {
        return $this->minPrice;
    }

    /**
     *  @param int|null $minPrice
     * @return PropertySearch
     */
    public function setMinPrice(int $minprice): PropertySearch
    {
        $this->minPrice = $minprice;
        return $this;
    }



}