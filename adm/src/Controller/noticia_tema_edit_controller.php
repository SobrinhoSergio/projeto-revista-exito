<?php

use Friweb\CMS\AppException\AppException;
use Friweb\CMS\Model\TemaMateria;

error_reporting(E_ALL ^ E_NOTICE);

session_start();
isSessionValid();

$exception = null;

if ($_POST['update-submit']) {
    try {
        if (!$_POST['active']) {
            $_POST['active'] = 0;
        }

        if (!$_POST['publish']) {
            $_POST['publish'] = 0;
        }

        $update = new TemaMateria($_POST);
        $update->update($_SESSION['update_tema_id']);

        header("location: noticia_tema_list_controller.php?page=1");
    } catch (AppException $e) {
        $exception = $e;
    }
}

try {
    $tema = new TemaMateria($_GET);

    $rows = $tema->getResultFromSelect(['chave_tipo' => $_GET['chave_tipo']]);
    if (!$rows) {
        header("location: noticia_tema_list_controller.php?page=1");
    }

    $fields = $rows->fetch_assoc();

    $_SESSION['update_tema_id'] = $_GET['chave_tipo'];
} catch (AppException $e) {
    $exception = $e;
}

loadView('noticia_tema_edit', ['AppException' => $exception] + $fields);
