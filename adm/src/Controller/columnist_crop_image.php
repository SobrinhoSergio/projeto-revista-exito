<?php

use Friweb\CMS\AppException\AppException;
use Friweb\CMS\Model\Columnist;

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// AJAX
//if (isset($_POST['image'])) {


    $columnistImg = new Columnist($_POST);

    try {
        
        $tmp_path = $columnistImg->moveImage('colunistas/');
        unlink(dirname("../../materia.php"). '/img/colunistas/thumbs/'.$_POST['id'].'.jpg');
        $columnistImg->renameImg($_POST['id'], $tmp_path, 'jpg', 'thumbs/');
        unset($_POST);
        exit();

    } catch (AppException $e) {
        $exception = $e;
    }
//}