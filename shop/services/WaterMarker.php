<?php

namespace shop\services;

use PHPThumb\GD;
use Yii;

class WaterMarker
{
    private $width;
    private $height;
    private $waterTxt;

    public function __construct($width, $height, $waterTxt)
    {
        $this->width = $width;
        $this->height = $height;
        $this->waterTxt = $waterTxt;
    }

    public function process(GD $thumb): void
    {
        if (!empty($this->width) || !empty($this->height)) {
            $thumb->adaptiveResize($this->width, $this->height);
        }

        $destination = $thumb->getOldImage();

        imagealphablending($destination, true);
        $textcolor = imagecolorallocate($destination, 0, 0, 255);
        $font = Yii::getAlias('@webroot/fonts/Arsenal-Regular.otf');
        //imagestring($destination, $font, 0, 0, $this->waterTxt, $textcolor);
        imagettftext($destination, 12, 0, 200, 100, 0, $font, $this->waterTxt);

        $thumb->setOldImage($destination);
        $thumb->setWorkingImage($destination);
    }
} 