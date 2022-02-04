<?php

use Friweb\CMS\AppException\AppException;
use Friweb\CMS\Model\Partner;

session_start();
isSessionValid();
if ($_SESSION['type_user'] != 1) { header("Location: cms_controller.php"); }

$exception = null;


// post
if (isset($_POST['image'])) {

    $partnerImg = new Partner($_POST);

    try {
        $tmp_path = $partnerImg->moveImage('guia/');
        chmod($tmp_path, 0644);
        $partnerImg->renameImg($_SESSION['update_partner_id'], $tmp_path, 'png', 'guia/');
        unlink($_SESSION['partner_original_image']);
        unset($_SESSION['partner_original_image']);

    } catch (AppException $e) {
        $exception = $e;
    }
}


loadView('update_partner_image', ['AppException' => $exception]);