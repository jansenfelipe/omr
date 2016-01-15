<?php

namespace JansenFelipe\OMR;

use JansenFelipe\OMR\Contracts\Target;

class Result
{
    /**
     * Path Image
     *
     * @var string
     */
    private $imagePath;

    /**
     * MIME Image
     *
     * @var string
     */
    private $imageMime;

    /**
     * Width Image
     *
     * @var int
     */
    private $width;

    /**
     * Height Image
     *
     * @var int
     */
    private $height;

    /**
     * Targets
     *
     * @var Target[]
     */
    private $targets;

    /**
     * Set dimensions
     *
     * @param $width
     * @param $height
     */
    public function setDimensions($width, $height)
    {
        $this->width = $width;
        $this->height = $height;
    }

    /**
     * Add target
     *
     * @param Target $target
     * @return void
     */
    public function addTarget(Target $target)
    {
        $this->targets[] = $target;
    }

    /**
     * Get target
     *
     * @return Target[]
     */
    public function getTargets()
    {
        return $this->targets;
    }

    /**
     * Set mime image
     *
     * @param string $imageMime
     */
    public function setImageMime($imageMime)
    {
        $this->imageMime = $imageMime;
    }

    /**
     * Set Path image
     *
     * @param string $imagePath
     */
    public function setImagePath($imagePath)
    {
        $this->imagePath = $imagePath;
    }
}