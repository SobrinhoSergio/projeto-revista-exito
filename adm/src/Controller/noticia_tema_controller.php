<?php

use Friweb\CMS\AppException\AppException;
use Friweb\CMS\Model\TemaMateria;

session_start();
isSessionValid();

$exception = null;

if ($_POST) {
    $tema = new TemaMateria($_POST);
    try {
        $tema->insert();
        header("location: noticia_tema_list_controller.php");
    } catch (AppException $e) {
        $exception = $e;
    }
}


loadView('tema_noticia', $_POST + ['AppException' => $exception]);
