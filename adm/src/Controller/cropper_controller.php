<?php
// error_reporting(E_ALL ^ E_NOTICE);
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

use Friweb\CMS\AppException\AppException;
use Friweb\CMS\Model\Sponsor;

session_start();
isSessionValid();
if ($_SESSION['type_user'] != 1) { header("Location: cms_controller.php"); }

$exception = null;

// post
if ($_POST['image']) {
    $sponsorImg = new Sponsor($_POST);
    try {
        // salva caminho da imagem temporária em anuncios
        $tmp_path = $sponsorImg->moveImage('anuncios/');

        // salva caminho temporário em variável de sessão
        $_SESSION['tmp_path'] = $tmp_path;


    } catch (AppException $e) {
        $exception = $e;
    }
}

loadView('sponsor', ['AppException' => $exception]);