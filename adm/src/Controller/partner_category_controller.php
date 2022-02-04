<?php

use Friweb\CMS\AppException\AppException;
use Friweb\CMS\Model\CategoryPartner;

session_start();
isSessionValid();

$exception = null;

if ($_POST) {
    $category = new CategoryPartner($_POST);
    try {
        $category->insert();
        header("location: partners_categories_list_controller.php?page=1");
    } catch (AppException $e) {
        $exception = $e;
    }
}


loadView('partner_category', $_POST + ['AppException' => $exception]);