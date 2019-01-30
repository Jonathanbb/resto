<?php

namespace AppBundle\Entity;

/**
 * Commands
 */
class Commands
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var \stdClass
     */
    private $userId;

    /**
     * @var float
     */
    private $totalPrice;


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
     * Set userId
     *
     * @param \stdClass $userId
     *
     * @return Commands
     */
    public function setUserId($userId)
    {
        $this->userId = $userId;

        return $this;
    }

    /**
     * Get userId
     *
     * @return \stdClass
     */
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * Set totalPrice
     *
     * @param float $totalPrice
     *
     * @return Commands
     */
    public function setTotalPrice($totalPrice)
    {
        $this->totalPrice = $totalPrice;

        return $this;
    }

    /**
     * Get totalPrice
     *
     * @return float
     */
    public function getTotalPrice()
    {
        return $this->totalPrice;
    }
}
