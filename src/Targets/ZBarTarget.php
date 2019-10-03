<?php

namespace JansenFelipe\OMR\Targets;

use JansenFelipe\OMR\Point;

class ZBarTarget extends TextTarget
{
    public const TYPE_QR_CODE   = 1;

    public const TYPE_EAN_13    = 2;
    
    public const TYPE_CODE_39   = 3;
    
    public const TYPE_CODE_128  = 4;

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
     * @param string $format
     */
    public function __construct($id, Point $a, Point $b, string $format)
    {
        parent::__construct($id, $a, $b);
        $this->format = $format;
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

    /**
     * Decode the barcode image
     *
     * @return string
     */
    public function decode()
    {
        // TODO
    }
}