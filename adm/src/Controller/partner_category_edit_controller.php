<?php

use Friweb\CMS\AppException\AppException;
use Friweb\CMS\Model\CategoryPartner;

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

        $update = new CategoryPartner($_POST);
        $update->update($_SESSION['update_category_id']);

        header("location: partners_categories_list_controller.php?page=1");

    } catch (AppException $e) {
        $exception = $e;
    }
}

try {
    $category = new CategoryPartner($_GET);

    $rows = $category->getResultFromSelect(['chave_categoria' => $_GET['category_id']]);
    if (!$rows) {header("location: partners_category_list_controller.php?page=1");}

    $fields = $rows->fetch_assoc();

    $_SESSION['update_category_id'] = $_GET['category_id'];

} catch (AppException $e) {
    $exception = $e;
}

loadView('partner_category_edit', ['AppException' => $exception] + $fields);