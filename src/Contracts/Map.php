<?php

namespace JansenFelipe\OMR\Contracts;

use JansenFelipe\OMR\Point;

interface Map
{

    /**
     * Most point to the top/left
     *
     * @return Point
     */
    public function topLeft();

    /**
     * Most point to the top/right
     *
     * @return Point
     */
    public function topRight();

    /**
     * Most point to the bottom/left
     *
     * @return Point
     */
    public function bottomLeft();

    /**
     * Most point to the bottom/left
     *
     * @return Point
     */
    public function bottomRight();

    /**
     * Targets
     *
     * @return Target[]
     */
    public function targets();

}