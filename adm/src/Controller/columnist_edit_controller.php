<?php

// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

use Friweb\CMS\AppException\AppException;
use Friweb\CMS\Model\Columnist;

session_start();
isSessionValid();

if ($_POST['update-submit']) {

    if (!$_POST['active']) {
        $_POST['active'] = 0;
    }

    if (!$_POST['publish']) {
        $_POST['publish'] = 0;
    }

    try {

        $columnistEdit = new Columnist($_POST);

        $columnistEdit->update($_SESSION['update_columnist_id']);

        if ($_POST['change_img'] == 1) {
            $columnistEdit->checkDimensions($_FILES['main_img']['tmp_name']);
            $ext = pathinfo($_FILES['main_img']['name'], PATHINFO_EXTENSION);

            copy($_FILES['main_img']['tmp_name'], dirname("../../materia.php").'/img/colunistas/originais/'.$_SESSION['update_columnist_id'].'.jpg');

            $tmp_path = '/img/colunistas/thumbs/'.$_SESSION['update_columnist_id'].'.jpg';

            $columnistEdit->resize_image($_FILES['main_img']['tmp_name'], $tmp_path);

            $newImg = $columnistEdit->renameImg($_SESSION['update_columnist_id'], $tmp_path, 'jpg', 'thumbs/');

            $columnistEdit->insertImageLink($newImg, $_SESSION['update_columnist_id']);

            chmod($newImg, 0644);
        }
        header("Location: columnists_list_controller.php?page=1");

    } catch (AppException $e) {
        $exception = $e;
    }

}

$exception = null;

try {

    $columnist = new Columnist($_GET);
    $rows = $columnist->getResultFromSelect(['chave_colunista' => $_GET['columnist_id']]);
    if (!$rows) {header("location: columnists_list_controller.php");}
    $fields = $rows->fetch_assoc();

    $_SESSION['update_columnist_id'] = $_GET['columnist_id'];

} catch (AppException $e) {
    $exception = $e;
}

loadView('columnist_edit', ['AppException' => $exception] + $fields);