<?php

namespace JansenFelipe\OMR\Targets;

use JansenFelipe\OMR\Contracts\Target;
use JansenFelipe\OMR\Point;

class TextTarget extends Target
{
    /**
     * Pointer Top/Left
     *
     * @var Point
     */
    private $a;

    /**
     * Pointer Bottom/Right
     *
     * @var Point
     */
    private $b;

    /**
     * Image
     *
     * @var string
     */
    private $imageBlob;

    /**
     * Contructor
     *
     * @param $id
     * @param Point $a
     * @param Point $b
     */
    public function __construct($id, Point $a, Point $b)
    {
        $this->id = $id;
        $this->a = $a;
        $this->b = $b;
    }

    /**
     * Get Pointer Top/Left
     *
     * @return Point
     */
    public function getA()
    {
        return $this->a;
    }

    /**
     * Get Pointer Bottom/Right
     *
     * @return Point
     */
    public function getB()
    {
        return $this->b;
    }

    /**
     * Set image blob
     *
     * @param string
     */
    public function setImageBlob($imageBlob)
    {
        $this->imageBlob = $imageBlob;
    }

    /**
     * Set image blob
     *
     * @return string
     */
    public function getImageBlob()
    {
        return $this->imageBlob;
    }

}