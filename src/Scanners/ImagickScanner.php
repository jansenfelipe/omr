<?php

namespace JansenFelipe\OMR\Scanners;

use Imagick;
use ImagickDraw;
use JansenFelipe\OMR\Area;
use JansenFelipe\OMR\Contracts\Scanner;
use JansenFelipe\OMR\Point;

class ImagickScanner extends Scanner
{

    private $imagick;
    private $draw;

    public function __construct()
    {
        $this->draw = new ImagickDraw();
        $this->draw->setFontSize(6);
    }

    /**
     * Create or return instance Imagick
     *
     * @return Imagick
     */
    private function getImagick()
    {
        if(is_null($this->imagick))
        {
            $this->imagick = new Imagick($this->imagePath);
            $this->imagick->setResolution(300, 300);
            $this->imagick->thresholdImage(0.5);
            $this->imagick->medianFilterImage(2);
            $this->imagick->setImageCompression(imagick::COMPRESSION_JPEG);
            $this->imagick->setImageCompressionQuality(100);
        }

        return $this->imagick;
    }

    /**
     * Most point to the top/right
     *
     * @return Point
     */
    protected function topRight(Point $near)
    {
        $imagick = $this->getImagick();

        $first = new Point($near->getX() - 200, $near->getY() - 100);
        $last  = new Point($near->getX() + 100, $near->getY() + 200);

        $point = new Point($first->getX(), $last->getY());

        //Add draw debug
        $this->draw->setStrokeOpacity(1);
        $this->draw->setFillOpacity(0);
        $this->draw->setStrokeWidth(2);
        $this->draw->setStrokeColor("#00CC00");
        $this->draw->rectangle($first->getX(), $first->getY(), $last->getX(), $last->getY());

        for($y = $first->getY(); $y != $last->getY(); $y++)
        {
            for($x = $first->getX(); $x != $last->getX(); $x++)
            {
                $color = $imagick->getImagePixelColor($x, $y)->getColor();

                if ($color['r'] <= 5 && $color['g'] <= 5 && $color['b'] <= 5)
                {
                    if ($x >= $point->getX())
                        $point->setX($x);

                    if ($y <= $point->getY())
                        $point->setY($y);
                }
            }
        }

        //Debug draw
        $this->draw->setFillColor("#00CC00");
        $this->draw->point($point->getX(), $point->getY());$this->debug();

        return $point;
    }

    /**
     * Most point to the bottom/left
     *
     * @return Point
     */
    protected function bottomLeft(Point $near)
    {
        $imagick = $this->getImagick();
        $side = 200;

        $first = new Point($near->getX() - 100, $near->getY() - 200);
        $last  = new Point($near->getX() + 200, $near->getY() + 100);

        $point = new Point($last->getX(), $first->getY());

        //Add draw debug
        $this->draw->setStrokeOpacity(1);
        $this->draw->setFillOpacity(0);
        $this->draw->setStrokeWidth(2);
        $this->draw->setStrokeColor("#00CC00");
        $this->draw->rectangle($first->getX(), $first->getY(), $last->getX(), $last->getY());

        for($y = $first->getY(); $y != $last->getY(); $y++)
        {
            for($x = $first->getX(); $x != $last->getX(); $x++)
            {
                $color = $imagick->getImagePixelColor($x, $y)->getColor();

                if ($color['r'] <= 5 && $color['g'] <= 5 && $color['b'] <= 5)
                {
                    if ($x <= $point->getX())
                        $point->setX($x);

                    if ($y >= $point->getY())
                        $point->setY($y);
                }
            }
        }

        //Debug draw
        $this->draw->setFillColor("#00CC00");
        $this->draw->point($point->getX(), $point->getY());

        return $point;
    }

    /**
     * Increases or decreases image size
     *
     * @param float $percent
     */
    protected function ajustSize($percent)
    {
        $imagick = $this->getImagick();

        $widthAjusted = $imagick->getImageWidth() + (($imagick->getImageWidth() * $percent) / 100);
        $heightAjust = $imagick->getImageHeight() + (($imagick->getImageHeight() * $percent) / 100);

        $this->imagick->resizeImage($widthAjusted, $heightAjust, Imagick::FILTER_POINT, 0, false);
    }

    /**
     * Rotate image
     *
     * @param float $degrees
     */
    protected function ajustRotate($degrees)
    {
        if($degrees<0)
            $degrees = 360 + $degrees;

        $imagick = $this->getImagick();

        $originalWidth = $imagick->getImageWidth();
        $originalHeight = $imagick->getImageHeight();

        $imagick->rotateImage("#FFFFFF", $degrees);

        $imagick->setImagePage($imagick->getimageWidth(), $imagick->getimageheight(), 0, 0);
        $imagick->cropImage($originalWidth, $originalHeight, ($imagick->getimageWidth() - $originalWidth) / 2, ($imagick->getimageHeight() - $originalHeight) / 2);
    }

    /**
     * Genereate file debug.jpg with targets, topRight and buttonLeft
     *
     * @param void
     */
    public function debug()
    {
        $imagick = $this->getImagick();
        $imagick->drawImage($this->draw);
        $imagick->writeImage($this->debugPath);
    }

    /**
     * Returns pixel analysis in a rectangular area
     *
     * @param Point $a
     * @param Point $b
     * @param float $tolerance
     * @return Area
     */
    protected function rectangleArea(Point $a, Point $b, $tolerance)
    {
        $imagick = $this->getImagick();

        $width = $b->getX() - $a->getX();
        $height = $b->getY() - $a->getY();

        $pixels = $imagick->exportImagePixels($a->getX(), $a->getY(), $width, $height, "I", Imagick::PIXEL_CHAR);
        $counts = array_count_values($pixels);

        $blacks = 0;
        $whites = 0;

        foreach($counts as $k => $qtd){
            if($k == -1)
                $whites += $qtd;
            else
                $blacks += $qtd;
        }

        $area = new Area(count($pixels), $whites, $blacks);

        //Add draw debug
        $this->draw->setStrokeOpacity(1);
        $this->draw->setFillOpacity(0);
        $this->draw->setStrokeWidth(2);
        $this->draw->setStrokeColor($area->percentBlack()>=$tolerance?"#0000CC":"#CC0000");
        $this->draw->rectangle($a->getX(), $a->getY(), $b->getX(), $b->getY());

        return $area;
    }

    /**
     * Returns pixel analysis in a circular area
     *
     * @param Point $a
     * @param float $radius
     * @param float $tolerance
     * @return Area
     */
    protected function circleArea(Point $a, $radius, $tolerance)
    {
        return true;
    }

    /**
     * Returns image blob in a rectangular area
     *
     * @param Point $a
     * @param Point $b
     * @return string
     */
    protected function textArea(Point $a, Point $b)
    {
        $imagick = $this->getImagick();

        $width = $b->getX() - $a->getX();
        $height = $b->getY() - $a->getY();

        $region = $imagick->getImageRegion($width, $height, $a->getX(), $a->getY());

        //Add draw debug
        $this->draw->setStrokeOpacity(1);
        $this->draw->setFillOpacity(0);
        $this->draw->setStrokeWidth(2);
        $this->draw->setStrokeColor("#FFFF00");
        $this->draw->rectangle($a->getX(), $a->getY(), $b->getX(), $b->getY());

        return $region->getImageBlob();
    }

    /**
     * Finish processes
     *
     * @param void
     */
    protected function finish()
    {
        $this->getImagick()->clear();
    }
}