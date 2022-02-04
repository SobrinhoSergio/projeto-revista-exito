<?php
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);
use Friweb\CMS\AppException\AppException;
use Friweb\CMS\Model\Sponsor;

session_start();
isSessionValid();
if ($_SESSION['type_user'] != 1) { header("Location: cms_controller.php"); }

$exception = null;

if ($_GET['update_crop']) {
    if (!isset($_SESSION['update_sponsor_id'])) {
        unset($_SESSION['sponsor_original_image']);
    } else {
        $_SESSION['sponsor_original_image'] = $_SESSION['current_sponsor_img'];
        $_SESSION['type_sponsor'] = $_GET['type_sponsor'];
    }
}


// post
if (isset($_POST['image'])) {

    $_POST['type'] = $_SESSION['type_sponsor'];
    $sponsorImg = new Sponsor($_POST);

    try {
        $tmp_path = $sponsorImg->moveImage('anuncios/');
        $path = $sponsorImg->renameImg($_SESSION['update_sponsor_id'], $tmp_path, 'png', '');
        $sponsorImg->insertImageLink($path, $_SESSION['update_sponsor_id']);
        unlink($_SESSION['sponsor_original_image']); 
        unset($_SESSION['sponsor_original_image']);
        unset($_SESSION['update_sponsor_id']);
        unset($_SESSION['type_sponsor']);


    } catch (AppException $e) {
        $exception = $e;
    }
}


loadView('update_sponsor_img', ['AppException' => $exception]);