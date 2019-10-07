<?php

namespace JansenFelipe\OMR;

use JansenFelipe\OMR\Contracts\Target;
use JansenFelipe\OMR\Targets\TextTarget;

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
    private $targets = [];

    /**
     * Set dimensions
     *
     * @param int $width
     * @param int $height
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

    /**
     * To Array
     *
     * @return array
     */
    public function toArray()
    {
        $filtered = array_filter($this->targets, function (Target $target) {
            return !($target instanceof TextTarget);
        });

        $targets = array_map(function (Target $item) {
            return [
                'id' => $item->getId(),
                'marked' => $item->isMarked() ? 'yes' : 'no'
            ];
        }, $filtered);

        return compact('targets');
    }

    /**
     * To Json
     *
     * @return string
     */
    public function toJson()
    {
        return json_encode($this->toArray());
    }
}