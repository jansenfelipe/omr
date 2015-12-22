<?php

namespace JansenFelipe\OMR\Targets;

use JansenFelipe\OMR\Contracts\Target;
use JansenFelipe\OMR\Point;

class CircleTarget extends Target
{
    /**
     * Center point
     *
     * @var Point
     */
    private $point;

    /**
     * Radius
     *
     * @var float
     */
    private $radius;

    /**
     * Constructor
     *
     * @param $id
     * @param Point $point
     * @param $radius
     */
    public function __construct($id, Point $point, $radius)
    {
        $this->id = $id;
        $this->point = $point;
        $this->radius = $radius;
    }

    /**
     * Get center pointer
     *
     * @return Point
     */
    public function getPoint()
    {
        return $this->point;
    }

    /**
     * Get radius circle
     *
     * @return float
     */
    public function getRadius()
    {
        return $this->radius;
    }



}