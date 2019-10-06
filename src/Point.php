<?php

namespace JansenFelipe\OMR;


class Point
{
    /**
     * Value X
     *
     * @var float
     */
    private $x;

    /**
     * Value Y
     *
     * @var float
     */
    private $y;

    /**
     * Constructor
     *
     * @param float $x
     * @param float $y
     */
    public function __construct($x, $y)
    {
        $this->x = $x;
        $this->y = $y;
    }

    /**
     * Position X
     *
     * @return float
     */
    public function getX()
    {
        return $this->x;
    }

    /**
     * Position Y
     *
     * @return float
     */
    public function getY()
    {
        return $this->y;
    }

    /**
     * Position X
     *
     * @param float $x
     */
    public function setX($x)
    {
        $this->x = $x;
    }

    /**
     * Position Y
     *
     * @param float $y
     */
    public function setY($y)
    {
        $this->y = $y;
    }



    /**
     * Move the point at $position on the X axis
     *
     * @param int $position
     * @return Point
     */
    public function moveX($position)
    {
        $this->x = $this->x + $position;
        return $this;
    }

    /**
     * Move the point at $position on the Y axis
     *
     * @param int $position
     * @return Point
     */
    public function moveY($position)
    {
        $this->y = $this->y + $position;
        return $this;
    }

}