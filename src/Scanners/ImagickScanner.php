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
    protected function topRight()
    {
        $imagick = $this->getImagick();
        $side = 300;

        $first["x"] = $imagick->getImageWidth() - $side;
        $first["y"] = $side;

        for($y = $side; $y>0; $y--)
        {
            for($x = ($imagick->getImageWidth() - $side); $x<=$imagick->getImageWidth(); $x++)
            {
                $color = $imagick->getImagePixelColor($x, $y)->getColor();

                if ($color['r'] == 0 && $color['g'] == 0 && $color['b'] == 0)
                {
                    if ($x >= $first["x"])
                        $first["x"] = $x;

                    if ($y <= $first["y"])
                        $first["y"] = $y;
                }
            }
        }

        $point = new Point($first["x"], $first["y"]);

        //Debug draw
        $this->draw->setFillColor("#00CC00");
        $this->draw->point($point->getX(), $point->getY());

        return $point;
    }

    /**
     * Most point to the bottom/left
     *
     * @return Point
     */
    protected function bottomLeft()
    {
        $imagick = $this->getImagick();
        $side = 300;

        $last["x"] = $side;
        $last["y"] = $imagick->getImageHeight() - $side;

        for($y = ($imagick->getImageHeight() - $side); $y<=$imagick->getImageHeight(); $y++)
        {
            for($x = $side; $x>0; $x--)
            {
                $color = $imagick->getImagePixelColor($x, $y)->getColor();

                if ($color['r'] == 0 && $color['g'] == 0 && $color['b'] == 0)
                {
                    if ($x <= $last["x"])
                        $last["x"] = $x;

                    if ($y >= $last["y"])
                        $last["y"] = $y;
                }
            }
        }

        $point = new Point($last["x"], $last["y"]);

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

        $imagick->resizeImage($widthAjusted, $heightAjust, Imagick::FILTER_POINT, 0, false);
    }

    /**
     * Rotate image
     *
     * @param float $degrees
     */
    protected function ajustRotate($degrees)
    {
        $imagick = $this->getImagick();
        $imagick->rotateImage("#FFFFFF", $degrees);
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
        file_put_contents('debug.jpg', $imagick->getImageBlob());
    }

    /**
     * Returns pixel analysis in a rectangular area
     *
     * @param Point $a
     * @param Point $b
     * @return Area
     */
    protected function rectangleArea(Point $a, Point $b)
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

        $area = new Area(count($pixels), $whites, $blacks);;

        //Add draw debug
        $this->draw->setStrokeOpacity(1);
        $this->draw->setFillOpacity(0);
        $this->draw->setStrokeWidth(2);
        $this->draw->setStrokeColor($area->percentBlack()>=$this->tolerance?"#0000CC":"#CC0000");
        $this->draw->rectangle($a->getX(), $a->getY(), $b->getX(), $b->getY());

        return $area;
    }

    /**
     * Returns pixel analysis in a circular area
     *
     * @param Point $a
     * @param float $radius
     * @return Area
     */
    protected function circleArea(Point $a, $radius)
    {
        return true;
    }

}