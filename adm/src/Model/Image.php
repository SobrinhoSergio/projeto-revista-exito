<?php


namespace Friweb\CMS\Model;


interface Image
{
    function moveImage($dir);

    function getDimensions($img);

    function renameImg($key, $tmp, $ext, $dir = '');

    function checkDimensions($img);

}