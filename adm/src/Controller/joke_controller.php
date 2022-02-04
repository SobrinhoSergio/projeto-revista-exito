<?php

use Friweb\CMS\AppException\AppException;
use Friweb\CMS\Model\Joke;

session_start();
isSessionValid();
if ($_SESSION['type_user'] != 1) { header("Location: cms_controller.php"); }

$exception = null;

if ($_POST) {
    try {
        $joke = new Joke($_POST);
//        $key = $joke->insertJoke();

        $joke->checkDimensions($_FILES['main_image']['tmp_name']);
        $ext = pathinfo($_FILES['main_image']['name'], PATHINFO_EXTENSION);
        $joke->renameImg($joke->insertJoke()[0]['chave_piada'], $_FILES['main_image']['tmp_name'], $ext, '');


        header("Location: jokes_list_controller.php?page=1");
    } catch (AppException $e) {
        $exception = $e;
    }
}


loadView('new_joke', $_POST + ['AppException' => $exception]);