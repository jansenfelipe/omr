<?php

namespace JansenFelipe\OMR\Targets;

use JansenFelipe\OMR\Contracts\Target;
use JansenFelipe\OMR\Point;

class ZBarTarget extends Target
{
    public const TYPE_QR_CODE   = 1;

    public const TYPE_EAN_13    = 2;
    
    public const TYPE_CODE_39   = 3;
    
    public const TYPE_CODE_128  = 4;

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
     * The barcode format
     *
     * @var string
     */
    private $format;

    /**
     * The barcode result
     *
     * @var string
     */
    private $result;

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
     * Get the barcode format
     *
     * @return string
     */
    public function getFormat()
    {
        return $this->format;
    }

    /**
     * Set the barcode format
     *
     * @return string
     */
    public function setFormat($format)
    {
        $this->format = $format;
    }

    /**
     * @param string $result
     */
    public function setResult($result)
    {
        $this->result = $result;
    }

    /**
     * Get the decoded barcode result
     *
     * @return string
     */
    public function getResult()
    {
        return $this->result;
    }
}