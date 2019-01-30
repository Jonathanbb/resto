<?php

namespace AppBundle\Entity;

/**
 * CommandDetails
 */
class CommandDetails
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var \stdClass
     */
    private $commandId;

    /**
     * @var \stdClass
     */
    private $cardId;

    /**
     * @var int
     */
    private $quantity;


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
     * Set commandId
     *
     * @param \stdClass $commandId
     *
     * @return CommandDetails
     */
    public function setCommandId($commandId)
    {
        $this->commandId = $commandId;

        return $this;
    }

    /**
     * Get commandId
     *
     * @return \stdClass
     */
    public function getCommandId()
    {
        return $this->commandId;
    }

    /**
     * Set cardId
     *
     * @param \stdClass $cardId
     *
     * @return CommandDetails
     */
    public function setCardId($cardId)
    {
        $this->cardId = $cardId;

        return $this;
    }

    /**
     * Get cardId
     *
     * @return \stdClass
     */
    public function getCardId()
    {
        return $this->cardId;
    }

    /**
     * Set quantity
     *
     * @param integer $quantity
     *
     * @return CommandDetails
     */
    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;

        return $this;
    }

    /**
     * Get quantity
     *
     * @return int
     */
    public function getQuantity()
    {
        return $this->quantity;
    }
}
