<?php

namespace AppBundle\Entity;

/**
 * Menu
 */
class Menu
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $productName;

    /**
     * @var string
     */
    private $productDescription;

    /**
     * @var string
     */
    private $productImage;

    /**
     * @var float
     */
    private $price;

    /**
     * @var int
     */
    private $stock;

    /**
     * @var \stdClass
     */
    private $category;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set productName
     *
     * @param string $productName
     *
     * @return Menu
     */
    public function setProductName($productName)
    {
        $this->productName = $productName;

        return $this;
    }

    /**
     * Get productName
     *
     * @return string
     */
    public function getProductName()
    {
        return $this->productName;
    }

    /**
     * Set productDescription
     *
     * @param string $productDescription
     *
     * @return Menu
     */
    public function setProductDescription($productDescription)
    {
        $this->productDescription = $productDescription;

        return $this;
    }

    /**
     * Get productDescription
     *
     * @return string
     */
    public function getProductDescription()
    {
        return $this->productDescription;
    }

    /**
     * Set productImage
     *
     * @param string $productImage
     *
     * @return Menu
     */
    public function setProductImage($productImage)
    {
        $this->productImage = $productImage;

        return $this;
    }

    /**
     * Get productImage
     *
     * @return string
     */
    public function getProductImage()
    {
        return $this->productImage;
    }

    /**
     * Set price
     *
     * @param float $price
     *
     * @return Menu
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get price
     *
     * @return float
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set stock
     *
     * @param integer $stock
     *
     * @return Menu
     */
    public function setStock($stock)
    {
        $this->stock = $stock;

        return $this;
    }

    /**
     * Get stock
     *
     * @return int
     */
    public function getStock()
    {
        return $this->stock;
    }

    /**
     * Set category
     *
     * @param \stdClass $category
     *
     * @return Menu
     */
    public function setCategory($category)
    {
        $this->category = $category;

        return $this;
    }

    /**
     * Get category
     *
     * @return \stdClass
     */
    public function getCategory()
    {
        return $this->category;
    }
    /**
     * @var \AppBundle\Entity\Category
     */
    private $categorie;


    /**
     * Set categorie
     *
     * @param \AppBundle\Entity\Category $categorie
     *
     * @return Menu
     */
    public function setCategorie(\AppBundle\Entity\Category $categorie)
    {
        $this->categorie = $categorie;

        return $this;
    }

    /**
     * Get categorie
     *
     * @return \AppBundle\Entity\Category
     */
    public function getCategorie()
    {
        return $this->categorie;
    }
}
