<?php

use Friweb\CMS\AppException\AppException;

try {

    $image_array_1 = explode(";", $_POST['image']);
    $image_array_2 = explode(",", $image_array_1[1]);
    $decodedImg = base64_decode($image_array_2[1]);

    $tmp_name = 'assets/img/' . uniqid() . '.png';

    file_put_contents($tmp_name, $decodedImg);

    rename($tmp_name, $_POST['currentImg']);
    echo "Sucesso";


} catch (AppException $e) {
    $exception = $e;
    echo $e;
}