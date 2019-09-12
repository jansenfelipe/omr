<?php

namespace JansenFelipe\OMR\Contracts;


use JansenFelipe\OMR\Area;
use JansenFelipe\OMR\Point;
use JansenFelipe\OMR\Result;
use JansenFelipe\OMR\Targets\CircleTarget;
use JansenFelipe\OMR\Targets\RectangleTarget;
use JansenFelipe\OMR\Targets\TextTarget;

abstract class Scanner
{
    /**
     * Path image to be scanned
     *
     * @var string
     */
    protected $imagePath;

    /**
     * Debug flag
     *
     * @var boolean
     */
    protected $debug = false;

    /**
     * Path image to wirte debug image file
     *
     * @var string
     */
    protected $debugPath = 'debug.jpg';

    /**
     * Most point to the top/right
     *
     * @return Point
     */
    protected abstract function topRight(Point $near);

    /**
     * Most point to the bottom/left
     *
     * @return Point
     */
    protected abstract function bottomLeft(Point $near);

    /**
     * Returns pixel analysis in a rectangular area
     *
     * @param Point $a
     * @param Point $b
     * @param float $tolerance
     * @return Area
     */
    protected abstract function rectangleArea(Point $a, Point $b, $tolerance);

    /**
     * Returns pixel analysis in a circular area
     *
     * @param Point $a
     * @param float $radius
     * @param float $tolerance
     * @return Area
     */
    protected abstract function circleArea(Point $a, $radius, $tolerance);

    /**
     * Returns image blob in a rectangular area
     *
     * @param Point $a
     * @param Point $b
     * @return string
     */
    protected abstract function textArea(Point $a, Point $b);

    /**
     * Increases or decreases image size
     *
     * @param float $percent
     */
    protected abstract function ajustSize($percent);

    /**
     * Rotate image
     *
     * @param float $degrees
     */
    protected abstract function ajustRotate($degrees);

    /**
     * Genereate file debug.jpg with targets, topRight and buttonLeft
     *
     * @param void
     */
    protected abstract function debug();

    /**
     * Finish processes
     *
     * @param void
     */
    protected abstract function finish();

    /**
     * Set image path
     *
     * @param mixed $imagePath
     */
    public function setImagePath($imagePath)
    {
        $this->imagePath = $imagePath;
    }

    /**
     * Set debug image path
     *
     * @param mixed $debugPath
     */
    public function setDebugPath($debugPath)
    {
        $this->debugPath = $debugPath;
    }

    /**
     * Scan specific image
     *
     * @param $imagePath
     * @param Map $map
     * @return Result
     */
    public function scan(Map $map)
    {
        $info = getimagesize($this->imagePath);

        /*
         * Setup result
         */
        $result = new Result();
        $result->setDimensions($info[0], $info[1]);
        $result->setImageMime($info['mime']);
        $result->setImagePath($this->imagePath);

        /*
         * Check map
         */
        $topRightMap = $map->topRight();
        $bottomLeftMap = $map->bottomLeft();

        $angleMap = $this->anglePoints($topRightMap, $bottomLeftMap);
        $distanceCornersMap = $this->distancePoints($topRightMap, $bottomLeftMap);

        /*
         * Check image
         */
        $topRightImage = $this->topRight($topRightMap);
        $bottomLeftImage = $this->bottomLeft($bottomLeftMap);

        /*
         * Ajust angle image
         */
        $angleImage = $this->anglePoints($topRightImage, $bottomLeftImage);
        $this->ajustRotate($angleMap - $angleImage);

        /*
         * Check image again
         */
        $topRightImage = $this->topRight($topRightMap);
        $bottomLeftImage = $this->bottomLeft($bottomLeftMap);

        /*
         * Ajust size image
         */
        $distanceCornersImage = $this->distancePoints($topRightImage, $bottomLeftImage);
        $p = 100 - ((100 * $distanceCornersImage) / $distanceCornersMap);
        $this->ajustSize($p);

        /*
         * Check image again
         */
        $topRightImage = $this->topRight($topRightMap);
        $bottomLeftImage = $this->bottomLeft($bottomLeftMap);

        $ajustX = $topRightImage->getX() - $topRightMap->getX();
        $ajustY = $bottomLeftImage->getY() - $bottomLeftMap->getY();

        if($ajustX < 0) $ajustX = 0;
        if($ajustY < 0) $ajustY = 0;

        foreach($map->targets() as $target)
        {
            if ($target instanceof TextTarget)
            {
                $target->setImageBlob($this->textArea($target->getA()->moveX($ajustX)->moveY($ajustY), $target->getB()->moveX($ajustX)->moveY($ajustY)));

            }else {

                if ($target instanceof RectangleTarget)
                {
                    $area = $this->rectangleArea($target->getA()->moveX($ajustX)->moveY($ajustY), $target->getB()->moveX($ajustX)->moveY($ajustY), $target->getTolerance());
                }

                if ($target instanceof CircleTarget)
                {
                    $area = $this->circleArea($target->getPoint()->moveX($ajustX)->moveY($ajustY), $target->getRadius(), $target->getTolerance());
                }

                $target->setBlackPixelsPercent($area->percentBlack());
                
                $target->setMarked($area->percentBlack() >= $target->getTolerance());
            }

            $result->addTarget($target);
        }


        if($this->debug)
            $this->debug();

        $this->finish();

        return $result;
    }

    /**
     * Calculates distance between two points
     *
     * @param Point $a
     * @param Point $b
     * @return float
     */
    protected function distancePoints(Point $a, Point $b){

        $diffX = $b->getX() - $a->getX();
        $diffY = $b->getY() - $a->getY();

        return sqrt(pow($diffX, 2) + pow($diffY, 2));
    }

    /**
     * Calculates angle between two points
     *
     * @param Point $a
     * @param Point $b
     * @return float
     */
    protected function anglePoints(Point $a, Point $b){

        $diffX = $b->getX() - $a->getX();
        $diffY = $b->getY() - $a->getY();

        return rad2deg(atan($diffY/$diffX));
    }

    /**
     * Set debug flag
     *
     * @param boolean $debug
     */
    public function setDebug($debug)
    {
        $this->debug = $debug;
    }

    /**
     * Create Result object from imagePath
     *
     * @param string $imagePath
     * @return Result
     */
    protected function createResult($imagePath){

        $info = getimagesize($imagePath);

        $result = new Result();
        $result->setDimensions($info[0], $info[1]);

        return $result;
    }

}
