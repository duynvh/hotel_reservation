<?php
/**
 * Created by PhpStorm.
 * User: macos
 * Date: 10/10/18
 * Time: 10:55
 */

namespace App\Helper;


use Intervention\Image\Facades\Image;

class ImageOption
{
    function resizeImage($dataImage){
        $path = $dataImage['path'];
        $pathNew = $dataImage['pathNew'];
        $name = $dataImage['name'];
        $width = $dataImage['width'];
        $height = $dataImage['height'];

        $img = Image::make($path.'/'.$name)->resize($width,$height);
        $img->save($pathNew.'/'.$name);

        return $img;
    }
}
